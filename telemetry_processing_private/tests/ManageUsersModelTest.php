<?php declare(strict_types=1);
/**
 * ManageUsersModelTest.php
 *
 * Tests for the successful management of users.
 * Tests:
 * - Correct retrieval of stored users (however, one must be created first).
 * - Correct deletion of a stored user.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DriverManager;
use TelemProc\ManageUsersModel;
use TelemProc\DoctrineWrapper;
use TelemProc\BcryptWrapper;

final class ManageUsersModelTest extends TestCase
{
    /** @var array $settings Stores Doctrine settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test To identify if stored users can be successfully retrieved (after creation).
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testRetrieveUserList()
    {
        $manage_users_model = new ManageUsersModel();
        $doctrine_wrapper = new DoctrineWrapper();
        $bcrypt_wrapper = new BcryptWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $user_credentials = array(
            'username' => 'testUsername',
            'password' => $bcrypt_wrapper->createHashedPassword('testPassword')
        );

        // Creates a user - pre-requisite for test to pass.
        $doctrine_wrapper->storeUserDetails(
            $user_credentials['username'],
            $user_credentials['password']
        );

        $manage_users_model->setDatabaseHandle($doctrine_wrapper);
        $manage_users_model->setDatabaseSettings($database_connection_settings);

        $manage_users_model->retrieveRegisteredUsers();

        $this->assertNotEmpty(
            $manage_users_model->getResult()
        );
    }

    /**
     * @test To identify if a stored user can be successfully deleted.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testDeleteStoredUser()
    {
        $manage_users_model = new ManageUsersModel();
        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];

        $user_to_delete = 'testUsername';

        $manage_users_model->setDatabaseHandle($doctrine_wrapper);
        $manage_users_model->setDatabaseSettings($database_connection_settings);

        $manage_users_model->deleteRegisteredUser($user_to_delete);

        $this->assertNotFalse(
            $manage_users_model->getResult()
        );
    }

    /**
     * @test To identify if a stored user's password can be successfully updated.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testChangeUserPassword()
    {
        $manage_users_model = new ManageUsersModel();
        $doctrine_wrapper = new DoctrineWrapper();
        $bcrypt_wrapper = new BcryptWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $user_credentials = array(
            'username' => 'testUsername',
            'password' => $bcrypt_wrapper->createHashedPassword('testPassword')
        );

        // Creates a user - pre-requisite for test to pass.
        $doctrine_wrapper->storeUserDetails(
            $user_credentials['username'],
            $user_credentials['password']
        );

        // New Password
        $user_credentials = array(
            'username' => 'testUsername',
            'password' => 'testNewPassword'
        );

        $manage_users_model->setBcryptHandle($bcrypt_wrapper);
        $manage_users_model->setDatabaseHandle($doctrine_wrapper);
        $manage_users_model->setDatabaseSettings($database_connection_settings);

        $manage_users_model->changeUserPassword($user_credentials);

        $this->assertNotFalse(
            $manage_users_model->getResult()
        );
    }
}
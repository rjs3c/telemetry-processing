<?php declare(strict_types=1);
/**
 * LoginModelTest.php
 *
 * Tests Login functionality.
 * Tests:
 * - Tests successful authentication as a valid user.
 * - Tests unsuccessful authentication of an invalid user.
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
use TelemProc\DoctrineWrapper;
use TelemProc\BcryptWrapper;
use TelemProc\UserLoginModel;

class LoginModelTest extends TestCase
{
    /** @var array $settings Stores Bcrypt and Doctrine settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test That a user with valid credentials can be successfully authenticated.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testLoginValidCredentials()
    {
        $test_parameters = array(
            'username' => 'testUsername',
            'password' => 'testPassword'
        );

        $doctrine_wrapper = new DoctrineWrapper();
        $bcrypt_wrapper = new BcryptWrapper();
        $login_model = new UserLoginModel();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $bcrypt_settings = $this->settings['telemetrySettings']['bcryptSettings'];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();

        $doctrine_wrapper->setQueryBuilder($query_builder);

        $login_model->setDatabaseHandle($doctrine_wrapper);
        $login_model->setDatabaseSettings($database_connection_settings);

        $login_model->setBcryptWrapper($bcrypt_wrapper);
        $login_model->setBcryptSettings($bcrypt_settings);

        $login_model->setCredentials($test_parameters);

        $login_model->loginUser();
        $login_result = $login_model->getResult();

        $this->assertTrue($login_result);
    }

    /**
     * @test That a user with invalid credentials cannot be authenticated.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testLoginInvalidCredentials()
    {
        $test_parameters = array(
            'username' => 'invalidUsername',
            'password' => 'invalidPassword'
        );

        $doctrine_wrapper = new DoctrineWrapper();
        $bcrypt_wrapper = new BcryptWrapper();
        $login_model = new UserLoginModel();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $bcrypt_settings = $this->settings['telemetrySettings']['bcryptSettings'];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();

        $doctrine_wrapper->setQueryBuilder($query_builder);

        $login_model->setDatabaseHandle($doctrine_wrapper);
        $login_model->setDatabaseSettings($database_connection_settings);

        $login_model->setBcryptWrapper($bcrypt_wrapper);
        $login_model->setBcryptSettings($bcrypt_settings);

        $login_model->setCredentials($test_parameters);

        $login_model->loginUser();
        $login_result = $login_model->getResult();

        $this->assertFalse($login_result);
    }
}

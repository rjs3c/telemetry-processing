<?php declare(strict_types=1);
/**
 * LoginModelTest.php
 *
 * Tests successful and unsuccessful authentication of a user.
 * Tests:
 * - Correct successful authentication of a valid user.
 * - Correct unsuccessful authentication of an invalid user.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DriverManager;
use TelemProc\DoctrineWrapper;
use TelemProc\BcryptWrapper;
use TelemProc\SessionWrapper;
use TelemProc\LoginModel;

final class LoginModelTest extends TestCase
{
    /** @var array $settings Stores Doctrine settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test To identify if a registered user can be authenticated correctly.
     */
    public function testLoginValidCredentials()
    {
        $cleaned_parameters = array(
            'username' => 'testUsername',
            'password' => 'testPassword'
        );

        // Doctrine wrapper setup
        $doctrine_wrapper = new DoctrineWrapper();
        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $bcrypt_wrapper = new BcryptWrapper();
        $session_wrapper = new SessionWrapper();

        $login_model = new LoginModel();
        $login_model->setDoctrineWrapper($doctrine_wrapper);
        $login_model->setBcryptWrapper($bcrypt_wrapper);
        $login_model->setSessionWrapper($session_wrapper);
        $login_model->setUserCredentials($cleaned_parameters);

        $login_model->login();
        $login_result = $login_model->getResult();

        $this->assertTrue($login_result);
    }

    /**
     * @test To identify that an invalid/unregistered user cannot be authenticated.
     */
    public function testLoginInvalidCredentials()
    {
        $cleaned_parameters = array(
            'username' => 'invalidUsername',
            'password' => 'invalidPassword'
        );

        // Doctrine wrapper setup
        $doctrine_wrapper = new DoctrineWrapper();
        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $bcrypt_wrapper = new BcryptWrapper();

        $login_model = new LoginModel();
        $login_model->setDoctrineWrapper($doctrine_wrapper);
        $login_model->setBcryptWrapper($bcrypt_wrapper);
        $login_model->setUserCredentials($cleaned_parameters);

        $login_model->login();
        $login_result = $login_model->getResult();

        $this->assertFalse($login_result);
    }
}

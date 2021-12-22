<?php


use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DriverManager;
use TelemProc\DoctrineWrapper;
use TelemProc\BcryptWrapper;
use TelemProc\LoginModel;


class LoginModelTest extends TestCase
{

    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    public function testLoginValidCredentials()
    {

        $cleaned_parameters = array(

            'username' => 'testUsername',
            'password' => 'testPassword'

        );

        //doctrine wrapper setup
        $doctrine_wrapper = new DoctrineWrapper();
        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $bcrypt_wrapper = new BcryptWrapper();

        $login_model = new LoginModel();
        $login_model->setDoctrineWrapper($doctrine_wrapper);
        $login_model->setBCryptWrapper($bcrypt_wrapper);
        $login_model->setLoginCredentials($cleaned_parameters);

        $login_result = $login_model->login();

        $this->assertTrue($login_result);

    }

    public function testLoginInvalidCredentials()
    {

        $cleaned_parameters = array(

            'username' => 'invalidUsername',
            'password' => 'invalidPassword'

        );

        //doctrine wrapper setup
        $doctrine_wrapper = new DoctrineWrapper();
        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $bcrypt_wrapper = new BcryptWrapper();

        $login_model = new LoginModel();
        $login_model->setDoctrineWrapper($doctrine_wrapper);
        $login_model->setBCryptWrapper($bcrypt_wrapper);
        $login_model->setLoginCredentials($cleaned_parameters);

        $login_result = $login_model->login();

        $this->assertFalse($login_result);

    }

}

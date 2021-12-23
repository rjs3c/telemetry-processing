<?php declare(strict_types=1);
/**
 * RegisterModelTest.php
 *
 * Tests Register functionality.
 * Tests:
 * - That a user can be successfully registered.
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
use TelemProc\UserRegisterModel;

class RegisterModelTest extends TestCase
{
    /** @var array $settings Stores Bcrypt and Doctrine settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test That a register with valid information can be successfully registered.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testRegisterUser()
    {
        $test_parameters = array(
            'username' => 'testUsername',
            'password' => 'testPassword'
        );

        $doctrine_wrapper = new DoctrineWrapper();
        $bcrypt_wrapper = new BcryptWrapper();
        $register_model = new UserRegisterModel();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];
        $bcrypt_settings = $this->settings['telemetrySettings']['bcryptSettings'];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();

        $doctrine_wrapper->setQueryBuilder($query_builder);

        $register_model->setDatabaseHandle($doctrine_wrapper);
        $register_model->setDatabaseSettings($database_connection_settings);

        $register_model->setBcryptWrapper($bcrypt_wrapper);
        $register_model->setBcryptSettings($bcrypt_settings);

        $register_model->setCredentials($test_parameters);

        $register_model->registerUser();
        $register_result = $register_model->getResult();

        $this->assertTrue(
            $register_result
        );
    }
}
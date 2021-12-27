<?php declare(strict_types=1);
/**
 * RegisterModelTest.php
 *
 * Tests the registration of a user.
 * Tests:
 * - Correct successful registration of a valid user.
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
use TelemProc\RegisterModel;

class RegisterModelTest extends TestCase
{
    /** @var array $settings Stores Doctrine settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test RegisterModel for correct registration. Expect to fail if run more than once.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testRegisterUser()
    {
        $cleaned_parameters = array(

            'username' => 'testUsername',
            'password' => 'testPassword'

        );
        //doctrine wrapper setup
        $doctrine_wrapper = new DoctrineWrapper();
        $database_connection_settings =$this->settings['telemetrySettings']['doctrineSettings'];
        $database_connection = DriverManager::getConnection($database_connection_settings);
        $query_builder = $database_connection->createQueryBuilder();
        $doctrine_wrapper->setQueryBuilder($query_builder);

        $bcrypt_wrapper = new BcryptWrapper();

        $register_model = new RegisterModel();
        $register_model->setDoctrineWrapper($doctrine_wrapper);
        $register_model->setBcryptWrapper($bcrypt_wrapper);
        $register_model->setRegisterCredentials($cleaned_parameters);

        $register_model->register();
        $register_result = $register_model->getRegisterResult();

        $this->assertTrue(
            $register_result
        );
    }
}

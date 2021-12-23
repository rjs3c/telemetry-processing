<?php
/**
 * UserRegistersModel.php
 *
 * Utilises Doctrine and Bcrypt to register users.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

use Doctrine\DBAL\DriverManager;

class UserRegisterModel implements \TelemProc\UserModelInterface
{
    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_handle;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private array $doctrine_settings;

    /** @var resource $bcrypt_handle Contains handle to BcryptWrapper. */
    private $bcrypt_handle;

    /** @var array $bcrypt_settings Contains settings for <Bcrypt>. */
    private array $bcrypt_settings;

    /** @var resource $logger_handle Contains handle for <TelemetryLogger> */
    private $logger_handle;

    /** @var array $login_credentials Contains user-entered login credentials. */
    private array $user_credentials;

    /** @var bool $register_result Stores result for authentication. */
    private bool $register_result;

    public function __construct()
    {
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->bcrypt_handle = null;
        $this->bcrypt_settings = array();
        $this->logger_handle = null;
        $this->user_credentials = array();
        $this->register_result = false;
    }

    public function __destruct() {}

    /**
     * Sets handle to <Doctrine>.
     *
     * @param $doctrine_handle
     */
    public function setDatabaseHandle($doctrine_handle) : void
    {
        $this->doctrine_handle = $doctrine_handle;
    }

    /**
     * Sets database connection settings.
     *
     * @param array $doctrine_settings
     */
    public function setDatabaseSettings(array $doctrine_settings) : void
    {
        $this->doctrine_settings = $doctrine_settings;
    }

    /**
     * Sets handle to BcryptWrapper.
     *
     * @param $bcrypt_handle
     */
    public function setBcryptWrapper($bcrypt_handle) : void
    {
        $this->bcrypt_handle = $bcrypt_handle;
    }

    /**
     * @param array $bcrypt_settings
     */
    public function setBcryptSettings(array $bcrypt_settings) : void
    {
        $this->bcrypt_settings = $bcrypt_settings;
    }

    /**
     * Sets handle to <Monolog> logger.
     *
     * @param $telemetry_logger
     */
    public function setLoggerHandle($telemetry_logger) : void
    {
        $this->logger_handle = $telemetry_logger;
    }

    /**
     * Sets register credentials
     *
     * @param array $user_credentials
     */
    public function setCredentials(array $user_credentials) : void
    {
        $this->user_credentials = $user_credentials;
    }

    public function getResult() : bool
    {
        return $this->register_result;
    }

    /**
     * Registers new users. Returns true if registered successfully and false if not.
     * Will not allow multiple accounts of the same username and will return false if attempted.
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function registerUser() : void
    {
        $register_result = false;

        $user_name = $this->user_credentials['username'];
        $user_password = $this->user_credentials['password'];

        if ($this->checkUsernameAvailability($user_name) !== false) {
            $this->bcrypt_handle->setBcryptSettings($this->bcrypt_settings);
            $hashed_password = $this->bcrypt_handle->hashPassword($user_password);

            $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
            $query_builder = $dbal_connection->createQueryBuilder();

            $this->doctrine_handle->setQueryBuilder($query_builder);

            if ($this->logger_handle !== null) {
                $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
            }

            if (!empty($hashed_password)) {
                $this->doctrine_handle->storeUserDetails($user_name, $hashed_password);
                $register_result = $this->doctrine_handle->getQueryResult();
            }
        }

        $this->register_result = $register_result;
    }

    /**
     * Checks if the username already exists within the user table.
     *
     * @param string $user_name
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    private function checkUsernameAvailability(string $user_name) : bool
    {
        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        $this->doctrine_handle->setQueryBuilder($query_builder);

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        $this->doctrine_handle->checkUsernameAvailable($user_name);

        return $this->doctrine_handle->getQueryResult();
    }
}
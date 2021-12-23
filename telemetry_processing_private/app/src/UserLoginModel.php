<?php
/**
 * UserLoginModel.php
 *
 * Utilises Doctrine and Bcrypt to authenticate users.
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

class UserLoginModel implements \TelemProc\UserModelInterface
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

    /** @var array $user_credentials Contains user-entered login credentials. */
    private array $user_credentials;

    /** @var bool $login_result Stores result for authentication. */
    private bool $login_result;

    public function __construct()
    {
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->bcrypt_handle = null;
        $this->bcrypt_settings = array();
        $this->logger_handle = null;
        $this->user_credentials = array();
        $this->login_result = false;
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
     * Sets login credentials
     *
     * @param array $user_credentials
     */
    public function setCredentials(array $user_credentials) : void
    {
        $this->user_credentials = $user_credentials;
    }

    /**
     * Returns result from login operation.
     *
     * @return bool
     */
    public function getResult() : bool
    {
        return $this->login_result;
    }

    /**
     * Authenticates user and creates persistent session.
     *
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    public function loginUser() : void
    {
        $login_result = false;

        if ($this->verifyUser() !== false) {
//            $this->createSession(); /** @TODO SessionWrapper */
            $login_result = true;
        }

        $this->login_result = $login_result;
    }

    /**
     * Verifies that a user's credentials are valid.
     *
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    private function verifyUser() : bool
    {
        $verify_result = false;

        $user_name = $this->user_credentials['username'];
        $user_password = $this->user_credentials['password'];

        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        $this->doctrine_handle->setQueryBuilder($query_builder);

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        $this->doctrine_handle->fetchUserPassword($user_name);
        $query_result = $this->doctrine_handle->getQueryResult();

        if (!empty($query_result)) {
            $fetched_password = $query_result[0]['password'];

            $this->bcrypt_handle->setBcryptSettings($this->bcrypt_settings);
            $verify_result = $this->bcrypt_handle->verifyPassword($user_password, $fetched_password);
        }

        return $verify_result;
    }

    /**
     * Subsequently creates a session once a user is successfully verified.
     * @TODO Create SessionWrapper.
     */
    private function createSession() : bool {}
}
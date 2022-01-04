<?php
/**
 * RegisterModel.php
 *
 * Allows users to register their information.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class RegisterModel
{
    /** @var resource $bcrypt_wrapper Contains the handle to <Bcrypt>. */
    private $bcrypt_wrapper;

    /** @var resource $doctrine_wrapper Contains the handle to <Doctrine>.*/
    private $doctrine_wrapper;

    /** @var resource $logger_handle Contains handle to <Monolog>. */
    private $logger_handle;

    /** @var array $register_credentials Contains user-entered credentials. */
    private $register_credentials;

    /** @var bool $register_result Contains the result from registration. */
    private $register_result;

    public function __construct()
    {
        $this->bcrypt_wrapper = null;
        $this->doctrine_wrapper = null;
        $this->logger_handle = null;
        $this->register_credentials = array();
        $this->register_result = false;
    }

    public function __destruct() {}

    /**
     * Sets <Bcrypt> wrapper
     *
     * @param $bcrypt_wrapper
     */
    public function setBcryptWrapper($bcrypt_wrapper) : void
    {
        $this->bcrypt_wrapper = $bcrypt_wrapper;
    }

    /**
     * Sets <Doctrine> wrapper
     *
     * @param $doctrine_wrapper
     */
    public function setDoctrineWrapper($doctrine_wrapper) : void
    {
        $this->doctrine_wrapper = $doctrine_wrapper;
    }

    /**
     * Sets <Monolog> handle.
     *
     * @param $logger_handle
     */
    public function setLoggerHandle($logger_handle) : void
    {
        $this->logger_handle = $logger_handle;
    }

    /**
     * Sets register credentials
     *
     * @param array $register_credentials
     */
    public function setRegisterCredentials(array $register_credentials) : void
    {
        $this->register_credentials = $register_credentials;
    }

    /**
     * Returns result for user registration.
     *
     * @return bool
     */
    public function getRegisterResult() : bool
    {
        return $this->register_result;
    }

    /**
     * Using the Logger handle, produce a log of level NOTICE
     * Optional parameters in $additional if more information is needed.
     *
     * @param string $log_message
     * @param array|null $additional
     */
    private function logEvent(string $log_message, ?array $additional = null) : void
    {
        if ($additional !== null) {
            $this->logger_handle->notice($log_message, $additional);
        } else {
            $this->logger_handle->notice($log_message);
        }
    }

    /**
     * Registers new users. Returns true if registered successfully and false if not.
     * Will not allow multiple accounts of the same username and will return false if attempted.
     */
    public function register() : void
    {
        $register_result = false;

        // Check if account with username already exists
        $username = $this->register_credentials['username'];

        if (!empty($username)) {
            $this->doctrine_wrapper->checkIfUsernameAvailable($username);
            $is_available = $this->doctrine_wrapper->getQueryResult();

            // Hash password
            if ($is_available) {
                $password = $this->register_credentials['password'];
                $hashed_password = $this->bcrypt_wrapper->createHashedPassword($password);

                // Store new user details
                if (!empty($hashed_password)) { // If hash of password hasn't failed
                    $this->doctrine_wrapper->storeUserDetails($username, $hashed_password);
                    $register_result = $this->doctrine_wrapper->getQueryResult();
                }
            }
        }

        // Log Successful Registration
        if ($register_result !== false
            && $this->logger_handle !== null) {
                $this->logEvent('User Registration', array($this->register_credentials['username']));
        }

        $this->register_result = $register_result;
    }
}
<?php
/**
 * ManageUsersModel.php
 *
 * Provides a model to retrieve and delete registered users.
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

class ManageUsersModel
{
    /** @var resource $bcrypt_handle Contains handle to <Bcrypt>. */
    private $bcrypt_handle;

    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_handle;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private array $doctrine_settings;

    /** @var resource $logger_handle Contains handle for <TelemetryLogger> */
    private $logger_handle;

    /** @var null $manage_user_result Contains result from query to retrieve telemetry data/ */
    private $manage_user_result;

    public function __construct()
    {
        $this->bcrypt_handle = null;
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->logger_handle = null;
        $this->manage_user_result = null;
    }

    public function __destruct() {}

    /**
     * Sets handle to <Bcrypt>.
     *
     * @param $bcrypt_handle
     * @return void
     */
    public function setBcryptHandle($bcrypt_handle) : void
    {
        $this->bcrypt_handle = $bcrypt_handle;
    }

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
     * Sets database connection settings for <Doctrine>.
     *
     * @param array $doctrine_settings
     */
    public function setDatabaseSettings(array $doctrine_settings) : void
    {
        $this->doctrine_settings = $doctrine_settings;
    }

    /**
     * Sets handle to <Monolog> logger.
     *
     * @param $logger_handle
     */
    public function setLoggerHandle($logger_handle) : void
    {
        $this->logger_handle = $logger_handle;
    }

    /**
     * Returns result from queries to retrieve all and delete specific users.
     */
    public function getResult()
    {
        return $this->manage_user_result;
    }

    /**
     * Retrieves all currently stored/registered users.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function retrieveRegisteredUsers() : void
    {
        $retrieve_result = array();

        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        $this->doctrine_handle->setQueryBuilder($query_builder);

        $this->doctrine_handle->fetchAllUsers();

        $retrieve_result = $this->doctrine_handle->getQueryResult();

        $this->manage_user_result = $retrieve_result;
    }

    /**
     * Deletes a specific user by username, using <Doctrine>.
     *
     * @param string $cleaned_username
     * @throws \Doctrine\DBAL\Exception
     */
    public function deleteRegisteredUser(string $cleaned_username) : void
    {
        $delete_user = false;

        if (!empty($cleaned_username)
        && $this->checkUserAvailability($cleaned_username) !== true) {
            $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
            $query_builder = $dbal_connection->createQueryBuilder();

            if ($this->logger_handle !== null) {
                $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
            }

            $this->doctrine_handle->setQueryBuilder($query_builder);

            $this->doctrine_handle->deleteUser($cleaned_username);

            $delete_user = $this->doctrine_handle->getQueryResult();
        }

        $this->manage_user_result = $delete_user;
    }

    /**
     * Changes the password of an existing user using <Doctrine>.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function changeUserPassword(array $cleaned_parameters) : void
    {
        $user_password_changed = false;

        if (!empty($cleaned_parameters)
        && $this->checkUserAvailability($cleaned_parameters['username']) !== true) {
            if ($this->bcrypt_handle !== null) {
                $hashed_password = $this->bcrypt_handle->createHashedPassword(
                    $cleaned_parameters['password']
                );

                $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
                $query_builder = $dbal_connection->createQueryBuilder();

                if ($this->logger_handle !== null) {
                    $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
                }

                $this->doctrine_handle->setQueryBuilder($query_builder);

                $this->doctrine_handle->changeUserPassword(
                    $cleaned_parameters['username'],
                    $hashed_password
                );

                $user_password_changed = $this->doctrine_handle->getQueryResult();
            }
        }

        $this->manage_user_result = $user_password_changed;
    }

    /**
     * Checks for the existence of a specific username prior to deletion.
     *
     * @param string $cleaned_username
     * @return bool
     * @throws \Doctrine\DBAL\Exception
     */
    private function checkUserAvailability(string $cleaned_username) : bool
    {
        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        $this->doctrine_handle->setQueryBuilder($query_builder);

        $this->doctrine_handle->checkIfUsernameAvailable($cleaned_username);

        return $this->doctrine_handle->getQueryResult();
    }
}
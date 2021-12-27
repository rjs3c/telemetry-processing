<?php
/**
 * DoctrineWrapper.php
 *
 * Provides a wrapper for Doctrine functionalities.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class DoctrineWrapper
{
    /** @var resource $doctrine_logger Contains handle to <telemetryLogger>. */
    private $doctrine_logger;

    /** @var resource $query_builder Stores Doctrine's QueryBuilder Object. */
    private $query_builder;

    /** @var mixed $query_result Stores the result of an executed SQL query. */
    private $query_result;

    public function __construct()
    {
        $this->doctrine_logger = null;
        $this->query_builder = null;
        $this->query_result = null;
    }

    public function __destruct() {}

    /**
     * Sets handle for <Doctrine>.
     *
     * @param $doctrine_logger
     */
    public function setDoctrineLogger($doctrine_logger) : void
    {
        $this->doctrine_logger = $doctrine_logger;
    }

    /**
     * Sets QueryBuilder object.
     *
     * @param $query_builder
     */
    public function setQueryBuilder($query_builder) : void
    {
        $this->query_builder = $query_builder;
    }

    /**
     * Returns result from executed SQL queries.
     *
     * @return mixed|null
     */
    public function getQueryResult()
    {
        return $this->query_result;
    }

    /**
     * Using the Logger handle, produce a log of level ERROR
     * Optional parameters in $additional if more information is needed
     *
     * @param string $log_message
     * @param array|null $additional
     */
    private function logDoctrineError(string $log_message, ?array $additional = null) : void
    {
        if ($additional !== null) {
            $this->doctrine_logger->error($log_message, $additional);
        } else {
            $this->doctrine_logger->error($log_message);
        }
    }

    /**
     * Utilises <Doctrine> to store all fetched, parsed and validated telemetry data within the telemetry_data table.
     *
     * @param array $cleaned_message
     */
    public function storeTelemetryData(array $cleaned_message) : void
    {
        $store_result = array();

        $sender_number = $cleaned_message['MSDN'];
        $switches = $cleaned_message['SW'];
        $fan = $cleaned_message['FN'];
        $temperature = $cleaned_message['TMP'];
        $keypad = $cleaned_message['KP'];

        $switch_one = $switches['SW1'];
        $switch_two = $switches['SW2'];
        $switch_three = $switches['SW3'];
        $switch_four = $switches['SW4'];

        try {
            if ($this->checkDuplicateData($cleaned_message) !== true) {
                $query_builder = $this->query_builder
                    ->insert('telemetry_data')
                    ->values(array(
                        'sender_number' => ':sender_number',
                        'switch_one' => ':switch_one',
                        'switch_two' => ':switch_two',
                        'switch_three' => ':switch_three',
                        'switch_four' => ':switch_four',
                        'fan' => ':fan',
                        'temperature' => ':temperature',
                        'keypad' => ':keypad',
                    ))
                    ->setParameters(array(
                        'sender_number' => $sender_number,
                        'switch_one' => $switch_one,
                        'switch_two' => $switch_two,
                        'switch_three' => $switch_three,
                        'switch_four' => $switch_four,
                        'fan' => $fan,
                        'temperature' => $temperature,
                        'keypad' => $keypad,
                    ));

                $store_result = $query_builder->execute();
            }
        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            $this->query_result = $store_result;
        }
    }

    /**
     * Checks the telemetry_data table for any duplicate records.
     *
     * @param array $cleaned_message
     * @return bool
     */
    private function checkDuplicateData(array $cleaned_message) : bool
    {
        $duplication_result = false;

        $sender_number = $cleaned_message['MSDN'];
        $switches = $cleaned_message['SW'];
        $fan = $cleaned_message['FN'];
        $temperature = $cleaned_message['TMP'];
        $keypad = $cleaned_message['KP'];

        $switch_one = $switches['SW1'];
        $switch_two = $switches['SW2'];
        $switch_three = $switches['SW3'];
        $switch_four = $switches['SW4'];

        try {
            $query_builder = $this->query_builder
                ->select('d.*')
                ->from('telemetry_data', 'd')
                ->where('d.sender_number = :sender_number')
                ->andWhere('d.switch_one = :switch_one')
                ->andWhere('d.switch_two = :switch_two')
                ->andWhere('d.switch_three = :switch_three')
                ->andWhere('d.switch_four = :switch_four')
                ->andWhere('d.fan = :fan')
                ->andWhere('d.temperature = :temperature')
                ->andWhere('d.keypad = :keypad')
                ->setParameters(array(
                    'sender_number' => $sender_number,
                    'switch_one' => $switch_one,
                    'switch_two' => $switch_two,
                    'switch_three' => $switch_three,
                    'switch_four' => $switch_four,
                    'fan' => $fan,
                    'temperature' => $temperature,
                    'keypad' => $keypad
                ));

            $duplicate_retrieval = $query_builder->execute();

            $duplication_result = !empty((bool)$duplicate_retrieval->fetchAll());
        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            return $duplication_result;
        }
    }

    /**
     * Uses <Doctrine> to retrieve all stored telemetry data from the telemetry_data table.
     */
    public function fetchTelemetryData() : void
    {
        $retrieve_result = array();

        try {
            $query_builder = $this->query_builder
                ->select('d.*')
                ->from('telemetry_data', 'd')
                ->orderBy('d.timestamp', 'DESC');

            $query = $query_builder->execute();
            $retrieve_result = $query->fetchAll();

        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            $this->query_result = $retrieve_result;
        }
    }

    /**
     * Uses <Doctrine> to fetch the password of the given username
     *
     * @param $username
     */
    public function fetchUserPassword($username) : void
    {
        $password = null;

        try {
            $query_builder = $this->query_builder
                ->select('u.password')
                ->from('telemetry_users', 'u')
                ->where('u.username = :username')
                ->setParameters(array(
                    'username' => $username,
                ));

            $query = $query_builder->execute();
            $password = $query->fetchAll();

        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            $this->query_result = $password;
        }

    }

    /**
     * Uses <Doctrine> to store new user details
     *
     * @param $username
     * @param $password
     */
    public function storeUserDetails($username, $password) : void
    {
        $store_result = false;

        try{
            $query_builder = $this->query_builder
                ->insert('telemetry_users')
                ->values(array(
                    'username' => ':username',
                    'password' => ':password'
                ))
                ->setParameters(array(
                    'username' => $username,
                    'password' => $password
                ));

            $store_result = $query_builder->execute();

            if ($store_result == 1) {
                $store_result = true;
            } else {
                $store_result = false;
            }
        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            $this->query_result = $store_result;
        }
    }

    /**
     * Uses <Doctrine> to check if a given username is available when registering.
     *
     * @param $username
     */
    public function checkIfUsernameAvailable($username) : void
    {
        $is_available = false;

        try {
            $query_builder = $this->query_builder
                ->select('u.*')
                ->from('telemetry_users', 'u')
                ->where('u.username = :username')
                ->setParameters(array(
                    'username' => $username,
                ));

            $query = $query_builder->execute();
            $result = $query->fetchAll();

            if (empty($result)) { // If empty, username is available
                $is_available = true;
            }
        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        } finally {
            $this->query_result = $is_available;
        }
    }
}

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
            $query_builder = $this->query_builder->insert('telemetry_data')
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

        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        }

        $this->query_result = $store_result;
    }

    public function fetchTelemetryData($queryBuilder) : void
    {
        $retrieve_result = array();

        try {
            $queryBuilder
                ->select('d.*')
                ->from('telemetry_data', 'd')
                ->orderBy('d.timestamp', 'DESC')
                ->setMaxResults(2);

            //select * from tbl_name order by id desc limit N;

            $query = $queryBuilder->execute();
            $retrieve_result = $query->fetchAll();
            //$result['outcome'] = $query;

        } catch (\Exception $exception) {
            if ($this->doctrine_logger !== null) {
                $this->logDoctrineError('Doctrine Error', array($exception->getMessage()));
            }
        }

        $this->query_result = $retrieve_result;
    }

}
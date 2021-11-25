<?php
/**
 * DatabaseWrapper.php
 *
 * Provides a wrapper for DBMS operations.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class DatabaseWrapper
{
    /** @var array $database_settings Contains the DBMS Settings. */
    private $database_settings;

    /** @var resource $db_handle Contains the handle for PDO. */
    private $db_handle;

    /** @var resource $prepared_statement Contains handle for PDO operations. */
    private $prepared_statement;

    /** @var resource $db_logger Contains handle to <telemetryLogger>. */
    private $db_logger;

    public function __construct()
    {
        $this->database_settings = array();
        $this->db_handle = null;
        $this->prepared_statement = null;
        $this->db_logger = null;
    }

    public function __destruct() {}

    /**
     * Sets Database Settings.
     *
     * @param array $database_connection_settings
     */
    public function setDatabaseSettings(array $database_connection_settings) : void
    {
        $this->database_settings = $database_connection_settings;
    }

    /**
     * Sets handle for <telemetryLogger>.
     *
     * @param $db_logger
     */
    public function setDBLogger($db_logger) : void
    {
        $this->db_logger = $db_logger;
    }

    /**
     * Using the Logger handle, produce a log of level ERROR
     * Optional parameters in $additional if more information is needed
     *
     * @param string $log_message
     * @param array|null $additional
     */
    private function logDBError(string $log_message, ?array $additional = null) : void
    {
        if ($additional !== null) {
            $this->db_logger->error($log_message, $additional);
        } else {
            $this->db_logger->error($log_message);
        }
    }

    /**
     * Creates Database Connection and sets Handle.
     */
    public function createDatabaseHandle() : void
    {
        $database_settings = $this->database_settings;
        $rdbms_host = $database_settings['rdbms'] . ':host=' . $database_settings['db_host'] . ';port=' . $database_settings['db_port'];
        $db_name = ';dbname=' . $database_settings['db_name'];
        $rdbms_information = $rdbms_host . $db_name;
        $db_user_name = $database_settings['db_user_name'];
        $db_user_password = $database_settings['db_user_password'];
        $pdo_attributes = $database_settings['pdo_attributes'];

        try {
            $pdo_handle = new \PDO($rdbms_information, $db_user_name, $db_user_password, $pdo_attributes);
            $this->db_handle = $pdo_handle;
        } catch (\PDOException $e) {
            $this->logDBError('PDO Error', array($e->getMessage()));
        }
    }

    /**
     * @param $query_string
     * @param null $params
     */
    private function safeQuery($query_string, $query_params = null) : void
    {
        try
        {
            $this->prepared_statement = $this->db_handle->prepare($query_string);
            $this->prepared_statement->execute($query_params);
        }
        catch (\PDOException $e)
        {
            $this->logDBError('PDO Error', array($e->getMessage()));
        }
    }

    /**
     * Returns record in the form of an array.
     *
     * @return array
     */
    public function safeFetchQueryRow() : array
    {
        return $this->prepared_statement->fetch(\PDO::FETCH_NUM);
    }

    /**
     * Returns array with indexed columns.
     *
     * @return array
     */
    public function safeFetchQueryArray() : array
    {
        $row = $this->prepared_statement->fetch(\PDO::FETCH_ASSOC);
        $this->prepared_statement->closeCursor();
        return $row;
    }

    /**
     * Returns row count in query.
     *
     * @return int
     */
    public function countQueryRows() : int
    {
        return $this->prepared_statement->rowCount();
    }
}
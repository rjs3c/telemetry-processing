<?php

namespace TelemProc;

class TelemetryModel
{
    private $telemetry_data;
    private $storage_result;
    private $database_wrapper;
    private $database_connection_settings;
    private $logger;
    private $sql_queries;

    public function __construct()
    {
        $this->telemetry_data = null;
        $this->storage_result = null;
        $this->database_wrapper = null;
        $this->database_connection_settings = null;
        $this->sql_queries = null;
        $this->logger = null;
    }

    public function __destruct() { }

    public function setTelemetryData($telemetry_data)
    {
        $this->telemetry_data = $telemetry_data;
    }

    public function setDatabaseWrapper($database_wrapper)
    {
        $this->database_wrapper = $database_wrapper;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function getStorageResult()
    {
        return $this->storage_result;
    }

    public function storeTelemetryDataInDatabase()
    {
        $store_result = false;

        $this->database_wrapper->setSqlQueries($this->sql_queries);
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->SetLogger($this->logger);
        $this->database_wrapper->makeDatabaseConnection();

        $store_result = $this->database_wrapper->storeTelemetryData($this->telemetry_data);

        if ($store_result !== false)
        {
            $store_result = true;
        }
        return $store_result;
    }

    private function retrieveTelemetryDataFromDatabase()
    {
        $retrieved_values = [];
        $this->database_wrapper->setSqlQueries($this->sql_queries);
        $this->database_wrapper->setDatabaseConnectionSettings($this->database_connection_settings);
        $this->database_wrapper->SetLogger($this->logger);
        $this->database_wrapper->makeDatabaseConnection();

        return $retrieved_values;
    }
}
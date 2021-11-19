<?php


namespace TelemProc;

use PDO;
use PDOException;

class DatabaseWrapper
{
    private $database_connection_settings;
    private $db_handle;
    private $sql_queries;
    private $prepared_statement;
    private $errors;
    private $session_logger;
    private $telemetry_data;

    public function __construct()
    {
        $this->database_connection_settings = null;
        $this->db_handle = null;
        $this->sql_queries = null;
        $this->prepared_statement = null;
        $this->logger = null;
        $this->errors = [];
    }

    public function __destruct() { }

    public function setDatabaseConnectionSettings($database_connection_settings)
    {
        $this->database_connection_settings = $database_connection_settings;
    }

    public function setSqlQueries($sql_queries)
    {
        $this->sql_queries = $sql_queries;
    }

    public function setTelemetryData($telemetry_data){
      $this->telemetry_data = $telemetry_data;
    }

public function setLogger($logger)
{
    $this->logger = $logger;
}

public function makeDatabaseConnection()
{
    $pdo_error = '';

    $database_settings = $this->database_connection_settings;
    $host_name = $database_settings['rdbms'] . ':host=' . $database_settings['host'];
    $port_number = ';port=' . '3306';
    $user_database = ';dbname=' . $database_settings['db_name'];
    $host_details = $host_name . $port_number . $user_database;
    $user_name = $database_settings['user_name'];
    $user_password = $database_settings['user_password'];
    $pdo_attributes = $database_settings['options'];

    try
    {
        $pdo_handle = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
        $this->db_handle = $pdo_handle;
        $this->session_logger->notice('Successfully connected to database');
    }
    catch (PDOException $exception_object)
    {
        trigger_error('error connecting to database');
        $pdo_error = 'error connecting to database';
        $this->session_logger->warning('Error connecting to database');
    }

    return $pdo_error;
}

public function storeTelemetryData(){

    $query_string = $this->sql_queries->insertTelemetryData();

    $query_parameters = [

        ':sender_name' => $this->telemetry_data['sender_name'],
        ':sender_number' => $this->telemetry_data['sender_number'],
        ':sender_email' => $this->telemetry_data['sender_email'],
        ':sender_group' => $this->telemetry_data['sender_group'],
        ':switch_one' => $this->telemetry_data['switch_one'],
        ':switch_two' => $this->telemetry_data['switch_two'],
        ':switch_three' => $this->telemetry_data['switch_three'],
        ':switch_four' => $this->telemetry_data['switch_four'],
        ':fan' => $this->telemetry_data['fan'],
        ':temperature' => $this->telemetry_data['temperature'],
        ':keypad' => $this->telemetry_data['keypad']
    ];

    return $this->safeQuery($query_string, $query_parameters);

}


private function safeQuery($query_string, $params = null)
{
    $this->errors['db_error'] = false;
    $query_parameters = $params;

    try
    {
        $this->prepared_statement = $this->db_handle->prepare($query_string);
        $execute_result = $this->prepared_statement->execute($query_parameters);
        $this->errors['execute-OK'] = $execute_result;
        $this->session_logger->notice('Successfully connected to database');
    }
    catch (PDOException $exception_object)
    {
        $error_message  = 'PDO Exception caught. ';
        $error_message .= 'Error with the database access.' . "\n";
        $error_message .= 'SQL query: ' . $query_string . "\n";
        $error_message .= 'Error: ' . var_dump($this->prepared_statement->errorInfo(), true) . "\n";
        // NB would usually log to file for sysadmin attention
        $this->errors['db_error'] = true;
        $this->errors['sql_error'] = $error_message;
        $this->session_logger->warning('Error connecting to database');
    }
    return $this->errors['db_error'];
}

}
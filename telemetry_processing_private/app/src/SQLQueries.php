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

class SQLQueries
{
    public function __construct() {}

    public function __destruct() {}

    /**
     * Returns query string for inserting telemetry data.
     *
     * @return string
     */
    public static function insertTelemetryData() : string
    {
        $sql_query  = "INSERT INTO telemetry_data ";
        $sql_query .= "SET sender_name = :sender_name, ";
        $sql_query .= "sender_number = :sender_number, ";
        $sql_query .= "sender_email = :sender_email, ";
        $sql_query .= "sender_group = :sender_group, ";
        $sql_query .= "switch_one = :switch_one, ";
        $sql_query .= "switch_two = :switch_two, ";
        $sql_query .= "switch_three = :switch_three, ";
        $sql_query .= "switch_four = :switch_four, ";
        $sql_query .= "fan = :fan, ";
        $sql_query .= "temperature = :temperature, ";
        $sql_query .= "keypad = :keypad";

        return $sql_query;
    }

    /**
     * Returns query string for retrieving telemetry data.
     *
     * @return string
     */
    public static function getTelemetryData() : string
    {
        $sql_query  = "SELECT * ";
        $sql_query .= "FROM telemetry_db ";
        // $sql_query .= "WHERE session_id = :local_session_id ";
        // $sql_query .= "AND session_var_name = :session_var_name";

        //To be updated when needed depending on what we choose to display to the user

        return $sql_query;
    }
}
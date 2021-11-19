<?php


namespace TelemProc;

class SQLQueries
{
    public function __construct() {}

    public function __destruct() {}

    public static function insertTelemetryData()
    {
        $query_string  = "INSERT INTO telemetry_data ";
        $query_string .= "SET sender_name = :sender_name, ";
        $query_string .= "sender_number = :sender_number, ";
        $query_string .= "sender_email = :sender_email, ";
        $query_string .= "sender_group = :sender_group, ";
        $query_string .= "switch_one = :switch_one, ";
        $query_string .= "switch_two = :switch_two, ";
        $query_string .= "switch_three = :switch_three, ";
        $query_string .= "switch_four = :switch_four, ";
        $query_string .= "fan = :fan, ";
        $query_string .= "temperature = :temperature, ";
        $query_string .= "keypad = :keypad";

        return $query_string;
    }

    public static function getTelemetryData()
    {
        $query_string  = "SELECT * ";
        $query_string .= "FROM telemetry_db ";
        // $query_string .= "WHERE session_id = :local_session_id ";
        // $query_string .= "AND session_var_name = :session_var_name";

        //To be updated when needed depending on what we choose to display to the user

        return $query_string;
    }
}
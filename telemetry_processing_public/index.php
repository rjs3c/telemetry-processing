<?php
/**
 * Index.php
 *
 * A Program to Parse, Store and Display Telemetry SMS Data.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/* Debugging Ini Parameters */
ini_set('xdebug.trace_output_name', 'telemetry_processing');
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_format', 1);

if (function_exists(xdebug_start_trace()))
{
    xdebug_start_trace();
}

include 'telemetry_processing/bootstrap.php';

if (function_exists(xdebug_stop_trace()))
{
    xdebug_stop_trace();
}
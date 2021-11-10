<?php
/**
 * Settings.php
 *
 * Contains all application settings and constants.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/* Ini Configurations */
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.trace_output_name', 'telemetry_processing.%t');
ini_set('xdebug.trace_format', '1');

/* Pre-amble */
$css_file_name = '';
$css_path = dirname($_SERVER['SCRIPT_NAME'] . '/css/' . $css_file_name);

$log_path = '/p3t/phpappfolder/logs/';

$settings = array(

);

$soap_settings = array(
    'wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',
    'attributes' => array(
        'trace' => true,
        'exceptions' => true
    )
);

/* Constants */
define('CSS_PATH', $css_path);
define('LOG_PATH', $log_path);
define('SOAP_SETTINGS', $soap_settings);

return $settings;
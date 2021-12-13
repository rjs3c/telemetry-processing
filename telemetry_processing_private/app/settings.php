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

/** Ini Configurations and XDebug. **/
ini_set('display_errors', 'On');
ini_set('html_errors', 'On');
ini_set('xdebug.profiler_output_name', 'telemetry_processing.%t');
ini_set('xdebug.profiler_enable', '1'); # Set to '1' to enable!
ini_set('xdebug.trace_output_name', 'telemetry_processing.%t');
ini_set('xdebug.trace_format', '1');

/** Paths needed for <CSS>, <Twig> and <Monolog>. **/
$app_path = '/app/';
$app_title = 'Telemetry Processing';
$cache_path = __DIR__ . '/cache/';
$css_file_name = ''; // CSS file name needed here.
$css_path = dirname($_SERVER['SCRIPT_NAME'] . '/css/' . $css_file_name);
$template_path = __DIR__ . '/templates/';
$log_path = '/p3t/phpappfolder/logs/';

/** Constants for <CSS>, <Twig> and <Monolog> paths. **/
define('APP_PATH', $app_path);
define('APP_TITLE', $app_title);
define('CACHE_PATH', $cache_path);
define('CSS_PATH', $css_path);
define('TEMPLATE_PATH', $template_path);
define('LOG_PATH', $log_path);

/** Settings for <Twig> (telemetryView), <PDO> (databaseSettings) and <SOAPClient> (soapSettings). **/
return array(
    'telemetrySettings' => array(
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'telemetryView' => array(
            'twig_attributes' => array(
                'cache' => CACHE_PATH,
                'auto_reload' => true,
            )
        ),
        'soapSettings' => array(
            'ee_m2m_username' => '', # Enter your own details!
            'ee_m2m_password' => '', # Enter your own details!
            'ee_m2m_phone_number' => '+447817814149',
            'wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',
            'soap_attributes' => array(
                'trace' => true,
                'exceptions' => true
            )
        ),
        'doctrineSettings' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'telemetry_db',
            'port' => '3306',
            'user' => 'telemetry_user',
            'password' => 'telemetry_user_pass',
            'charset' => 'utf8'
        ],
    )
);

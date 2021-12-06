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
$css_file_name = ''; // CSS file name needed here.
$css_path = dirname($_SERVER['SCRIPT_NAME'] . '/css/' . $css_file_name);
$template_path = __DIR__ . '/templates/';
$log_path = '/p3t/phpappfolder/logs/';

/** Constants for <CSS>, <Twig> and <Monolog> paths. **/
define('APP_PATH', $app_path);
define('APP_TITLE', $app_title);
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
                'cache' => false,
                'auto_reload' => true,
            )
        ),
        'databaseSettings' => array(
            'rdbms' => 'mysql',
            'db_host' => 'localhost',
            'db_port' => '3306',
            'db_name' => 'telemetry_db',
            'db_user_name' => 'telemetry_user',
            'db_user_password' => 'telemetry_user_pass',
            'db_encoding' => 'utf8',
            'db_collation' => 'utf8_unicode_ci',
            'pdo_attributes' => array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
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
        )
    )
);

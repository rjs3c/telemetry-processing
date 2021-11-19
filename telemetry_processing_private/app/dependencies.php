<?php
/**
 * dependencies.php
 *
 * Sets up DIC for SLIM.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/**
 * External namespaces from <Slim>, <Twig> and <Monolog>.
 */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extension\DebugExtension;

/**
 * <Monolog> Functionality.
 */
$container['telemetryLogger'] = function () {
    $telemetry_logger = new Logger('telemetryLogger');

    /* Logs of level NOTICE */
    $log_notice_name = 'telemetry_processing_notice.log';
    $log_notice_path = LOG_PATH . $log_notice_name;
    $notice_stream_handler = new StreamHandler($log_notice_path, Logger::NOTICE);

    /* Logs of level ERROR */
    $log_error_name = 'telemetry_processing_error.log';
    $log_error_path = LOG_PATH . $log_error_name;
    $error_stream_handler = new StreamHandler($log_error_path, Logger::ERROR);

    $telemetry_logger->pushHandler($notice_stream_handler);
    $telemetry_logger->pushHandler($error_stream_handler);

    return $telemetry_logger;
};

/**
 * <Twig> Functionality.
 */
$container['telemetryView'] = function ($container) {
    $telemetry_view = new Twig(
        TEMPLATE_PATH,
        $container['telemetrySettings']['telemetryView']['twig_attributes']
    );

    $base_uri = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/'); // Seek a replacement
    $router = $container['router'];
    $telemetry_view->addExtension(new TwigExtension($router, $base_uri));

    $telemetry_view->addExtension(new DebugExtension());

    return $telemetry_view;
};

/**
 * <SOAP> Functionality.
 */
$container['soapWrapper'] = function () {
    return new \TelemProc\SoapWrapper();
};

$container['telemetryModel'] = function () {
    return new \TelemProc\TelemetryModel();
};

$container['sqlQueries'] = function () {
    return new \TelemProc\SQLQueries();
};

$container['databaseWrapper'] = function () {
    return new \TelemProc\DatabaseWrapper();
};

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

/** Specific Components within <TelemProc> namespace. */
use TelemProc\DatabaseWrapper;
use TelemProc\SoapWrapper;
use TelemProc\TelemetryWrapper;
use TelemProc\TelemetryModel;
use TelemProc\TelemetryParser;
use TelemProc\TelemetryValidator;

$container['databaseWrapper'] = function () {
    return new DatabaseWrapper();
};

$container['soapWrapper'] = function () {
    return new SoapWrapper();
};

$container['telemetryWrapper'] = function () {
    return new TelemetryWrapper();
};

$container['telemetryModel'] = function () {
    return new TelemetryModel();
};

$container['telemetryParser'] = function () {
    return new TelemetryParser();
};

$container['telemetryValidator'] = function () {
    return new TelemetryValidator();
};

/** External namespaces from <Slim>, <Twig> and <Monolog>. */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

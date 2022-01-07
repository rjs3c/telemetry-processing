<?php
/**
 * bootstrap.php
 *
 * A Program to Parse, Store and Display Telemetry SMS Data.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/** Creates a Session. */
session_start();

/** Regenerates Session ID at each page within application. */
session_regenerate_id(true);

/** <PSR-4> Autoloading using <Composer>. */
require 'vendor/autoload.php';

/** Settings File - Global Constants and Configurations. */
$settings = require __DIR__ . '/app/' . 'settings.php';

/** Points to relative /app/ directory. */
$app_path = __DIR__ . APP_PATH;

///** XDebug Start Trace/Profiling */
//if (function_exists(xdebug_start_trace()))
//{
//    xdebug_start_trace();
//}

/** Instantiation of Slim DIC. */
$container = new \Slim\Container($settings);

/** Dependencies File - Using DIC Containers for different classes. */
require $app_path . 'dependencies.php';

/** Instantiation of Slim App. */
$app = new \Slim\App($container);

/** Routes File - provides different routes. */
require $app_path . 'routes.php';

$app->run();

///** XDebug Stop Trace/Profiling */
//if (function_exists(xdebug_stop_trace()))
//{
//    xdebug_stop_trace();
//}
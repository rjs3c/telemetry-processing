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

/** <PSR-4> Autoloading using <Composer>. */
require 'vendor/autoload.php';

/** Points to relative /app/ directory. */
$app_path = __DIR__ . '/app/';

/** Settings File - Global Constants and Configurations. */
$settings = require $app_path . 'settings.php';

/** XDebug Start Trace/Profiling */
if (function_exists(xdebug_start_trace()))
{
    xdebug_start_trace();
}

/** Instantiation of Slim DIC. */
$container = new \Slim\Container($settings);

/** Dependencies File - Using DIC Containers for different classes. */
require $app_path . 'dependencies.php';

/** Instantiation of Slim App. */
$app = new \Slim\App($container);

/** Routes File - provides different routes. */
require $app_path . 'routes.php';

$app->run();

/** XDebug Stop Trace/Profiling */
if (function_exists(xdebug_stop_trace()))
{
    xdebug_stop_trace();
}
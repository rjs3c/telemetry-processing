<?php
/**
 * boostrap.php
 *
 * A Program to Parse, Store and Display Telemetry SMS Data.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

require 'vendor/autoload.php';

/* Points to /app/ directory */
$app_path = __DIR__ . '/app/';

/* Settings File - Global Constants and Configurations */
$settings = require $app_path . 'settings.php';

$container = new \Slim\Container($settings);

/* Dependencies File - Using DIC Containers for different classes */
require $app_path . 'dependencies.php';

$app = new \Slim\App($container);

/* Routes File - provides different routes */
require $app_path . 'routes.php';

$app->run();
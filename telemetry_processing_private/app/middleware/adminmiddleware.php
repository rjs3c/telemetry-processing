<?php
/**
 * adminmiddleware.php
 *
 * Provides middleware to check if a user is an administrator.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

$container = $app->getContainer();

// Get Wrappers, Settings + Middleware
$authentication_validator = $container->get('authenticationValidator');
$session_wrapper = $container->get('sessionWrapper');
$doctrine_wrapper = $container->get('doctrineWrapper');
$database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];
$middleware = $container->get('adminMiddleware');

// Set Wrappers + Settings in Middleware
$middleware->setAuthenticationValidator($authentication_validator);
$middleware->setDoctrineWrapper($doctrine_wrapper);
$middleware->setDoctrineSettings($database_connection_settings);
$middleware->setSessionWrapper($session_wrapper);

// Add Middleware to $app
$app->add($middleware);
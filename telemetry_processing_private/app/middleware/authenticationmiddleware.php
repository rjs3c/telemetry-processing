<?php
/**
 * authenticationmiddleware.php
 *
 * Provides middleware to check if a user is authenticated.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

$container = $app->getContainer();

// Get Wrapper + Middleware
$session_wrapper = $container->get('sessionWrapper');
$middleware = $container->get('authenticationMiddleware');

// Set Wrappers in Middleware
$middleware->setSessionWrapper($session_wrapper);

// Add Middleware to $app
$app->add($middleware);
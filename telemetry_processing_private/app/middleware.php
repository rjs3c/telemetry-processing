<?php
/**
 * middleware.php
 *
 * Contains all application middleware.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/* Middleware to check if a user is authenticated */
require 'middleware/authenticationmiddleware.php';

/* Middleware to check if a user is of administrator status */
require 'middleware/adminmiddleware.php';
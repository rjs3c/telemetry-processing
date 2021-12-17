<?php
/**
 * routes.php
 *
 * Contains all application routes.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

/* Homepage */
require 'routes/homepage.php';

/* Retrieval of Telemetry Data */
require 'routes/fetchtelemetrydata.php';

/* Presenting of Stored Telemetry Data */
require 'routes/presenttelemetrydata.php';

/* Interface to send telemetry data back to circuit board */
require 'routes/sendtelemetrydataform.php';

/* Presenting the form for users to login */
require 'routes/loginform.php';

/* Presenting the form for users to register for an account */
require 'routes/registerform.php'; 
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

/* Sends telemetry data back to the simulated circuit board */
require 'routes/sendtelemetrydata.php';

/* Application logic and form for users to login */
require 'routes/loginform.php';
require 'routes/login.php';

/* Application logic and form for users to register for an account */
require 'routes/registerform.php';
require 'routes/register.php';
<?php
/**
 * presenttelemetrydata.php
 *
 * Presents stored telemetry data to user.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/presenttelemetrydata', function(Request $request, Response $response) use ($app)
{

})->setName('presenttelemetrydata');

function retrieveStoredTelemetryData()
{

}

function validateStoredTelemetryData()
{

}

function gzipCompress()
{

}

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
    $tainted_telemetry_data = retrieveStoredTelemetryData($app);
    $cleaned_telemetry_data = validateStoredTelemetryData($app, $tainted_telemetry_data);

    $html_output = $this->view->render($response,
        'presenttelemetrydata.html.twig',
        array(
            'page_title' => APP_TITLE,
            'telemetry_data' => $cleaned_telemetry_data,
        )
    );

    return gzipCompress($app, $html_output);

})->setName('presenttelemetrydata');

function retrieveStoredTelemetryData($app)
{

}

function validateStoredTelemetryData($app, $tainted_telemetry_data)
{

}
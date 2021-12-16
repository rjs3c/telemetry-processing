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

$app->get('/presenttelemetrydata', function(Request $request, Response $response) use ($app) : Response
{
    $tainted_telemetry_data = retrieveStoredTelemetryData($app);
    $cleaned_telemetry_data = validateStoredTelemetryData($app, $tainted_telemetry_data);

    return $this->telemetryView->render($response,
        'presenttelemetrydata.html.twig',
        array(
            'page_title' => APP_TITLE,
            'heading_1' => 'Present Telemetry Data'
        )
    );
})->setName('presenttelemetrydata');

/**
 * @param $app
 * @return array
 */
function retrieveStoredTelemetryData($app) : array
{
    $telemetry_model = $app->getContainer()->get('presentTelemetryModel');
    $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

    $telemetry_model->setDatabaseHandle($doctrine_handle);
    $telemetry_model->setDatabaseSettings($database_connection_settings);
    $telemetry_model->setLoggerHandle($logger_handle);

    $telemetry_model->retrieveTelemetryData();

    return $telemetry_model->getRetrievalResult();
}

/**
 * Validates telemetry data stored within the database for additional security.
 *
 * @param $app
 * @param array $tainted_telemetry_data
 * @return array
 */
function validateStoredTelemetryData($app, array $tainted_telemetry_data) : array
{
    $telemetry_validator = $app->getContainer()->get('telemetryValidator');
    return $telemetry_validator->validateStoredTelemetryData($tainted_telemetry_data);
}
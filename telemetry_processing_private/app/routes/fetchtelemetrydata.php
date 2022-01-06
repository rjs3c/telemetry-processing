<?php
/**
 * fetchtelemetrydata.php
 *
 * Fetches and stores telemetry data from EE M2M's SOAP service.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/fetchtelemetrydata', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_telemetry_data = retrieveTelemetryData($app);
    $cleaned_telemetry_data = validateRetrievedTelemetryData($app, $tainted_telemetry_data);

    if (storeRetrievedTelemetryData($app, $cleaned_telemetry_data) !== false) {
        sendTelemetryMessageReceipt($app, $cleaned_telemetry_data);
    }

    return $response->withRedirect('presenttelemetrydata', 302);
})->setName('fetchtelemetrydata');

/**
 * Retrieves telemetry data from EE M2M's SOAP service, parses the result and returns it.
 *
 * @param $app
 * @return array
 */
function retrieveTelemetryData($app) : array
{
    $telemetry_model = $app->getContainer()->get('fetchTelemetryModel');
    $soap_handle = $app->getContainer()->get('soapWrapper');
    $parser_handle = $app->getContainer()->get('telemetryParser');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $soap_settings = $app->getContainer()->get('telemetrySettings')['soapSettings'];

    $telemetry_model->setSoapHandle($soap_handle);
    $telemetry_model->setSoapSettings($soap_settings);
    $telemetry_model->setLoggerHandle($logger_handle);
    $telemetry_model->setParserHandle($parser_handle);

    $telemetry_model->fetchTelemetryData();

    return $telemetry_model->getSoapResult();
}

/**
 * Store the retrieved telemetry data.
 *
 * @param $app
 * @param array $cleaned_telemetry_data
 * @return bool
 */
function storeRetrievedTelemetryData($app, array $cleaned_telemetry_data) : bool {
    $telemetry_model = $app->getContainer()->get('fetchTelemetryModel');
    $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

    $telemetry_model->setDatabaseHandle($doctrine_handle);
    $telemetry_model->setDatabaseSettings($database_connection_settings);
    $telemetry_model->setLoggerHandle($logger_handle);

    $telemetry_model->storeTelemetryData($cleaned_telemetry_data);

    return in_array(1, $telemetry_model->getStorageResult());
}

/**
 * Sends a message in receipt to sent telemetry messages.
 *
 * @param $app
 * @param array $cleaned_telemetry_data
 */
function sendTelemetryMessageReceipt($app, array $cleaned_telemetry_data) : void
{
    $telemetry_model = $app->getContainer()->get('fetchTelemetryModel');
    $soap_handle = $app->getContainer()->get('soapWrapper');
    $parser_handle = $app->getContainer()->get('telemetryParser');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $soap_settings = $app->getContainer()->get('telemetrySettings')['soapSettings'];

    $telemetry_model->setSoapHandle($soap_handle);
    $telemetry_model->setSoapSettings($soap_settings);
    $telemetry_model->setLoggerHandle($logger_handle);
    $telemetry_model->setParserHandle($parser_handle);

    $telemetry_model->sendTelemetryReceipt($cleaned_telemetry_data);
}

/**
 * Validates and properly formats telemetry retrieved from EE M2M's SOAP service.
 *
 * @param $app
 * @param array $tainted_telemetry_data
 * @return array
 */
function validateRetrievedTelemetryData($app, array $tainted_telemetry_data) : array
{
    $telemetry_validator = $app->getContainer()->get('telemetryValidator');
    return $telemetry_validator->validateTelemetryData($tainted_telemetry_data);
}

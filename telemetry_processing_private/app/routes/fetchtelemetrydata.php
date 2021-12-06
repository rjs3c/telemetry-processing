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

$app->get('/fetchtelemetrydata', function(Request $request, Response $response) use ($app)
{
    $result_message = '';
    $tainted_telemetry_data = fetchTelemetryData($app);
    $cleaned_telemetry_data = validateTelemetryData($app, $tainted_telemetry_data);

    $store_result = storeTelemetryData($app, $cleaned_telemetry_data);

    if ($store_result !== false) {
        $result_message = 'Telemetry data successfully retrieved and stored.';
    } else {
        $result_message = 'Oops, something went wrong. Please try again later.';
    }

    $html_output = $this->view->render($response,
        'fetchtelemetryresult.html.twig',
        array(
            'page_title' => APP_TITLE,
            'result_message' => $result_message,
            'present_telemetry_route' => 'presenttelemetrydata'
        )
    );

    return gzipCompress($app, $html_output);

})->setName('fetchtelemetrydata');

/**
 * Retrieves telemetry data from EE M2M's SOAP service, parses the result and returns it.
 *
 * @param $app
 * @return array
 */
function fetchTelemetryData($app) : array
{
    $telemetry_model = $app->getContainer()->get('telemetryModel');
    $soap_handle = $app->getContainer()->get('soapWrapper');
    $parser_handle = $app->getContainer()->get('telemetryParser');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $soap_settings = $app->getContainer()->get('telemetrySettings')['soapSettings'];

    $telemetry_model->setSoapHandle($soap_handle);
    $telemetry_model->setSoapSettings($soap_settings);
    $telemetry_model->setLoggerHandle($logger_handle);
    $telemetry_model->setParserHandle($parser_handle);

    $telemetry_model->fetchTelemetryData();

    return $telemetry_model->getResult();
}

/**
 * @TODO Doctrine functionality (from Model).
 *
 * @param $app
 * @param $cleaned_telemetry_data
 */
function storeTelemetryData($app, $cleaned_telemetry_data) {}

/**
 * Validates and properly formats telemetry retrieved from EE M2M's SOAP service.
 *
 * @param $app
 * @param array $tainted_telemetry_data
 * @return array
 */
function validateTelemetryData($app, array $tainted_telemetry_data) : array
{
    $telemetry_validator = $app->getContainer()->get('telemetryValidator');
    return $telemetry_validator->validateTelemetryData($tainted_telemetry_data);
}

/**
 * Compresses html output using GZIP.
 *
 * @param $app
 * @param string $html_output
 * @return mixed
 */
function gzipCompress($app, string $html_output) : string
{
    $gzip_wrapper = $app->getContainer()->get('gzipWrapper');
    $gzip_wrapper->setHtmlOutput($html_output);
    $gzip_wrapper->gzipCompress();
    return $gzip_wrapper->getCompressionOutput();
}
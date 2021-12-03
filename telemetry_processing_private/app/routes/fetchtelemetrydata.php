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

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $result_message = '';
    $fetch_result = fetchTelemetryData($app);
    $store_result = storeTelemetryData($app, $fetch_result);

    if ($store_result !== null) {
        $result_message = 'Telemetry data successfully retrieved and stored.';
    } else {
        $result_message = 'Oops, something went wrong. Please try again later.';
    }

    $html_output = $this->view->render($response,
        'homepage.html.twig',
        array(
            'page_title' => APP_TITLE,
            'result_message' => $result_message
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
 * @param $fetch_result
 */
function storeTelemetryData($app, $fetch_result) : bool {}

/**
 * Compresses html output using GZIP.
 *
 * @param $app
 * @param $html_output
 * @return mixed
 */
function gzipCompress($app, $html_output)
{
    $gzip_wrapper = $app->getContainer()->get('gzipWrapper');
    $gzip_wrapper->setHtmlOutput($html_output);
    $gzip_wrapper->gzipCompress();
    return $gzip_wrapper->getCompressionOutput();
}
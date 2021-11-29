<?php
/**
 * testfetchtelemetrydata.php
 *
 * Displays the Telemetry Processing homepage.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app) {
    testModel($app);
    $response->getBody()->write('Status: OK');
})->setName('testfetchtelemetrydata');

function testModel($app) {
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
    var_dump($telemetry_model->getResult());
}
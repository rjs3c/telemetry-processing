<?php
/**
 * sendinitialtelemetrymessages.php
 *
 * Sends initial/test telemetry messages to EE M2M server.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/sendinitialtelemetrymessages', function (Request $request, Response $response) use ($app) : Response
{
    sendInitialTelemetryData($app);

    return $response->withRedirect('index.php', 302);
})->setName('sendinitialtelemetrymessages');

/**
 * Sends initial telemetry messages to EE M2M server.
 * Provides a failsafe, in the event that messages cannot be sent successfully from a mobile device.
 *
 * @param $app
 * @return void
 */
function sendInitialTelemetryData($app) : void
{
    $telemetry_model = $app->getContainer()->get('fetchTelemetryModel');
    $soap_handle = $app->getContainer()->get('soapWrapper');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $soap_settings = $app->getContainer()->get('telemetrySettings')['soapSettings'];

    $telemetry_model->setSoapHandle($soap_handle);
    $telemetry_model->setSoapSettings($soap_settings);
    $telemetry_model->setLoggerHandle($logger_handle);

    $telemetry_model->sendTelemetryTestMessages();
}
<?php
/**
 * sendtelemetrydata.php
 *
 * Retrieves latest telemetry message from the database
 * Sends this back to a simulated 'Circuit Board'.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \TelemProc\CircuitBoard;

$app->get('/sendtelemetrydata', function(Request $request, Response $response) use ($app) : Response
{
    $tainted_telemetry_data = retrieveStoredTelemetryData($app);
    $cleaned_telemetry_data = validateTelemetryData($app, $tainted_telemetry_data);

    $circuit_board_status = sendDataToCircuitBoard($cleaned_telemetry_data[0]);

    return $this->telemetryView->render($response,
        'sendtelemetrydataresult.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => 'index.php',
            'heading_1' => 'Send Latest Telemetry Message to Circuit Board',
            'circuit_board_status' => $circuit_board_status
        )
    );
})->setName('sendtelemetrydata');

/**
 * Sends values and updates the status of the simulated circuit board.
 *
 * @param array $cleaned_telemetry_data
 * @return string
 */
function sendDataToCircuitBoard(array $cleaned_telemetry_data) : string
{
    $switches = array(
        'switch_one' => $cleaned_telemetry_data['switch_one'],
        'switch_two' => $cleaned_telemetry_data['switch_two'],
        'switch_three' => $cleaned_telemetry_data['switch_three'],
        'switch_four' => $cleaned_telemetry_data['switch_four']
    );
    $fan = $cleaned_telemetry_data['fan'];
    $temperature = $cleaned_telemetry_data['temperature'];
    $keypad = $cleaned_telemetry_data['keypad'];

    CircuitBoard::setSwitches($switches);
    CircuitBoard::setFanState($fan);
    CircuitBoard::setTemperature($temperature);
    CircuitBoard::setKeypadNumber($keypad);

    return CircuitBoard::getStatusMessage();
}
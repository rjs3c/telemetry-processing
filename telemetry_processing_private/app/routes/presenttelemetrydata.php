<?php
/**
 * presenttelemetrydata.php
 *
 * Presents stored telemetry data to the user.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/presenttelemetrydata[/{page}]', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_page_number = $request->getQueryParam('page');

    if (empty($tainted_page_number)) {
        $tainted_page_number = 1;
    }

    $cleaned_page_number = validatePageNumber($tainted_page_number);

    $tainted_telemetry_data = retrieveStoredTelemetryData($app, $cleaned_page_number);
    $cleaned_telemetry_data = validateTelemetryData($app, $tainted_telemetry_data);

    // Checks if 21 entries exist. If there are then next page button can be shown
    $is_next_page = false;
    
    if (count($cleaned_telemetry_data) == 21) {
        $is_next_page = true;
        array_pop($cleaned_telemetry_data);
    }

    return $this->telemetryView->render($response,
        'presenttelemetrydata.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'heading_1' => 'Present Telemetry Data',
            'links'=> array(
                'register' => 'registerform',
                'login' => 'loginform',
                'homepage' => 'index.php',
                'present_telemetry'=> 'presenttelemetrydata',
                'fetch_telemetry'=> 'fetchtelemetrydata',
                'prev'=> 'presenttelemetrydata',
                'next'=> 'presenttelemetrydata'
            ),
            'telemetry_data' => $cleaned_telemetry_data,
            'page_number'=> $cleaned_page_number,
            'is_next_page' => $is_next_page
        )
    );
})->setName('presenttelemetrydata');

/**
 * Retrieves stored telemetry data.
 *
 * @param $app
 * @param int $offset
 * @return array
 */
function retrieveStoredTelemetryData($app, int $offset) : array
{
    $telemetry_model = $app->getContainer()->get('presentTelemetryModel');
    $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

    $telemetry_model->setDatabaseHandle($doctrine_handle);
    $telemetry_model->setDatabaseSettings($database_connection_settings);
    $telemetry_model->setLoggerHandle($logger_handle);

    $offset = ($offset - 1) * 20; // Minus 1 and multiply by 20 to convert page number into offset
    $telemetry_model->retrieveTelemetryData($offset);

    return $telemetry_model->getRetrievalResult();
}

/**
 * Validates telemetry data stored within the database for additional security.
 *
 * @param $app
 * @param array $tainted_telemetry_data
 * @return array
 */
function validateTelemetryData($app, array $tainted_telemetry_data) : array
{
    $telemetry_validator = $app->getContainer()->get('telemetryValidator');
    return $telemetry_validator->validateStoredTelemetryData($tainted_telemetry_data);
}

/**
 * Validates page number GET variable for additional security
 *
 * @param int $tainted_page_number
 * @return int
 */
function validatePageNumber(int $tainted_page_number) : int 
{
    if (filter_var($tainted_page_number, FILTER_VALIDATE_INT) && $tainted_page_number > 0) {
        $cleaned_page_number = $tainted_page_number;
        return $cleaned_page_number;
    } else {
        return 1; // Default page value
    }
}

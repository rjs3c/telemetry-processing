<?php
/**
 * manageusersform.php
 *
 * Displays an administration interface for managing registered users.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/manageusersform', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_users = retrieveUsers($app);
    $cleaned_users = validateUsernames($app, $tainted_users);

    return $this->telemetryView->render($response,
        'manageusersform.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => 'index.php',
            'heading_1' => 'Manage Users',
            'register_action' => 'registerform',
            'links' => array(
                'register' => 'registerform',
                'login' => 'loginform',
                'homepage' => 'index.php',
                'present_telemetry'=> 'presenttelemetrydata',
                'fetch_telemetry'=> 'fetchtelemetrydata'
            ),
            'users_list' => $cleaned_users
        )
    );
})->setName('manageusersform');

/**
 * Retrieves all currently stored (registered) users.
 *
 * @param $app
 * @return array
 */
function retrieveUsers($app) : array
{
    $manage_users_model = $app->getContainer()->get('manageUsersModel');
    $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
    $logger_handle = $app->getContainer()->get('telemetryLogger');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

    $manage_users_model->setDatabaseHandle($doctrine_handle);
    $manage_users_model->setDatabaseSettings($database_connection_settings);
    $manage_users_model->setLoggerHandle($logger_handle);

    $manage_users_model->retrieveRegisteredUsers();

    return $manage_users_model->getResult();
}

/**
 * Validates all stored users.
 *
 * @param $app
 * @param array $tainted_users
 * @return array
 */
function validateUsernames($app, array $tainted_users) : array
{
    $usernames_validator = $app->getContainer()->get('manageUsersValidator');
    return $usernames_validator->validateRetrievedUsernames($tainted_users);
}

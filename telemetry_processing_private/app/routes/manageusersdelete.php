<?php
/**
 * manageusersdelete.php
 *
 * Responsible for the deletion of users through manageusersform.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/manageusersdelete', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_username = $request->getQueryParam('username');

    if ($tainted_username !== null) {
        $cleaned_username = validateUsername($app, $tainted_username);
        deleteUsername($app, $cleaned_username);
    }

    return $response->withRedirect('manageusersform', 301);
});

/**
 * Deletes a stored user.
 *
 * @param $app
 * @param string $cleaned_username
 * @return bool
 */
function deleteUsername($app, string $cleaned_username) : bool
{
    $deleted_user_result = false;

    if (!empty($cleaned_username)) {
        $manage_users_model = $app->getContainer()->get('manageUsersModel');
        $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
        $logger_handle = $app->getContainer()->get('telemetryLogger');

        $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

        $manage_users_model->setDatabaseHandle($doctrine_handle);
        $manage_users_model->setDatabaseSettings($database_connection_settings);
        $manage_users_model->setLoggerHandle($logger_handle);

        $manage_users_model->deleteRegisteredUser($cleaned_username);

        $deleted_user_result = $manage_users_model->getResult();
    }

    return $deleted_user_result;
}

/**
 * Validates the username in the request.
 *
 * @param $app
 * @param string $tainted_username
 * @return string
 */
function validateUsername($app, string $tainted_username) : string
{
    $usernames_validator = $app->getContainer()->get('manageUsersValidator');
    return $usernames_validator->validateUserName($tainted_username);
}

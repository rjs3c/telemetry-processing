<?php
/**
* manageuserschangepassword.php
*
* Responsible for the changing of user passwords through manageusersform.
*
* @package telemetry_processing
*
* @author James Brass
* @author Mo Aziz
* @author Ryan Instrell
*/

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/manageuserschangepassword', function (Request $request, Response $response) use ($app) : Response
{
    $is_admin = $request->getAttribute('isAdmin');

    if ($is_admin) {
        $tainted_parameters = $request->getParsedBody();

        if (!empty($tainted_parameters)) {
            $cleaned_parameters = validateUsernameAndPassword($app, $tainted_parameters);
            changeUserPassword($app, $cleaned_parameters);
        }

        return $response->withRedirect('manageusersform', 301);
    } else {
        return $response->withRedirect('index.php', 302);
    }
});

/**
 * Changes the password of a stored user.
 *
 * @param $app
 * @param array $cleaned_parameters
 * @return bool
 */
function changeUserPassword($app, array $cleaned_parameters) : bool
{
    $user_password_change_result = false;

    if (!empty($cleaned_parameters)) {
        $manage_users_model = $app->getContainer()->get('manageUsersModel');
        $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
        $doctrine_handle = $app->getContainer()->get('doctrineWrapper');
        $logger_handle = $app->getContainer()->get('telemetryLogger');

        $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];

        $manage_users_model->setBcryptHandle($bcrypt_wrapper);
        $manage_users_model->setDatabaseHandle($doctrine_handle);
        $manage_users_model->setDatabaseSettings($database_connection_settings);
        $manage_users_model->setLoggerHandle($logger_handle);

        $manage_users_model->changeUserPassword($cleaned_parameters);

        $user_password_change_result = $manage_users_model->getResult();
    }

    return $user_password_change_result;
}

/**
 * Validates the username and password from the request.
 *
 * @param $app
 * @param array $tainted_parameters
 * @return array
 */
function validateUsernameAndPassword($app, array $tainted_parameters) : array
{
    $cleaned_parameters = array();

    if (!empty($tainted_parameters)
    && isset($tainted_parameters['username'])
    && isset($tainted_parameters['password'])) {
        $users_validator = $app->getContainer()->get('manageUsersValidator');
        $cleaned_parameters['username'] = $users_validator->validateUsername($tainted_parameters['username']);
        $cleaned_parameters['password'] = $tainted_parameters['password'];
    }

    return $cleaned_parameters;
}

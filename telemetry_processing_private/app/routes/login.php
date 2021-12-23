<?php
/**
 * login.php
 *
 * Facilitates authentication of a user.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/login', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_parameters = $request->getParsedBody();
    $cleaned_parameters = validateLoginData($app, $tainted_parameters);

    $login_result = login($app, $cleaned_parameters);

    if ($login_result !== false) {
        return $response->withRedirect('index.php', 301);
    } else {
        return $response->withRedirect('loginform', 301);
    }
})->setName('login');

/**
 * Conducts main processing of authentication.
 *
 * @param $app
 * @param array $cleaned_parameters
 * @return bool
 */
function login($app, array $cleaned_parameters) : bool
{
    $login_model = $app->getContainer()->get('loginModel');
    $doctrine_wrapper = $app->getContainer()->get('doctrineWrapper');
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];
    $bcrypt_settings = $app->getContainer()->get('telemetrySettings')['bcryptSettings'];

    $login_model->setDatabaseHandle($doctrine_wrapper);
    $login_model->setDatabaseSettings($database_connection_settings);

    $login_model->setBcryptWrapper($bcrypt_wrapper);
    $login_model->setBcryptSettings($bcrypt_settings);

    $login_model->setCredentials($cleaned_parameters);

    $login_model->loginUser();

    return $login_model->getResult();
}

/**
 * Validates and sanitises user-entered information.
 *
 * @param $app
 * @param array $tainted_parameters
 * @return array
 */
function validateLoginData($app, array $tainted_parameters) : array
{
    $cleaned_parameters = array();

    $authentication_validator = $app->getContainer()->get('authenticationValidator');

    $cleaned_parameters['username'] = $authentication_validator->validateUserName($tainted_parameters['username']);
    $cleaned_parameters['password'] = $tainted_parameters['password'];

    return $cleaned_parameters;
}

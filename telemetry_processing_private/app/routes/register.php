<?php
/**
 * register.php
 *
 * Facilitates registration of a user.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/register', function (Request $request, Response $response) use ($app) : Response
{
    $tainted_parameters = $request->getParsedBody();
    $cleaned_parameters = validateRegisterData($app, $tainted_parameters);

    $register_result = register($app, $cleaned_parameters);

    if ($register_result !== false) {
        return $response->withRedirect('index.php', 301);
    } else {
        return $response->withRedirect('registerform', 301);
    }
})->setName('register');

/**
 * Conducts main processing of registration.
 *
 * @param $app
 * @param array $cleaned_parameters
 * @return bool
 */
function register($app, array $cleaned_parameters) : bool
{
    $register_model = $app->getContainer()->get('registerModel');
    $doctrine_wrapper = $app->getContainer()->get('doctrineWrapper');
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');

    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];
    $bcrypt_settings = $app->getContainer()->get('telemetrySettings')['bcryptSettings'];

    $register_model->setDatabaseHandle($doctrine_wrapper);
    $register_model->setDatabaseSettings($database_connection_settings);

    $register_model->setBcryptWrapper($bcrypt_wrapper);
    $register_model->setBcryptSettings($bcrypt_settings);

    $register_model->setCredentials($cleaned_parameters);

    $register_model->registerUser();

    return $register_model->getResult();
}

/**
 * Validates and sanitises user-entered information.
 *
 * @param $app
 * @param array $tainted_parameters
 * @return array
 */
function validateRegisterData($app, array $tainted_parameters) : array
{
    $cleaned_parameters = array();

    $authentication_validator = $app->getContainer()->get('authenticationValidator');

    $cleaned_parameters['username'] = $authentication_validator->validateUserName($tainted_parameters['username']);
    $cleaned_parameters['password'] = $tainted_parameters['password'];

    return $cleaned_parameters;
}
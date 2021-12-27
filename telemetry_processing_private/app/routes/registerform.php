<?php
/**
 * registerform.php
 *
 * Displays the form necessary for users to register their information.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\DriverManager;

$app->get('/registerform', function (Request $request, Response $response) use ($app)
{
    return $this->telemetryView->render($response,
        'registerform.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => 'index.php',
            'heading_1' => 'User Register',
            'register_action' => 'registerform',
            'links'=> array(
                'register' => 'registerform',
                'login' => 'loginform',
                'homepage' => 'index.php',
                'present_telemetry'=> 'presenttelemetrydata',
                'fetch_telemetry'=> 'fetchtelemetrydata'
            )
        )
    );
})->setName('registerform');

$app->post('/registerform', function (Request $request, Response $response) use ($app)
{
    //Get given credentials
    $tainted_parameters = $request->getParsedBody();
    $cleaned_parameters = cleanRegisterData($app, $tainted_parameters);

    //Get models
    $container = $app->getContainer();
    $register_model = $container->get('registerModel');
    $bcrypt_wrapper = $container->get('bcryptWrapper');
    $doctrine_wrapper = $container->get('doctrineWrapper');

    //Doctrine wrapper setup
    $database_connection_settings = $container->get('telemetrySettings')['doctrineSettings'];
    $database_connection = DriverManager::getConnection($database_connection_settings);
    $query_builder = $database_connection->createQueryBuilder();
    $doctrine_wrapper->setQueryBuilder($query_builder);

    //RegisterModel setup
    $register_model->setDoctrineWrapper($doctrine_wrapper);
    $register_model->setBcryptWrapper($bcrypt_wrapper);
    $register_model->setRegisterCredentials($cleaned_parameters);

    $register_model->register();
    $register_result = $register_model->getRegisterResult();

    if ($register_result) {
        return $response->withRedirect('index.php', 301);
    } else {
        return $response->withRedirect('registerform', 301);
    }
})->setName('registerform');

/**
 * Validates user-entered credentials.
 *
 * @param $app
 * @param $tainted_parameters
 * @return array
 */
function cleanRegisterData($app, $tainted_parameters) : array
{
    $cleaned_parameters = array();

    $authentication_validator = $app->getContainer()->get('authenticationValidator');

    $cleaned_parameters['username'] = $authentication_validator->validateUserName($tainted_parameters['username']);
    $cleaned_parameters['password'] = $tainted_parameters['password'];

    return $cleaned_parameters;
}
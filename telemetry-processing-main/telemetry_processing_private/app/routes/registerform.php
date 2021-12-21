<?php
/**
 * register.php
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

//$app->post('/registerform', function (Request $request, Response $response) use ($app)
//{
//
//    $tainted_parameters = $request->getParsedBody();
//    $cleaned_parameters = cleanRegisterData($tainted_parameters);
//
//    //doctrine wrapper setup
//    $doctrine_wrapper = $app->getContainer()->get('doctrineWrapper');
//    $database_connection_settings = $app->getContainer()->get('telemetrySettings')['doctrineSettings'];
//    $database_connection = DriverManager::getConnection($database_connection_settings);
//    $query_builder = $database_connection->createQueryBuilder();
//    $doctrine_wrapper->setQueryBuilder($query_builder);
//
//    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
//
//    $register_model = $app->getContainer()->get('registerModel');
//    $register_model->setDoctrineWrapper($doctrine_wrapper);
//    $register_model->setBCryptWrapper($bcrypt_wrapper);
//    $register_model->setRegisterCredentials($cleaned_parameters);
//
//    $register_result = $register_model->register();
//
//    return $this->telemetryView->render($response,
//        'registerform.html.twig',
//        array(
//            'page_title' => APP_TITLE,
//            'css_file' => CSS_PATH,
//            'landing_page' => 'index.php',
//            'heading_1' => 'User Register',
//            'register_action' => 'registerform',
//            'links'=> array(
//                'register' => 'registerform',
//                'login' => 'loginform',
//                'homepage' => 'index.php',
//                'present_telemetry'=> 'presenttelemetrydata',
//                'fetch_telemetry'=> 'fetchtelemetrydata'
//            )
//        )
//    );
//})->setName('registerform');
//
//function cleanRegisterData($app, $tainted_parameters) : array {
//
//    $cleaned_parameters = [];
//
//    $authentication_validator = $app->getContainer()->get('authenticationValidator');
//
//    $cleaned_parameters['username'] = $authentication_validator->validateUserName($tainted_parameters['username']);
//    $cleaned_parameters['password'] = $tainted_parameters['password'];
//
//    return $cleaned_parameters;
//
//}
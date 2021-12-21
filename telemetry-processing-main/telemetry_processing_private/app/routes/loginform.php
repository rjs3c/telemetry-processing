<?php
/**
 * loginform.php
 *
 * Displays the form necessary for users to login.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/loginform', function (Request $request, Response $response) use ($app)
{
    return $this->telemetryView->render($response,
        'loginform.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => 'index.php',
            'heading_1' => 'User Login',
            'login_action' => '/loginform',
            'links'=> array(
                'register' => 'registerform',
                'login' => 'loginform',
                'homepage' => 'index.php',
                'present_telemetry'=> 'presenttelemetrydata',
                'fetch_telemetry'=> 'fetchtelemetrydata'
            )
        )
    );
})->setName('loginform');

//$app->post('/loginform', function (Request $request, Response $response) use ($app)
//{
//
//    $tainted_parameters = $request->getParsedBody();
//    $cleaned_parameters = cleanLoginData($tainted_parameters);
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
//    $login_model = $app->getContainer()->get('loginModel');
//    $login_model->setDoctrineWrapper($doctrine_wrapper);
//    $login_model->setBCryptWrapper($bcrypt_wrapper);
//    $login_model->setLoginCredentials($cleaned_parameters);
//
//    $login_result = $login_model->login();
//
//    return $this->telemetryView->render($response,
//        'loginform.html.twig',
//        array(
//            'page_title' => APP_TITLE,
//            'css_file' => CSS_PATH,
//            'landing_page' => 'index.php',
//            'heading_1' => 'User Login',
//            'login_action' => '/loginform',
//            'links'=> array(
//                'register' => 'registerform',
//                'login' => 'loginform',
//                'homepage' => 'index.php',
//                'present_telemetry'=> 'presenttelemetrydata',
//                'fetch_telemetry'=> 'fetchtelemetrydata'
//            )
//        )
//    );
//})->setName('loginform');
//
//function cleanLoginData($app, $tainted_parameters) : array {
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

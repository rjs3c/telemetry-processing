<?php
/**
 * homepage.php
 *
 * Displays the Telemetry Processing homepage.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) use ($app) : Response
{
    $is_admin = $request->getAttribute('isAdmin');
    $is_authenticated = $request->getAttribute('isAuthenticated');

    return $this->telemetryView->render($response,
        'homepage.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => __FILE__,
            'heading_1' => APP_TITLE,
            'links'=> array(
                'register' => 'registerform',
                'login' => 'loginform',
                'homepage' => '#',
                'send_initial_messages' => 'sendinitialtelemetrymessages',
                'present_telemetry' => 'presenttelemetrydata',
                'manage_users' => 'manageusersform',
                'send_telemetry' => 'sendtelemetrydata',
                'logout' => 'logout'
            ),
            'isAuthenticated' => $is_authenticated,
            'isAdmin' => $is_admin
        )
    );
})->setName('homepage');
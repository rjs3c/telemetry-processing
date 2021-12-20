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

$app->get('/', function(Request $request, Response $response) use ($app)
{
    return $this->telemetryView->render($response,
        'homepage.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => __FILE__,
            'heading_1' => APP_TITLE,
            'fetch_telem_action' => 'fetchtelemetrydata',
            'present_telem_action' => 'presenttelemetrydata',
            'send_telem_action' => 'sendtelemetrydata',
            'login_action' => 'loginform',
            'register_action' => 'register'
        )
    );
})->setName('homepage');

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
            'login_action' => 'register'
        )
    );
})->setName('registerform');
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
            'login_action' => 'login'
        )
    );
})->setName('loginform');
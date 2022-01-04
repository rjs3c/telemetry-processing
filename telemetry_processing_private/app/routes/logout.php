<?php
/**
 * logout.php
 *
 * Responsible for logging out a user and unsetting session variables accordingly.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/logout', function (Request $request, Response $response) use ($app) : Response
{
    if (checkIfAuthenticated($app)) {
        logoutUser();
    }

    return $response->withRedirect('loginform', 302);
})->setName('logout');

/**
 * Checks if the relevant session value is set prior to logging a user out.
 *
 * @param $app
 * @return bool
 */
function checkIfAuthenticated($app) : bool
{
    $session_wrapper = $app->getContainer()->get('sessionWrapper');

    return !empty($session_wrapper->getSessionVar('user'));
}

/**
 * Destroys all session data associated with the specific user.
 *
 * @return void
 */
function logoutUser() : void
{
     session_destroy();
}
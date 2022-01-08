<?php
/**
 * AuthenticationMiddleware.php
 *
 * Provides middleware to check if a user is authenticated.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AuthenticationMiddleware
{
    /** @var resource $session_wrapper Contains the handle to <SessionWrapper>. */
    private $session_wrapper;

    public function __construct()
    {
        $this->session_wrapper = null;
    }

    /**
     * Sets <SessionWrapper>.
     *
     * @param $session_wrapper
     */
    public function setSessionWrapper($session_wrapper) : void
    {
        $this->session_wrapper = $session_wrapper;
    }

    /**
     * Invoke method for AuthenticationMiddleware.
     *
     * @param Request $request PSR7 request
     * @param Response $response PSR7 response
     * @param callable $next Next middleware
     *
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function __invoke(Request $request, Response $response, callable $next) : Response
    {
        $is_authenticated = false;
        $username = $this->session_wrapper->getSessionVar('user');

        if (!empty($username)) {
            $is_authenticated = true;
            $request = $request->withAttribute('isAuthenticated', $is_authenticated);
        }

        $response = $next($request, $response);

        return $response;
    }
}

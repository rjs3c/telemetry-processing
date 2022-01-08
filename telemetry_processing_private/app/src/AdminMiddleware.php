<?php
/**
 * AdminMiddleware.php
 *
 * Provides middleware to check if an authenticated user has the 'admin' flag set.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

use Doctrine\DBAL\DriverManager;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AdminMiddleware
{
    /** @var resource $authentication_validator Contains handle to <AuthenticationValidator>. */
    private $authentication_validator;

    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_wrapper;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private $doctrine_settings;

    /** @var resource $session_wrapper Contains the handle to <SessionWrapper>. */
    private $session_wrapper;

    public function __construct()
    {
        $this->authentication_validator = null;
        $this->doctrine_wrapper = null;
        $this->doctrine_settings = array();
        $this->session_wrapper = null;
    }

    /**
     * Sets <AuthenticationValidator> handle.
     *
     * @param $authentication_validator
     */
    public function setAuthenticationValidator($authentication_validator) : void
    {
        $this->authentication_validator = $authentication_validator;
    }

    /**
     * Sets <DoctrineWrapper> handle.
     *
     * @param $doctrine_wrapper
     */
    public function setDoctrineWrapper($doctrine_wrapper) : void
    {
        $this->doctrine_wrapper = $doctrine_wrapper;
    }

    /**
     * Sets database connection settings for <Doctrine>.
     *
     * @param array $doctrine_settings
     */
    public function setDoctrineSettings(array $doctrine_settings) : void
    {
        $this->doctrine_settings = $doctrine_settings;
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
     * Invoke method for AdminMiddleware.
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
        $is_admin = false;

        // Validate username from sessions file in case integrity is affected.
        $tainted_username = $this->session_wrapper->getSessionVar('user');
        $cleaned_username = $this->authentication_validator->validateUserName($tainted_username);

        if (!empty($cleaned_username)) {
            $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
            $query_builder = $dbal_connection->createQueryBuilder();

            $this->doctrine_wrapper->setQueryBuilder($query_builder);

            $this->doctrine_wrapper->checkifAdmin($cleaned_username);
            $is_admin = $this->doctrine_wrapper->getQueryResult();
        }

        $request = $request->withAttribute('isAdmin', $is_admin);

        $response = $next($request, $response);

        return $response;
    }
}
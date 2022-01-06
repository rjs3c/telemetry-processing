<?php
/**
 * LoginRegisterInterface.php
 *
 * Sets a template for the LoginModel and RegisterModel to implement.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

interface LoginRegisterInterface
{
    /**
     * Sets <Bcrypt> wrapper
     *
     * @param $bcrypt_wrapper
     */
    public function setBcryptWrapper($bcrypt_wrapper) : void;

    /**
     * Sets <DoctrineWrapper> handle.
     *
     * @param $doctrine_wrapper
     */
    public function setDoctrineWrapper($doctrine_wrapper) : void;

    /**
     * Sets <Monolog> handle.
     *
     * @param $logger_handle
     */
    public function setLoggerHandle($logger_handle) : void;

    /**
     * Sets login/register credentials
     *
     * @param array $user_credentials
     */
    public function setUserCredentials(array $user_credentials) : void;

    /**
     * Returns result for user authentication/registration.
     *
     * @return bool
     */
    public function getResult() : bool;
}
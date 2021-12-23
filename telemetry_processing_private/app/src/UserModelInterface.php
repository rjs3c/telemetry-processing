<?php
/**
 * UserModelInterface.php
 *
 * Provides an template for UserLoginModel and UserRegisterModel.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

interface UserModelInterface
{
    /**
     * Sets handle to <Doctrine>.
     *
     * @param $doctrine_handle
     */
    public function setDatabaseHandle($doctrine_handle);

    /**
     * Sets database connection settings.
     *
     * @param array $doctrine_settings
     */
    public function setDatabaseSettings(array $doctrine_settings);

    /**
     * Sets handle to BcryptWrapper.
     *
     * @param $bcrypt_handle
     */
    public function setBcryptWrapper($bcrypt_handle);

    /**
     * @param array $bcrypt_settings
     */
    public function setBcryptSettings(array $bcrypt_settings);

    /**
     * Sets handle to <Monolog> logger.
     *
     * @param $telemetry_logger
     */
    public function setLoggerHandle($telemetry_logger);

    /**
     * Sets login credentials
     *
     * @param array $user_credentials
     */
    public function setCredentials(array $user_credentials);

    /**
     * Returns result from login operation.
     */
    public function getResult();
}
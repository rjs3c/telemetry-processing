<?php
/**
 * TelemetryModelInterface.php
 *
 * Provides an template for PresentTelemetryModel and FetchTelemetryModel.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

interface TelemetryModelInterface
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
     * Sets handle to <Monolog> logger.
     *
     * @param $telemetry_logger
     */
    public function setLoggerHandle($telemetry_logger);
}
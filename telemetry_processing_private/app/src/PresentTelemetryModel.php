<?php
/**
 * PresentTelemetryModel.php
 *
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class PresentTelemetryModel
{
    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_handle;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private array $doctrine_settings;

    /** @var resource $logger_handle Contains handle for <TelemetryLogger> */
    private $logger_handle;

    public function __construct()
    {
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->logger_handle = null;
    }

    public function __destruct() {}

    /**
     * Sets handle to <Doctrine>.
     *
     * @param $doctrine_handle
     */
    public function setDatabaseHandle($doctrine_handle) : void
    {
        $this->doctrine_handle = $doctrine_handle;
    }

    /**
     * Sets database connection settings.
     *
     * @param array $doctrine_settings
     */
    public function setDatabaseSettings(array $doctrine_settings) : void
    {
        $this->doctrine_settings = $doctrine_settings;
    }

    /**
     * Sets handle to <Monolog> logger.
     *
     * @param $telemetry_logger
     */
    public function setLoggerHandle($telemetry_logger) : void
    {
        $this->logger_handle = $telemetry_logger;
    }

    /**
     * Retrieves stored telemetry data using <Doctrine>.
     *
     * @return array
     */
    public function retrieveStoredTelemetryData($app) : array
    {
        $database_connection_settings = $app->getContainer()->get('doctrine_settings');
        $doctrine_queries = $app->getContainer()->get('doctrineWrapper');
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $fetch_result = $doctrine_queries::fetchTelemetryData($queryBuilder);

        return $fetch_result;
    }
}
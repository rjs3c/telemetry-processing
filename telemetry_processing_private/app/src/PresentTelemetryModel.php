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

use Doctrine\DBAL\DriverManager;

class PresentTelemetryModel implements \TelemProc\TelemetryModelInterface
{
    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_handle;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private array $doctrine_settings;

    /** @var resource $logger_handle Contains handle for <TelemetryLogger> */
    private $logger_handle;

    /** @var array $retrieve_result Contains result from query to retrieve telemetry data/ */
    private array $retrieve_result;

    public function __construct()
    {
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->logger_handle = null;
        $this->retrieve_result = array();
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
     * Sets database connection settings for <Doctrine>.
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
     * @param $logger_handle
     */
    public function setLoggerHandle($logger_handle) : void
    {
        $this->logger_handle = $logger_handle;
    }

    /**
     * Returns result from <Doctrine> query to fetch telemetry data.
     *
     * @return array
     */
    public function getRetrievalResult()
    {
        return $this->retrieve_result;
    }

    /**
     * Retrieves stored telemetry data using <Doctrine>.
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function retrieveTelemetryData() : void
    {
        $retrieve_result = array();

        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        $this->doctrine_handle->setQueryBuilder($query_builder);

        $this->doctrine_handle->fetchTelemetryData();

        $retrieve_result = $this->doctrine_handle->getQueryResult();

        $this->retrieve_result = $retrieve_result;
    }
}
<?php
/**
 * TelemetryModel.php
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

class TelemetryModel
{
    /** @var resource $doctrine_handle Contains handle to <Doctrine>. */
    private $doctrine_handle;

    /** @var array $doctrine_settings Contains settings for <Doctrine>. */
    private array $doctrine_settings;

    /** @var resource $parser_handle Contains handle to <TelemetryParser>. */
    private $parser_handle;

    /** @var resource $soap_handle Contains handle to <SoapWrapper>. */
    private $soap_handle;

    /** @var array $soap_result Stores result of parsed, SOAP operation. */
    private array $soap_result;

    /** @var array $soap_settings Stores settings for <SoapWrapper>.*/
    private array $soap_settings;

    /** @var bool|array $storage_result Stores result of DB-based operations. */
    private $storage_result;

    /** @var resource $logger_handle Contains handle for <TelemetryLogger> */
    private $logger_handle;

    public function __construct()
    {
        $this->doctrine_handle = null;
        $this->doctrine_settings = array();
        $this->parser_handle = null;
        $this->soap_handle = null;
        $this->soap_result = array();
        $this->soap_settings = array();
        $this->storage_result = false;
        $this->logger_handle = null;
    }

    public function __destruct() { }

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
     * Sets handle to <TelemetryParser>.
     *
     * @param $parser_handle
     */
    public function setParserHandle($parser_handle) : void
    {
        $this->parser_handle = $parser_handle;
    }

    /**
     * Sets handle to <SoapWrapper>.
     *
     * @param $soap_handle
     */
    public function setSoapHandle($soap_handle) : void
    {
        $this->soap_handle = $soap_handle;
    }

    /**
     * Sets settings required for <SoapWrapper>.
     *
     * @param array $soap_settings
     */
    public function setSoapSettings(array $soap_settings) : void
    {
        $this->soap_settings = $soap_settings;
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
     * Returns result from retrieval and storage operations.
     *
     * @return array|bool
     */
    public function getResult() : array
    {
        return $this->soap_result;
    }

    /**
     * Retrieves telemetry data from EE's M2M SOAP service.
     */
    public function fetchTelemetryData($app) : array
    {
        $database_connection_settings = $app->getContainer()->get('doctrine_settings');
        $doctrine_wrapper = $app->getContainer()->get('databaseWrapper');
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();
        return $store_result = $doctrine_wrapper->fetchTelemetryData($queryBuilder);
    }

    /**
     * Parses the telemetry data - extracts group-specific messages.
     *
     * @param array $soap_data
     * @return array
     */
    private function parseTelemetryData(array $soap_data) : array
    {
        $telemetry_data = array();

        if ($this->parser_handle !== null) {
            $this->parser_handle->setTelemetryMessages($soap_data);
            $this->parser_handle->parseTelemetry();
            $telemetry_data = $this->parser_handle->getTelemetryParseResults();
        }

        return $telemetry_data;
    }

    /**
     * Stores parsed telemetry data using <Doctrine>.
     *
     * @TODO Add <Doctrine> functionality.
     */
    private function storeTelemetryData($app, $cleaned_telemetry_data) :array
    {

        $database_connection_settings = $app->getContainer()->get('doctrine_settings');
        $doctrine_wrapper = $app->getContainer()->get('databaseWrapper');
        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();
        return $store_result = $doctrine_wrapper->storeTelemetryData($queryBuilder, $cleaned_telemetry_data);

    }
}
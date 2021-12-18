<?php
/**
 * FetchTelemetryModel.php
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

class FetchTelemetryModel
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
     * Returns result from retrieval operations.
     *
     * @return array|bool
     */
    public function getSoapResult() : array
    {
        return $this->soap_result;
    }

    /**
     * Returns result from storage operation.
     *
     * @return array|bool
     */
    public function getStorageResult()
    {
        return $this->storage_result;
    }

    /**
     * Retrieves telemetry data from EE's M2M SOAP service.
     */
    public function fetchTelemetryData() : void
    {
        $soap_result = array();

        $this->soap_handle->setSoapSettings($this->soap_settings);

        if ($this->logger_handle !== null) {
            $this->soap_handle->setSoapLogger($this->logger_handle);
        }

        if ($this->soap_handle->createSoapHandle() !== null) {
            $peek_messages_args = array(
                $this->soap_settings['ee_m2m_username'],
                $this->soap_settings['ee_m2m_password'],
                100,
                $this->soap_settings['ee_m2m_phone_number'],
                '44'
            );

            $soap_data = $this->soap_handle->callSoapFunction('peekMessages', $peek_messages_args);

            if ($soap_data !== null) {
                $soap_result = $this->parseTelemetryData($soap_data);
            }
        }

        $this->soap_result = $soap_result;
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
     * Sends a receipt for telemetry messages.
     *
     * @param array $cleaned_telemetry_data
     * @return void
     */
    public function sendTelemetryReceipt(array $cleaned_telemetry_data) : void
    {
        $this->soap_handle->setSoapSettings($this->soap_settings);

        if ($this->logger_handle !== null) {
            $this->soap_handle->setSoapLogger($this->logger_handle);
        }

        if ($this->soap_handle->createSoapHandle() !== false) {

            $send_messages_args = array(
                $this->soap_settings['ee_m2m_username'],
                $this->soap_settings['ee_m2m_password'],
                '',
                'Telemetry Message Successfully Sent.',
                false,
                'SMS'
            );

            foreach($cleaned_telemetry_data as $telemetry_message) {
                foreach($telemetry_message as $element_name => $element_value) {
                    if (strcmp($element_name, 'MSDN') === 0) {
                        $send_messages_args[2] = $element_value;
                        $this->soap_handle->callSoapFunction('sendMessage', $send_messages_args);
                    }
                }
            }
        }
    }

    /**
     * Stores parsed telemetry data using <Doctrine>.
     *
     * @param array $cleaned_telemetry_data
     * @throws \Doctrine\DBAL\Exception
     */
    public function storeTelemetryData(array $cleaned_telemetry_data) : void
    {
        $storage_result = array();

        $dbal_connection = DriverManager::getConnection($this->doctrine_settings);
        $query_builder = $dbal_connection->createQueryBuilder();

        $this->doctrine_handle->setQueryBuilder($query_builder);

        if ($this->logger_handle !== null) {
            $this->doctrine_handle->setDoctrineLogger($this->logger_handle);
        }

        foreach($cleaned_telemetry_data as $cleaned_message) {
            $this->doctrine_handle->storeTelemetryData($cleaned_message);
            array_push($storage_result, $this->doctrine_handle->getQueryResult());
        }

        $this->storage_result = $storage_result;
    }
}
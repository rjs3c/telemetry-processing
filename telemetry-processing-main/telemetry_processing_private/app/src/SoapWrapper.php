<?php
/**
 * SoapWrapper.php
 *
 * Provides a wrapper for SOAP-related operations.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class SoapWrapper
{
    /** @var resource $soap_client Contains the handle to <SoapClient>. */
    private $soap_client;

    /** @var array $soap_settings Contains settings for <SoapClient>.*/
    private $soap_settings;

    /** @var resource $soap_logger Contains handle to <telemetryLogger>. */
    private $soap_logger;

    public function __construct()
    {
        $this->soap_client = null;
        $this->soap_settings = array();
        $this->soap_logger = null;
    }

    public function __destruct() {}

    /**
     * Sets SOAP settings needed to create handle.
     *
     * consists of <wsdl> and <attributes>.
     *
     * @param array $soap_settings
     */
    public function setSoapSettings(array $soap_settings) : void
    {
        $this->soap_settings = $soap_settings;
    }

    /**
     * Sets handle for <telemetryLogger>.
     *
     * @param $soap_logger
     */
    public function setSoapLogger($soap_logger) : void
    {
        $this->soap_logger = $soap_logger;
    }

    /**
     * Using the Logger handle, produce a log of level ERROR
     * Optional parameters in $additional if more information is needed
     *
     * @param string $log_message
     * @param array|null $additional
     */
    private function logSoapError(string $log_message, ?array $additional = null) : void
    {
        if ($additional !== null) {
            $this->soap_logger->error($log_message, $additional);
        } else {
            $this->soap_logger->error($log_message);
        }
    }

    /**
     * Creates SOAP Client and Handle using <SoapClient>.
     */
    public function createSoapHandle()
    {
        try {
            $soap_handle = null;
            $soap_settings = $this->soap_settings;

            $soap_handle = new \SoapClient($soap_settings['wsdl'], $soap_settings['soap_attributes']);
        } catch (\SoapFault $exception) {
            if ($this->soap_logger !== null) {
                $this->logSoapError('SOAP Error', array($exception->getMessage()));
            }
        } finally {
            $this->soap_client = $soap_handle;
        }

        return $soap_handle;
    }

    /**
     * Calls SOAP-based user-defined function.
     *
     * @param string $function_name
     * @param array|null $function_params
     * @return mixed
     */
    public function callSoapFunction(string $function_name, ?array $function_params = null)
    {
        try {
            $soap_result = null;

            if ($this->soap_client !== null) {
                $soap_result = $this->soap_client->__soapCall($function_name, $function_params);
            } else {
                throw new \SoapFault('Soap handle is not set');
            }
        } catch (\SoapFault $exception) {
            if ($this->soap_logger !== null) {
                $this->logSoapError('SOAP Error', array($exception->getMessage()));
            }
        } finally {
            return $soap_result;
        }
    }
}
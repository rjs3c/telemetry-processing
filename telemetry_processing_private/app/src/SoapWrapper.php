<?php
/**
 * SoapWrapper.php
 *
 * Provides a wrapper for SOAP-related operations.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class SoapWrapper
{
    /** @var null $soap_client Contains the handle to <SoapClient>. */
    private $soap_client;

    /** @var array $soap_settings Contains settings for <SoapClient>.*/
    private $soap_settings;

    public function __construct()
    {
        $this->soap_client = null;
        $this->soap_settings = array();
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
     * Creates SOAP Client and Handle using <SoapClient>.
     */
    public function createSoapHandle() : string
    {
        $soap_settings = $this->soap_settings;
        $soap_error = '';

        try {
            $soap_handle = new \SoapClient($soap_settings['wsdl'], $soap_settings['soap_attributes']);
            $this->soap_client = $soap_handle;
        } catch (\SoapFault $exception) {
           $soap_error = $exception->getMessage(); // Log for sysadmin attention.
        }

        return $soap_error;
    }

    /**
     * Calls SOAP-based user-defined function.
     *
     * @param string $function_name
     * @param null $function_params
     * @return mixed
     */
    public function callSoapFunction(string $function_name, $function_params = null) : string
    {
        $soap_result = null;

        try {
            if ($this->soap_client) {
                if ($function_params !== null) {
                    $soap_result = $this->soap_client->__soapCall($function_name, $function_params);
                } else {
                    $soap_result = $this->soap_client->__soapCall($function_name);
                }
            } else {
                throw new \SoapFault('Soap handle is not set');
            }
        } catch (\SoapFault $exception) {
            $soap_result = $exception->getMessage(); // Log for sysadmin attention.
        }

        return $soap_result;
    }
}
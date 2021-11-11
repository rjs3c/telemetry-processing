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

class SoapWrapper {
    private $soap_client;
    private $soap_settings;

    public function __construct() {
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
    public function setSOAPSettings(array $soap_settings) : void {
        $this->soap_settings = $soap_settings;
    }

    /**
     * Creates SOAP Client and Handle using <SoapClient>.
     */
    public function createSOAPHandle() : void {
        $soap_settings = $this->soap_settings;
        $soap_error = '';

        try
        {
            $soap_handle = new \SoapClient($soap_settings['wsdl'], $soap_settings['soap_attributes']);
            // var_dump($soap_handle->__getFunctions());
            // var_dump($soap_handle->__getTypes());
            $this->soap_client = $soap_handle;
        }
        catch (\SoapFault $exception)
        {
           $soap_error = $exception->getMessage();
           /* Log for Sysadmin Attention */
        }
    }

    /**
     * Calls SOAP-based user-defined function.
     *
     * @param string $function_name
     * @param null $function_params
     * @return mixed
     */
    public function callSOAPFunction(string $function_name, $function_params = null) : array
    {
        $call_result = null;
        $soap_error = '';

        try
        {
            if ($function_params !== null)
            {
                $call_result = $this->soap_client->__soapCall($function_name, $function_params);
            }
            else
            {
                $call_result = $this->soap_client->__soapCall($function_name);
            }
        }
        catch (\SoapFault $exception)
        {
            $soap_error = $exception->getMessage();
            /* Log for Sysadmin Attention */
        }

        return $call_result;
    }

}

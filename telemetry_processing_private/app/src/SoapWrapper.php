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
    private $soap_result;

    public function __construct() {
        $this->soap_client = null;
        $this->soap_settings = array();
        $this->soap_result = null;
    }

    public function __destruct() {}

    /**
     * Sets SOAP settings needed to create handle.
     *
     * consists of <wsdl> and <attributes>.
     *
     * @param array $soap_settings
     */
    public function setSoapSettings(array $soap_settings) : void {
        $this->soap_settings = $soap_settings;
    }

    /**
     * Returns result generated from SOAP function call.
     *
     * @return null
     */
    public function getSoapResult() {
        return $this->soap_result;
    }

    /**
     * Creates SOAP Client and Handle using <SoapClient>.
     */
    public function createSOAPHandle() : void {
        $soap_settings = $this->soap_settings;
        $soap_error = '';

        try {
            $soap_handle = new \SoapClient($soap_settings['wsdl'], $soap_settings['soap_attributes']);
            // var_dump($soap_handle->__getFunctions());
            // var_dump($soap_handle->__getTypes());
            $this->soap_client = $soap_handle;
        } catch (\SoapFault $exception) {
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
    public function callSOAPFunction(string $function_name, $function_params = null) : array {
        $soap_result = false;
        $soap_error = '';

        try {
            if ($this->soap_client !== null) {
                if ($function_params !== null) {
                    $soap_result = $this->soap_client->__soapCall($function_name, $function_params);
                } else {
                    $soap_result = $this->soap_client->__soapCall($function_name);
                }
            } else {
                throw new \SoapFault('Soap Handle is not set.');
            }
        } catch (\SoapFault $exception) {
            $soap_error = $exception->getMessage();
            /* Log for Sysadmin Attention */
        }

        $this->soap_result = $soap_result;
    }
}
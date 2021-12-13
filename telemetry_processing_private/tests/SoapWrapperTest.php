<?php declare(strict_types=1);
/**
 * SoapWrapperTest.php
 *
 * Tests SOAP Wrapper functionality.
 * Tests:
 * - Tests that a SOAP client handle can be successfully created using the WSDL file.
 * - Tests that the 'peekMessages' function can be successfully called within the SOAP client.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\SoapWrapper;

final class SoapWrapperTest extends TestCase
{
    /** @var array $settings Stores SOAP-related settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * Test to identify if creating a SOAP handle works successfully using the EE M2M WSDL file.
     */
    public function testSoapConnectsCorrectly()
    {
        $soap_wrapper = new SoapWrapper();

        $soap_wrapper->setSoapSettings($this->settings['telemetrySettings']['soapSettings']);

        $this->assertNotFalse(
            $soap_wrapper->createSoapHandle()
        );
    }

    /**
     * Test to identify if a function can be successfully called when a SOAP handle is set.
     * The function used here is 'peekMessages', as this is the primary function of interest.
     */
    public function testEEPeekMessagesFunction()
    {
        $soap_wrapper = new SoapWrapper();

        $soap_wrapper->setSoapSettings($this->settings['telemetrySettings']['soapSettings']);

        $soap_wrapper->createSoapHandle();

        $peek_messages_args = array(
            $this->settings['telemetrySettings']['soapSettings']['ee_m2m_username'],
            $this->settings['telemetrySettings']['soapSettings']['ee_m2m_password'],
            100,
            $this->settings['telemetrySettings']['soapSettings']['ee_m2m_phone_number'],
            '44'
        );

        $this->assertNotEmpty(
            $soap_wrapper->callSoapFunction('peekMessages', $peek_messages_args)
        );
    }
}
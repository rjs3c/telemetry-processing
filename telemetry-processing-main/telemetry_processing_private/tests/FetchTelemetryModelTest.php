<?php
/**
 * FetchTelemetryModelTest.php
 *
 * Tests Telemetry Data retrieval, parsing, validation and storage operations within the model.
 * Tests:
 * - Correct retrieval of telemetry data using SOAP.
 * - Correct storage of telemetry data using Doctrine.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\FetchTelemetryModel;
use TelemProc\SoapWrapper;
use TelemProc\DoctrineWrapper;

class FetchTelemetryModelTest extends TestCase
{
    /** @var array $settings Stores SOAP settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test To identify if telemetry data is retrieved and parsed correctly using the model.
     */
    public function testRetrieveAndParseTelemetryData()
    {
        $telemetry_model = new FetchTelemetryModel();
        $soap_wrapper = new SoapWrapper();

        $soap_settings = $this->settings['telemetrySettings']['soapSettings'];

        $telemetry_model->setSoapHandle($soap_wrapper);
        $telemetry_model->setSoapSettings($soap_settings);

        $telemetry_model->fetchTelemetryData();

        $this->assertNotNull(
            $telemetry_model->getSoapResult()
        );
    }

    /**
     * @test To ensure that telemetry data can be successfully stored using the model.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testStoresTelemetryData()
    {
        $telemetry_model = new FetchTelemetryModel();
        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];

        $telemetry_model->setDatabaseHandle($doctrine_wrapper);
        $telemetry_model->setDatabaseSettings($database_connection_settings);

        $telemetry_test_data = array(
            0 => array(
                'GID' => 'AF',
                'MSDN' => '+440000000000',
                'SW' => array(
                    'SW1' => 0,
                    'SW2' => 0,
                    'SW3' => 0,
                    'SW4' => 0
                ),
                'FN' => 1,
                'TMP' => 0.00,
                'KP' => 0
            )
        );

        $telemetry_model->storeTelemetryData($telemetry_test_data);

        $this->assertNotEmpty(
          $telemetry_model->getStorageResult()
        );
    }
}
<?php declare(strict_types=1);
/**
 * PresentTelemetryModelTest.php
 *
 * Tests retrieval of stored telemetry data using the model.
 * Tests:
 * - Correct retrieval of telemetry data using Doctrine.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\PresentTelemetryModel;
use TelemProc\DoctrineWrapper;

class PresentTelemetryModelTest extends TestCase
{
    /** @var array $settings Stores SOAP settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * @test To identify if telemetry data is retrieved correctly using Doctrine.
     */
    public function testRetrieveStoredTelemetryData()
    {
        $telemetry_model = new PresentTelemetryModel();
        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];

        $telemetry_model->setDatabaseHandle($doctrine_wrapper);
        $telemetry_model->setDatabaseSettings($database_connection_settings);

        $telemetry_model->retrieveTelemetryData();

        $this->assertNotEmpty(
            $telemetry_model->getRetrievalResult()
        );
    }
}

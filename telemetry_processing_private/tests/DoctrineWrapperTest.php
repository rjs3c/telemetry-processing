<?php declare(strict_types=1);
/**
 * DoctrineWrapperTest.php
 *
 * Tests Doctrine functionality.
 * Tests:
 * - Tests that, using test telemetry data, that this can be successfully be stored using <Doctrine>.
 * - Tests that <Doctrine> can successfully retrieve telemetry data stored within the database.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\DoctrineWrapper;
use Doctrine\DBAL\DriverManager;

final class DoctrineWrapperTest extends TestCase
{
    /** @var array $settings Stores Doctrine-related settings. */
    private $settings;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->settings = require('../app/settings.php');
    }

    /**
     * Test to ascertain if telemetry data can be successfully stored using Doctrine.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testStoreData()
    {
        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();

        $telemetryData = array(
            'GID' => 'AF',
            'MSDN' => '123456789',
            'SW' => array(
                'SW1' => 0,
                'SW2' => 0,
                'SW3' => 0,
                'SW4' => 0
            ),
            'FN' => 1,
            'TMP' => 0.00,
            'KP' => 0
        );

        $doctrine_wrapper->setQueryBuilder($query_builder);
        $doctrine_wrapper->storeTelemetryData($telemetryData);

        //['outcome'] = 1 when sql is executed successfully
        $this->assertEquals(
            1,
            $doctrine_wrapper->getQueryResult()
        );
    }

    /**
     * Test to ascertain if telemetry data can be successfully retrieved using Doctrine.
     *
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFetchData()
    {
        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = $this->settings['telemetrySettings']['doctrineSettings'];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $query_builder = $database_connection->createQueryBuilder();

        $doctrine_wrapper->setQueryBuilder($query_builder);
        $doctrine_wrapper->fetchTelemetryData();

        $this->assertNotNull(
            $doctrine_wrapper->getQueryResult()
        );
    }
}
<?php declare(strict_types=1);


use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;
use TelemProc\DoctrineWrapper;
use Doctrine\DBAL\DriveManager;

require __DIR__ . "/../app/src/DoctrineWrapper.php";



final class DoctrineWrapperTest extends TestCase
{

    public function testStoreData(){


        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'telemetry_db',
            'port' => '3306',
            'user' => 'user',
            'password' => 'user_pass',
            'charset' => 'utf8'
        ];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $telemetryData = array(
            0 => array (
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
            )
        );

        //['outcome'] = 1 when sql is executed successfully
        $this->assertEquals(
            1,
            $doctrine_wrapper->storeTelemetryData($queryBuilder, $telemetryData)['outcome']
        );

    }
    /**@test*/
    public function testFetchData(){


        $doctrine_wrapper = new DoctrineWrapper();

        $database_connection_settings = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'telemetry_db',
            'port' => '3306',
            'user' => 'user',
            'password' => 'user_pass',
            'charset' => 'utf8'
        ];

        $database_connection = DriverManager::getConnection($database_connection_settings);

        $queryBuilder = $database_connection->createQueryBuilder();

        $this->assertNotNull(

            $doctrine_wrapper->fetchTelemetryData($queryBuilder)
        );
    }

}

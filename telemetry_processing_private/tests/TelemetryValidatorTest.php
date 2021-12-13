<?php declare(strict_types=1);
/**
 * TelemetryValidatorTest.php
 *
 * Tests functionality for TelemetryValidator.
 * Tests:
 * -
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\TelemetryValidator;

require __DIR__ . "/../app/src/TelemetryValidator.php";

final class TelemetryValidatorTest extends TestCase
{
    /**
     * Test case to ensure that when providing a message that contains illegal input, this is handled appropriately and safely.
     */
    public function testProvideIllegalMessage()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Illegal message - with incorrect formats, invalid ranges, etc. */
        $illegal_message = array(
            0 => array (
                'Content' => array(
                    'GID' => 'AF',
                    'MSDN' => 'INVALID', /* Expected: +44[0-9]{10} */
                    'SW' => array(
                        'SW1' => '5', /* Expected: 1 or 0 */
                        'SW2' => '6', /* Expected: 1 or 0 */
                        'SW3' => '7', /* Expected: 1 or 0 */
                        'SW4' => '8' /* Expected: 1 or 0 */
                    ),
                    'FN' => 'backwards', /* Expected: 'forward', 'reverse', 'off' */
                    'TMP' => 'INVALID', /* Expected: float value (2 decimal places) */
                    'KP' => '10' /* Expected: values between 0-9 */
                )
            )
        );

        /* Illegal message - with incorrect formats, invalid ranges, etc. */
        $expected_output = array(
            0 => array (
                'GID' => 'AF',
                'MSDN' => '', /* Bad idea to use a default MSISDN value */
                'SW' => array(
                    'SW1' => 0, /* Casted to an integer with default value of 0 if fails */
                    'SW2' => 0, /* Casted to an integer with default value of 0 if fails */
                    'SW3' => 0, /* Casted to an integer with default value of 0 if fails */
                    'SW4' => 0 /* Casted to an integer with default value of 0 if fails */
                ),
                'FN' => 'off', /* Use default value 'off' if whitelist mechanism fails */
                'TMP' => 0.00, /* Casted to a float with default value 0.00 if fails */
                'KP' => 0 /* Casted to a int with default value 0 if fails */
            )
        );

        $this->assertEquals(
            $expected_output,
            $telemetry_validator->validateTelemetryData($illegal_message)
        );
    }

    public function testMSISDNValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();


    }

    public function testSwitchesValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

    }

    public function testFanStateValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

    }

    public function testTemperatureValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

    }

    public function testKeyPadValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

    }
}
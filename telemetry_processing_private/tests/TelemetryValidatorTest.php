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

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'MSDN' => '+440000000000', /* Expected: +44[0-9]{10} */
                )
            )
        );

        $expected_value = '+440000000000';

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['MSDN']
        );

    }

    public function testMSISDNValidationFailsCorrectly()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'MSDN' => '+4400000000', /* Truncated. Expected: +44[0-9]{10} */
                )
            )
        );

        $this->assertEmpty(
            $telemetry_validator->validateTelemetryData($test_message)[0]['MSDN']
        );
    }

    public function testSwitchesValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'SW' => array( /* Using an alternative order. */
                        'SW2' => '0',
                        'SW1' => '1',
                        'SW4' => '1',
                        'SW3' => '1' /* Expected: 1 or 0 */
                    )
                )
            )
        );

        $expected_values = array(
            'SW1' => 1,
            'SW2' => 0,
            'SW3' => 1,
            'SW4' => 1
        );

        $this->assertEquals(
            $expected_values,
            $telemetry_validator->validateTelemetryData($test_message)[0]['SW']
        );
    }

    public function testSwitchesValidationFailsCorrectly()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'SW' => array( /* Using invalid keypad values. */
                        'SW2' => '5',
                        'SW1' => '6',
                        'SW4' => '21',
                        'SW3' => '-1' /* Expected: 1 or 0 */
                    )
                )
            )
        );

        $expected_values = array(
            'SW1' => 0,
            'SW2' => 0,
            'SW3' => 0,
            'SW4' => 0
        );

        $this->assertEquals(
            $expected_values,
            $telemetry_validator->validateTelemetryData($test_message)[0]['SW']
        );
    }

    public function testFanStateValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'FN' => 'forward',
                    'TMP' => '34.0',
                    'KP' => '10'
                )
            )
        );

        $expected_value = 'forward';

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['FN']
        );

    }

    public function testFanStateValidationFailsCorrectly()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'FN' => 'backwards and forwards', /* Using invalid state 'backwards and forwards' */
                )
            )
        );

        $expected_value = 'off';

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['FN']
        );

    }

    public function testTemperatureValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'TMP' => '34',
                )
            )
        );

        $expected_value = 34.0;

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['TMP']
        );
    }

    public function testTemperatureValidationFailsCorrectly()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'TMP' => 'INVALID', /* Provides a string as opposed to value of float-type. */
                )
            )
        );

        $expected_value = 0.00;

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['TMP']
        );
    }

    public function testKeyPadValidationIsCorrect()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'KP' => '5'
                )
            )
        );

        $expected_value = 5;

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['KP']
        );

    }

    public function testKeyPadValidationFailsCorrectly()
    {
        $telemetry_validator = new TelemetryValidator();

        /* Message containing the value to test. */
        $test_message = array(
            0 => array (
                'Content' => array(
                    'KP' => '-1' /* Providing a value not within 1-9 range */
                )
            )
        );

        $expected_value = 0;

        $this->assertEquals(
            $expected_value,
            $telemetry_validator->validateTelemetryData($test_message)[0]['KP']
        );

    }
}
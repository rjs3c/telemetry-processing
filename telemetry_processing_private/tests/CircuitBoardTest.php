<?php declare(strict_types=1);
/**
 * CircuitBoardTest.
 *
 * Tests the correct manipulation of the CircuitBoard.
 * Tests:
 * - Tests that, if no values are set on the Circuit Board, the status message will reflect this.
 * - Tests that, if only some values are set on the Circuit Board, the status message will reflect this.
 * - Tests that, if all values are set on the Circuit Board, the status message will reflect this.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\CircuitBoard;

final class CircuitBoardTest extends TestCase
{
    /**
     * @test To identify if the correct status message is returned if no values have been set on the Circuit Board.
     */
    public function testStatusMessageIndicatesValuesAreNotSet()
    {
        $expected_status_message = 'Circuit board values are not set.';

        $this->assertEquals(
            CircuitBoard::getStatusMessage(),
            $expected_status_message
        );
    }

    /**
     * @test To identify if the correct status message is returned if only partial values are set.
     */
    public function testStatusMessagesNotAllValuesAreSet()
    {
        $expected_status_message = 'Circuit board values are not set.';

        // Some values are set - not all values are.
        $test_switch_values = array(
            'switch_one' => 1,
            'switch_two' => 0,
            'switch_three' => 1,
            'switch_four' => 1
        );

        $test_fan_state = 'forwards';

        // Set values in Circuit Board (keeping in mind, not all values are set).
        CircuitBoard::setSwitches($test_switch_values);
        CircuitBoard::setFanState($test_fan_state);

        $this->assertEquals(
            CircuitBoard::getStatusMessage(),
            $expected_status_message
        );
    }

    /**
     * @test To identify if an appropriate status message is returned if ALL values are set on the Circuit Board.
     */
    public function testStatusMessageIndicatesAllValuesAreSet()
    {
        $expected_status_substring = 'Circuit board values were updated on';

        // ALL values in Circuit Board.
        $test_switch_values = array(
            'switch_one' => 1,
            'switch_two' => 0,
            'switch_three' => 1,
            'switch_four' => 1
        );

        $test_fan_state = 'forwards';

        $test_temperature = 34.0;

        $test_keypad_number = 5;

        // Set ALL test values in Circuit Board.
        CircuitBoard::setSwitches($test_switch_values);
        CircuitBoard::setFanState($test_fan_state);
        CircuitBoard::setTemperature($test_temperature);
        CircuitBoard::setKeypadNumber($test_keypad_number);

        $this->assertStringContainsString(
            $expected_status_substring,
            CircuitBoard::getStatusMessage()
        );
    }
}

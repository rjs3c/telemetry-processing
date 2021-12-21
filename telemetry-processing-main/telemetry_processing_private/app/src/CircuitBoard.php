<?php
/**
 * CircuitBoard.php
 *
 * Simulates a Circuit Board
 * Contains all necessary values, among a message of its status.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class CircuitBoard
{
    /** @var null[] $switches Stores all switch inputs on board. */
    private static $switches = array(
        'switch_one' => null,
        'switch_two' => null,
        'switch_three' => null,
        'switch_four' => null
    );

    /** @var null $fan_state Contains state of fan. */
    private static $fan_state = null;

    /** @var null $temperature Contains the temperature of float-type. */
    private static $temperature = null;

    /** @var null $keypad_number Contains a single integer, representing a keypad-press. */
    private static $keypad_number = null;

    /** @var string Contains an overall status message of the circuit board. */
    private static $board_status = 'Circuit board values are not set.';

    /**
     * Sets switches on the circuit board.
     *
     * @param array $switches
     */
    public static function setSwitches(array $switches) : void
    {
        if (!empty($switches)) {
            self::$switches['switch_one'] = $switches['switch_one'] ?? null;
            self::$switches['switch_two'] = $switches['switch_two'] ?? null;
            self::$switches['switch_three'] = $switches['switch_three'] ?? null;
            self::$switches['switch_four'] = $switches['switch_four'] ?? null;
        }
        self::checkAllValuesSet();
    }

    /**
     * Sets the current fan state of the circuit board.
     *
     * @param string $fan_state
     */
    public static function setFanState(string $fan_state) : void
    {
        if (isset($fan_state)) {
            self::$fan_state = $fan_state;
        }

        self::checkAllValuesSet();
    }

    /**
     * Sets the temperature of the circuit board.
     *
     * @param float $temperature
     */
    public static function setTemperature(float $temperature) : void
    {
        if (isset($temperature)) {
            self::$temperature = $temperature;
        }

        self::checkAllValuesSet();
    }

    /**
     * Sets the current keypad number pressed on the circuit board.
     *
     * @param int $keypad_number
     */
    public static function setKeypadNumber(int $keypad_number) : void
    {
        if (isset($keypad_number)) {
            self::$keypad_number = $keypad_number;
        }

        self::checkAllValuesSet();
    }

    /**
     * Checks all values in the circuit board to identify if all values are set.
     * Sets the status message of the status board accordingly.
     */
    private static function checkAllValuesSet() : void
    {
        if (!in_array(null, self::$switches, true)
            && self::$fan_state !== null
            && self::$temperature !== null
            && self::$keypad_number !== null) {
            self::setStatusMessage('Circuit board values are updated.');
        }
    }

    /**
     * Sets the circuit board's status message.
     *
     * @param string $status_message
     */
    private static function setStatusMessage(string $status_message) : void
    {
        self::$board_status = $status_message;
    }

    /**
     * Returns the status board of the circuit board.
     *
     * @return string
     */
    public static function getStatusMessage() : string
    {
        return self::$board_status;
    }
}
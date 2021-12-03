<?php
/**
 * TelemetryValidator.php
 *
 * Provides a wrapper for validation of various types.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class TelemetryValidator
{
    public function __construct() {}

    public function __destruct() {}

    /**
     * Validates an array of telemetry messages
     * Interprets each element and calls a more specific validation method accordingly.
     *
     * @param array $tainted_telemetry_data
     * @return array
     */
    public function validateTelemetryData(array $tainted_telemetry_data) : array
    {
        $sanitised_telemetry_data = array();

        foreach($tainted_telemetry_data as $telemetry_message) {
            $filtered_telemetry_data = array();

            foreach($telemetry_message as $element => $element_data) {

                foreach($element_data as $element_key => $element_value) {

                    switch($element_key) {
                        case 'GID':
                            $filtered_telemetry_data[$element_key] = $this->validateString($element_value);
                            break;
                        case 'MSDN':
                            $filtered_telemetry_data[$element_key] = $this->validateSenderMSISDN($element_value);
                            break;
                        case 'SW':
                            $filtered_telemetry_data[$element_key] = $this->validateSwitches($element_value);
                            break;
                        case 'FN':
                            $filtered_telemetry_data[$element_key] = $this->validateFanState($element_value);
                            break;
                        case 'TMP':
                            $filtered_telemetry_data[$element_key] = $this->validateTemperature($element_value);
                            break;
                        case 'KP':
                            $filtered_telemetry_data[$element_key] = $this->validateKeypadNumber($element_value);
                            break;
                        default:
                            break;
                    }
                }
            }
            array_push($sanitised_telemetry_data, $filtered_telemetry_data);
        }

        return $sanitised_telemetry_data;
    }

    /**
     * Validates and sanitises a string using filter_var.
     *
     * @param string $tainted_string
     * @return mixed|string
     */
    private function validateString(string $tainted_string) : string
    {
        $cleaned_string = '';

        if (!empty($tainted_string)) {
            $cleaned_string = filter_var($tainted_string, FILTER_SANITIZE_STRING);
        }

        return $cleaned_string;
    }

    /**
     * Validates an MSISDN number by utilising filter_var's regex capability.
     *
     * @param string $tainted_msisdn
     * @return string
     */
    private function validateSenderMSISDN(string $tainted_msisdn) : string
    {
        $cleaned_msisdn = '';

        $msisdn_validation_options = array(
            'options' => array(
                'regexp' => '/^\+44([0-9]{10})/'
            )
        );

        if (!empty($tainted_msisdn)) {
            $cleaned_msisdn = filter_var($tainted_msisdn, FILTER_VALIDATE_REGEXP, $msisdn_validation_options);
        }

        return $cleaned_msisdn;
    }

    /**
     * Validates each switch stored in the 'SW' section.
     * Each individual switch is validated.
     *
     * @param array $tainted_switches
     * @return array
     */
    private function validateSwitches(array $tainted_switches) : array
    {
        $cleaned_switches = array();

        $switches_filter_args = array(
            'SW1' => array(
                'filter' => FILTER_VALIDATE_INT,
                'options' => array('min_range' => 0, 'max_range' => 1),
                'default' => 0
            ),
            'SW2' => array(
                'filter' => FILTER_VALIDATE_INT,
                'options' => array('min_range' => 0, 'max_range' => 1),
                'default' => 0
            ),
            'SW3' => array(
                'filter' => FILTER_VALIDATE_INT,
                'options' => array('min_range' => 0, 'max_range' => 1),
                'default' => 0
            ),
            'SW4' => array(
                'filter' => FILTER_VALIDATE_INT,
                'options' => array('min_range' => 0, 'max_range' => 1),
                'default' => 0
            )
        );

        if (!empty($tainted_switches) || !empty(array_diff_key($tainted_switches, $switches_filter_args))) {
            $cleaned_switches = filter_var_array($tainted_switches, $switches_filter_args);
        }

        return $cleaned_switches;
    }

    /**
     * Validates the state of the fan using a whitelist mechanism.
     *
     * @param string $tainted_fan_state
     * @return string
     */
    private function validateFanState(string $tainted_fan_state) : string
    {
        $cleaned_fan_state = 'off';

        $fan_states = array('forward', 'reverse', 'off');

        if (!empty($tainted_fan_state)
            && in_array($tainted_fan_state, $fan_states)) {
            $cleaned_fan_state = filter_var($tainted_fan_state, FILTER_SANITIZE_STRING);
        }

        return $cleaned_fan_state;
    }

    /**
     * Validates the temperature, by inspecting range and format.
     *
     * @param string $tainted_temperature
     * @return float
     */
    private function validateTemperature(string $tainted_temperature) : float
    {
        $cleaned_temperature = 0.00;

        $temperature_validation_options = array(
            'options' => array(
                'min_range' => -273.15,
                'max_range' => 200.00,
                'decimal' => 2,
                'default' => 0.00
            )
        );

        if (!empty($tainted_temperature)) {
            $cleaned_temperature = filter_var(
                $tainted_temperature,
                FILTER_VALIDATE_FLOAT,
                $temperature_validation_options
            );
        }

        return $cleaned_temperature;
    }

    /**
     * Validates the entered Keypad number.
     * This will be a singular digit, between the values 1 to 9.
     *
     * @param string $tainted_keypad_number
     * @return int
     */
    private function validateKeypadNumber(string $tainted_keypad_number) : int
    {
        $cleaned_keypad_number = 0;

        $keypad_validation_options = array(
          'options' => array(
              'min_range' => 0,
              'max_range' => 9,
              'default' => 0
          )
        );

        if (!empty($tainted_keypad_number)) {
            $cleaned_keypad_number = filter_var(
                $tainted_keypad_number,
                FILTER_VALIDATE_INT,
                $keypad_validation_options
            );
        }

        return $cleaned_keypad_number;
    }

}
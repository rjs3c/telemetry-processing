<?php
/**
 * TelemetryParser
 *
 * Provides a wrapper for parsing operations.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class TelemetryParser
{
    /** @var array $messages_to_parse The string to parse. */
    private $messages_to_parse;

    /** @var array $parse_results Parsed result. */
    private $parse_results;

    public function __construct()
    {
        $this->messages_to_parse = array();
        $this->parse_results = array();
    }

    public function __destruct() {}

    /**
     * Sets the string to be parsed.
     *
     * @param array|null $messages_to_parse
     */
    public function setTelemetryMessages(?array $messages_to_parse) : void
    {
        $this->messages_to_parse = $messages_to_parse;
    }

    /**
     * Returns parsed XML result.
     *
     * @return array|null
     */
    public function getTelemetryParseResults(): ?array
    {
        return $this->parse_results;
    }

    /** Parses XML string into a type array, or <False> if this fails. */
    public function parseTelemetry() : void
    {
        try {
            $xml_parse_result = array();

            libxml_use_internal_errors(true);

            foreach($this->messages_to_parse as $xml_message) {

                $xml = simplexml_load_string(
                    $xml_message,
                    'SimpleXMLElement'
                );

                if ($xml !== false) {
                    $xml_extracted = $this->extrapolateGroupTelemetry(json_decode(json_encode($xml),true));

                    if (isset($xml_extracted)) {
                        array_push($xml_parse_result, $xml_extracted);
                    }
                }
            }
        } catch (\Exception $e) {
        } finally {
            $this->parse_results = $xml_parse_result;
        }
    }

    /**
     * Extracts group-specific XML-based message from XML string.
     *
     * @param array|null $xml
     * @return false|mixed
     */
    private function extrapolateGroupTelemetry(?array $xml) : ?array
    {
        $group_xml_extracted = array();

        if (isset($xml['message'])) {
            $xml_message_section = $xml['message'];
            $group_xml_extracted = isset($xml_message_section['Content']['GID'])
            && $xml_message_section['Content']['GID'] === 'AF'
                ? $xml_message_section : null;
        }

        return $group_xml_extracted;

    }
}
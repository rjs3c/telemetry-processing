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
    /** @var string $string_to_parse The string to parse. */
    private $string_to_parse;

    /** @var array $parse_results Parsed result. */
    private $parse_results;

    public function __construct()
    {
        $this->string_to_parse = '';
        $this->parse_results = null;
    }

    public function __destruct() {}

    /**
     * Sets the string to be parsed.
     *
     * @param string $string_to_parse
     */
    public function setXMLString(string $string_to_parse) : void
    {
        $this->string_to_parse = $string_to_parse;
    }

    /**
     * Returns parsed XML result.
     *
     * @return array|null
     */
    public function getXMLParseResults() : array
    {
        return $this->parse_results;
    }

    /** Parses XML string into a type array, or <False> if this fails. */
    public function parseXML() : void
    {
        try {
            $xml_parse_result = false;

            libxml_use_internal_errors(true);

            $xml = simplexml_load_string(
                $this->string_to_parse,
                'SimpleXMLElement'
            );

            $xml_extracted = $this->extrapolateGroupXML(json_decode(json_encode($xml),true));

            $xml_parse_result = $xml_extracted;
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
    private function extrapolateGroupXML(?array $xml) : ?array
    {
        try {
            $group_xml_extracted = false;

            if (isset($xml['message'])) {

                $xml_message_section = simplexml_load_string(
                    $xml['message'],
                    'SimpleXMLElement'
                );

                if ($xml_message_section) {
                    $xml_message = json_decode(json_encode($xml['message']), true);

                    $group_xml_extracted = $xml_message = $xml_message['MessageMetadata']['Group'] === 'Fellowship' ? $xml_message : false;
                }
            }
        } catch (\Exception $e) {
        } finally {
            return $group_xml_extracted;
        }
    }
}
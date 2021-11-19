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
    public function getXMLParseResults(): ?array
    {
        return $this->parse_results;
    }

    /** Parses XML string into a type array, or <False> if this fails. */
    public function parseXML() : void
    {
        $xml = simplexml_load_string($this->string_to_parse);

        if ($xml !== false) {
            $this->parse_results = json_decode(json_encode($xml),true);
        } else {
            $this->parse_results = false;
        }
    }
}
<?php declare(strict_types=1);
/**
 * TelemetryParserTest.php
 *
 * Tests functionality for TelemetryParser.
 * Tests:
 * - Tests that, among numerous non-group specific messages, that the group-specific message can be correctly extracted.
 * - Tests that, if no group-specific messages exist amidst many others, an empty result is returned.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\TelemetryParser;

require __DIR__ . "/../app/src/TelemetryParser.php";

final class TelemetryParserTest extends TestCase
{
    /**
     * Test case to ensure that in a collection of non-group specific messages, that a group-specific message can be extracted correctly.
     */
    public function testReturnsGroupXML() {
        $telemetry_parser = new TelemetryParser();

        /* Message at index 1 is the correct message. The others are incorrect permutations of this. */
        $xml_messages = array(
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><GID>INVALID</GID><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><GID>AF</GID><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message>Invalid Message</message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
        );

        /* Parsed deconstruction of group-specific message. */
        $expected_array = array(
            0 => array (
                'Content' => array(
                    'GID' => 'AF',
                    'MSDN' => '+440000000000',
                    'SW' => array(
                        'SW1' => '1',
                        'SW2' => '1',
                        'SW3' => '0',
                        'SW4' => '1'
                    ),
                    'FN' => 'forward',
                    'TMP' => '34.0',
                    'KP' => '5'
                )
            )
        );

        $telemetry_parser->setTelemetryMessages($xml_messages);
        $telemetry_parser->parseTelemetry();

        $this->assertEquals(
            $expected_array,
            $telemetry_parser->getTelemetryParseResults()
        );
    }

    /**
     * Test case to identify if no provided XML messages meet the criteria to be classified as a group-specific message, nothing is returned (that is, empty result).
     */
    public function testReturnsNoGroupXML()
    {
        $telemetry_parser = new TelemetryParser();

        $incorrect_xml_messages = array(
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><GID>INVALID</GID><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><GID>A F</GID><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message>Invalid Message</message></messagerx>',
            '<messagerx><sourcemsisdn>440000000000</sourcemsisdn><destinationmsisdn>440000000000</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Content><MSDN>+440000000000</MSDN><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
        );

        $telemetry_parser->setTelemetryMessages($incorrect_xml_messages);
        $telemetry_parser->parseTelemetry();

        $this->assertEmpty(
            $telemetry_parser->getTelemetryParseResults()
        );
    }
}
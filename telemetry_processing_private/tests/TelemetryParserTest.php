<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TelemProc\TelemetryParser;

final class TelemetryParserTest extends TestCase
{
    public function testReturnsGroupXML() {
        $telemetry_parser = new TelemetryParser();

        $xml_messages = array(
            '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Metadata><GID>INVALID_GROUP</GID></Metadata><Content><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message><Metadata><GID>AF</GID></Metadata><Content><SW><SW1>1</SW1><SW2>1</SW2><SW3>0</SW3><SW4>1</SW4></SW><FN>forward</FN><TMP>34.0</TMP><KP>5</KP></Content></message></messagerx>',
            '<messagerx><sourcemsisdn>447817814149</sourcemsisdn><destinationmsisdn>447817814149</destinationmsisdn><receivedtime>25/11/2021 11:44:11</receivedtime><bearer>SMS</bearer><messageref>0</messageref><message>Invalid Message</message></messagerx>'
        );

        $expected_array = array(
            0 => array (
                'Metadata' => array(
                    'GID' => 'AF'
                ),
                'Content' => array(
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
}
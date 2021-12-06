<?php
/**
 * GzipWrapper.php
 *
 * Provides a wrapper for Gzip compression functionality.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class GzipWrapper
{
    /** @var string $compressed_html_output Stores result from compression. */
    private string $compressed_html_output;

    /** @var string $html_output Contains initial HTML output to be compressed. */
    private string $html_output;

    public function __construct() {
        $this->compressed_html_output = '';
        $this->html_output = '';
    }

    public function __destruct() {}

    /**
     * Sets HTML output to be compressed.
     *
     * @param string $html_output
     */
    public function setHtmlOutput(string $html_output) : void
    {
        $this->html_output = $html_output;
    }

    /**
     * Returns compression result.
     *
     * @return string
     */
    public function getCompressionOutput() : string
    {
        return $this->compressed_html_output;
    }

    /**
     * Compresses HTML string using GZIP compression; compression level 9.
     * If compression fails, the original HTML string is used.
     */
    public function gzipCompress() : void
    {
        $compressed_html_output = $this->html_output;

        if (substr_count($_SERVER['HTTP_USER_AGENT'], 'OPERA')
            && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
            $compressed_html_output = gzencode($this->html_output, 9, FORCE_DEFLATE);
        }

        $this->compressed_html_output = $compressed_html_output;
    }
}
<?php
/**
 * homepage.php
 *
 * Displays the Telemetry Processing homepage.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    return $this->telemetryView->render($response,
        'homepage.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => __FILE__,
            'heading_1' => APP_TITLE,
            'fetch_telem_action' => 'fetchtelemetrydata',
            'present_telem_action' => 'presenttelemetrydata',
        )
    );
})->setName('homepage');

/**
 * Compresses html output using GZIP.
 *
 * @param $app
 * @param string $html_output
 * @return mixed
 */
function gzipCompress($app, string $html_output) : string
{
    $gzip_wrapper = $app->getContainer()->get('gzipWrapper');
    $gzip_wrapper->setHtmlOutput($html_output);
    $gzip_wrapper->gzipCompress();

    return $gzip_wrapper->getCompressionOutput();
}
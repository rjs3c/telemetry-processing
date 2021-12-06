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
    $html_output = $this->view->render($response,
        'homepage.html.twig',
        array(
            'page_title' => APP_TITLE,
            'css_file' => CSS_PATH,
            'landing_page' => __FILE__,
            'fetch_telemetry_route' => 'fetchtelemetrydata',
            'heading_1' => APP_TITLE,
            'sub_heading' => ''
        )
    );

    return gzipCompress($app, $html_output);
})->setName('homepage');

/**
 * Compresses html output using GZIP.
 *
 * @param $app
 * @param $html_output
 * @return mixed
 */
function gzipCompress($app, $html_output)
{
    $gzip_wrapper = $app->getContainer()->get('gzipWrapper');
    $gzip_wrapper->setHtmlOutput($html_output);
    $gzip_wrapper->gzipCompress();
    return $gzip_wrapper->getCompressionOutput();
}
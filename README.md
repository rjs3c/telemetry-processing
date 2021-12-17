# Telemetry Processing
## Description
Telemetry Data Processing using PHP and EE's M2M SOAP Service. 
## Team
**21-3110-AF**
## Created by
* @MoAziz123
* @JamesB38
* @rjs3c
## Important Configuration
Telemetry Processing Directory Structure:
```markdown
├── includes
│   ├── **telemetry_processing** (originally telemetry_processing_private)
│   │   ├── app
│   │   ├── tests
│   │   ├── bootstrap.php
├── php_public
│   ├── **telemetry_processing** (originally telemetry_processing_public)
│   │   ├── css
│   │   ├── media
│   │   ├── .htaccess
│   │   ├── index.php
```
In composer.json:
```json
"autoload": {
        "psr-4": {
            "TelemProc\\" : "telemetry_processing/app/src"
        }
```
```json
 "require": {
        "nochso/html-compress-twig": "*"
```
* Further details on how to use html-compress-twig can be found [here](https://github.com/nochso/html-compress-twig)
```bash
$ composer update
```
In telemetry-processing_private/app/settings.php:
```php
return array(
    'telemetrySettings' => array(
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        /* TWIG Settings. */
        'telemetryView' => array(
            'twig_attributes' => array(
                'cache' => CACHE_PATH . 'twig/',
                'auto_reload' => true,
            )
        ),
        /* Doctrine Settings. */
        'doctrineSettings' => array( # Enter your own DB details!
            'driver' => '',
            'host' => '',
            'dbname' => '',
            'port' => '',
            'user' => '',
            'password' => '',
            'charset' => ''
        ),
        /* SOAP Settings. */
        'soapSettings' => array(
            'ee_m2m_username' => '', # Enter your own details!
            'ee_m2m_password' => '', # Enter your own details!
            'ee_m2m_phone_number' => '', # Enter M2M Server MSISDN!
            'wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',
            'soap_attributes' => array(
                'trace' => true,
                'exceptions' => true
            )
        )
    )
);
```
To access these settings in SLIM:
```php
$app->getContainer()->get('telemetrySettings')['telemetryView']
$app->getContainer()->get('telemetrySettings')['doctrineSettings']
$app->getContainer()->get('telemetrySettings')['soapSettings']
```
Application Constants:
* **APP_PATH** : '/app' directory
* **APP_TITLE** : 'Telemetry Processing'
* **CACHE_PATH** : '/cache' directory
* **CSS_PATH** : CSS directory and file
*remember to change the following setting*:
```php
$css_file_name = ''; // CSS file name needed here.
```
* **TEMPLATE_PATH** : '/templates' directory
* **LOG_PATH** : '/logs' directory 

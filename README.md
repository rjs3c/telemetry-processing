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
                'cache' => false,
                'auto_reload' => true,
            )
        ),
        /* Doctrine Settings. */
        'doctrine_settings' => array( # Change these to your own DB settings!
            'driver' => '',
            'host' => '',
            'dbname' => '',
            'port' => '',
            'user' => '',
            'password' => '',
            'charset' => 'utf8'
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
$app->ge
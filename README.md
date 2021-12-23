# Telemetry Processing
## Description
Telemetry Data Processing using PHP and EE's M2M SOAP Service. 
## Team
**21-3110-AF**
## Created by
* @MoAziz123
* @JamesB38
* @rjs3c
## Important Configuration (Must Read!)
### Directory structure
```markdown
├── includes
│   ├── telemetry_processing (NB. originally telemetry_processing_private)
│   │   ├── app
│   │   ├── tests
│   │   ├── bootstrap.php
├── php_public
│   ├── telemetry_processing (NB. originally telemetry_processing_public)
│   │   ├── css
│   │   ├── media
│   │   ├── .htaccess
│   │   ├── index.php
```
### composer.json
This must be configured as follows:
```json
"autoload": {
        "psr-4": {
            "TelemProc\\" : "telemetry_processing/app/src"
        }
```
```json
 "require": {
        "slim/slim": "^3.12",
        "slim/psr7": "^1.1",
        "slim/twig-view": "^2.4",
        "monolog/monolog": "^2",
        "doctrine/orm": "^2.6",
        "ext-sodium": "*",
        "ext-json": "*",
        "ext-simplexml": "*",
        "ext-libxml": "*",
        "nochso/html-compress-twig": "*"
```
```bash
$ composer update
```
* NB. html-compress-twig is **required**, otherwise SLIM routes will not work.
* Further details on how to use html-compress-twig can be found [here](https://github.com/nochso/html-compress-twig)
### settings.php
In `includes/telemetry_processing/app/settings.php`:
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
       /* BCrypt Settings. */
        'bcryptSettings' => array(
            'bcrypt_alg' => PASSWORD_DEFAULT,
            'options' => array(
                'cost' => PASSWORD_BCRYPT_DEFAULT_COST
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
To access these settings using SLIM's DIC:
```php
$app->getContainer()->get('telemetrySettings')['telemetryView'];
$app->getContainer()->get('telemetrySettings')['doctrineSettings'];
$app->getContainer()->get('telemetrySettings')['soapSettings'];
$app->getContainer()->get('telemetrySettings')['bcryptSettings'];
```
### Misc. 
Application Constants:
* **APP_PATH** : `telemetry_processing/app` directory
* **APP_TITLE** : `Telemetry Processing`
* **CACHE_PATH** : `telemetry_processing/app/cache` directory
* **CSS_PATH** : CSS directory and file
```php
/* in includes/telemetry_processing/app/settings.php */
$css_file_name = 'styles.css';
```
* **TEMPLATE_PATH** : `telemetry_processing/app/templates` directory
* **LOG_PATH** : `includes/logs` directory 

# Telemetry Processing
## Description
Telemetry Data Processing using PHP and EE's M2M SOAP Service. 
## Team
**21-3110-AF**
## Created by
* Mo Aziz
* James Brass
* Ryan Instrell
## Contents
1. [Important Configuration](#important-configuration)
2. [Access](#access)
3. [Usage](#usage)
## Important Configuration
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
```
### Administrator User
For correct user management, a user with the 'admin' flag **must** exist in the telemetry_users table.

By default, there is a user of administrator status included. NB. The credentials can and **should** be changed by using the User Management interface.

* **Username** : telemetry_user
* **Password** : telemetry_user_pass

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
## Access
* Go to your web browser (i.e. Firefox, Edge, Chrome, etc).
* Navigate to the web root of your Apache web server.
* Click on telemetry_processing directory.
* Enjoy!
## Usage
### Homepage
This is the main entry point of the application. This provides numerous options/routes:
* **Send Test Telemetry Messages** (Unauthenticated)
    * Uses SOAP to send test telemetry data to EE's M2M server (if your mobile device doesn't work).
* **Fetch and Present Telemetry Data** (Unauthenticated)
    * Shows all currently stored telemetry data in the telemetry_data table.
    * Allows refreshing of the data using 'Fetch' button.
* **Update Circuit Board Status** (Unauthenticated)
    * Allows you to update a simulated circuit board using the most recently stored telemetry values.
* **Manage Users** (Authenticated)
    * Allows a user of administrator status to manage all register users.
        * Changing of Passwords
        * Deletion
    * For a user to be of administrator status, the 'admin' flag must be set in the telemetry_users table.
* **Login**
    * Allows registered users to authenticate.
* **Register**
    * Allows unauthenticated users to register their information.

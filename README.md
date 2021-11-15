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
In telemetry-processing_private/app/settings.php:
```php
return array(
        'databaseSettings' => array( # PDO/DB Details Here!
            'rdbms' => '', 
            'db_host' => '',
            'db_port' => '',
            'db_name' => '',
            'db_user_name' => '',
            'db_user_password' => '',
            'db_encoding' => 'utf8',
            'db_collation' => 'utf8_unicode_ci',
            'pdo_attributes' => array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            )
        ),
        'soapSettings' => array(
            'ee_m2m_username' => '', # Enter your own details!
            'ee_m2m_password' => '', # Enter your own details!
            'ee_m2m_phone_number' => '', # MSISDN here!
            'wsdl' => 'https://m2mconnect.ee.co.uk/orange-soap/services/MessageServiceByCountry?wsdl',
            'soap_attributes' => array(
                'trace' => true,
                'exceptions' => true
            )
        )
    )
);
```

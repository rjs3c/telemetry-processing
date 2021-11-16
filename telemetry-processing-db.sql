CREATE DATABASE IF NOT EXISTS `telemetry_db` COLLATE 'utf8_unicode_ci';
CREATE USER 'telemetry_user'@localhost IDENTIFIED BY ‘telemetry_user_pass';
GRANT SELECT, INSERT ON telemetry_db.* TO 'telemetry_user'@'localhost';

USE telemetry_db;
DROP TABLE IF EXISTS `telemetry_data`;

CREATE TABLE telemetry_data (
 `sender_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
 `sender_number` INT COLLATE utf8_unicode_ci NOT NULL,
 `sender_email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
 `sender_group` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
 `switch_one` BIT COLLATE utf8_unicode_ci NOT NULL,
 `switch_two` BIT COLLATE utf8_unicode_ci NOT NULL,
 `switch_three` BIT COLLATE utf8_unicode_ci NOT NULL,
 `switch_four` BIT COLLATE utf8_unicode_ci NOT NULL,
 `fan` BIT COLLATE utf8_unicode_ci NOT NULL,
 `temperature` DECIMAL(10,2) COLLATE utf8_unicode_ci NOT NULL,
 `keypad` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON
UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
COMMENT='CURRENT_TIMESTAMP';

DROP TABLE IF EXISTS `telemetry_data`;
CREATE TABLE telemetry_data (
 `telemetry_id` INT COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `sender_number` VARCHAR(14) COLLATE utf8_unicode_ci NOT NULL,
 `switch_one` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `switch_two` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `switch_three` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `switch_four` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `fan` ENUM('forward', 'reverse', 'off') DEFAULT 'off' COLLATE utf8_unicode_ci NOT NULL,
 `temperature` DECIMAL(10,2) COLLATE utf8_unicode_ci NOT NULL,
 `keypad` INT(1) COLLATE utf8_unicode_ci NOT NULL,
 `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CURRENT_TIMESTAMP';

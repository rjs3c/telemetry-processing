--
-- Telemetry Data Table
--
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

--
-- Telemetry Dummy Data
--
INSERT INTO `telemetry_data` VALUES ('1', '+440000000000', 1, 1, 1, 1, 'forward', 34.0, 1, '2022-01-01 00:00:00');
INSERT INTO `telemetry_data` VALUES ('2', '+440000000000', 0, 0, 0, 0, 'reverse', 23.0, 5, '2022-01-01 00:00:00');
INSERT INTO `telemetry_data` VALUES ('3', '+440000000000', 1, 0, 1, 0, 'off', 28.0, 9, '2022-01-01 00:00:00');
INSERT INTO `telemetry_data` VALUES ('4', '+440000000000', 0, 1, 0, 1, 'off', 31.0, 2, '2022-01-01 00:00:00');

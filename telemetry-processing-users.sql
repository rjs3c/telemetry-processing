--
-- Telemetry Users Table
--
DROP TABLE IF EXISTS `telemetry_users`;
CREATE TABLE telemetry_users (
 `id` INT COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `username` varchar(30)COLLATE utf8_unicode_ci NOT NULL,
 `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
 `user_created_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CURRENT_TIMESTAMP';

--
-- Telemetry Users Dummy Data
--
INSERT INTO `telemetry_users` VALUES ('1', 'telemetry_user', '$2y$12$DLBlHC2tqH3716bl3qIJEOj/YC9rtRXkVOltx4QA9LvDoj1ESVVpC', '2022-01-01 00:00:00'); -- password: telemetry_user_pass

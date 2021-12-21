USE telemetry_db;
DROP TABLE IF EXISTS `telemetry_users`;
CREATE TABLE telemetry_users (
 `user_id` INT COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `username` varchar(30)COLLATE utf8_unicode_ci NOT NULL,
 `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CURRENT_TIMESTAMP';
DROP TABLE IF EXISTS `telemetry_users`;

CREATE TABLE `telemetry_users` (
    `user_id` INT COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    `user_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
    `user_msisdn` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
    `user_created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='CURRENT_TIMESTAMP';
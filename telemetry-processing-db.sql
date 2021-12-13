CREATE DATABASE IF NOT EXISTS `telemetry_db` COLLATE 'utf8_unicode_ci';
CREATE USER 'telemetry_user'@localhost IDENTIFIED BY 'telemetry_user_pass';
GRANT SELECT, INSERT ON telemetry_db.* TO 'telemetry_user'@'localhost';
USE telemetry_db;

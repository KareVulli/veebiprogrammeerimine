-- Anonüümsete sõnumite tabel


CREATE TABLE IF NOT EXISTS `vpamsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted` tinyint(1) DEFAULT NULL,
  `accepted_by` int(11) DEFAULT NULL,
  `accepted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `color` varchar(32) NOT NULL,
  `tail_length` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
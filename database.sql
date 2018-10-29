-- Anonüümsete sõnumite tabel
CREATE TABLE IF NOT EXISTS `vpamsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted` TINYINT(1) NOT NULL DEFAULT 0,
  `accepted_by` int(11) DEFAULT NULL,
  `accepted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
);


-- Kasside tabel
CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `color` varchar(32) NOT NULL,
  `tail_length` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

-- Kasutajate tabel
CREATE TABLE `vpusers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(32) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `password` VARCHAR(256) NOT NULL,
  `firstname` VARCHAR(64) NOT NULL,
  `lastname` VARCHAR(64) NOT NULL,
  `birthdate` DATE NOT NULL,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
);
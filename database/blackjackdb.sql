CREATE DATABASE IF NOT EXISTS blackjackdb;
USE blackjackdb;
SET default_storage_engine=INNODB;

/********************************USER TABLE*************************************/
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf16 NOT NULL,
  `password` varchar(50) CHARACTER SET utf16 NOT NULL,
  `blocked` tinyint(1) NOT NULL,
  `email` varchar(100) CHARACTER SET utf16 NOT NULL,
  `birthdate` date NOT NULL,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  `balance` int(10) NOT NULL,
  `role` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/********************************HISTORY TABLE*************************************/
DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(10) CHARACTER SET utf16 NOT NULL,
  `description` varchar(100) CHARACTER SET utf16 NOT NULL,
  `debit` int(10) NOT NULL,
  `credit` int(10) NOT NULL,
  `balance` int(10) NOT NULL,
  `player_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

/********************************TOPTEN TABLE*************************************/
DROP TABLE IF EXISTS `topten`;
CREATE TABLE IF NOT EXISTS `topten` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf16 NOT NULL,
  `date` date NOT NULL,
  `score` int(10) NOT NULL,
  `player_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

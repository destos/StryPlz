# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.1.49)
# Database: ko_app_story
# Generation Time: 2010-12-22 21:47:05 -0600
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table parts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `parts`;

CREATE TABLE `parts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(160) NOT NULL,
  `SmsSid` varchar(100) NOT NULL,
  `added` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;



# Dump of table stories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories`;

CREATE TABLE `stories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(5) NOT NULL,
  `turns` smallint(3) unsigned NOT NULL DEFAULT '10',
  `cur_turn` smallint(3) unsigned DEFAULT '1',
  `cur_teller` int(11) unsigned DEFAULT NULL,
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `started` int(12) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_2` (`slug`),
  UNIQUE KEY `cur_teller_2` (`cur_teller`),
  KEY `cur_teller` (`cur_teller`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;



# Dump of table stories_parts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories_parts`;

CREATE TABLE `stories_parts` (
  `story_id` int(11) unsigned NOT NULL,
  `part_id` int(11) unsigned NOT NULL,
  KEY `story_id` (`story_id`),
  KEY `part_id` (`part_id`),
  CONSTRAINT `stories_parts_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stories_parts_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tellers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tellers`;

CREATE TABLE `tellers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `joined` int(11) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;



# Dump of table tellers_parts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tellers_parts`;

CREATE TABLE `tellers_parts` (
  `teller_id` int(11) unsigned NOT NULL,
  `part_id` int(11) unsigned NOT NULL,
  KEY `teller_id` (`teller_id`),
  KEY `part_id` (`part_id`),
  CONSTRAINT `tellers_parts_ibfk_1` FOREIGN KEY (`teller_id`) REFERENCES `tellers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tellers_parts_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tellers_stories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tellers_stories`;

CREATE TABLE `tellers_stories` (
  `teller_id` int(11) unsigned NOT NULL,
  `story_id` int(11) unsigned NOT NULL,
  KEY `teller_id` (`teller_id`),
  KEY `story_id` (`story_id`),
  CONSTRAINT `tellers_stories_ibfk_1` FOREIGN KEY (`teller_id`) REFERENCES `tellers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tellers_stories_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

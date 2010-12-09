# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.0.77)
# Database: ko_app_story
# Generation Time: 2010-11-27 16:50:20 -0600
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
  `id` int(11) unsigned NOT NULL auto_increment,
  `text` varchar(140) NOT NULL,
  `SmsSid` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` (`id`,`text`,`SmsSid`)
VALUES
	(1,'my life is a mess i can take it any more, stuff like that is troubling, ya know. let me explain,','SM228b3114077f36c2c7798bae3e071c9f');

/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories`;

CREATE TABLE `stories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `turns` smallint(3) unsigned NOT NULL default '10',
  `cur_turn` smallint(3) unsigned default '1',
  `cur_teller` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cur_teller_2` (`cur_teller`),
  KEY `cur_teller` (`cur_teller`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `stories` WRITE;
/*!40000 ALTER TABLE `stories` DISABLE KEYS */;
INSERT INTO `stories` (`id`,`turns`,`cur_turn`,`cur_teller`)
VALUES
	(3,10,1,6);

/*!40000 ALTER TABLE `stories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stories_parts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories_parts`;

CREATE TABLE `stories_parts` (
  `story_id` int(11) unsigned NOT NULL,
  `part_id` int(11) unsigned NOT NULL,
  KEY `story_id` (`story_id`),
  KEY `part_id` (`part_id`),
  CONSTRAINT `stories_parts_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stories_parts_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `stories_parts` WRITE;
/*!40000 ALTER TABLE `stories_parts` DISABLE KEYS */;
INSERT INTO `stories_parts` (`story_id`,`part_id`)
VALUES
	(3,1);

/*!40000 ALTER TABLE `stories_parts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tellers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tellers`;

CREATE TABLE `tellers` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `joined` int(11) default NULL,
  `phone_number` varchar(15) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `tellers` WRITE;
/*!40000 ALTER TABLE `tellers` DISABLE KEYS */;
INSERT INTO `tellers` (`id`,`joined`,`phone_number`)
VALUES
	(6,1290895168,'+18458030695');

/*!40000 ALTER TABLE `tellers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tellers_parts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tellers_parts`;

CREATE TABLE `tellers_parts` (
  `teller_id` int(11) unsigned NOT NULL,
  `part_id` int(11) unsigned NOT NULL,
  KEY `teller_id` (`teller_id`),
  KEY `part_id` (`part_id`),
  CONSTRAINT `tellers_parts_ibfk_2` FOREIGN KEY (`part_id`) REFERENCES `parts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tellers_parts_ibfk_1` FOREIGN KEY (`teller_id`) REFERENCES `tellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tellers_parts` WRITE;
/*!40000 ALTER TABLE `tellers_parts` DISABLE KEYS */;
INSERT INTO `tellers_parts` (`teller_id`,`part_id`)
VALUES
	(6,1);

/*!40000 ALTER TABLE `tellers_parts` ENABLE KEYS */;
UNLOCK TABLES;


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

LOCK TABLES `tellers_stories` WRITE;
/*!40000 ALTER TABLE `tellers_stories` DISABLE KEYS */;
INSERT INTO `tellers_stories` (`teller_id`,`story_id`)
VALUES
	(6,3);

/*!40000 ALTER TABLE `tellers_stories` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

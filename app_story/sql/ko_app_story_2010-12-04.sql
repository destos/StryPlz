# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.0.77)
# Database: ko_app_story
# Generation Time: 2010-12-04 12:28:41 -0600
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` (`id`,`text`,`SmsSid`)
VALUES
	(1,'my life is a mess i can take it any more, stuff like that is troubling, ya know. let me explain,','SM228b3114077f36c2c7798bae3e071c9f'),
	(2,'It all started when','SMccf7414832ffe2dfa34b89fb87906700'),
	(3,'My father tied to beat me.','SMa060870492c61d06a8b9e1a585e29d81'),
	(4,'I can\'t quite understand the exact reasons for doing so bu the others may have a reason for this. Maybe so or what.','SMcf125fef14e49e745fc7586e51f28421'),
	(5,'one day i was walking down the road minding my own business when i decided to try something.','SM40131762bcf33024c53e6f052a8f7e13'),
	(6,'It was different, and you will understand my apprehension in telling you shortly. ','SMa3206ebc62952af42d4a2dcce23689b8'),
	(8,'I tried to moon walk.','SMf9e87faa8892f5ca352d856b7d4d2867'),
	(9,'once upon a time','SM117cf5d1ade61076b5bf272264a28d10'),
	(10,'A little mermaid had some fun with a lion fish, it didn\'t end well.','SM58aaed61f4a16625958e4f71ddbd1a3c'),
	(11,'can\'t get nothing without something.','SM74d8f2c3bc4a7c1bd81888d2e96c6519'),
	(12,'you know it!','SM235b96c9a16f4e73e539b9e6cdb66c6c'),
	(13,'i love you!','SMb35fa9ce5315ab36064869ca0d5a760d'),
	(14,'Really I do!','SM10cc9d3ab805fce2b88034c4db4a0fe6'),
	(15,'once upon a time... a monkey came after a friend of mine.','SM2cf7b14ed52238a9952f7de1153087ad'),
	(16,'And then we made lunch','SM34f6d542fa5d0f8cda8327785c06e214'),
	(17,'carlos is a total','SM43df8e5a62b945f0a3e76471274695c3'),
	(18,'Cool kid, but not as cool as Patrick. Patrick codes cool stuff on the Internet while Carlos spends his time listening to music.','SM8697fb44aab746418edbed4a59183b68'),
	(19,'However carlos does listen to some cool music, which makes him pretty cool.','SM21796384d019049171a153a381ca8c87'),
	(20,'make this story my mothers story, we can\'t get it running from here.','SMe4604e7a75259b640856defc659f4e32'),
	(21,'when we made change, the others laughed as well','SMd7b11953efa6f9b9e943a08cbd05cb6a');

/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stories`;

CREATE TABLE `stories` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `turns` smallint(3) unsigned NOT NULL default '10',
  `cur_turn` smallint(3) unsigned default '1',
  `cur_teller` int(11) unsigned default NULL,
  `locked` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cur_teller_2` (`cur_teller`),
  KEY `cur_teller` (`cur_teller`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

LOCK TABLES `stories` WRITE;
/*!40000 ALTER TABLE `stories` DISABLE KEYS */;
INSERT INTO `stories` (`id`,`turns`,`cur_turn`,`cur_teller`,`locked`)
VALUES
	(3,10,1,NULL,0),
	(4,5,3,NULL,0),
	(5,10,2,NULL,0),
	(6,4,2,NULL,0),
	(7,2,2,NULL,1),
	(8,10,2,NULL,0),
	(9,5,3,NULL,0),
	(10,5,1,NULL,0),
	(11,8,1,6,0);

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
	(3,1),
	(3,2),
	(3,3),
	(3,4),
	(4,5),
	(4,6),
	(4,8),
	(5,9),
	(5,10),
	(6,11),
	(6,12),
	(7,13),
	(7,14),
	(8,15),
	(8,16),
	(9,17),
	(9,18),
	(9,19),
	(10,20),
	(11,21);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

LOCK TABLES `tellers` WRITE;
/*!40000 ALTER TABLE `tellers` DISABLE KEYS */;
INSERT INTO `tellers` (`id`,`joined`,`phone_number`)
VALUES
	(6,1290895168,'+18458030695'),
	(7,1290901793,'+19182893927'),
	(8,1290966635,'+19184073416'),
	(9,1291045255,'+19185498611');

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
	(6,1),
	(6,3),
	(6,4),
	(6,5),
	(6,6),
	(6,8),
	(7,9),
	(6,10),
	(6,11),
	(6,12),
	(6,13),
	(6,14),
	(8,15),
	(6,16),
	(6,17),
	(9,18),
	(6,19),
	(6,20),
	(6,21);

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
	(6,3),
	(6,4),
	(7,5),
	(6,6),
	(6,7),
	(8,8),
	(6,9),
	(6,10),
	(6,11);

/*!40000 ALTER TABLE `tellers_stories` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

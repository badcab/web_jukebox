/*tables*/

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `web_jukebox` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `web_jukebox`;

CREATE TABLE IF NOT EXISTS `current_vote_stack` (
  `id_hash` int(11) unsigned NOT NULL,
  `song1_id` int(11) unsigned NOT NULL,
  `song2_id` int(11) unsigned NOT NULL,
  `song3_id` int(11) unsigned NOT NULL,
  `vote1` int(5) unsigned NOT NULL DEFAULT '0',
  `vote2` int(5) unsigned NOT NULL DEFAULT '0',
  `vote3` int(5) unsigned NOT NULL DEFAULT '0',
  `song1_desc` varchar(150) DEFAULT NULL,
  `song2_desc` varchar(150) DEFAULT NULL,
  `song3_desc` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `login` (
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(2) NOT NULL DEFAULT '0',
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `song_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `artist` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `file_path` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `has_played` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_1` 
  FOREIGN KEY (`song1_id`) 
  REFERENCES `songs` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_2` 
  FOREIGN KEY (`song2_id`) 
  REFERENCES `songs` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_3` 
  FOREIGN KEY (`song3_id`) 
  REFERENCES `songs` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `queue`
  ADD CONSTRAINT `queue_ibfk_1` 
  FOREIGN KEY (`song_id`) 
  REFERENCES `songs` (`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;



/*triggers*/

--when a row is removed from the queue




/*stored procedure*/

--add row to current_vote_stack


/*functions*/

--getRandomSong(CATAGORY)  //get a song not allready played or in the 
--vote stact or the queue in the category if possile

--getRandomCatagory()	 //randomly select a category   SELECT ROUND(RAND() * 999999);
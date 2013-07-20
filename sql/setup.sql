/*tables*/
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE `web_jukebox` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `web_jukebox`;

CREATE TABLE IF NOT EXISTS `current_vote_stack` (
  `id_hash` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `song1_id` int(11) unsigned NOT NULL,
  `song2_id` int(11) unsigned NOT NULL,
  `song3_id` int(11) unsigned NOT NULL,
  `vote1` int(5) unsigned NOT NULL DEFAULT 0,
  `vote2` int(5) unsigned NOT NULL DEFAULT 0,
  `vote3` int(5) unsigned NOT NULL DEFAULT 0,
  `song1_desc` varchar(150) DEFAULT NULL,
  `song2_desc` varchar(150) DEFAULT NULL,
  `song3_desc` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`current_vote_stack`.`id_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `login` (
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(2) NOT NULL DEFAULT 0,
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`login`.`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `song_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`queue`.`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `songs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `artist` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `file_path` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `has_played` tinyint(2) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`songs`.`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_1` 
  FOREIGN KEY (`current_vote_stack`.`song1_id`) 
  REFERENCES `songs` (`songs`.`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_2` 
  FOREIGN KEY (`current_vote_stack`.`song2_id`) 
  REFERENCES `songs` (`songs`.`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `current_vote_stack`
  ADD CONSTRAINT `current_vote_stack_ibfk_3` 
  FOREIGN KEY (`current_vote_stack`.`song3_id`) 
  REFERENCES `songs` (`songs`.`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `queue`
  ADD CONSTRAINT `queue_ibfk_1` 
  FOREIGN KEY (`queue`.`song_id`) 
  REFERENCES `songs` (`songs`.`id`) 
  ON DELETE CASCADE ON UPDATE CASCADE;

/*functions*/
DELIMITER $$
DROP FUNCTION IF EXISTS DELETE_VOTE_STACK $$
CREATE FUNCTION DELETE_VOTE_STACK (REMOVE TIMESTAMP) RETURNS INT
BEGIN
  DELETE FROM `web_jukebox`.`current_vote_stack` WHERE `current_vote_stack`.`id_hash` = REMOVE;
  RETURN 0;
END $$
DELIMITER ;

DELIMITER $$
DROP FUNCTION IF EXISTS ADD_QUEUE $$
CREATE FUNCTION ADD_QUEUE (SONG_ID INT(11)) RETURNS INT
BEGIN
  INSERT INTO `web_jukebox`.`queue` (`song_id`) VALUES (SONG_ID);
  UPDATE  `web_jukebox`.`songs` SET  `songs`.`has_played` =  '1' WHERE  `songs`.`id` = SONG_ID;
  RETURN 0;
END $$
DELIMITER ;

DELIMITER $$ 
DROP FUNCTION IF EXISTS SAVE_VOTE_STACK $$
CREATE FUNCTION SAVE_VOTE_STACK ( SONG1_ID INT(11), SONG2_ID INT(11), SONG3_ID INT(11), SONG1_ARTIST varchar(50), SONG2_ARTIST varchar(50), SONG3_ARTIST varchar(50), SONG1_NAME varchar(50), SONG2_NAME varchar(50), SONG3_NAME varchar(50)) RETURNS INT
BEGIN
  INSERT INTO `web_jukebox`.`current_vote_stack` (
    `id_hash` ,
    `song1_id` ,
    `song2_id` ,
    `song3_id` ,
    `song1_desc` ,
    `song2_desc` ,
    `song3_desc`
  )
  VALUES (
    CURRENT_TIMESTAMP , SONG1_ID, SONG2_ID, SONG3_ID, CONCAT(SONG1_NAME  ,' - ', SONG1_ARTIST), CONCAT(SONG2_NAME  ,' - ', SONG2_ARTIST), CONCAT(SONG3_NAME  ,' - ', SONG3_ARTIST)
  );

  RETURN 0;
END $$
DELIMITER ;

DELIMITER $$
DROP FUNCTION IF EXISTS SELECT_WINNING_SONG $$
CREATE FUNCTION SELECT_WINNING_SONG ( S1_ID INT(11), S2_ID INT(11), S3_ID INT(11), S1_V INT(5), S2_V INT(5), S3_V INT(5)) RETURNS INT
BEGIN
  IF S1_V >= S2_V THEN
    IF S1_V >= S3_V THEN RETURN S1_ID;
    END IF;
  ELSEIF S2_V >= S1_V THEN
    IF S2_V >= S3_V THEN RETURN S2_ID;
    END IF;
  ELSEIF S3_V >= S2_V THEN
    IF S3_V >= S1_V THEN RETURN S3_ID;
    END IF;
  END IF;
END $$
DELIMITER ;

DELIMITER $$
DROP FUNCTION IF EXISTS SET_SONG $$
CREATE FUNCTION SET_SONG ( SONG_RANDOM_SELECT INT(11), SONG_RANDOM_SELECT_CATEGORY_EXPIRE INT(11)) RETURNS INT
BEGIN
  IF ISNULL(SONG_RANDOM_SELECT) THEN RETURN SONG_RANDOM_SELECT_CATEGORY_EXPIRE;
  ELSE RETURN SONG_RANDOM_SELECT;
  END IF;
END $$
DELIMITER ;

/*stored procedure*/
DELIMITER $$ /*fail*/
DROP PROCEDURE IF EXISTS web_jukebox.ADD_TO_CURRENT_VOTE_STACK $$
CREATE PROCEDURE web_jukebox.ADD_TO_CURRENT_VOTE_STACK ()
BEGIN
  SET @CATAGORY_RANDOM_SELECT =(SELECT `songs`.`category` FROM `songs` WHERE `songs`.`has_played` = 0 ORDER BY RAND() LIMIT 1);
  SET @SONG1_RANDOM_SELECT =(SELECT `songs`.`id` FROM `songs` WHERE `songs`.`has_played` = 0 AND `songs`.`category` = @CATAGORY_RANDOM_SELECT ORDER BY RAND() LIMIT 1);
  SET @SONG2_RANDOM_SELECT =(SELECT `songs`.`id` FROM `songs` WHERE `songs`.`has_played` = 0 AND `songs`.`category` = @CATAGORY_RANDOM_SELECT AND `songs`.`id` != @SONG1_RANDOM_SELECT ORDER BY RAND() LIMIT 1);
  SET @SONG3_RANDOM_SELECT =(SELECT `songs`.`id` FROM `songs` WHERE `songs`.`has_played` = 0 AND `songs`.`category` = @CATAGORY_RANDOM_SELECT AND `songs`.`id` != @SONG1_RANDOM_SELECT AND `songs`.`id` != @SONG2_RANDOM_SELECT ORDER BY RAND() LIMIT 1);

  SET @SONG2_RANDOM_SELECT_CATEGORY_EXPIRE =(SELECT `songs`.`id` FROM `songs` WHERE `songs`.`id` != @SONG1_RANDOM_SELECT ORDER BY RAND() LIMIT 1);
  SET @SONG3_RANDOM_SELECT_CATEGORY_EXPIRE =(SELECT `songs`.`id` FROM `songs` WHERE `songs`.`id` != @SONG1_RANDOM_SELECT AND `songs`.`id` != @SONG2_RANDOM_SELECT ORDER BY RAND() LIMIT 1);
/*add code to these selects to not grab songs already in the vote_stack*/
  SET @SONG1_ID = @SONG1_RANDOM_SELECT;
  SET @SONG2_ID = SET_SONG ( @SONG2_RANDOM_SELECT, @SONG2_RANDOM_SELECT_CATEGORY_EXPIRE);
  SET @SONG3_ID = SET_SONG ( @SONG3_RANDOM_SELECT, @SONG3_RANDOM_SELECT_CATEGORY_EXPIRE);

  SET @SONG1_ARTIST =(SELECT `songs`.`artist` WHERE `songs`.`id` = @SONG1_ID);
  SET @SONG2_ARTIST =(SELECT `songs`.`artist` WHERE `songs`.`id` = @SONG2_ID);
  SET @SONG3_ARTIST =(SELECT `songs`.`artist` WHERE `songs`.`id` = @SONG3_ID);

  SET @SONG1_NAME =(SELECT `songs`.`name` WHERE `songs`.`id` = @SONG1_ID);
  SET @SONG2_NAME =(SELECT `songs`.`name` WHERE `songs`.`id` = @SONG2_ID);
  SET @SONG3_NAME =(SELECT `songs`.`name` WHERE `songs`.`id` = @SONG3_ID);

  SET @RESULT = SAVE_VOTE_STACK(@SONG1_ID, @SONG2_ID, @SONG3_ID, @SONG1_ARTIST, @SONG2_ARTIST, @SONG3_ARTIST, @SONG1_NAME, @SONG2_NAME, @SONG3_NAME);
END $$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS web_jukebox.ADD_TO_QUEUE $$
CREATE PROCEDURE web_jukebox.ADD_TO_QUEUE ()
BEGIN
  SET @OLDEST_VOTE_STACK_RECORD =(SELECT `current_vote_stack`.`id_hash` FROM `current_vote_stack` ORDER BY `current_vote_stack`.`id_hash` LIMIT 1);

  SET @S1_V =(SELECT `current_vote_stack`.`song1_id` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);
  SET @S1_ID =(SELECT `current_vote_stack`.`vote1` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);

  SET @S2_V =(SELECT `current_vote_stack`.`song2_id` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);
  SET @S2_ID =(SELECT `current_vote_stack`.`vote2` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);

  SET @S3_V =(SELECT `current_vote_stack`.`song3_id` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);
  SET @S3_ID =(SELECT `current_vote_stack`.`vote3` FROM `current_vote_stack` WHERE `current_vote_stack`.`id_hash` = @OLDEST_VOTE_STACK_RECORD);

  SET @WINNING_SONG_ID = SELECT_WINNING_SONG( @S1_ID, @S2_ID, @S3_ID, @S1_V, @S2_V, @S3_V);

  SET @DELETED = DELETE_VOTE_STACK (@OLDEST_VOTE_STACK_RECORD);
  SET @ADDED = ADD_QUEUE (@WINNING_SONG_ID);
END $$
DELIMITER ;

/*triggers*/
DELIMITER $$
DROP TRIGGER IF EXISTS `web_jukebox`.`ADD_TO_CURRENT_VOTE_STACK_trigger` $$
CREATE TRIGGER `web_jukebox`.`ADD_TO_CURRENT_VOTE_STACK_trigger` AFTER DELETE ON `web_jukebox`.`queue`
FOR EACH ROW
BEGIN
  CALL web_jukebox.ADD_TO_QUEUE ();
  CALL web_jukebox.ADD_TO_CURRENT_VOTE_STACK ();
END $$
DELIMITER ;

/*dummy data*/
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('I am the Best', '2NE1', 'path/to/file', 'kpop');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Fire', '2NE1', 'path/to/file', 'kpop');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Bubble Pop', 'Hyuna', 'path/to/file', 'kpop');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Animal', 'SNSD', 'path/to/file', 'kpop');

INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Its My Life', 'Bon Jovi', 'path/to/rockfile', 'rock');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Living On A Prayer', 'Bon Jovi', 'path/to/rockfile', 'rock');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Huricate', 'Scorpian', 'path/to/rockfile', 'rock');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Gangsters Paradice', 'Coolio', 'path/to/rockfile', 'rock');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Slipery When Wet', 'Bon Jovi', 'path/to/rockfile', 'rock');

INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man', 'Hey Man', 'path/to/indefile', 'inde');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man2', 'Hey Man2', 'path/to/indefile', 'inde');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man3', 'Hey Man3', 'path/to/indefile', 'inde');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man4', 'Hey Man4', 'path/to/indefile', 'inde');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man5', 'Hey Man5', 'path/to/indefile', 'inde');
INSERT INTO `web_jukebox`.`songs` (`name`, `artist`, `file_path`, `category`) VALUES ('Hey Man6', 'Hey Man6', 'path/to/indefile', 'inde');

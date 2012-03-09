<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2012 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', '../' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

include("../config.inc.php");
include("../libraries/functions.inc.php");
include("../libraries/classes.php");
include("../libraries/html.classes.php");
include("../libraries/GeoCalc.class.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("../languages/".get_lang($cfg['config_language']).".php");
include("../head.html.php");

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$upgrade = getUrlParam('HTTP_POST', 'INT', 'upgrade');
$db_root = getUrlParam('HTTP_POST', 'STRING', 'db_root');
$db_rootpass = getUrlParam('HTTP_POST', 'STRING', 'db_rootpass');

HTML::heading(_INST_OSM_SETUP._INST_DB_INST, 3);
HTML::message(_INST_GUIDED);
?>

<ol start="1" type="1">
  <li id="done"><?php echo _INST_WELCOME; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_CHECKS; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_CONFIG; ?> <img src='../images/tick_12.png'></li>
  <li id="current"><?php echo _INST_DB_CREATE_SETUP; ?></li>
  <li><?php echo _INST_DONE; ?></li>
</ol>
  
<?php
HTML::message(_INST_PROG_INST);

$mysql_err_count = 0;
// connect to database server
if($db_root && $db_rootpass) {
	$link = mysql_connect($cfg['db_host'], $db_root, $db_rootpass);
}else
	$link = mysql_connect($cfg['db_host'], $cfg['db_user'], $cfg['db_password']);

if(!$link) {
    out(_INST_DB_CONN_ERROR. mysql_error(), 3);
    $mysql_err_count++;
}else {

	// initial database installation: create database
	if(!$upgrade) {
		$query = "CREATE DATABASE IF NOT EXISTS `".$cfg['db_name']."`;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
	}
	
	// select database
	if(!mysql_select_db($cfg['db_name'], $link)) {
	    out(_INST_DB_ERROR. mysql_error(), 3);
	    $mysql_err_count++;
	}
	
	// initial database installation: create tables
	if(!$upgrade) {
		$query = "CREATE TABLE IF NOT EXISTS `${cfg['db_table_prefix']}gpx_files` (
		  `id` bigint(64) NOT NULL auto_increment,
		  `user_id` bigint(20) NOT NULL,
		  `visible` tinyint(1) NOT NULL default '1',
		  `name` varchar(255) NOT NULL default '',
		  `size` bigint(20) default NULL,
		  `length` int(11) default NULL,
		  `latitude` double default NULL,
		  `longitude` double default NULL,
		  `timestamp` datetime NOT NULL,
		  `timezone` tinyint(2) NOT NULL default '0',
		  `public` tinyint(1) NOT NULL default '1',
		  `description` varchar(255) NOT NULL default '',
		  `inserted` tinyint(1) NOT NULL,
		  PRIMARY KEY (`id`),
		  UNIQUE INDEX (`name`),
		  KEY `gpx_files_timestamp_idx` (`timestamp`),
		  KEY `gpx_files_visible_public_idx` (`visible`,`public`)
		) ENGINE=MyISAM CHARSET=utf8;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
		
		$query = "CREATE TABLE IF NOT EXISTS `${cfg['db_table_prefix']}gpx_import` (
		  `altitude` float default NULL,
		  `trackid` int(11) NOT NULL default '0',
		  `latitude` int(11) NOT NULL default '0',
		  `longitude` int(11) NOT NULL default '0',
		  `gpx_id` bigint(64) NOT NULL default '0',
		  `timestamp` datetime default NULL,
		  `tile` int(11) NOT NULL default '0',
		  `fix` tinyint(3) unsigned default NULL,
		  `sat` tinyint(3) unsigned default NULL,
		  `hdop` float unsigned default NULL,
		  `pdop` float unsigned default NULL,
		  `course` float default NULL,
		  `speed` float default NULL,
		  KEY `points_gpxid_idx` (`gpx_id`),
		  KEY `points_tile_idx` (`tile`)
		) ENGINE=MyISAM CHARSET=utf8;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
		
		// grant privileges to db user
		if($db_root && $db_rootpass) {
			$query = "GRANT select,insert,update,delete ON `".$cfg['db_name']."`.* TO 
				'".$cfg['db_user']."'@'".$cfg['db_host']."' identified by '".$cfg['db_password']."'; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
		}
	}
	
	// install or upgrade database for app version 0.3 and later
	if(!$upgrade || $upgrade >= 3) {
		// new in app version 0.3
		HTML::message(_INST_UPGR3_ADD_BOOKM_TBL);
		$query = "CREATE TABLE IF NOT EXISTS `${cfg['db_table_prefix']}bookmarks` (
		  `id` int(11) NOT NULL auto_increment,
		  `name` varchar(32) NOT NULL default '',
		  `url` varchar(255) NOT NULL default '',
		  `latitude` int(11) NOT NULL,
		  `longitude` int(11) NOT NULL,
		  `zoom` tinyint(2) NOT NULL default '12',
		  `timestamp` datetime default NULL,
		  `public` tinyint(1) NOT NULL default '1',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM CHARSET=utf8;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
		
		HTML::message(_INST_UPGR3_ADD_WAYPTS_TBL);
		$query = "CREATE TABLE IF NOT EXISTS `${cfg['db_table_prefix']}waypoints` (
		  `id` int(11) NOT NULL auto_increment,
		  `altitude` float default NULL,
		  `latitude` int(11) NOT NULL default '0',
		  `longitude` int(11) NOT NULL default '0',
		  `timestamp` datetime default NULL,
		  `name` varchar(64) NULL default '',
		  `cmt` varchar(255) NULL default '',
		  `desc` varchar(255) NULL default '',
		  `icon_file` varchar(128) NOT NULL default '',
		  `icon_size` varchar(8) NOT NULL default '',
		  `icon_offset` varchar(8) NOT NULL default '',
		  `gpx_id` bigint(64) NOT NULL default '0',
		  `user_id` bigint(20) NOT NULL,
		  `public` tinyint(1) NOT NULL default '1',
		  PRIMARY KEY (`id`),
		  KEY `gpx_id` (`gpx_id`)
		) ENGINE=MyISAM CHARSET=utf8;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
		
		// new in app version 0.5
		HTML::message(_INST_UPGR5_ADD_POIS_TBL);
		$query = "CREATE TABLE IF NOT EXISTS `${cfg['db_table_prefix']}pois` (
		  `id` int(11) NOT NULL auto_increment,
		  `altitude` float default NULL,
		  `latitude` int(11) NOT NULL default '0',
		  `longitude` int(11) NOT NULL default '0',
		  `timestamp` datetime default NULL,
		  `speed` float default NULL,
		  `move_dir` float default NULL,
		  `image_dir` float default NULL,
		  `size` int(11) NOT NULL default '0',
		  `file` varchar(255) NOT NULL default '',
		  `title` varchar(128) NOT NULL default '',
		  `description` tinytext NOT NULL,
		  `thumb` blob,
		  `icon_file` varchar(128) NOT NULL default '',
		  `icon_size` varchar(8) NOT NULL default '',
		  `icon_offset` varchar(8) NOT NULL default '',
		  `gpx_id` bigint(64) NOT NULL default '0',
		  `user_id` bigint(20) NOT NULL default '0',
		  `public` tinyint(1) NOT NULL default '1',
		  PRIMARY KEY (`id`),
		  KEY `gpx_id` (`gpx_id`)
		) ENGINE=MyISAM CHARSET=utf8;";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
	}
	
	// upgrade database for app version 0.4
	if($upgrade >= 4) {
		$query = "ALTER TABLE `${cfg['db_table_prefix']}waypoints` 
				CHANGE `name` `name` VARCHAR(64) NULL, 
				CHANGE `cmt` `cmt` VARCHAR(255) NULL, 
				CHANGE `desc` `desc` VARCHAR(255) NULL; ";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
	}
	
	// upgrade database for app version 0.5
	if($upgrade >= 5) {
		$query = "ALTER TABLE `${cfg['db_table_prefix']}gpx_import` 
				CHANGE `fix` `fix` VARCHAR(4) NULL; ";
		$result = mysql_query($query);
		if(!$result) {
		    out(_INST_DB_ERROR. mysql_error(), 3);
		    $mysql_err_count++;
		}
	}
	
	// upgrade database for app version 0.6
	if($upgrade >= 6) {
		// check for existing UNIQUE index on column 'name'
		$unique_exists = FALSE;
		$query = "SHOW INDEX FROM `${cfg['db_table_prefix']}gpx_files`; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if(!$row['Non_unique'] && $row['Column_name'] == "name")
				$unique_exists = TRUE;
		}
		// add UNIQUE index if it does not exist
		if(!$unique_exists) {
			$query = "ALTER IGNORE TABLE `${cfg['db_table_prefix']}gpx_files` 
					ADD UNIQUE (`name`); ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
			#out("add unique to gpx_files", 'OUT_DEBUG');
		}
		
		// check for existing UNIQUE index on column 'timestamp'
		$unique_exists = FALSE;
		$query = "SHOW INDEX FROM `${cfg['db_table_prefix']}gpx_import`; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if(!$row['Non_unique'] && $row['Column_name'] == "timestamp")
				$unique_exists = TRUE;
		}
		// delete UNIQUE index if it exists
		if($unique_exists) {
			$query = "ALTER IGNORE TABLE `${cfg['db_table_prefix']}gpx_import` 
					DROP INDEX `timestamp`; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
			#out("drop unique from gpx_import trkpts", 'OUT_DEBUG');
		}
		
		// check for existing UNIQUE index on column 'timestamp'
		$unique_names = array();
		$query = "SHOW INDEX FROM `${cfg['db_table_prefix']}waypoints`; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if(!$row['Non_unique'] && $row['Column_name'] == "timestamp")
				$unique_names[] = $row['Key_name'];
		}
		// delete UNIQUE index if it exists
		foreach($unique_names as $index_name) {
			$query = "ALTER IGNORE TABLE `${cfg['db_table_prefix']}waypoints` 
					DROP INDEX `$index_name`; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
			#out("drop unique $index_name from waypoints", 'OUT_DEBUG');
		}
		
		// check for existing column 'length'
		$column_exists = FALSE;
		$query = "SHOW COLUMNS FROM `${cfg['db_table_prefix']}gpx_files` LIKE 'length'; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['Field'] == "length")
				$column_exists = TRUE;
		}
		// add column for track length for gpx files
		if(!$column_exists) {
			$query = "ALTER TABLE `${cfg['db_table_prefix']}gpx_files` 
					ADD `length` int(11) default NULL AFTER `size`; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
			
			// fill that column (calculate length of all tracks)
			$query = "SELECT `id` FROM `${cfg['db_table_prefix']}gpx_files` WHERE `length` IS NULL; ";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				Trip::writeDistanceDB($row['id']);
		}
	}
	
	// upgrade database for app version 0.7
	if($upgrade >= 7) {
		// check for existing column 'timezone'
		$column_exists = FALSE;
		$query = "SHOW COLUMNS FROM `${cfg['db_table_prefix']}gpx_files` LIKE 'timezone'; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['Field'] == "timezone")
				$column_exists = TRUE;
		}
		// add column for timezone of gpx files
		if(!$column_exists) {
			$query = "ALTER TABLE `${cfg['db_table_prefix']}gpx_files` 
					ADD `timezone` tinyint(2) NOT NULL default '0' AFTER `timestamp`; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
			// fill that column with defaults
			$query = "UPDATE IGNORE `${cfg['db_table_prefix']}gpx_files` 
						SET `timezone` = '${cfg['timezone_offset']}'; ";
			$result = mysql_query($query);
		}
		
		// check for existing column 'speed'
		$column_exists = FALSE;
		$query = "SHOW COLUMNS FROM `${cfg['db_table_prefix']}pois` LIKE 'speed'; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['Field'] == "speed")
				$column_exists = TRUE;
		}
		// add column for speed and direction of movement/view
		if(!$column_exists) {
			$query = "ALTER TABLE `${cfg['db_table_prefix']}pois` 
					ADD `speed` float default NULL AFTER `timestamp`,
					ADD `move_dir` float default NULL,
					ADD `image_dir` float default NULL; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
		}
		
		// check for existing column 'icon_file'
		$column_exists = FALSE;
		$query = "SHOW COLUMNS FROM `${cfg['db_table_prefix']}waypoints` LIKE 'icon_file'; ";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['Field'] == "icon_file")
				$column_exists = TRUE;
		}
		// add column for map icon file
		if(!$column_exists) {
			$query = "ALTER TABLE `${cfg['db_table_prefix']}waypoints`
					ADD `icon_file` varchar(128) default NULL after `desc`,
					ADD `icon_size` varchar(8) NOT NULL default '',
					ADD `icon_offset` varchar(8) NOT NULL default ''; ";
			$result = mysql_query($query);
			if(!$result) {
			    out(_INST_DB_ERROR. mysql_error(), 3);
			    $mysql_err_count++;
			}
		}
	}
	
	mysql_close($link);
}

if(!$mysql_err_count) {
	echo "<p><img src='../images/tick_32.png'> ". _INST_PROG_DB ."<br>\n";
	echo "<a href='done.php'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";
}else {
	echo "<p><img src='../images/cancel_32.png'> ". _INST_ERROR ."</p>\n";
	echo "<p><a href=\"Javascript:history.back()\"><img src='../images/back_32.png' border=0> ". _CMN_PREV ."</a></p>";
}

include("../foot.html.php");
?>
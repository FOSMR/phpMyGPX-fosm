<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

$DEV = FALSE;
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);


// checks for configuration file, if none found redirect to installation page
if(!file_exists( 'config.inc.php' ) || filesize( 'config.inc.php' ) < 1000) {
	#$self = str_replace( '/index.php', '', $_SERVER['PHP_SELF'] ). '/';
	$self = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') +1);
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "installation/index.php?upgrade=0");
	exit();
} else {
	include_once("./config.inc.php");
	include_once("./libraries/functions.inc.php");
}
// checks for installation folder, if found redirect to installation page
if(file_exists( 'installation' ) && is_dir( 'installation' )) {
	#$self = str_replace( '/index.php', '', $_SERVER['PHP_SELF'] ). '/';
	$self = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') +1);
	if(!$DEV) {
		header("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "installation/index.php?upgrade=999");
		exit();
	}
}

/*
// connect to database
$link = mysql_connect($cfg['db_host'], $cfg['db_user'], $cfg['db_password']);
if($link) {
	// check if database already exists
	if(mysql_select_db($cfg['db_name'])) {
	    $query = "SELECT * FROM `${cfg['db_table_prefix']}config`; ";
	    $result = @mysql_query($query);
	    if($result != FALSE) {
	    	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	    	if($row['db_scheme'] != _DB_SCHEME || $row['cfg_scheme'] != _CFG_SCHEME) {
				#$self = str_replace( '/index.php', '', $_SERVER['PHP_SELF'] ). '/';
				$self = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/') +1);
				echo("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "installation/index.php?upgrade=999");
				exit();
			}
	    }
    }
    // close database
    mysql_close($link);
}
*/
?>
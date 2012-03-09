<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

include("./config.inc.php");
include("./libraries/functions.inc.php");
#include("./libraries/classes.php");

setlocale (LC_TIME, $cfg['config_locale']);
#include("./languages/".get_lang($cfg['config_language']).".php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$task 		= getUrlParam('HTTP_GET', 'STRING', 'task');
$f_minlat 	= getUrlParam('HTTP_GET', 'FLOAT', 'b') * 1000000;
$f_maxlat 	= getUrlParam('HTTP_GET', 'FLOAT', 't') * 1000000;
$f_minlon 	= getUrlParam('HTTP_GET', 'FLOAT', 'l') * 1000000;
$f_maxlon 	= getUrlParam('HTTP_GET', 'FLOAT', 'r') * 1000000;

/*
// convert lat/lon from float value to database integer format
if($option == "search") {
	$option = "filter";
	$f_lat *= 1000000; 
	$f_lon *= 1000000; 
	$f_lat_range *= 1000000; 
	$f_lon_range *= 1000000; 
}
*/
// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);


switch ($task) {
	case 'getData':
		getData();
		break;

	case 'getPhotos':
		getPhotos($f_minlat, $f_maxlat, $f_minlon, $f_maxlon);
		break;

	default:
        getData();
		break;
}


function getData() {
	global $DEBUG, $cfg;
	$limit = intval($cfg['result_datalayer_limit']);
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM `${cfg['db_table_prefix']}pois` ";
    /*
	if($option == "filter") {
		$query .= "WHERE `name` LIKE '%$description%' ";
	}
	*/
	$query .= "ORDER BY `id` ASC LIMIT 0, $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		#$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		
		// write table header for datalayer
		echo "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['description'])
				$description = $row['description'];
			else
				$description = "Altitude: ${row['altitude']} m<br />${row['timestamp']}<br /><a href='${cfg['photo_images_dir']}${row['file']}'><img src='${cfg['photo_thumbs_dir']}${cfg['photo_thumbs_prefix']}${row['file']}' hspace=5 /></a>";
			
			// write table row for datalayer
			echo ($row['latitude']/1000000)."\t".($row['longitude']/1000000).
				"\t${row['title']} \t${description}\t${row['icon_file']}".
				"\t${row['icon_size']}\t${row['icon_offset']}\n";
		}
	}
}

function getPhotos($b, $t, $l, $r) {
	global $DEBUG, $cfg;
	$limit = intval($cfg['result_datalayer_limit']);
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM `${cfg['db_table_prefix']}pois` 
    		WHERE `latitude` BETWEEN $b AND $t AND `longitude` BETWEEN $l AND $r ";
    /*
	if($option == "filter") {
		$query .= "WHERE `name` LIKE '%$description%' ";
	}
	*/
	$query .= "ORDER BY `id` ASC LIMIT 0, $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		#$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		
		// write photo array for datalayer
		echo "[";
		$i = 1;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($i>1)
				echo ",";
			
			echo "{\"width\":\"0\",\"time\":\"${row['timestamp']}\",\"lat\":\"".lat2y($row['latitude']/1000000)."\",\"photoid\":\"${row['id']}\",\"lon\":\"".lon2x($row['longitude']/1000000)."\",\"height\":\"0\"}";
			
			$i++;
		}
		echo "]";
	}
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}


function lat2y($lat) {
	return (20037508.34 / 180) * (180/M_PI * log(tan(M_PI/4 + $lat*(M_PI/180)/2)));
}
function lon2x($lon) {
	return (20037508.34 / 180) * $lon;
}
?>

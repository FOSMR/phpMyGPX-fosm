<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
define('_GRID_LINES', 5);
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);
include("./config.inc.php");
include("./libraries/functions.inc.php");
setlocale (LC_TIME, $cfg['config_locale']);

$id 	= getUrlParam('HTTP_GET', 'INT', 'id');
$width 	= getUrlParam('HTTP_GET', 'INT', 'width');
$height	= getUrlParam('HTTP_GET', 'INT', 'height');
$name 	= getUrlParam('HTTP_GET', 'STRING', 'name');
$type 	= getUrlParam('HTTP_GET', 'STRING', 'type');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$name)
	header ("Content-type: image/png");
$im = @ImageCreate ($width, $height)
      or die ("Kann keinen neuen GD-Bild-Stream erzeugen");
$background_color = ImageColorAllocate ($im, 255, 255, 255);
$trace_color = ImageColorAllocate ($im, 0, 0, 255);
$text_color = ImageColorAllocate ($im, 233, 14, 91);
$grid_color = ImageColorAllocate ($im, 90, 250, 90);

// draw track as birdviw map
if(!$type || $type == "birdview") { 
	$query = "SELECT `gpx_id`, COUNT(*) AS 'nmbr',
				MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat',
				MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon'
				FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' GROUP BY `gpx_id` ;";
	$result = db_query($query);
	#if($DEBUG)	out($query, 'OUT_DEBUG');
	
	if(mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$offset_lat = $row['minlat'];
			$offset_lon = $row['minlon'];
			$range_lat = $row['maxlat'] - $row['minlat'];
			$range_lon = $row['maxlon'] - $row['minlon'];
			if($range_lat > $range_lon)		
				$range_max = $range_lat;
			else
				$range_max = $range_lon;
			#ImageString ($im, 1, 5, 15, $range_lat, $text_color);
			#ImageString ($im, 1, 5, 25, $range_lon, $text_color);
			#ImageString ($im, 1, 5, 40, $range_max, $text_color);
			ImageString ($im, 2, 5,  5, "ID: ". $row['gpx_id'], $text_color);
			ImageString ($im, 2, 5, 18, "TP: ". $row['nmbr'], $text_color);
		}
	}
	
	$query = "SELECT latitude, longitude FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' ;";
	$result = db_query($query);
	#if($DEBUG)	out($query, 'OUT_DEBUG');
	
	if(mysql_num_rows($result)) {
		$pt = array('i'=>0, 'x'=>0, 'y'=>0, 'xold'=>0, 'yold'=>0);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
						
			$pt['i']++;
			$pt['xold'] = $pt['x'];
			$pt['yold'] = $pt['y'];
			$pt['y'] = round($height - ($row['latitude'] - $offset_lat) / $range_max * $height);
			$pt['x'] = round(($row['longitude'] - $offset_lon) / $range_max * $width);
			if($pt['xold'] && $pt['yold'])
				ImageLine($im, $pt['xold'], $pt['yold'], $pt['x'], $pt['y'], $trace_color);
			#ImageSetPixel($im, $x, $y, $trace_color);
		}
	}
}

// draw altitude profile
if($type == "altitude") { 
	$query = "SELECT `gpx_id`, COUNT(*) AS 'nmbr',
				MIN(`altitude`) AS 'minalt', MAX(`altitude`) AS 'maxalt',
				MIN(`timestamp`) AS 'mintime', MAX(`timestamp`) AS 'maxtime'
				FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' 
				AND `altitude` >1 GROUP BY `gpx_id` ;";
	$result = db_query($query);
	#if($DEBUG)	out($query, 'OUT_DEBUG');

	if(mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$offset_alt = $row['minalt'];
			$range_alt = $row['maxalt'] - $row['minalt'];
			$range_time = $row['nmbr'];
			#$range_time = $row['maxtime'] - $row['mintime'];
			
			ImageString ($im, 1, 75, 5, "min alt: ". (int)$row['minalt'], $text_color);
			ImageString ($im, 1, 75, 18, "max alt: ". (int)$row['maxalt'], $text_color);
			ImageString ($im, 2, 5,  5, "ID: ". $row['gpx_id'], $text_color);
			ImageString ($im, 2, 5, 18, "TP: ". $row['nmbr'], $text_color);
		}
	}
	
	// draw grid for altitude
	for($i=0; $i<_GRID_LINES; $i++) {
		$y = $height - $i/_GRID_LINES * $height;
		ImageLine ($im, 35, $y-1, $width-1, $y-1, $grid_color);
		ImageString ($im, 2, 0, $y-12, 
			round($i/_GRID_LINES * $range_alt + $offset_alt) ." m", $grid_color);
	}

	$query = "SELECT altitude FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' ;";
	$result = db_query($query);
	#if($DEBUG)	out($query, 'OUT_DEBUG');
	
	if(mysql_num_rows($result)) {
		$pt = array('i'=>0, 'x'=>0, 'y'=>0, 'xold'=>0, 'yold'=>0);
		#$pt = array('i'=>0, 'x'=>array(0,0,0), 'y'=>array(0,0,0));
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$pt['i']++;
			if($row['altitude']) {
				$pt['xold'] = $pt['x'];
				$pt['yold'] = $pt['y'];
				$pt['y'] = round($height - ($row['altitude'] - $offset_alt) / $range_alt * $height);
				$pt['x'] = round($pt['i'] / $range_time * $width);
				if($pt['xold'] && $pt['yold'])
					ImageLine($im, $pt['xold'], $pt['yold'], $pt['x'], $pt['y'], $trace_color);
				#ImageSetPixel($im, $pt['x'], $pt['y'], $trace_color);
			}
		}
	}
}

if(!$name)
	ImagePNG ($im);
else
	ImagePNG ($im, "./files/".$name.".png");

ImageDestroy ($im);


// TO DO: function not used yet...
function mercator_lat2y($a) {
	return 180/M_PI * log(tan(M_PI/4 + $a *(M_PI/180)/2));
}
?>
<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
define( 'E_NONE', 0 );
define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);
else       error_reporting(E_NONE);
include("./config.inc.php");
include("./libraries/functions.inc.php");
setlocale (LC_TIME, $cfg['config_locale']);

$id 			= getUrlParam('HTTP_GET', 'INT', 'id');
$wpt 			= getUrlParam('HTTP_GET', 'INT', 'wpt');
$trkpt 			= getUrlParam('HTTP_GET', 'INT', 'trkpt');	// -1:all; 0:none; 1:reduce
$f_date 		= getUrlParam('HTTP_GET', 'STRING', 'date');
$f_lat			= getUrlParam('HTTP_GET', 'INT', 'lat');
$f_lon			= getUrlParam('HTTP_GET', 'INT', 'lon');
$f_lat_range 	= getUrlParam('HTTP_GET', 'INT', 'lat_range');
$f_lon_range 	= getUrlParam('HTTP_GET', 'INT', 'lon_range');
$name			= getUrlParam('HTTP_GET', 'STRING', 'name');
$cmt			= getUrlParam('HTTP_GET', 'STRING', 'cmt');
$desc			= getUrlParam('HTTP_GET', 'STRING', 'desc');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);


if(!$DEBUG) {
	header("Content-type: text/xml");
	header('Content-Disposition: attachment; filename="export_'.$id.'.gpx"');
}
{
	// get trackpoints from database
	if($trkpt) {
		$query = "SELECT SQL_CALC_FOUND_ROWS *, 
				DATE(`timestamp`) AS 'date', TIME(`timestamp`) AS 'time' 
				FROM `${cfg['db_table_prefix']}gpx_import` ";
		$query .= "WHERE 1 ";
		if($id)
			$query .= "AND `gpx_id` = '$id' ";
		if($f_date)
			$query .= "AND DATE(`timestamp`) = '$f_date' ";
		if($f_lat)
			$query .= "AND `latitude` BETWEEN '$f_lat'-'$f_lat_range' 
					AND '$f_lat'+'$f_lat_range' ";
		if($f_lon)
			$query .= "AND `longitude` BETWEEN '$f_lon'-'$f_lon_range' 
					AND '$f_lon'+'$f_lon_range' ";
		$query .= "ORDER BY `timestamp` ";
		
	    $result_trkpt = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
		
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		$divider = 1;
		// set max number of trackpoints per GPX
		if($trkpt > 0) {
			if($trkpt == 1 && $cfg['map_gpx_max_trkpts']) {
				$trkpt = $cfg['map_gpx_max_trkpts'];
			}
			$divider = ceil($num_found / $trkpt);
			if($DEBUG)	out("$num_found / $trkpt = $divider", 'OUT_DEBUG');
		}
	}
	// get waypoints from database
	if($wpt) {
		$query = "SELECT SQL_CALC_FOUND_ROWS *, 
				DATE(`timestamp`) AS 'date', TIME(`timestamp`) AS 'time' 
				FROM `${cfg['db_table_prefix']}waypoints` ";
		$query .= "WHERE 1 ";
		if($id)
			$query .= "AND `gpx_id` = '$id' ";
		if($f_date)
			$query .= "AND DATE(`timestamp`) = '$f_date' ";
		if($f_lat)
			$query .= "AND `latitude` BETWEEN '$f_lat'-'$f_lat_range' 
					AND '$f_lat'+'$f_lat_range' ";
		if($f_lon)
			$query .= "AND `longitude` BETWEEN '$f_lon'-'$f_lon_range' 
					AND '$f_lon'+'$f_lon_range' ";
		if($name)
			$query .= "AND `name` LIKE '%$name%' ";
		if($comment)
			$query .= "AND `cmt` LIKE '%$comment%' ";
		if($description)
			$query .= "AND `desc` LIKE '%$description%' ";
		$query .= "ORDER BY `timestamp` ";
		
	    $result_wpt = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	}

	// prepare GPX XML output
	writeGpxHeader();
	// write trackpoints
	if($trkpt) {
		writeGpxTrkBegin();
		$i = 1;
		while($row = mysql_fetch_array($result_trkpt, MYSQL_ASSOC)) {
			$i++;
			if($i % $divider)	continue;
			writeGpxTrkpt($row);
		}
		writeGpxTrkEnd();
	}
	// write waypoints
	if($wpt) {
		while($row = mysql_fetch_array($result_wpt, MYSQL_ASSOC)) {
			writeGpxWpt($row);
		}
	}
	writeGpxFooter();
}


function writeGpxWpt($tp) {
	echo '  <wpt lat="'.($tp['latitude']/1000000).'" lon="'.($tp['longitude']/1000000)."\">\n";
	echo "    <time>".$tp['date']."T".$tp['time'].".00Z</time>\n";
	if($tp['name'])
		echo "    <name>".$tp['name']."</name>\n";
	if($tp['cmt'])
		echo "    <cmt>".$tp['cmt']."</cmt>\n";
	if($tp['desc'])
		echo "    <desc>".$tp['desc']."</desc>\n";
	echo "  </wpt>\n";
}

function writeGpxTrkpt($tp) {
	echo '      <trkpt lat="'.($tp['latitude']/1000000).'" lon="'.($tp['longitude']/1000000)."\">\n";
	if($tp['altitude'])
		echo "        <ele>".$tp['altitude']."</ele>\n";
	echo "        <time>".$tp['date']."T".$tp['time'].".00Z</time>\n";
	/*
	if($tp['course'])
		echo "        <course>".$tp['course']."</course>\n";
	if($tp['speed'])
		echo "        <speed>".$tp['speed']."</speed>\n";
	*/
	if($tp['fix'])
		echo "        <fix>".$tp['fix']."d</fix>\n";
	if($tp['sat'])
		echo "        <sat>".$tp['sat']."</sat>\n";
	if($tp['hdop'])
		echo "        <hdop>".$tp['hdop']."</hdop>\n";
	if($tp['pdop'])
		echo "        <pdop>".$tp['pdop']."</pdop>\n";
	echo "      </trkpt>\n";
}

function writeGpxTrkBegin() {
	echo "  <trk>\n";
	echo "    <trkseg>\n";
}

function writeGpxTrkEnd() {
	echo "    </trkseg>\n";
	echo "  </trk>\n";
}

function writeGpxHeader() {
	$str = <<<GPX_H
<?xml version="1.0" encoding="utf-8"?>
<gpx version="1.1" creator="phpMyGPX"
        xmlns="http://www.topografix.com/GPX/1/1"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.topografix.com/GPS/1/1
        http://www.topografix.com/GPX/1/1/gpx.xsd">
  <metadata>
    <link href="http://phpmygpx.tuxfamily.org/">
    	<text>phpMyGPX - Web based management for GPX files and photos</text>
    </link>
  </metadata>
GPX_H;
	echo $str ."\n";
}

function writeGpxFooter() {
	echo "</gpx>\n";
}
?>
<?php
/**
* @version $Id$
* @package osm-things
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
include("./libraries/GeoCalc.class.php");
require('./libraries/phplot/phplot.php');

settimezone();
setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");

$id 	= getUrlParam('HTTP_GET', 'INT', 'id');
$width 	= getUrlParam('HTTP_GET', 'INT', 'width');
$height	= getUrlParam('HTTP_GET', 'INT', 'height');
$name 	= getUrlParam('HTTP_GET', 'STRING', 'name');
$begin_timestamp 	= getUrlParam('HTTP_GET', 'INT', 'bts');
$end_timestamp 		= getUrlParam('HTTP_GET', 'INT', 'ets');
$timezone			= getUrlParam('HTTP_GET', 'INT', 'tz');
$filter	= getUrlParam('HTTP_GET', 'INT', 'filter');
$alt	= getUrlParam('HTTP_GET', 'INT', 'alt');
$speed	= getUrlParam('HTTP_GET', 'INT', 'speed');
$type 	= getUrlParam('HTTP_GET', 'STRING', 'type');

if(!$width)
	$width = $cfg['chart_width'];
if(!$height)
	$height = $cfg['chart_height'];
if(!$filter)
	$filter = $cfg['alt_data_filter_mva'];

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);


// Create plot object
$plot = new PHPlot($width, $height);
// Disable auto-output
$plot->SetPrintImage(0);

// chart type: altitude against time
if($type == "alt_time") {
	$query = "SELECT `altitude`, `timestamp`, `speed` 
				FROM `${cfg['db_table_prefix']}gpx_import` 
				WHERE `gpx_id` = '$id' ";
	if(isset($begin_timestamp) && isset($end_timestamp)) {
		$query .= "AND UNIX_TIMESTAMP(`timestamp`) 
					BETWEEN $begin_timestamp AND $end_timestamp ";
	}
	$query .= "ORDER BY `timestamp`; ";

	$result = db_query($query);
	
	if(mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if($row['altitude']) {
				$time_data[] = strtotime($row['timestamp']) + $timezone * 3600;
				$alt_data[] = $row['altitude'];
				$speed_data[] = $row['speed'] * 3.6;
			}
		}
		// disable speed chart if no speed data available
		if(!array_sum($speed_data))
			$speed = FALSE;
	}

	// filter altitude data
	if($filter) {
		// process moving average filter
		$alt_data = moving_average_m($alt_data, $filter, 'MODE_ALL');
		$speed_data = moving_average_m($speed_data, $filter, 'MODE_ALL');
	}
	
	foreach($time_data as $key=>$value) {
		$chart1_data[] = array('', $time_data[$key], $alt_data[$key]);
		$chart2_data[] = array('', $time_data[$key], $speed_data[$key]);
	}
	
	if($speed) {
		# Set up area for first plot:
		$plot->SetPlotAreaPixels(50, 10, $width-20, intval($height/2)-10);
	}
	
	$plot->SetPlotType('lines');
	$plot->SetXLabelType('time', '%H:%M');
	$plot->setPrecisionY(0);
	#$plot->setTitle(_CHART_ELEVATION_TITLE);
	#$plot->setXTitle(_CHART_AXIS_TIME .' / hh:mm');
	$plot->setYTitle(_CHART_AXIS_ELE .' / m');
	#$plot->setLegend(_CMN_GPX_ID .': '.$id);

	$plot->SetDataValues($chart1_data);
	$plot->SetDataType('data-data');
	$plot->DrawGraph();
	
	if($speed) {
		# Set up area for second plot:
		$plot->SetPlotAreaPixels(50, intval($height/2)+20, $width-20, $height-40);
		
		$plot->SetPlotType('lines');
		$plot->SetDataColors(array('green'));
		$plot->SetXLabelType('time', '%H:%M');
		$plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);
		$plot->SetXAxisPosition(0);
		$plot->setPrecisionY(0);
		#$plot->setTitle(_CHART_ELEVATION_TITLE);
		$plot->setXTitle(_CHART_AXIS_TIME .' / hh:mm');
		$plot->setYTitle(_CHART_AXIS_SPEED .' / km/h');
		#$plot->setLegend(_CMN_GPX_ID .': '.$id);
	
		$plot->SetDataValues($chart2_data);
		$plot->SetDataType('data-data');
		$plot->DrawGraph();
	}
}

// chart type: altitude against distance
if($type == "alt_dist") {
	$query = "SELECT `altitude`, `timestamp`, `latitude`, `longitude`, `speed` 
				FROM `${cfg['db_table_prefix']}gpx_import` 
				WHERE `gpx_id` = '$id' ";
	if(isset($begin_timestamp) && isset($end_timestamp)) {
		$query .= "AND UNIX_TIMESTAMP(`timestamp`) 
					BETWEEN $begin_timestamp AND $end_timestamp ";
	}
	$query .= "ORDER BY `timestamp`; ";

	$result = db_query($query);
	
	if(mysql_num_rows($result)) {
		$pt = array('i'=>0, 'x'=>0, 'y'=>0, 'xold'=>0, 'yold'=>0, 'a'=>0, 'aold'=>0);
		$dist = 0;
		$oGC = new GeoCalc();
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$pt['i']++;
			$pt['yold'] = $pt['y'];
			$pt['xold'] = $pt['x'];
			$pt['aold'] = $pt['a'];
			$pt['y'] = $row['latitude'] /1000000;
			$pt['x'] = $row['longitude'] /1000000;
			$pt['a'] = $row['altitude'];
			
			if($pt['xold'] && $pt['yold'] && $row['altitude']) {
				// get distance between 2 trackpoints
				$distP2P = $oGC->GCDistance($pt['y'], $pt['x'], $pt['yold'], $pt['xold']);
				if(!$distP2P || is_nan($distP2P)) {
					if($DEBUG) {
						out($row['timestamp']." :  xo=".$pt['xold']." yo=".$pt['yold'].
							" x=".$pt['x']." y=".$pt['y']." d=".$distP2P, 'OUT_DEBUG');
					}
					continue;
				}
				// sum point-to-point distances
				$dist += $distP2P;
				// make array for data points used in graph
				#$time_data[] = strtotime($row['timestamp']);
				$dist_data[] = $dist;
				$alt_data[] = $row['altitude'];
				$speed_data[] = $row['speed'] * 3.6;
			}
		}
		// disable speed chart if no speed data available
		if(!array_sum($speed_data))
			$speed = FALSE;
	}
	
	// filter altitude data
	if($filter) {
		// process moving average filter
		$alt_data = moving_average_m($alt_data, $filter, 'MODE_ALL');
		$speed_data = moving_average_m($speed_data, $filter, 'MODE_ALL');
	}
	
	foreach($dist_data as $key=>$value) {
		$chart1_data[] = array('', $dist_data[$key], $alt_data[$key]);
		$chart2_data[] = array('', $dist_data[$key], $speed_data[$key]);
	}
	
	// TODO: this is really nice, but should be done in traces.php
	// calculate climbing/falling altitude difference sum
	/*
	for($i=0; $i<sizeof($altdata); $i++) {
		if($altdata[$i] > $altdata[$i-1] && $altdata[$i-1]>0)
		    $altdiff_climb += ($altdata[$i] - $altdata[$i-1]);
		if($altdata[$i] < $altdata[$i-1] && $altdata[$i]>0)
		    $altdiff_fall += ($altdata[$i] - $altdata[$i-1]);
	}
	*/
	
	if($speed) {
		// Set up area for first plot:
		$plot->SetPlotAreaPixels(50, 10, $width-20, intval($height/2)-10);
	}
	
	$plot->SetPlotType('lines');
	#$plot->SetXLabelType('data', 1 , '', ' km/h');
	$plot->setPrecisionX(1);
	$plot->setPrecisionY(0);
	#$plot->setTitle(_CHART_ELEVATION_TITLE);
	#$plot->setXTitle(_CHART_AXIS_DIST . ' / km');
	$plot->setYTitle(_CHART_AXIS_ELE .' / m');
	#$plot->setLegend(_CMN_GPX_ID .': '.$id);
	
	$plot->SetDataValues($chart1_data);
	$plot->SetDataType('data-data');
	$plot->DrawGraph();

	if($speed) {
		// Set up area for second plot:
		$plot->SetPlotAreaPixels(50, intval($height/2)+20, $width-20, $height-40);
		
		$plot->SetPlotType('lines');
		$plot->SetDataColors(array('green'));
		#$plot->SetXLabelType('data', 1 , '', ' km/h');
		$plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);
		$plot->SetXAxisPosition(0);
		$plot->setPrecisionX(1);
		$plot->setPrecisionY(0);
		#$plot->setTitle(_CHART_ELEVATION_TITLE);
		$plot->setXTitle(_CHART_AXIS_DIST . ' / km');
		$plot->setYTitle(_CHART_AXIS_SPEED .' / km/h');
		#$plot->setLegend(_CMN_GPX_ID .': '.$id);
	
		$plot->SetDataValues($chart2_data);
		$plot->SetDataType('data-data');
		$plot->DrawGraph();
	}
}

$plot->PrintImage();
?>
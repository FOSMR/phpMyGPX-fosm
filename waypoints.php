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

session_start();
ob_start();

include("./check_db.php");
#include("./config.inc.php");
#include("./libraries/functions.inc.php");
#include("./libraries/classes.php");
include("./libraries/html.classes.php");
include("./libraries/map.classes.php");
include("./libraries/GeoCalc.class.php");
include("./waypoints.html.php");

settimezone();
setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");
include("./head.html.php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$sort 			= getUrlParam('HTTP_GET', 'INT', 's');
$order 			= getUrlParam('HTTP_GET', 'INT', 'o');
$limit 			= getUrlParam('HTTP_GET', 'INT', 'l');
$p 				= getUrlParam('HTTP_GET', 'INT', 'p');
$id 			= getUrlParam('HTTP_GET', 'INT', 'id');
$task 			= getUrlParam('HTTP_GET', 'STRING', 'task');
$option 		= getUrlParam('HTTP_GET', 'STRING', 'option');
$date_from	 	= getUrlParam('HTTP_GET', 'STRING', 'date_from');
$date_to 		= getUrlParam('HTTP_GET', 'STRING', 'date_to');
$f_lat			= getUrlParam('HTTP_GET', 'FLOAT', 'lat');
$f_lon			= getUrlParam('HTTP_GET', 'FLOAT', 'lon');
$f_lat_range 	= getUrlParam('HTTP_GET', 'FLOAT', 'lat_range');
$f_lon_range 	= getUrlParam('HTTP_GET', 'FLOAT', 'lon_range');
$name 			= getUrlParam('HTTP_GET', 'STRING', 'name');
$comment 		= getUrlParam('HTTP_GET', 'STRING', 'cmt');
$description 	= getUrlParam('HTTP_GET', 'STRING', 'desc');
$submit			= getUrlParam('HTTP_POST', 'STRING', 'submit');
$confirm		= getUrlParam('HTTP_POST', 'STRING', 'confirm');

// convert lat/lon from float value to database integer format
if($option == "search") {
	$option = "filter";
	$f_lat *= 1000000; 
	$f_lon *= 1000000; 
	$f_lat_range *= 1000000; 
	$f_lon_range *= 1000000; 
}

// handling of sql result limit
if($limit) {
	// calc new page number caused by changed result limit
	$p = round($p * $_COOKIE['limit'] / $limit);
	setcookie('limit', $limit, time() + 3600 * $cfg['pref_cookie_lifetime']);
} elseif(isset($_COOKIE['limit']))
	$limit = $_COOKIE['limit'];
// use default from config file if not set in cookie
if(!$limit)
	$limit = $cfg['result_table_limit'];

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$cfg['embedded_mode'] || !$cfg['public_host'] || check_password($cfg['admin_password'])) {
	HTML::heading(_APP_NAME, 2);
	HTML::main_menu();
}

switch ($task) {
	case 'view':
		viewWaypoints($id, $p, $sort, $order, $limit);
		break;

	case 'export':
		exportWaypoints($id);
		break;

	case 'download':
		downloadWaypoints($id);
		break;

	case 'edit':
		editWaypoints($id, $submit);
		break;

	case 'delete':
		deleteWaypoints($id, $submit, $confirm);
		break;

	case 'search':
		searchWaypoints();
		break;

	default:
        viewWaypoints(NULL, NULL, $sort, $order, $limit);
		break;
}


function viewWaypoints($id, $page, $sort, $order, $limit) {
	global $DEBUG, $cfg;
	global $option, $date_from, $date_to, $f_lat, $f_lon, $f_lat_range, $f_lon_range;
	global $name, $comment, $description;
	HTML::heading(_MENU_WPT_VIEW, 3);
	$search_url = "";
	
	switch($sort) {
		case '1':
			$qs = 'gpx_id';
			break;
		case '2':
			$qs = 'altitude';
			break;
		case '4':
			$qs = 'name';
			break;
		case '3':
		default:
			$qs = 'timestamp';
			$sort = 3;
			break;
	}
	
	if(!$order)
		$qo = 'ASC';
	else
		$qo = 'DESC';
	
	$query = "SELECT SQL_CALC_FOUND_ROWS wpt.* , `gpx`.`timezone`, 
				`gpx`.`name` AS 'gpx_filename', `gpx`.`description` AS `gpx_description` 
				FROM `${cfg['db_table_prefix']}waypoints` AS `wpt` 
				LEFT JOIN `${cfg['db_table_prefix']}gpx_files` AS `gpx` 
				ON `gpx_id` = `gpx`.`id` ";
	if($id) {
		$query .= "WHERE `gpx_id` = '$id' ";
		$search_url = "&id=$id";
	}
	if($option == "filter") {
		$query .= "WHERE 1 ";
		if(strtotime($date_from) || strtotime($date_to)) {
			if(!strtotime($date_from))
				$from = 0; // 1970-01-01
			else
				$from = strtotime($date_from);
			if(!strtotime($date_to))
				$to = 'UNIX_TIMESTAMP(NOW())';
			else
				$to = strtotime($date_to) + 24*3600; // add one day
			$query .= "AND UNIX_TIMESTAMP(`wpt`.`timestamp`) BETWEEN $from AND $to ";
		}
		if($f_lat)
			$query .= "AND `wpt`.`latitude` BETWEEN '".($f_lat - $f_lat_range)."' 
					AND '".($f_lat + $f_lat_range)."' ";
		if($f_lon)
			$query .= "AND `wpt`.`longitude` BETWEEN '".($f_lon - $f_lon_range)."e' 
					AND '".($f_lon + $f_lon_range)."' ";
		if($name)
			$query .= "AND `wpt`.`name` LIKE '%".db_escape_string($name)."%' ";
		if($comment)
			$query .= "AND `wpt`.`cmt` LIKE '%".db_escape_string($comment)."%' ";
		if($description)
			$query .= "AND `wpt`.`desc` LIKE '%".db_escape_string($description)."%' ";

		$search_url = "&option=filter&date_from=$date_from&date_to=$date_to&lat=$f_lat&lon=$f_lon&lat_range=$f_lat_range&lon_range=$f_lon_range&name=$name&cmt=$comment&desc=$description";
	}
	$query .= "ORDER BY `$qs` $qo LIMIT ". ($page*$limit) .", $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		if($option == "filter" || $id)
			HTML::message_r(_CMN_SEARCH_RESULTS, $num_found);
    	
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"waypoints.php?task=view&id=$id&s=$sort&o=$order".$search_url);
		HTML::viewResultLimitSelect("waypoints.php?task=view&id=$id&p=$page&s=$sort&o=$order".$search_url);
		
		HTML_waypoints::viewWPTsTableHeader("waypoints.php?task=view&id=$id&p=$page".$search_url, $sort, $order);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			HTML_waypoints::viewWPTsTableRow($row);
		}
		HTML_waypoints::viewWPTsTableFooter();
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"waypoints.php?task=view&id=$id&s=$sort&o=$order".$search_url);
		if($option != "filter" && !$id) {
			HTML::message($num_found ._DB_WPTS_AVAILABLE);
		}else {
			HTML::message("<a href='export.php?wpt=-1$search_url'>". _TRC_EXPORT_AS_GPX ."</a>");
		}
	}
	else
		HTML::message(_TRC_NO_WPTS_IN_DB);
}

function exportWaypoints($id) {
	global $DEBUG, $cfg, $option;
    HTML::heading(_MENU_WPT_EXPORT, 3);
    HTML::message(_CMN_NOT_IMPLEMENTED);
}

function downloadWaypoints($id) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_WPT_DOWNL, 3);
    HTML::message(_CMN_NOT_IMPLEMENTED);
}

function editWaypoints($id, $submit) {
	global $DEBUG, $cfg;
	HTML::heading(_MENU_WPT_EDIT, 3);
	if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
		if(!$submit) {
			if($id) {
				// get waypoint to edit from database
				$query = "SELECT * FROM `${cfg['db_table_prefix']}waypoints` 
					WHERE `id` = '$id' ;";
				$result = db_query($query);
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				if(mysql_num_rows($result)) {
					if($row['icon_file'] == '')
						$row['icon_file'] = 'openlayers/img/marker.png';
					HTML_waypoints::editForm('waypoints.php?task=edit&id='.$id, $id, $row);
				}else
					HTML::message(_TRC_WPT_DOES_NOT_EXIST);
			} else {
				// show form to enter new waypoint
				HTML_waypoints::editForm('waypoints.php?task=edit&id=0', 0, 
					array('latitude'=>$cfg['home_latitude']*1000000, 
					'longitude'=>$cfg['home_longitude']*1000000,
					'icon_file'=>'openlayers/img/marker.png'));
			}
		} else {
			$lat = intval($_POST['wpt_lat']*1000000);
			$lon = intval($_POST['wpt_lon']*1000000);
			$alt = floatval($_POST['wpt_alt']);
			$name = db_escape_string(strip_tags($_POST['name']));
			$comment = db_escape_string(strip_tags($_POST['cmt']));
			$description = db_escape_string(strip_tags($_POST['desc']));
			$icon_file = db_escape_string(strip_tags($_POST['map_icon_url']));
			
			if($id) {
				// update waypoint
				$query = "UPDATE IGNORE `${cfg['db_table_prefix']}waypoints` SET 
					`latitude` = '$lat', 
					`longitude` = '$lon', 
					`altitude` = '$alt', 
					`name` = '$name', 
					`cmt` = '$comment', 
					`desc` = '$description', 
					`icon_file` = '$icon_file' 
					WHERE `id` = '$id' ;";
			} else {
				// insert new waypoint
				$query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}waypoints` SET
					`latitude` = '$lat', 
					`longitude` = '$lon', 
					`altitude` = '$alt', 
					`name` = '$name', 
					`cmt` = '$comment',
					`desc` = '$description',
					`icon_file` = '$icon_file',
					`timestamp` = NOW() ;";
			}
			$result = db_query($query);
			if(mysql_affected_rows()) {
				HTML::message(_WPT_EDITED);
			}
		}
	}else {
		HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
	}
}

function deleteWaypoints($id, $submit, $confirm) {
	global $DEBUG, $cfg;
	HTML::heading(_MENU_WPT_DELETE, 3);
	if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
		if(!$submit) {
			HTML_waypoints::deleteForm('waypoints.php?task=delete&id='.$id, $id);
		} else {
			if($confirm == _CMN_YES) {
				// delete waypoints
				$query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}waypoints` 
					WHERE `id` = '$id' ;";
				$result = db_query($query);
				$num_rows = mysql_affected_rows();
				HTML::message_r(_TRC_WPT_DELETED, $num_rows);
			} else {
				HTML::message(_TRC_NO_CONFIRM_DELETE);
			}    
		}
	}else {
		HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
	}
}

function searchWaypoints() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_WPT_SEARCH, 3);
    HTML_waypoints::searchWptForm('');
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>

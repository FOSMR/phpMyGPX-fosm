<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
define( 'PHOTO_UPLOAD_DIR', './upload/');
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
include("./photos.html.php");

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
$view 			= getUrlParam('HTTP_GET', 'STRING', 'view');
$gpx_id			= getUrlParam('HTTP_GET', 'INT', 'gpx_id');
$option 		= getUrlParam('HTTP_GET', 'STRING', 'option');
$f_date 		= getUrlParam('HTTP_GET', 'STRING', 'date');
$f_lat			= getUrlParam('HTTP_GET', 'FLOAT', 'lat');
$f_lon			= getUrlParam('HTTP_GET', 'FLOAT', 'lon');
$f_lat_range 	= getUrlParam('HTTP_GET', 'FLOAT', 'lat_range');
$f_lon_range 	= getUrlParam('HTTP_GET', 'FLOAT', 'lon_range');
$title_option 	= getUrlParam('HTTP_POST', 'STRING', 'title_opt');
$title 			= getUrlParam('HTTP_POST', 'STRING', 'title');
$desc_option 	= getUrlParam('HTTP_POST', 'STRING', 'desc_opt');
$description 	= getUrlParam('HTTP_POST', 'STRING', 'description');
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
	$p = round($p *
	    (isset($_COOKIE['limit']) ? $_COOKIE['limit'] : 0 ) /
	    $limit);
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
	case 'details':
		details($id);
		break;

	case 'view':
		viewPhoto($gpx_id, $p, $sort, $order, $limit, $view);
		break;

	case 'full':
		fullPhoto($id);
		break;

	case 'upload':
		uploadPhoto();
		break;

	case 'batchimport':
		batchimportPhotos();
		break;

	case 'delete':
		deletePhoto($id, $submit, $confirm);
		break;

	default:
        viewPhoto(NULL, NULL, $sort, $order, $limit, NULL);
		break;
}


function details($id) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_PHOTO_DETAILS, 3);
    $query = "SELECT * FROM `${cfg['db_table_prefix']}pois` WHERE `id` = '$id' ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			if(file_exists($cfg['photo_images_dir'] .$row['file'])) {
				$query2 = "SELECT `id` FROM `${cfg['db_table_prefix']}pois` 
							WHERE `id` < '$id' ORDER BY `id` DESC LIMIT 1; ";
				$query3 = "SELECT `id` FROM `${cfg['db_table_prefix']}pois` 
							WHERE `id` > '$id' ORDER BY `id` ASC LIMIT 1; ";
				$result2 = db_query($query2);
				$result3 = db_query($query3);
				$prev = @mysql_result($result2, 0);
				$next = @mysql_result($result3, 0);
					
				HTML_photos::viewPhotoDetails($row, $prev, $next);
		    }else
				HTML::message(_IMPORT_FILE_ERROR);
    	}
    }else {
		HTML::message(_PHOTO_DOES_NOT_EXIST);
		return 1;
    }
}

function fullPhoto($id) {
	global $DEBUG, $cfg;
	if($cfg['photo_full_size']) {
	    $query = "SELECT * FROM `${cfg['db_table_prefix']}pois` WHERE `id` = '$id' ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if(file_exists($cfg['photo_images_dir'] .$row['file'])) {
					HTML_photos::fullPhoto($row);
			    }else
					HTML::message(_IMPORT_FILE_ERROR);
	    	}
	    }else {
			HTML::message(_PHOTO_DOES_NOT_EXIST);
			return 1;
	    }
    }else {
		HTML::message(_NOT_AUTH);
		return 1;
    }
}

function viewPhoto($id, $page, $sort, $order, $limit, $view) {
	global $DEBUG, $cfg;
	global $option, $f_date, $f_lat, $f_lon, $f_lat_range, $f_lon_range;
	HTML::heading(_MENU_PHOTO_VIEW, 3);
	$search_url = "";
	
	switch($sort) {
		case '1':
			$qs = 'gpx_id';
			break;
		case '2':
			$qs = 'altitude';
			break;
		case '4':
			$qs = 'file';
			break;
		case '5':
			$qs = 'size';
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
	
	$query = "SELECT SQL_CALC_FOUND_ROWS `pois`.* , 
				`gpx`.`name` AS 'gpx_filename', `gpx`.`description` AS `gpx_description` 
				FROM `${cfg['db_table_prefix']}pois` AS `pois` 
				LEFT JOIN `${cfg['db_table_prefix']}gpx_files` AS `gpx` 
				ON `gpx_id` = `gpx`.`id` ";
	if($id)
		$query .= "WHERE `gpx_id` = '$id' ";
	if($option == "filter") {
		$query .= "WHERE 1 ";
		if($f_date)
			$query .= "AND DATE(`pois`.`timestamp`) = '$f_date' ";
		if($f_lat)
			$query .= "AND `pois`.`latitude` BETWEEN '$f_lat'-'$f_lat_range' 
					AND '$f_lat'+'$f_lat_range' ";
		if($f_lon)
			$query .= "AND `pois`.`longitude` BETWEEN '$f_lon'-'$f_lon_range' 
					AND '$f_lon'+'$f_lon_range' ";

		$search_url = "&option=filter&date=$f_date&lat=$f_lat&lon=$f_lon&lat_range=$f_lat_range&lon_range=$f_lon_range";
	}
	$query .= "ORDER BY `$qs` $qo LIMIT ". ($page*$limit) .", $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		if($id)
			HTML::message_r(_CMN_SEARCH_RESULTS, $num_found);
    	
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"photos.php?task=view&view=$view&gpx_id=$id&s=$sort&o=$order".$search_url);
		HTML::viewResultLimitSelect("photos.php?task=view&view=$view&gpx_id=$id&p=$page&s=$sort&o=$order".$search_url);
		
		HTML::viewTableViewSelect($view, 
			"photos.php?task=view&gpx_id=$id&p=$page&s=$sort&o=$order".$search_url);
		// detailed table layout
		if($view == 'detailed') {
			HTML_photos::viewPhotoTableHeader("photos.php?task=view&view=$view&gpx_id=$id&p=$page".$search_url, $sort, $order);
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				HTML_photos::viewPhotoTableRow($row);
			}
			HTML_photos::viewPhotoTableFooter();
		// simple thumbs layout
		}else {
			HTML_photos::viewPhotoTableSimple($result);
		}
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"photos.php?task=view&view=$view&gpx_id=$id&s=$sort&o=$order".$search_url);
		if(!$id)
			HTML::message($num_found ._DB_PHOTOS_AVAILABLE);
	}
	else
		HTML::message(_PHOTO_NONE_IN_DB);
}

function uploadPhoto() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_PHOTO_UPL, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
    	HTML_photos::fileUploadForm('photos.php?task=import', $cfg['max_file_size']);
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function batchimportPhotos() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_PHOTO_BATCH_IMPORT, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    echo "<script src='./libraries/import.js'></script>\n";
	    // set current upload dir and scan it for photo files
		$dir = PHOTO_UPLOAD_DIR;
		$photo_files = scan_dir_f($dir, 0, 'FILETYPE_FILE', 'JPG');
		
		// get names of all gpx files
		$gpx_files = array();
	    $query = "SELECT `id`, `name`, `description` FROM `${cfg['db_table_prefix']}gpx_files` 
	    			WHERE 1 ORDER BY `id` DESC; ";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				$gpx_files[] = $row;
		} 
		
		HTML::message_r(_TRC_BATCH_IMPORTING_DIR, $dir);
		HTML::message(_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING);
		if($DEBUG)	print_r($photo_files);
		
		HTML_photos::viewBatchImportTableHeader();
		for($i=0; $i<sizeof($photo_files); $i++) {
			HTML_photos::viewBatchImportTableRow($i+1, $photo_files[$i]);
		}
		HTML_photos::viewBatchImportTableFooter($dir, $gpx_files);
		HTML_photos::viewImportProgress();
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function deletePhoto($id, $submit, $confirm) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_PHOTO_DELETE, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    if(!$submit) {
	    	HTML_photos::deleteForm('photos.php?task=delete&id='.$id, $id);
	    } else {
			if($confirm == _CMN_YES) {
				// delete image file from db
		        $query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}pois` 
		        	WHERE `id` = '$id' ;";
		        $result = db_query($query);
		        $num_rows = mysql_affected_rows();
		        HTML::message_r(_PHOTO_DELETED, $num_rows);
			} else {
				HTML::message(_TRC_NO_CONFIRM_DELETE);
			}    
	    }
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
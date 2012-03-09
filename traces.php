<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
define( 'GPX_UPLOAD_DIR', './upload/');
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

session_start();
ob_start();

include("./check_db.php");
#include("./config.inc.php");
#include("./libraries/functions.inc.php");
include("./libraries/classes.php");
include("./libraries/html.classes.php");
include("./libraries/GeoCalc.class.php");
include("./traces.html.php");

settimezone();
setlocale(LC_TIME, $cfg['config_locale']);
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
$description 	= getUrlParam('HTTP_GET', 'STRING', 'description');
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
}elseif(isset($_COOKIE['limit']))
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
	case 'gpx':
		viewGPX($p, $sort, $order, $limit);
		break;

	case 'details':
		details($id);
		break;

	case 'view':
		viewTrace($id, $p, $sort, $order, $limit);
		break;

	case 'upload':
		uploadTrace();
		break;

	case 'batchimport':
		batchimportTraces();
		break;

	case 'import':
		importTrace();
		break;

	case 'edit':
		editTrace($id, $submit);
		break;

	case 'delete':
		deleteTrace($id, $submit, $confirm);
		break;

	case 'searchGPX':
		searchGPX();
		break;

	case 'searchTP':
		searchTP();
		break;

	default:
        viewTrace(NULL, NULL);
		break;
}


function viewGPX($page, $sort, $order, $limit) {
	global $DEBUG, $cfg;
	global $option, $description, $date_from, $date_to, 
		$f_lat, $f_lon, $f_lat_range, $f_lon_range;
    HTML::heading(_MENU_GPX_VIEW, 3);
	$search_url = "";
	
	switch($sort) {
		case '1':
			$qs = 'gpx.id';
			break;
		case '2':
			$qs = 'gpx.size';
			break;
		case '4':
			$qs = 'gpx.timestamp';
			break;
		case '5':
			$qs = 'gpx.length';
			break;
		case '3':
		default:
			$qs = 'mints';
			$sort = 3;
			break;
	}
	
	if(!$order)
		$qo = 'ASC';
	else
		$qo = 'DESC';
	
	// prepare subquery conditions
	$subquery_conditions = "WHERE 1 ";
	if($option == "filter") {
		if(strtotime($date_from) || strtotime($date_to)) {
			if(!strtotime($date_from))
				$from = 0; // 1970-01-01
			else
				$from = strtotime($date_from);
			if(!strtotime($date_to))
				$to = 'UNIX_TIMESTAMP(NOW())';
			else
				$to = strtotime($date_to) + 24*3600; // add one day
			$subquery_conditions .= "AND UNIX_TIMESTAMP(`timestamp`) BETWEEN $from AND $to ";
		}
		if($f_lat)
			$subquery_conditions .= "AND `latitude` BETWEEN '".($f_lat - $f_lat_range)."' 
					AND '".($f_lat + $f_lat_range)."' ";
		if($f_lon)
			$subquery_conditions .= "AND `longitude` BETWEEN '".($f_lon - $f_lon_range)."' 
					AND '".($f_lon + $f_lon_range)."' ";
	}

    $query = "SELECT SQL_CALC_FOUND_ROWS gpx.*, gpx.timestamp AS 'insert_ts', 
    				MIN(`pts`.`mintime`) AS 'mints', MAX(`pts`.`maxtime`) AS 'maxts' 
    			FROM `${cfg['db_table_prefix']}gpx_files` AS gpx INNER JOIN (
    				SELECT `gpx_id`, MIN(`timestamp`) mintime, MAX(`timestamp`) maxtime 
    					FROM `${cfg['db_table_prefix']}gpx_import` 
    					$subquery_conditions
    					GROUP BY `gpx_id` 
    				UNION 
    				SELECT `gpx_id`, MIN(`timestamp`) mintime, MAX(`timestamp`) maxtime 
    					FROM `${cfg['db_table_prefix']}waypoints` 
    					$subquery_conditions
    					GROUP BY `gpx_id` 
    				) AS pts 
    			ON gpx.id = pts.gpx_id ";
	if($option == "filter") {
		$query .= "WHERE 1 ";
		if($description)
			$query .= "AND gpx.description LIKE '%".db_escape_string($description)."%' ";
		
		$search_url = "&option=filter&date_from=$date_from&date_to=$date_to&lat=$f_lat&lon=$f_lon&lat_range=$f_lat_range&lon_range=$f_lon_range&description=$description";
	}
	$query .= "GROUP BY pts.gpx_id ORDER BY $qs $qo LIMIT ". ($page*$limit) .", $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		if($option == "filter")
			HTML::message_r(_CMN_SEARCH_RESULTS, $num_found);
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"traces.php?task=gpx&s=$sort&o=$order".$search_url);
		HTML::viewResultLimitSelect("traces.php?task=gpx&p=$page&s=$sort&o=$order".$search_url);
		
		HTML_traces::viewGpxTableHeader("traces.php?task=gpx&p=$page".$search_url, $sort, $order);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			HTML_traces::viewGpxTableRow($row);
		}
		HTML_traces::viewGpxTableFooter();
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			'traces.php?task=gpx&s=$sort&o=$order'.$search_url);
		if($option != "filter")
			HTML::message($num_found ._DB_GPX_AVAILABLE);
	}
	else
		HTML::message(_TRC_NO_GPX_IN_DB);
}

function details($id) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_DETAILS, 3);
    #HTML::message(_TRC_DETAILS_OF_GPX . $id);
    $query = "SELECT * FROM `${cfg['db_table_prefix']}gpx_files` WHERE `id` = '$id' ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			HTML_traces::viewGpxDetails($row);
			$gpxStats = $row;
    	}
    	
    	// query stats for trackpoints
	    $query = "SELECT `gpx_id`, COUNT(*) AS 'trkpts', 
			MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat', AVG(`latitude`) AS 'avglat', 
			MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon', AVG(`longitude`) AS 'avglon',
			MIN(`altitude`) AS 'minalt', MAX(`altitude`) AS 'maxalt', AVG(`altitude`) AS 'avgalt', 
			MIN(`timestamp`) AS 'mints', MAX(`timestamp`) AS 'maxts',
			MIN(`sat`) AS 'minsat', MAX(`sat`) AS 'maxsat', AVG(`sat`) AS 'avgsat', 
			MIN(`hdop`) AS 'minhdop', MAX(`hdop`) AS 'maxhdop', AVG(`hdop`) AS 'avghdop', 
			MIN(`pdop`) AS 'minpdop', MAX(`pdop`) AS 'maxpdop', AVG(`pdop`) AS 'avgpdop'
			FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$id' GROUP BY `gpx_id` ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$gpxStats = array_merge($gpxStats, $row);
	    	}
		}else
			$gpxStats['gpx_id'] = $id;
		
    	// query stats for waypoints
	    $query = "SELECT COUNT(*) AS 'wpts' FROM `${cfg['db_table_prefix']}waypoints` 
	    			WHERE `gpx_id` = '$id' ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$gpxStats['wpts'] = $row['wpts'];
	    	}
	    }
	    
    	// query stats for photos
	    $query = "SELECT COUNT(*) AS 'photos' FROM `${cfg['db_table_prefix']}pois` 
	    			WHERE `gpx_id` = '$id' ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$gpxStats['photos'] = $row['photos'];
	    	}
	    }
	    
	    HTML_traces::viewGpxContentLinks($gpxStats);
	    
		// show details if trackpoints availabe
		if($gpxStats['trkpts']) {
		    HTML_traces::viewGpxDetailsTable($gpxStats);
		
			// track distance calculation
			$stw = microtime_float();
			$distances = Trip::getDistancesArray($id);
			if($DEBUG)
				out("(dist calc took ". round(microtime_float() - $stw, 4) ." s)", 'OUT_DEBUG');
			HTML_traces::viewGpxDistances($distances, $gpxStats['timezone']);
			
			// split elevation chart if breaks found
			if(sizeof($distances) > 2)
				HTML::message(_TRC_DETAILS_CHART_SPLIT);
			
			HTML::viewChartViewSelect();
			
			// draw elevation charts
			$chart_count = 1;
			foreach($distances as $key=>$val) {
				if(!$key)
					continue;
				if($cfg['chart_altitude_type'] == 'dist')
					$charttype = 'alt_dist';
				else
					$charttype = 'alt_time';
				
				echo '<a id="chart_link_'.$chart_count.'" href="./graph.php?type='.$charttype.
				'&alt=1&speed=1'.'&id='.$id.'&tz='.$gpxStats['timezone'].
				'&bts='.$distances[$key-1][2].'&ets='.$val[1].
				'&width='.$cfg['chart_big_width'].'&height='.$cfg['chart_big_height'].'">
				<img id="chart_'.$chart_count.'" src="./graph.php?type='.$charttype.
				'&alt=1&speed=1'.'&id='.$id.'&tz='.$gpxStats['timezone'].
				'&bts='.$distances[$key-1][2].'&ets='.$val[1].
				'&width='.$cfg['chart_width'].'&height='.$cfg['chart_height'].'"'.
				'width="'.$cfg['chart_width'].'" height="'.$cfg['chart_height'].'" '.
				'border="1" alt="GPX Altitude Profile" /></a>';
				
				$chart_count++;
			}
		}else
			HTML::message(_TRC_NO_TRKPTS_IN_DB);
    }else {
		HTML::message(_TRC_GPX_DOES_NOT_EXIST);
		return 1;
    }
}

function viewTrace($id, $page, $sort, $order, $limit) {
	global $DEBUG, $cfg;
	global $option, $date_from, $date_to, $f_lat, $f_lon, $f_lat_range, $f_lon_range;
	HTML::heading(_MENU_TRKPT_VIEW, 3);
	$search_url = "";
	
	switch($sort) {
		case '1':
			$qs = 'gpx_id';
			break;
		case '2':
			$qs = 'altitude';
			break;
		case '4':
			$qs = 'fix';
			break;
		case '5':
			$qs = 'sat';
			break;
		case '6':
			$qs = 'hdop';
			break;
		case '7':
			$qs = 'pdop';
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
	
	$query = "SELECT SQL_CALC_FOUND_ROWS `tpt`.* , `gpx`.`timezone`, 
				`gpx`.`name` AS 'gpx_filename', `gpx`.`description` AS `gpx_description` 
				FROM `${cfg['db_table_prefix']}gpx_import` AS `tpt` 
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
			$query .= "AND UNIX_TIMESTAMP(`tpt`.`timestamp`) BETWEEN $from AND $to ";
		}
		if($f_lat)
			$query .= "AND `tpt`.`latitude` BETWEEN '".($f_lat - $f_lat_range)."' 
					AND '".($f_lat + $f_lat_range)."' ";
		if($f_lon)
			$query .= "AND `tpt`.`longitude` BETWEEN '".($f_lon - $f_lon_range)."' 
					AND '".($f_lon + $f_lon_range)."' ";

		$search_url = "&option=filter&date_from=$date_from&date_to=$date_to&lat=$f_lat&lon=$f_lon&lat_range=$f_lat_range&lon_range=$f_lon_range";
	}
	$query .= "ORDER BY `$qs` $qo LIMIT ". ($page*$limit) .", $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		if($option == "filter" || $id)
			HTML::message_r(_CMN_SEARCH_RESULTS, $num_found);
    	
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"traces.php?task=view&id=$id&s=$sort&o=$order".$search_url);
		HTML::viewResultLimitSelect("traces.php?task=view&id=$id&p=$page&s=$sort&o=$order".$search_url);
		
		HTML_traces::viewTraceTableHeader("traces.php?task=view&id=$id&p=$page".$search_url, $sort, $order);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			HTML_traces::viewTraceTableRow($row);
		}
		HTML_traces::viewTraceTableFooter();
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			"traces.php?task=view&id=$id&s=$sort&o=$order".$search_url);
		if($option != "filter" && !$id) {
			HTML::message($num_found ._DB_TRKPTS_AVAILABLE);
		}else {
			HTML::message("<a href='export.php?trkpt=-1$search_url'>". _TRC_EXPORT_AS_GPX ."</a>");
		}
	}
	else
		HTML::message(_TRC_NO_TRKPTS_IN_DB);
}

function uploadTrace() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_UPL, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
    	HTML_traces::fileUploadForm('traces.php?task=import', 
    		check_max_filesize($cfg['max_file_size']));
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function batchimportTraces() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_BATCH_IMPORT, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    echo "<script src='./libraries/import.js'></script>\n";
	    // set current upload dir and scan it for gpx files
		$dir = GPX_UPLOAD_DIR;
		$gpx_files = scan_dir_f($dir, 0, 'FILETYPE_FILE', 'GPX');
		
		HTML::message_r(_TRC_BATCH_IMPORTING_DIR, $dir);
		HTML::message(_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING);
		if($DEBUG)	print_r($gpx_files);
		
		HTML_traces::viewBatchImportTableHeader();
		for($i=0; $i<sizeof($gpx_files); $i++) {
			HTML_traces::viewBatchImportTableRow($i+1, $gpx_files[$i]);
		}
		HTML_traces::viewBatchImportTableFooter($dir);
		HTML_traces::viewImportProgress();
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function importTrace() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_IMPORT, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    echo "<script src='./libraries/import.js'></script>\n";
		if($DEBUG) {
		    out($_FILES['userfile']['name'] ." (file name)", 'OUT_DEBUG');
		    out($_FILES['userfile']['size'] ." Bytes (size)", 'OUT_DEBUG');
		    out($_FILES['userfile']['error'] ." (error number)", 'OUT_DEBUG');
		}
		// set current upload dir and move file there
		$dir = GPX_UPLOAD_DIR;
		$file = $dir. $_FILES['userfile']['name'];
		
	    if(!move_uploaded_file($_FILES['userfile']['tmp_name'], $file)) {
	    	switch ($_FILES['userfile']['error']) {
		        case UPLOAD_ERR_INI_SIZE:
		        case UPLOAD_ERR_FORM_SIZE:
		            $upl_error = _CMN_UPLOAD_ERR_SIZE;
		            break;
		        case UPLOAD_ERR_PARTIAL:
		            $upl_error = _CMN_UPLOAD_ERR_PARTIAL;
		            break;
		        case UPLOAD_ERR_NO_FILE:
		            $upl_error = _CMN_UPLOAD_ERR_NO_FILE;
		            break;
		        case UPLOAD_ERR_NO_TMP_DIR:
		            $upl_error = _CMN_UPLOAD_ERR_NO_TMP_DIR;
		            break;
		        case UPLOAD_ERR_CANT_WRITE:
		            $upl_error = _CMN_UPLOAD_ERR_CANT_WRITE;
		            break;
		        case UPLOAD_ERR_EXTENSION:
		        default:
		            $upl_error = 'Unknown upload error';
	    	}
	    	HTML::message(_TRC_UPL_ERROR . $upl_error);
	    }else {
	    	HTML::message(_TRC_UPL_SUCCESS);
			HTML_traces::viewImportForm(1, basename($file), $dir, 
				strip_tags($_POST['description']), intval($_POST['tz']));
			HTML_traces::viewImportProgress();
		}
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function editTrace($id, $submit) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_EDIT, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    if(!$submit) {
	        $query = "SELECT * FROM `${cfg['db_table_prefix']}gpx_files` 
	        	WHERE `id` = '$id' ;";
	        $result = db_query($query);
	        $row = mysql_fetch_array($result, MYSQL_ASSOC);
	    	if(mysql_num_rows($result))
	    		HTML_traces::editForm('traces.php?task=edit&id='.$id, $id, $row);
		    else
				HTML::message(_TRC_GPX_DOES_NOT_EXIST);
	    } else {
			// edit description of gpx file
			$description = db_escape_string(strip_tags($_POST['description']));
	        $query = "UPDATE IGNORE `${cfg['db_table_prefix']}gpx_files` 
	        	SET `description` = '$description' WHERE `id` = '$id' ;";
	        $result = db_query($query);
	        if(mysql_affected_rows()) {
	        	HTML::message(_TRC_GPX_EDITED);
	        	HTML::message("<a href='?task=details&id=${id}'>"._MENU_GPX_DETAILS."</a>");
	        }
	    }
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function deleteTrace($id, $submit, $confirm) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_DELETE, 3);
    if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
	    if(!$submit) {
	    	HTML_traces::deleteForm('traces.php?task=delete&id='.$id, $id);
	    } else {
			if($confirm == _CMN_YES) {
				// delete waypoints
		        $query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}waypoints` 
		        	WHERE `gpx_id` = '$id' ;";
		        $result = db_query($query);
		        $num_rows = mysql_affected_rows();
		        HTML::message_r(_TRC_WPT_DELETED, $num_rows);
	
				// delete track points
		        $query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}gpx_import` 
		        	WHERE `gpx_id` = '$id' ;";
		        $result = db_query($query);
		        $num_rows = mysql_affected_rows();
		        HTML::message_r(_TRC_TRKPT_DELETED, $num_rows);
	
				// delete gpx file
		        $query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}gpx_files` 
		        	WHERE `id` = '$id' ;";
		        $result = db_query($query);
		        $num_rows = mysql_affected_rows();
		        HTML::message_r(_TRC_GPX_DELETED, $num_rows);
			} else {
				HTML::message(_TRC_NO_CONFIRM_DELETE);
			}    
	    }
    }else {
    	HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
    }
}

function searchGPX() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_GPX_SEARCH, 3);
    HTML_traces::searchGpxForm('');
}

function searchTP() {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_TRKPT_SEARCH, 3);
    HTML_traces::searchTrkPtForm('');
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
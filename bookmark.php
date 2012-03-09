<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

session_start();

include("./check_db.php");
#include("./config.inc.php");
#include("./libraries/functions.inc.php");
#include("./libraries/classes.php");
include("./libraries/html.classes.php");
include("./bookmark.html.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");
include("./head.html.php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$sort 	= getUrlParam('HTTP_GET', 'INT', 's');
$order 	= getUrlParam('HTTP_GET', 'INT', 'o');
$limit 	= getUrlParam('HTTP_GET', 'INT', 'l');
$p		= getUrlParam('HTTP_GET', 'INT', 'p');
$id		= getUrlParam('HTTP_GET', 'INT', 'id');
$task	= getUrlParam('HTTP_GET', 'STRING', 'task');
$url	= getUrlParam('HTTP_GET', 'STRING', 'url');
$name	= getUrlParam('HTTP_GET', 'STRING', 'name');

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
	case 'add':
		addBookmark($url, $name);
		break;
	case 'delete':
		deleteBookmark($id);
		break;
	case 'list':
	default:
        listBookmarks($p, $sort, $order, $limit);
		break;
}


function addBookmark($url, $name) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_BOOKM_ADD, 3);
	if($url) {
		if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
    		// insert bookmark into database
	        $query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}bookmarks` SET 
	        	`name` = '".$name."', 
	        	`url` = '".$url."',
	        	`latitude` = '0', 
	        	`longitude` = '0',
	        	`zoom` = '0', 
	        	`timestamp` = NOW(),
	        	`public` = '1' ;";
	        $result = db_query($query);
	        $bookmark_id = mysql_insert_id();
			HTML::message(_BOOKM_ADDED);
			HTML::message("<a href='".$url."'>"._CMN_BACK."</a>");
		}else {
			HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
		}
	}else {
		HTML::message(_BOOKM_NO_URL);
	}
}

function deleteBookmark($id) {
	global $DEBUG, $cfg;
    HTML::heading(_MENU_BOOKM_DELETE, 3);
	if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
		// delete bookmark
        $query = "DELETE IGNORE FROM `${cfg['db_table_prefix']}bookmarks` 
        	WHERE `id` = '$id' ;";
        $result = db_query($query);
		HTML::message(_BOOKM_DELETED);
	}else {
		HTML::message(_NOT_AUTH ." ". _DO_LOGIN);
	}
}

function listBookmarks($page, $sort, $order, $limit) {
	global $DEBUG, $cfg;
	global $option, $description;
    HTML::heading(_MENU_BOOKM_VIEW, 3);
	$search_url = "";
	
	switch($sort) {
		case '1':
			$qs = 'id';
			break;
		case '2':
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
	
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM `${cfg['db_table_prefix']}bookmarks` ";
	if($option == "filter") {
		$query .= "WHERE `name` LIKE '%$description%' ";
		$search_url = "&option=filter&description=$description";
	}
	$query .= "ORDER BY `$qs` $qo LIMIT ". ($page*$limit) .", $limit ;";
    $result = db_query($query);
	if($DEBUG)	out($query, 'OUT_DEBUG');
    if(mysql_num_rows($result)) {
		$num_found = mysql_result(db_query("SELECT FOUND_ROWS();") ,0);
		HTML::viewPagination($page, ceil($num_found/$limit), 
			'bookmark.php?task=list&s=$sort&o=$order'.$search_url);
		HTML::viewResultLimitSelect("bookmark.php?task=list&p=$page&s=$sort&o=$order".$search_url);
		
		HTML_bookmarks::viewBookmarksTableHeader("bookmark.php?task=list&p=$page".$search_url, $sort, $order);
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			HTML_bookmarks::viewBookmarksTableRow($row);
		}
		HTML_bookmarks::viewBookmarksTableFooter();
		
		HTML::viewPagination($page, ceil($num_found/$limit), 
			'bookmark.php?task=list&s=$sort&o=$order'.$search_url);
		HTML::message($num_found ._DB_BOOKM_AVAILABLE);
	}
	else
		HTML::message(_BOOKM_NONE_IN_DB);
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
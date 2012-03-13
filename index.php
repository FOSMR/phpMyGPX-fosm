<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2008 Sebastian Klemm.
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

setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");
include("./head.html.php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$task = getUrlParam('HTTP_GET', 'STRING', 'task');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$cfg['embedded_mode'] || !$cfg['public_host'] || check_password($cfg['admin_password'])) {
	HTML::heading(_APP_NAME, 2);
	HTML::main_menu();
}

switch ($task) {
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	default:
        start();
		break;
}


function login() {
	global $cfg;
	if(isset($_POST['pwd'])) {
		$_SESSION['pwd_hash'] = md5(strip_tags($_POST['pwd']));
		if(check_password($cfg['admin_password'])) {
			HTML::message(_LOGIN_SUCCESS);
		}else {
			$_SESSION['pwd_hash'] = '';
			HTML::message(_LOGIN_FAILED);
		}
	}else {
		HTML::message(_LOGIN_DESCRIPTION);
		echo "<form method='post'>\n";
		echo "<input type='password' name='pwd' size=8 />\n";
		echo "<input type='submit' value='Login' />\n";
		echo "</form>\n";
	}
}

function logout() {
	$_SESSION['pwd_hash'] = '';
	HTML::message(_LOGOUT_SUCCESS);
}

function start() {
	global $cfg;
	HTML::heading(_HOME_WELCOME_TO . _APP_NAME, 3);
	#HTML::message(_HOME_INTRO);
	echo "<table width=\"100%\">\n<tr>\n<td>\n<ul>\n";
	HTML::message('<li><a target="_blank" href="http://www.openstreetmap.org/">OpenStreetMap</a>');
	HTML::message('<li><a target="_blank" href="http://www.osmtools.de/osmlinks/?lang='.
		_LANGUAGE .'&lat='. $cfg['home_latitude'] .'&lon='. $cfg['home_longitude']
		.'&zoom='. $cfg['home_zoom'] .'">OpenStreetMap Links</a>');
	if($cfg['pma_app_show_link']) {
		HTML::message('<li><a target="_blank" href="'.$cfg['pma_app_path'].'">phpMyAdmin</a>');
	}
	echo "</td>\n<td>\n<ul>\n";
	HTML::message('<li><a target="_blank" href="http://www.fosm.org/">FreeOSM</a>');
	HTML::message('<li><a target="_blank" href="https://plus.google.com/u/0/109605121902034223436/posts">FOSM on Google+</a>');
	HTML::message('<li><a target="_blank" href="http://fosm-announcements.blogspot.com/">FOSM announcements blog</a>');
	HTML::message('<li><a target="_blank" href="http://tianjara.net/leaflet.html">Tianjara Leaflet Demo</a>');
	HTML::message('<li><a target="_blank" href="http://tianjara.net/cgi-bin/fosm-deep-history/">Tianjara Deep History</a>');
	HTML::message('<li><a target="_blank" href="http://map.4x4falcon.com/">4x4falcon Mapnik</a>');
	HTML::message('<li><a target="_blank" href="http://map.4x4falcon.com/slider/">4x4falcon OSM-FOSM comparison viewer</a>');
	if($cfg['nearmap_support']) {
		HTML::message('<li><a target="_blank" href="https://www.nearmap.com/login">NearMap login</a>');
	}
	echo "</td>\n</tr>\n</table>\n";
}


if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
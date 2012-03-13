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
#include("./libraries/GeoCalc.class.php");
include("./database.html.php");

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
    case 'stats':
        statsDB();
        break;

    default:
        statsDB( NULL );
        break;
}




function statsDB() {
    global $DEBUG, $cfg;
    HTML::heading(_MENU_DB_STAT, 3);

    // Shown if gpx feature is activated.
    if($cfg['gpx_features']) {
        // GPX files quantity.
        $query = "SELECT COUNT(*) AS 'num' FROM `${cfg['db_table_prefix']}gpx_files` ;";
        $result = db_query($query);
        $num['files'] = mysql_result($result, 0);
        HTML::message($num['files'] ._DB_GPX_AVAILABLE);

        // GPX files size.
        $query = "SELECT SUM(`size`) AS 'num' FROM `${cfg['db_table_prefix']}gpx_files` ;";
        $result = db_query($query);
        $num['gpx_size'] = mysql_result($result, 0);
        HTML::message(intval($num['gpx_size']/1024/1024) ." MB " ._DB_GPX_SIZE);

        // Waypoints.
        $query = "SELECT COUNT(*) AS 'num' FROM `${cfg['db_table_prefix']}waypoints` ;";
        $result = db_query($query);
        $num['wpoints'] = mysql_result($result, 0);
        HTML::message($num['wpoints'] ._DB_WPTS_AVAILABLE);

        // Trackpoints.
        $query = "SELECT COUNT(*) AS 'num' FROM `${cfg['db_table_prefix']}gpx_import` ;";
        $result = db_query($query);
        $num['tpoints'] = mysql_result($result, 0);
        HTML::message($num['tpoints'] ._DB_TRKPTS_AVAILABLE);

        // Dates.
        $query = "SELECT COUNT(DISTINCT date(`timestamp`)) AS 'num'
              FROM `${cfg['db_table_prefix']}gpx_import` ;";
        $result = db_query($query);
        $num['dates'] = mysql_result($result, 0);
        HTML::message($num['dates'] ._DB_DAYS_AVAILABLE);

        // Distance.
        $query = "SELECT SUM(`length`) AS 'num' FROM `${cfg['db_table_prefix']}gpx_files` ;";
        $result = db_query($query);
        $num['dist'] = mysql_result($result, 0);
        HTML::message(intval($num['dist']/1000) ." km " ._DB_TOTAL_DISTANCE);
    }

    // Shown if photo feature is activated.
    if($cfg['photo_features']) {
        // Photo files quantity.
        $query = "SELECT COUNT(*) AS 'num' FROM `${cfg['db_table_prefix']}pois` ;";
        $result = db_query($query);
        $num['photos'] = mysql_result($result, 0);
        HTML::message($num['photos'] ._DB_PHOTOS_AVAILABLE);

        // Photo files size.
        $query = "SELECT SUM(`size`) AS 'num' FROM `${cfg['db_table_prefix']}pois` ;";
        $result = db_query($query);
        $num['photos_size'] = mysql_result($result, 0);
        HTML::message(intval($num['photos_size']/1024/1024) ." MB " ._DB_PHOTOS_SIZE);
    }

    // Bookmarks.
    $query = "SELECT COUNT(*) AS 'num' FROM `${cfg['db_table_prefix']}bookmarks` ;";
    $result = db_query($query);
    $num['bookmarks'] = mysql_result($result, 0);
    HTML::message($num['bookmarks'] ._DB_BOOKM_AVAILABLE);
}

if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', '../' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

include("../config.inc.php");
include("../libraries/functions.inc.php");
include("../libraries/html.classes.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("../languages/".get_lang($cfg['config_language']).".php");
include("../head.html.php");

HTML::heading(_INST_OSM_SETUP._INST_DONE, 3);
HTML::message(_INST_GUIDED);
?>

<ol start="1" type="1">
  <li id="done"><?php echo _INST_WELCOME; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_CHECKS; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_CONFIG; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_DB_CREATE_SETUP; ?> <img src='../images/tick_12.png'></li>
  <li id="current"><?php echo _INST_DONE; ?></li>
</ol>

<?php
HTML::message(_INST_PROG_DONE);

$mysql_err_count = 0;

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);
if(!$link) {
	$mysql_err_count++;
}else {
    out("MySQL Server Version: ".mysql_get_server_info(), 2);
    echo "<u>"._INST_DB_STAT."'".$cfg['db_name']."':</u><br>\n";
    // get number of rows for each table
    $query = "SELECT `gpx_id` FROM `${cfg['db_table_prefix']}gpx_import`";
    $num = mysql_num_rows(db_query($query));
    echo $num ._DB_TRKPTS_AVAILABLE ."<br>\n";
    $query = "SELECT `id` FROM `${cfg['db_table_prefix']}gpx_files`";
    $num = mysql_num_rows(db_query($query));
    echo $num ._DB_GPX_AVAILABLE ."<br>\n";
    // close database
    db_close(TRUE, $link);
    
    // rename installation folder for security reasons
    $obscured_dir = substr(md5(date('U').$_SERVER["REMOTE_ADDR"]), 5, 12);
    if(rename(_PATH .'installation', _PATH .$obscured_dir)) {
    	HTML::message(_INST_PROG_RENAMED);
    }else {
    	out(_INST_PROG_RENAME_ERROR, 3);
		#$mysql_err_count++;
	}
}

if(!$mysql_err_count) {
	echo "<p><img src='../images/tick_32.png'> ". _INST_PROG_TEST ."<br>\n";
	echo "<a href='../index.php'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";
}else {
	echo "<p><img src='../images/cancel_32.png'> ". _INST_ERROR ."</p>\n";
	echo "<p><a href=\"Javascript:history.back()\"><img src='../images/back_32.png' border=0> ". _CMN_PREV ."</a></p>";
}

include("../foot.html.php");
?>

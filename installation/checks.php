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

// load default config values
include("./config.defaults.php");
include("../libraries/functions.inc.php");
include("../libraries/html.classes.php");

if(isset($_GET['lang']))
	$cfg['config_language'] = strip_tags($_GET['lang']);

setlocale (LC_TIME, $cfg['config_locale']);
include("../languages/".get_lang($cfg['config_language']).".php");
include("../head.html.php");

$upgrade = getUrlParam('HTTP_GET', 'INT', 'upgrade');

HTML::heading(_INST_OSM_SETUP._INST_CHECKS, 3);
HTML::message(_INST_GUIDED);
?>

<ol start="1" type="1">
  <li id="done"><?php echo _INST_WELCOME; ?> <img src='../images/tick_12.png'></li>
  <li id="current"><?php echo _INST_CHECKS; ?></li>
  <li><?php echo _INST_CONFIG; ?></li>
  <li><?php echo _INST_DB_CREATE_SETUP; ?></li>
  <li><?php echo _INST_DONE; ?></li>
</ol>
  
<?php
HTML::message(_INST_PROG_CHECKS);

{
	echo "<table>\n";
	
    // check directory permissions
    $dir = _PATH;
    printDirPerms($dir);
    
    $dir = _PATH .'files/';
    printDirPerms($dir);
    
    $dir = _PATH .'photos/';
    printDirPerms($dir);
    
    $dir = _PATH .'upload/';
    printDirPerms($dir);
    
    $dir = _PATH .'tiles/mapnik/';
    printDirPerms($dir);
    
    $dir = _PATH .'tiles/osma/';
    printDirPerms($dir);
    
    $dir = _PATH .'tiles/hikebike/';
    printDirPerms($dir);
    
    // check web server capabilities and PHP extensions
    printCapability('mysql', 'MySQL extension', 0);
    #printCapability('mysqli', 'MySQLi extension', 0);

    printCapability('DOM', 'DOM extension', 0);
    
    printCapability('GD2', 'GD2 extension', 0);

    printCapability('CURL', 'cURL extension', 1);

    printCapability('EXIF', 'Exif extension', 1);

    printCapability('mbstring', 'mbstring extension', 1);

	echo "</table>\n";
	
	if(!(checkCapability('EXIF') && checkCapability('mbstring')))
		HTML::message(_INST_PROG_PHOTOS_DISABLED);
}

if(!$error_count) {
	echo "<p><img src='../images/tick_32.png'> ". _INST_PROG_CHECKED ."<br>\n";
	echo "<a href='edit_config.php?lang=${cfg['config_language']}&upgrade=$upgrade'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";
}else {
	echo "<p><img src='../images/cancel_32.png'> ". _INST_ERROR ."</p>\n";
	echo "<p><a href=\"Javascript:history.back()\"><img src='../images/back_32.png' border=0> ". _CMN_PREV ."</a></p>";
}

include("../foot.html.php");


function checkDirPerms($file) {
    if($DEBUG) {
	    echo "$file : ". decoct(fileperms($file) & 511) .",";
	    echo " u=". decoct((fileperms($file) & 0700)/0100) .",";
	    echo " g=". decoct((fileperms($file) & 0070)/010) .",";
	    echo " o=". decoct((fileperms($file) & 0007)) ."<br/>";
	    echo " owner: ". fileowner($file) .",";
	    echo " group: ". filegroup($file) ."<br/>";
    }
    if(is_writable($file) && is_readable($file)) {
    	// all is fine
    	return TRUE;
    }else {
    	// try to change permissions
    	@chmod($file, 0755);
    	clearstatcache();
	    // if successful
	    if(is_writable($file) && is_writable($file)) {
	    	return TRUE;
	    // not writable and unable to chmod
	    }else {
	    	return FALSE;
	    }
    }
}

function printDirPerms($dir) {
	global $error_count;
    if(checkDirPerms($dir)) {
    	echo "<tr><td><i>$dir</i></td><td><img src='../images/tick_12.png' />";
    	echo "<span id='passed'>". _CMN_WRITABLE ."</span></td></tr>\n";
    }else {
    	echo "<tr><td><i>$dir</i></td><td><img src='../images/cancel_12.png' />";
    	echo "<span id='failed'>". _CMN_NOT_WRITABLE."</span></td></tr>\n";
		$error_count++;
    }
}

function printCapability($capability, $capab_string, $optional) {
	global $error_count;
    echo "<tr><td>$capab_string </td>";
    if(checkCapability($capability)) {
    	echo "<td><img src='../images/tick_12.png' />";
    	echo "<span id='passed'>". _CMN_AVAILABLE."</span></td></tr>\n";
    }else {
    	echo "<td><img src='../images/cancel_12.png' />";
    	if($optional) {
    		echo "<span id='optional'>". _CMN_OPTIONAL."</span>";
    	}else {
    		echo "<span id='failed'>". _CMN_MISSING."</span>";
			$error_count++;
    	}
    	echo "</td></tr>\n";
    }
}
?>

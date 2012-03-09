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

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$upgrade = getUrlParam('HTTP_POST', 'INT', 'upgrade');
$db_root = getUrlParam('HTTP_POST', 'STRING', 'db_root');
$db_rootpass = getUrlParam('HTTP_POST', 'STRING', 'db_rootpass');

HTML::heading(_INST_OSM_SETUP._INST_CONFIG, 3);
HTML::message(_INST_GUIDED);
?>

<ol start="1" type="1">
  <li id="done"><?php echo _INST_WELCOME; ?> <img src='../images/tick_12.png'></li>
  <li id="done"><?php echo _INST_CHECKS; ?> <img src='../images/tick_12.png'></li>
  <li id="current"><?php echo _INST_CONFIG; ?></li>
  <li><?php echo _INST_DB_CREATE_SETUP; ?></li>
  <li><?php echo _INST_DONE; ?></li>
</ol>
  
<?php
#HTML::message(_INST_PROG_CONFIG);

$error_count = 0;

if($DEBUG)
	$configfile = _PATH ."config.test.php";
else
	$configfile = _PATH ."config.inc.php";

// overwrite config vars with data given by user via form
$cfg['db_host'] 		= getUrlParam('HTTP_POST', 'STRING', 'db_host');
$cfg['db_name'] 		= getUrlParam('HTTP_POST', 'STRING', 'db_name');
$cfg['db_table_prefix'] = getUrlParam('HTTP_POST', 'STRING', 'db_table_prefix');
$cfg['db_user'] 		= getUrlParam('HTTP_POST', 'STRING', 'db_user');
$cfg['db_password'] 	= getUrlParam('HTTP_POST', 'STRING', 'db_password');
$cfg['public_host'] 	= (bool) getUrlParam('HTTP_POST', 'STRING', 'public_host');
$cfg['admin_password'] 	= getUrlParam('HTTP_POST', 'STRING', 'admin_password');
$cfg['home_latitude'] 	= getUrlParam('HTTP_POST', 'FLOAT', 'home_latitude');
$cfg['home_longitude'] 	= getUrlParam('HTTP_POST', 'FLOAT', 'home_longitude');
$cfg['home_zoom'] 		= getUrlParam('HTTP_POST', 'INT', 'home_zoom');
$cfg['timezone_offset'] = getUrlParam('HTTP_POST', 'INT', 'tz');

// disable photo features if PHP's EXIF and mbstring extensions are missing
if(!(checkCapability('EXIF') && checkCapability('mbstring')))
	$cfg['photo_features'] = false;

// disable local cache proxy for map tiles if PHP's cURL extension is missing
if(!checkCapability('CURL'))
	$cfg['local_tile_proxy'] = false;

// write updated config file
if($handle = fopen($configfile, "w+")) {
	// print one config var per line
	if($DEBUG) {
		foreach($cfg as $key=>$value) {
			$line = '$cfg[\''. $key .'\'] = '. $value;
			echo $line ."<br/>\n";
		}
	}
	// set content of config file to write 
	$content = "<?php\n";
	$content .= "// For explanations please see '/installation/config.defaults.php'!\n";
	$content .= '$cfg = ';
	$content .= var_export($cfg, TRUE);
	$content .= ";\n?>";
	
	if(!fwrite($handle, $content))
		$error_count++;
	fclose($handle);
	
	// show form to alter some config vars
	echo '<form action="install_db.php" method="post" name="make_config">';
	echo "<input type='hidden' name='upgrade' value='$upgrade' />\n";
	
	echo "<input type='hidden' name='db_root' value='$db_root' />\n";
	echo "<input type='hidden' name='db_rootpass' value='$db_rootpass' />\n";
	echo "</form>\n";
		
}else
	$error_count++;

if(!$error_count) {
	echo "<p><img src='../images/tick_32.png'> ". _INST_PROG_CONFIG_UPDATED ."<br>\n";
	echo "<a href='javascript:document.make_config.submit();'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";
}else {
	echo "<p><img src='../images/cancel_32.png'> ". _INST_ERROR ."</p>\n";
	echo "<p><a href=\"Javascript:history.back()\"><img src='../images/back_32.png' border=0> ". _CMN_PREV ."</a></p>";
}

include("../foot.html.php");
?>

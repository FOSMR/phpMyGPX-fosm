<?php
/**
* @version $Id$
* @package phpmygpx-fosm
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
include("../libraries/map.classes.php");

if(isset($_GET['lang']))
	$cfg['config_language'] = getUrlParam('HTTP_GET', 'STRING', 'lang');

setlocale (LC_TIME, $cfg['config_locale']);
include("../languages/".get_lang($cfg['config_language']).".php");
$cfg['config_locale'] = _INST_LOCALE;
setlocale (LC_TIME, $cfg['config_locale']);
include("../head.html.php");

$upgrade = getUrlParam('HTTP_GET', 'INT', 'upgrade');

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

if(is_readable("./config.defaults.php")) {
    // make a backup of default config values
    $cfg_defaults = $cfg;
    
    if($DEBUG)
		$configfile = _PATH ."config.test.php";
    else
		$configfile = _PATH ."config.inc.php";
	
    // check for existing config file
    if(file_exists($configfile)) {
    	// load existing config file
    	include_once($configfile);
    	HTML::message(_INST_PROG_CONFIG_FOUND);
    	
    	// merge existing config vars with defaults
    	$cfg = array_merge($cfg_defaults, $cfg);
		if(isset($_GET['lang']))
			$cfg['config_language'] = strip_tags($_GET['lang']);
    }
    
    // write merged config file
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
		$content .= "\n?>";
		
		if(fwrite($handle, $content))
			HTML::message(_INST_PROG_CONFIG_UPDATED);
		else
			$error_count++;
		fclose($handle);
		
		// show form to alter some config vars
		echo '<form action="make_config.php" method="post" name="edit_config">';
		echo "<input type='hidden' name='upgrade' value='$upgrade' />\n";
		
		echo "<fieldset><legend>"._INST_DB_ACCOUNT."</legend>\n";
		echo "<table>\n";
		echo "<tr><td>"._INST_DB_HOST."</td><td><input type='text' name='db_host' value='${cfg['db_host']}' /></td></tr>";
		echo "<tr><td>"._INST_DB_NAME."</td><td><input type='text' name='db_name' value='${cfg['db_name']}' /></td></tr>";
		echo "<tr><td>"._INST_DB_TABLE_PREFIX."</td><td><input type='text' name='db_table_prefix' value='${cfg['db_table_prefix']}' /></td></tr>";
		echo "<tr><td>"._INST_DB_USER."</td><td><input type='text' name='db_user' value='${cfg['db_user']}' /></td></tr>";
		echo "<tr><td>"._INST_DB_PASSWORD."</td><td><input type='text' name='db_password' value='${cfg['db_password']}' /></td></tr>";
		echo "</table>\n";
		echo "</fieldset>\n";
		
		echo "<fieldset><legend>"._INST_DB_ROOT_ACCOUNT."</legend>\n";
		HTML::message(_INST_DB_ROOT_ACCOUNT_MAN);
		echo "<table>\n";
		echo "<tr><td>"._INST_DB_ROOT."</td><td><input type='text' name='db_root' value='' /></td></tr>";
		echo "<tr><td>"._INST_DB_ROOTPASS."</td><td><input type='password' name='db_rootpass' value='' /></td></tr>";
		echo "</table>\n";
		echo "</fieldset>\n";
		
		echo "<fieldset><legend>"._INST_CFG_ADMIN_ACCESS."</legend>\n";
		HTML::message(_INST_CFG_ADMIN_ACCESS_MAN);
		echo "<table>\n";
		if($cfg['public_host'])
			echo "<tr><td>"._INST_CFG_PUBLIC_HOST."</td><td><input type='checkbox' name='public_host' value='1' checked='checked' /></td></tr>";
		else
			echo "<tr><td>"._INST_CFG_PUBLIC_HOST."</td><td><input type='checkbox' name='public_host' value='1' /></td></tr>";
		echo "<tr><td>"._INST_CFG_ADMIN_PASSWORD."</td><td><input type='text' name='admin_password' value='${cfg['admin_password']}' /></td></tr>";
		echo "</table>\n";
		echo "</fieldset>\n";
		
		echo "<fieldset><legend>"._INST_CFG_HOME_LOCATION."</legend>\n";
		echo "<table width='100%'><tr><td valign='top'>\n";
		
		HTML::message(_INST_CFG_HOME_LOCATION_MAN);
		echo "<table>\n";
		echo "<tr><td>"._CMN_LAT."</td><td><input type='text' name='home_latitude' value='${cfg['home_latitude']}' title='[-90.0 ... +90.0]' />&deg;</td></tr>";
		echo "<tr><td>"._CMN_LON."</td><td><input type='text' name='home_longitude' value='${cfg['home_longitude']}' title='[-180.0 ... +180.0]' />&deg;</td></tr>";
		echo "<tr><td>"._CMN_ZOOM."</td><td><input type='text' name='home_zoom' value='${cfg['home_zoom']}' /></td></tr>";
		echo "<tr><td>"._CMN_TIMEZONE."</td><td>";
		HTML::viewTimezoneSelect($cfg['timezone_offset']);
		echo "</td></tr>";
		echo "</table>\n";
		
		echo "</td><td align='right'>\n";
		$map = new SlippyMap();
		$map->setMapSize(400, 250);
		$map->enableFeatures(array('controls'=>'minimal'));
		$map->embed();
		echo "</td></tr></table>\n";

		echo "</fieldset>\n";
		echo "</form>\n";
		
	}else
		$error_count++;
}else
	$error_count++;

if(!$error_count) {
	echo "<a href='javascript:document.edit_config.submit();'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";
}else {
	echo "<p><img src='../images/cancel_32.png'> ". _INST_ERROR ."</p>\n";
	echo "<p><a href=\"Javascript:history.back()\"><img src='../images/back_32.png' border=0> ". _CMN_PREV ."</a></p>";
}

include("../foot.html.php");
?>

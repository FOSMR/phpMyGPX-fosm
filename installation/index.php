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

// try to guess the user's preferred
$cfg['config_language'] = get_accepted_lang();
// set language, if already chosen
if(isset($_GET['lang']))
	$cfg['config_language'] = getUrlParam('HTTP_GET', 'STRING', 'lang');

$upgrade = getUrlParam('HTTP_GET', 'INT', 'upgrade');

setlocale (LC_TIME, $cfg['config_locale']);
include("../languages/".get_lang($cfg['config_language']).".php");
include("../head.html.php");

HTML::heading(_INST_OSM_SETUP._INST_WELCOME, 3);
HTML::message(_INST_GUIDED);

// check for configuration file, if found assume upgrade
if(file_exists( _PATH.'config.inc.php' ) && filesize( _PATH.'config.inc.php' ) >= 1000)
	$upgrade = 999;
?>

<ol start="1" type="1">
  <li id="current"><?php echo _INST_WELCOME; ?></li>
  <li><?php echo _INST_CHECKS; ?></li>
  <li><?php echo _INST_CONFIG; ?></li>
  <li><?php echo _INST_DB_CREATE_SETUP; ?></li>
  <li><?php echo _INST_DONE; ?></li>
</ol>

<form action="checks.php" method="get" name="lang_mode">
	<fieldset><legend><?php echo _INST_LANGUAGE ?></legend>
<?php
		HTML::message(_INST_LANGUAGE_CHOOSE);
	    echo "<select name='lang' size='1' onchange='location.href=\"index.php?lang=\"+(this.options[this.selectedIndex].value);' />\n";
		$languages = scan_dir_f(_PATH.'languages/', 0, 'FILETYPE_FILE', 'php');
		foreach($languages as $value) {
			$lang = substr($value, 0, -4);
			if($lang == $cfg['config_language'])
				echo "<option value='$lang' selected='selected'>$lang</option>\n";
	    	else
				echo "<option value='$lang'>$lang</option>\n";
	    }
?>
	    </select>
	    
    </fieldset>
    <fieldset><legend><?php echo _INST_MODE ?></legend>
<?php
    	echo '<input type="radio" name="upgrade" value="0" ';
    	if($upgrade < 1)
    		echo 'checked="checked"';
    	echo " /> ". _INST_MODE_NEW . _INST_MODE_NEW_DESC ."<br />\n";
    	echo '<input type="radio" name="upgrade" value="999" ';
    	if($upgrade > 0)
    		echo 'checked="checked"';
    	echo "/> ". _INST_MODE_UPGR_LATEST . _INST_MODE_UPGR3_DESC ."<br />\n";
?>
    </fieldset>
</form>

<?php
#echo "<p><img src='../images/tick_32.png'> ". _INST_PROG_CHECKED ."<br>\n";
echo "<a href='javascript:document.lang_mode.submit();'><img src='../images/next_32.png' border=0> ". _CMN_CONTINUE ."</a></p>";

include("../foot.html.php");
?>
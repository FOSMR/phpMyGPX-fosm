/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

<?php
define( '_VALID_OSM', TRUE );
define( '_PATH', '../' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

if(isset($_GET['lang']))
	$cfg['config_language'] = strip_tags($_GET['lang']);
else
	$cfg['config_language'] = 'english';
include(_PATH ."languages/".$cfg['config_language'].".php");
?>

var DEBUG = 0;

var i18n_strings = new Array();
i18n_strings['_MAP_JS_BOOKM_NAME'] = "<?php echo _MAP_JS_BOOKM_NAME ?>";
i18n_strings['_IMPORT_NO_AJAX'] = "<?php echo _IMPORT_NO_AJAX ?>";
i18n_strings['_IMPORT_PHP_ERROR'] = "<?php echo _IMPORT_PHP_ERROR ?>";
i18n_strings['_CMN_NO_ITEM_SELECTED'] = "<?php echo _CMN_NO_ITEM_SELECTED ?>";

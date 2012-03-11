<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
define( 'GPX_FILES_DIR', './files/');
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);

session_start();

include("./check_db.php");
#include("./config.inc.php");
#include("./libraries/functions.inc.php");
include("./libraries/classes.php");
include("./libraries/html.classes.php");
include("./libraries/map.classes.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");
include("./head.html.php");

if($cfg['show_exec_time'])
    $startTime = microtime_float();

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$id 	= getUrlParam('HTTP_GET', 'INT', 'id');
$id1 	= getUrlParam('HTTP_GET', 'INT', 'id1');
if(isset($id1)) {
	$id = NULL;
	$nextid = getUrlParam('HTTP_GET', 'INT', 'id1');
	for($i=2; $nextid; $i++) {
		$id[] = $nextid;
		$nextid = getUrlParam('HTTP_GET', 'INT', 'id'.$i);
	}
}
$gpx 	= getUrlParam('HTTP_GET', 'STRING', 'gpx');
$f_lat	= getUrlParam('HTTP_GET', 'FLOAT', 'lat');
$f_lon	= getUrlParam('HTTP_GET', 'FLOAT', 'lon');
$zoom 	= getUrlParam('HTTP_GET', 'INT', 'zoom');
$marker	= getUrlParam('HTTP_GET', 'INT', 'marker');
$poi 	= getUrlParam('HTTP_GET', 'INT', 'poi');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

if(!$cfg['embedded_mode'] || !$cfg['public_host'] || check_password($cfg['admin_password'])) {
	HTML::heading(_APP_NAME, 2);
	HTML::main_menu();
}

$f_minlat = 0;
$f_maxlat = 0;
$f_minlon = 0;
$f_maxlon = 0;
$whereGPX = "";
$whereId = "";

if(!$zoom)	$zoom = 15;
if(!$f_lat || !$f_lon) {
	if($id) {
	    if(is_Array($id)) {
			foreach ($id as $d) {
				if($whereGPX!="")	$whereGPX .= " OR ";
				$whereGPX .= "`gpx_id` = '$d'";
				if($whereId!="")	$whereId .= " OR ";
				$whereId .= "`id` = '$d'";
				$gpx[] = "export.php?trkpt=1&wpt=1&id=$d";
			}
		}else {
			$whereGPX = "`gpx_id` = '$id'";
			$whereId = "`id` = '$id'";
			$gpx = "export.php?trkpt=1&wpt=1&id=$id";
		}
		if(!$gpx) {
			$query = "SELECT * FROM `${cfg['db_table_prefix']}gpx_files` 
						WHERE $whereId;";
			$result = db_query($query);
			if($DEBUG)	out($query, 'OUT_DEBUG');
			if(mysql_num_rows($result)) {
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					if(is_Array($id))
						$gpx[] = GPX_FILES_DIR . $row['name'];
					else
						$gpx = GPX_FILES_DIR . $row['name'];
				}
			}
		}
		
	    $query = "SELECT `gpx_id`, 
			MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat', AVG(`latitude`) AS 'avglat', 
			MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon', AVG(`longitude`) AS 'avglon'
			FROM `${cfg['db_table_prefix']}gpx_import` WHERE $whereGPX GROUP BY `gpx_id` ;";
	    $result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
	    if(mysql_num_rows($result)) {
	    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				if( $f_minlat==0 || $f_minlat>$row['minlat'] /1000000 )
					$f_minlat = $row['minlat'] /1000000;
				if( $f_maxlat==0 || $f_maxlat<$row['maxlat'] /1000000 )
					$f_maxlat = $row['maxlat'] /1000000;
				if( $f_minlon==0 || $f_minlon>$row['minlon'] /1000000 )
					$f_minlon = $row['minlon'] /1000000;
				if ($f_maxlon==0 || $f_maxlon<$row['maxlon'] /1000000 )
					$f_maxlon = $row['maxlon'] /1000000;
	    	}
		}else {
		    $query = "SELECT `gpx_id`, 
				MIN(`latitude`) AS 'minlat', MAX(`latitude`) AS 'maxlat', AVG(`latitude`) AS 'avglat', 
				MIN(`longitude`) AS 'minlon', MAX(`longitude`) AS 'maxlon', AVG(`longitude`) AS 'avglon'
				FROM `${cfg['db_table_prefix']}waypoints` WHERE $whereGPX GROUP BY `gpx_id` ;";
		    $result = db_query($query);
			if($DEBUG)	out($query, 'OUT_DEBUG');
		    if(mysql_num_rows($result)) {
		    	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					if( $f_minlat==0 || $f_minlat>$row['minlat'] /1000000 )
						$f_minlat = $row['minlat'] /1000000;
					if( $f_maxlat==0 || $f_maxlat<$row['maxlat'] /1000000 )
						$f_maxlat = $row['maxlat'] /1000000;
					if( $f_minlon==0 || $f_minlon>$row['minlon'] /1000000 )
						$f_minlon = $row['minlon'] /1000000;
					if ($f_maxlon==0 || $f_maxlon<$row['maxlon'] /1000000 )
						$f_maxlon = $row['maxlon'] /1000000;
		    	}
			}
		}
	}else {
		$f_lat = $cfg['home_latitude'];
		$f_lon = $cfg['home_longitude'];
		$zoom = $cfg['home_zoom'];
	}
}

$map = new SlippyMap();
$map->setMapSize($cfg['page_width'], $cfg['map_height']);
$map->setMapCenter($f_lat, $f_lon, $zoom);
$map->setBoundingBox($f_maxlat, $f_maxlon, $f_minlat, $f_minlon);
if($cfg['local_tile_proxy'] && checkCapability('proxysimple'))
	$map->enableFeatures(array('proxy'=>TRUE));
$map->enableFeatures(array('gpx'=>$gpx));
if($marker)
	$map->enableOverlays(new Layer('marker',TRUE));
if($cfg['photo_features'])
	$map->enableOverlays(new Layer('photos',TRUE));
$map->enableOverlays(new Layer('hiking',TRUE));
$map->embedJSincludes();
$map->embedMapcontainer();

if(!$cfg['embedded_mode']) {
	if(!$cfg['public_host'] || check_password($cfg['admin_password'])){

?>

<img src="images/b_bookmark.png" />
<input type="hidden" name="url" id="bookmarklink" />
<a href="JavaScript:addBookmark();"><?php echo _MAP_ADD_BOOKM ?></a><br />
<?php
	}
	if($cfg['gpx_features']) {
?>
<img src="images/b_select.png" />
<a href="" id="searchGPXlink"><?php echo _MENU_GPX ?></a>&nbsp;
<img src="images/b_select.png" />
<a href="" id="searchTRKPTlink"><?php echo _MENU_TRKPT ?></a>&nbsp;
<img src="images/b_select.png" />
<a href="" id="searchWPTlink"><?php echo _MENU_WPT ?></a><?php echo _MAP_CURRENT_AREA ?><br />
<?php
	}
?>
<img src="images/icon_josm.png" />
<a target="josm" href="" id="josmlink"><?php echo _MAP_JOSM_EDIT ?></a>&nbsp;
<img src="images/icon_osb.png" />
<a target="osb" href="" id="osblink">OpenStreetBugs</a>&nbsp;
<img src="images/icon_keepright.png" />
<a target="keepright" href="" id="keeprightlink">keep right!</a><br />

<?php
}
$map->embedJSinitMap();

if($cfg['show_exec_time']) {
    $endTime = microtime_float();
    $exectime = round($endTime - $startTime, 4);
}
include("./foot.html.php");
?>
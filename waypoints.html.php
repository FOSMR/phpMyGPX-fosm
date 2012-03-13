<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

include("./config.inc.php");

class HTML_waypoints {
    function viewWPTsTableHeader($url, $sort, $order) {
		global $cfg;
		if(!$cfg['public_host'] || check_password($cfg['admin_password']))
			$icon_columns = 3;
		else
			$icon_columns = 2;
		echo "<table class='data'>";
        echo "<tr class='head'>";
        echo "<th>"._CMN_ICON."</th>";
        HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
        echo "<th>"._CMN_LAT."</th><th>"._CMN_LON."</th>";
        HTML::viewTabColHead($url, 2, $sort, $order, _CMN_ALT);
        HTML::viewTabColHead($url, 4, $sort, $order, _CMN_NAME);
		echo "<th>"._CMN_COMMENT."</th><th>"._CMN_DESCRIPTION."</th>";
		HTML::viewTabColHead($url, 1, $sort, $order, _CMN_GPX_ID);
		echo "<th colspan=$icon_columns></th></tr>\n";
		echo "</tr>\n";
	}

    function viewWPTsTableRow($tp) {
		global $cfg;
    	$lat = $tp['latitude']/1000000;
    	$lon = $tp['longitude']/1000000;
		echo "<tr><td><img id='map_icon' src='".$tp['icon_file']."' border=0 />
                        <td>". strftime(_DATE_FORMAT_LC3, strtotime($tp['timestamp']) + $tp['timezone']*3600) ."</td>
			<td>$lat</td>
			<td>$lon</td>
			<td>".intval($tp['altitude'])."</td>
			<td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1&icon=".$tp['icon_file']."'>".$tp['name']."</a></td>
                        <td>".$tp['cmt']."</td>
                        <td>".$tp['desc']."</td>
			<td>". HTML::getGpxLink($tp) ."</td>";
		// show map icon only if waypoint belongs to a gpx file
		if($tp['gpx_id'])
			echo "<td><a href='map.php?id=$tp[gpx_id]'><img src='images/icon_osm_32.png' title='"._TRC_SHOW_MAP."' border='0' width=16 height=16 /></a></td>";
		else
			echo "<td></td>";
		// show edit and delete icons only if logged in or on private hosts
		if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
			echo "<td><a href='?task=edit&id=$tp[id]'><img src='images/b_edit.png' title='"._MENU_WPT_EDIT."' border='0' /></a></td>
				<td><a href='?task=delete&id=$tp[id]'><img src='images/b_drop.png' title='"._MENU_WPT_DELETE."' border='0' /></a></td>";
		}
		echo "</tr>\n";
	}

    function viewWPTsTableFooter() {
		echo "</table>\n";
	}

	function searchWptForm($url) {
        echo "<form method='get' action='$url' class='filter'>\n";
        echo "<table border=0><tr><td colspan=4>";
		echo _TRC_CHOOSE_SEARCH_FILTER ."<br />\n";
		echo _TRC_SEARCH_PARAMS_LOGIC_AND ."<br />\n";
		echo _TRC_USE_DP_FOR_SEARCH ."<br />\n";
		echo _CMN_MOUSEOVER_FOR_TOOLTIP ."<br />\n";
		echo '<input type="hidden" name="task" value="view">';
		echo '<input type="hidden" name="option" value="search">';
		echo "</td></tr><tr>";
		echo '<td>'. _CMN_DATE .' [YYYY-MM-DD]: '. _CMN_FROM .'</td>
			<td><input type="text" name="date_from" title="[YYYY-MM-DD]"></td>
			<td><a href="javascript:copyDate();" title="'._CMN_COPY_DATE.'" >[&gt;&gt;]</a> '._CMN_TO.' </td>
			<td><input type="text" name="date_to" title="[YYYY-MM-DD]"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_LAT .': </td><td><input type="text" name="lat" title="[-90.0 ... +90.0]">&deg;</td>';
		echo '<td> +/- '. _CMN_RANGE .': </td><td><input type="text" name="lat_range">&deg;</td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_LON .': </td><td><input type="text" name="lon" title="[-180.0 ... +180.0]">&deg;</td>';
		echo '<td> +/- '. _CMN_RANGE .': </td><td><input type="text" name="lon_range">&deg;</td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_NAME .': </td><td colspan=3><input type="text" name="name" size="32"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_COMMENT .': </td><td colspan=3><input type="text" name="cmt" size="32"></td>';
		echo "</tr><tr>";
		echo '<td>'. _CMN_DESCRIPTION .': </td><td colspan=3><input type="text" name="desc" size="32"></td>';
		echo "</tr><tr>";
        echo "<td colspan=4><input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</td></tr></table>";
        echo "</form>\n";
	}

	function editForm($url, $id, $wpt) {
		global $cfg;
		$lat = $wpt['latitude']/1000000;
		$lon = $wpt['longitude']/1000000;
		
		define('MAP_ICONS_PATH', 'images/map-icons/');
		echo "<div id='icon_layer' class='icon_layer' style='visibility:hidden; z-index:2000; position:absolute; top:130px; width:700px; background-color:#FFFFCC; border:5px solid #804000; padding:10px'><table width='700px'>";
		foreach(scan_dir(MAP_ICONS_PATH, 0, 'FILETYPE_DIR') as $icon_dir) {
			echo "<tr><td>$icon_dir</td><td>\n";
			foreach(scan_dir_f(MAP_ICONS_PATH.$icon_dir."/", 0, 'FILETYPE_FILE', 'png') as $icon_file) {
				echo "<a href='javascript:selectMapIcon(\"".MAP_ICONS_PATH."\",\"$icon_dir/$icon_file\");'>
					<img src='".MAP_ICONS_PATH."$icon_dir/$icon_file' title='$icon_file' hspace='1px' /></a>\n";
			}
			echo "</td></tr>";
		}
		echo "\n</table></div>";
		
		echo "<form method='post' action='$url' class='filter'>\n";
		echo "<table width='100%'><tr><td><table>\n";
		echo "<tr><td><b>". _CMN_ICON .":</b> </td><td><input type='hidden' name='map_icon_url' value='".$wpt['icon_file']."' /><a href='javascript:showMapIcons();'><img id='map_icon' src='".$wpt['icon_file']."' border=0 /></a></td></tr>\n";
		echo "<tr><td><b>". _CMN_DATE .":</b></td><td>". strftime(_DATE_FORMAT_LC2, 
			strtotime(($id)?($wpt['timestamp']):('now'))) ."</td></tr>\n";
		echo "<tr><td><b>". _CMN_LAT .":</b> </td><td><input type='text' name='wpt_lat' value='".$lat."' size=12 maxlength=12 /></td></tr>\n";
		echo "<tr><td><b>". _CMN_LON .":</b> </td><td><input type='text' name='wpt_lon' value='".$lon."' size=12 maxlength=12 /></td></tr>\n";
		echo "<tr><td><b>". _CMN_ALT .":</b> </td><td><input type='text' name='wpt_alt' value='".$wpt['altitude']."' size=12 maxlength=12 /> m</td></tr>\n";
		echo "<tr><td><b>". _CMN_GPX_ID .":</b> </td><td>". $wpt['gpx_id'] ."</td></tr>\n";
		echo "<tr><td><b>". _CMN_NAME .":</b> </td><td><input type='text' name='name' value='".$wpt['name']."' size=32 maxlength=64 /></td></tr>\n";
		echo "<tr><td><b>". _CMN_COMMENT .":</b> </td><td><textarea name='cmt' cols=32 rows=3>".$wpt['cmt']."</textarea></td></tr>\n";
		echo "<tr><td><b>". _CMN_DESCRIPTION .":</b> </td><td><textarea name='desc' cols=32 rows=3>".$wpt['desc']."</textarea></td></tr>\n";
		echo "<tr><td colspan=2>"; 
		echo "<input type='submit' name='submit_btn' value='"._MENU_WPT_SAVE."' onClick='submit();' />\n";
		echo "<input type='hidden' name='submit' value='edit' />\n";
		echo "</td></tr></table></td><td align='right' valign='top'>\n";
		$map = new SlippyMap();
		$map->setMapSize(400, 250);
		$map->setMapCenter($lat, $lon, ($id)?(17):(12));
		if(intval($cfg['local_tile_proxy'] && checkCapability('proxysimple')))
			$map->enableFeatures(array('proxy'=>TRUE));
		$map->enableFeatures(array('controls'=>'minimal'));
		$map->enableFeatures(array('icon_url'=>$wpt['icon_file']));
		$map->enableOverlays(new Layer('marker',TRUE));
		$map->embed();
		echo "</td></tr></table>\n";
		echo "</form>\n";
	}

	function deleteForm($url, $id) {
		echo "<form method='post' action='$url' class='filter'>\n";
		echo "<h3 style='font-weight:bold;color:red;'>"._CMN_WARNING."</h3>\n";
		echo "<p>"._MENU_WPT." # $id:<br />"._WPT_REALLY_DELETE."</p>\n";
		echo "<p>"._TRC_CONFIRM_DELETE."</p>\n";
		echo "<input type='text' name='confirm' value='"._CMN_NO."'>\n";
		echo "<input type='submit' name='submit_btn' value='"._MENU_WPT_DELETE."' onClick='submit();'>\n";
		echo "<input type='hidden' name='submit' value='delete'>\n";
		echo "\n";
		echo "</form>\n";
	}
}
?>

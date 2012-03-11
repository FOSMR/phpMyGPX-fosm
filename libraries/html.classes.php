<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

class HTML {
	function html_head($str, $size) {
		$s = intval($size);
	}

	function html_foot($str, $size) {
		$s = intval($size);
	}

	function heading($str, $size) {
		$s = intval($size);
		if($s > 0 && $s < 7)
			echo "<h$s>$str</h$s>\n";
	}

    function message($str) {
    	HTML::message_r($str, NULL);
    }

    function message_r($str, $replace) {
    	if(!is_null($replace)) {
            $search = array("%1%","%2%","%3%","%4%","%5%");
    		$mod_str = str_replace($search, $replace, $str);
    		$str = $mod_str;
    	}
        echo "<p>$str</p>\n";
    }

    function main_menu() {
    	global $cfg;
		echo '<div id="menu">';
		if($cfg['gpx_features']) {
			echo '<span id="menu_category">'._MENU_GPX.':&nbsp;</span>';
			echo '<a href="traces.php?task=gpx">'._MENU_VIEW.'</a> | ';
			if(!$cfg['public_host'] || check_password($cfg['admin_password']))
				echo '<a href="traces.php?task=upload">'._MENU_UPL.'</a> | ';
			echo '<a href="traces.php?task=searchGPX">'._MENU_SEARCH.'</a> | ';
			echo '<span id="menu_category">'._MENU_TRKPT.':&nbsp;</span>';
			echo '<a href="traces.php?task=view">'._MENU_VIEW.'</a> | ';
			echo '<a href="traces.php?task=searchTP">'._MENU_SEARCH.'</a> | ';
			echo '<span id="menu_category">'._MENU_WPT.':&nbsp;</span>';
			echo '<a href="waypoints.php?task=view">'._MENU_VIEW.'</a> | ';
			echo '<a href="waypoints.php?task=search">'._MENU_SEARCH.'</a> | ';
			if(!$cfg['public_host'] || check_password($cfg['admin_password']))
				echo '<a href="waypoints.php?task=edit&id=0">'._MENU_NEW.'</a> | ';
			echo '<br>';
		}
		if($cfg['photo_features']) {
			echo '<span id="menu_category">'._MENU_PHOTO.':&nbsp;</span>';
			echo '<a href="photos.php?task=view">'._MENU_VIEW.'</a> | ';
			if(!$cfg['public_host'] || check_password($cfg['admin_password']))
				echo '<a href="photos.php?task=upload">'._MENU_UPL.'</a> | ';
		}
		echo '<span id="menu_category">'._MENU_MISC.':&nbsp;</span>';
		echo '<a href="index.php">'._MENU_HOME.'</a> | ';
		echo '<a href="map.php">'._MENU_MAP.'</a> | ';
		echo '<a href="bookmark.php">'._MENU_BOOKMARK.'</a> | ';
		echo '<a href="database.php?task=stats">'._MENU_DB_STAT.'</a> | ';
		echo '<a href="about.php">'._MENU_ABOUT.'</a> | ';
		if($cfg['public_host']) {
			if(check_password($cfg['admin_password']))
				echo '[<a href="index.php?task=logout">'._MENU_LOGOUT.'</a>]';
			else
				echo '[<a href="index.php?task=login">'._MENU_LOGIN.'</a>]';
		}
		echo '</div>';
		echo '<br clear="all"> ';
    }

    function viewPagination($cur, $max, $url) {
		echo '<div class="pagination">';
		if($cur!=0) {
			echo ' <a href="'. $url .'&p=0">'. _CMN_FIRST ."</a> ";
			echo ' <a href="'. $url .'&p='. ($cur-1) .'">'. _CMN_PREV ."</a> ";
		}
		echo "[". _CMN_PAGE ." ". ($cur+1) ."/". $max ."]";
		if($cur < $max-1) {
			echo ' <a href="'. $url .'&p='. ($cur+1) .'">'. _CMN_NEXT ."</a> ";
			echo ' <a href="'. $url .'&p='. ($max-1) .'">'. _CMN_LAST ."</a> ";
		}
		echo "</div>\n";
    }

    function viewTableViewSelect($view, $url) {
		echo '<div class="viewSelect">';
		echo "["._CMN_VIEW.": <a href='${url}&view=simple'>"._CMN_VIEW_SIMPLE."</a>\n";
		echo " | <a href='${url}&view=detailed'>"._CMN_VIEW_DETAIL."</a>]\n";
		echo "</div>\n";
	}

    function viewChartViewSelect() {
		echo '<div class="viewSelect">';
		echo "["._CMN_VIEW.": <a href='javascript:changeChartType(\"time\")'>"._CHART_AXIS_TIME."</a>\n";
		echo " | <a href='javascript:changeChartType(\"dist\")'>"._CHART_AXIS_DIST."</a>]\n";
		echo "</div>\n";
	}

    function viewResultLimitSelect($url) {
    	global $limit;
		echo '<div class="viewSelect">';
		echo "<select size=1 name='l' onchange='changeResultLimit(this.options[this.selectedIndex].value, \"$url\");' >\n";
		echo "  <option value=0>"._CMN_SHOW.": $limit</option>\n";
		echo "  <option value=10>10</option>\n";
		echo "  <option value=15>15</option>\n";
		echo "  <option value=20>20</option>\n";
		echo "  <option value=25>25</option>\n";
		echo "  <option value=35>35</option>\n";
		echo "  <option value=50>50</option>\n";
		echo "  <option value=100>100</option>\n";
		echo "  <option value=500>500</option>\n";
		echo "</select>\n";
		echo "</div>\n";
	}

    function viewTimezoneSelect($selected) {
    	global $limit;
		echo '<div class="viewSelect">'. _CMN_TIMEZONE .': ';
		echo "<select size=1 name='tz' >\n";
		echo "  <option value=0>"._CMN_TIMEZONE.": $limit</option>\n";
		for($offset=-12; $offset<13; $offset++) {
			echo "  <option value='${offset}' ". ($offset==$selected?'selected="selected"':'')
				.">GMT". ($offset>0?'+':'') ."${offset}</option>\n";
		}
		echo "</select>\n";
		echo "</div>\n";
	}

	function viewTabColHead($url, $nr, $sort, $order, $name) {
		echo "<th><a title='". ($order ? _CMN_SORT_ASC : _CMN_SORT_DESC);
		echo "' href='$url&s=$nr&o=". (intval(!(bool)$order)) ."'>". $name;
		if($sort == $nr) {
			$arrow = array("&#9650;", "&#9660;");
			echo $arrow[intval($order)];
		}
		echo "</a></th>\n";
	}
	
	function getGpxLink($gpx) {
		if($gpx['gpx_id'])
			$string = "<a href='traces.php?task=details&id=${gpx['gpx_id']}' 
				title='${gpx['gpx_description']} (${gpx['gpx_filename']})'>${gpx['gpx_id']}</a>";
		else
			$string = " - ";
		return $string;
	}
}
?>
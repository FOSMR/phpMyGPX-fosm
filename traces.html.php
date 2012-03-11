<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

include("./config.inc.php");

class HTML_traces {
    function viewGpxDetails($gpx) {
    	echo "<b>". _CMN_FILE_NAME .":</b> ". $gpx['name'] ."<br />\n";
    	echo "<b>". _CMN_FILE_SIZE .":</b> ". (round($gpx['size']/1024, 1)) ." kB<br />\n";
    	echo "<b>". _CMN_DESCRIPTION .":</b> ". $gpx['description'] ."<br />\n";
    	echo "<b>". _CMN_TIMEZONE .":</b> GMT". ($gpx['timezone']>0?'+':'') . $gpx['timezone'] ."<br />\n";
    }

    function viewGpxDetailsTable($gpx) {
		global $cfg;
		echo "<table width=${cfg['page_width']} cellspacing=0 cellpadding=0 border=0><tr><td>";
		echo "<table class='data'>";
        echo "<tr class='head'><th></th><th>MIN</th><th>AVG</th>
        	<th>MAX</th></tr>\n";
		echo "<tr><td>"._CMN_LAT."</td><td>".($gpx['minlat']/1000000)."</td><td>"
			.($gpx['avglat']/1000000)."</td><td>".($gpx['maxlat']/1000000)."</td></tr>\n";
		echo "<tr><td>"._CMN_LON."</td><td>".($gpx['minlon']/1000000)."</td><td>"
			.($gpx['avglon']/1000000)."</td><td>".($gpx['maxlon']/1000000)."</td></tr>\n";
		echo "<tr><td>"._CMN_ALT."</td>
			<td>".round($gpx['minalt'])." m</td><td>".round($gpx['avgalt'])." m</td>
			<td>".round($gpx['maxalt'])." m</td></tr>\n";
		echo "<tr><td>"._CMN_DATE."</td>
			<td>".strftime(_DATE_FORMAT_LC3, strtotime($gpx['mints']) + $gpx['timezone']*3600)."</td><td></td>
			<td>".strftime(_DATE_FORMAT_LC3, strtotime($gpx['maxts']) + $gpx['timezone']*3600)."</td></tr>\n";
		echo "<tr><td>"._CMN_SAT."</td>
			<td>${gpx['minsat']}</td><td>".round($gpx['avgsat'], 2)."</td>
			<td>${gpx['maxsat']}</td></tr>\n";
		echo "<tr><td>"._CMN_HDOP."</td><td>${gpx['minhdop']}</td>
			<td>".round($gpx['avghdop'], 2)."</td>
			<td>${gpx['maxhdop']}</td></tr>\n";
		echo "<tr><td>"._CMN_PDOP."</td><td>${gpx['minpdop']}</td>
			<td>".round($gpx['avgpdop'], 2)."</td>
			<td>${gpx['maxpdop']}</td></tr>\n";
		echo "</table>\n";
		
		echo "</td><td style='text-align:right;padding-left:20px;'>\n";
		echo '<a href="./image.php?type=birdview&id='.$gpx['gpx_id'].
			'&width='.$cfg['image_big_size'].'&height='.$cfg['image_big_size'].'">
			<img src="./image.php?type=birdview&id='.$gpx['gpx_id'].
			'&width='.$cfg['image_size'].'&height='.$cfg['image_size'].'"'.
			'width="'.$cfg['image_size'].'" height="'.$cfg['image_size'].'" '.
			'border="1" alt="GPX Trace" /></a>';
		
		echo "</td></tr></table><br />\n";
	}

    function viewGpxContentLinks($gpx) {
    	echo "<div>\n";
		echo _MENU_TRKPT.": <a href='traces.php?task=view&id=${gpx['gpx_id']}'>${gpx['trkpts']}
			<img src='images/b_browse.png' title='"._MENU_TRKPT_VIEW."' border='0' />
			</a>\n";
    	echo "&nbsp;|&nbsp;";
		echo _MENU_WPT.": <a href='waypoints.php?task=view&id=${gpx['gpx_id']}'>${gpx['wpts']}
			<img src='images/b_browse.png' title='"._MENU_WPT_VIEW."' border='0' />
			</a>\n";
    	echo "&nbsp;|&nbsp;";
		echo _MENU_PHOTO.": <a href='photos.php?task=view&gpx_id=${gpx['gpx_id']}'>${gpx['photos']}
			<img src='images/camera1.png' title='"._MENU_PHOTO_VIEW."' border='0' width=20 height=20 />
			</a>\n";
    	echo "&nbsp;|&nbsp;";
    	echo _MENU_MAP." <a target='_self' href='map.php?id=${gpx['gpx_id']}'>
    		<img src='images/icon_osm_32.png' title='"._TRC_SHOW_MAP."' border='0' width=16 height=16 />
    		</a>\n";
    	echo "</div><br/>\n";
    }

    function viewGpxDistances($dist, $timezone) {
		echo "<table class='data' width=900>\n";
		echo "<tr><th></th><th>"._TRC_APPROX_DIST."</th><th>"._TRC_AVG_SPEED.
			"</th><th>"._TRC_TRIP_TIME."</th></tr>\n";
		// split track into segments if breaks found
		if(sizeof($dist) > 2) {
	    	foreach($dist as $key=>$val) {
	    		if(!$key)
	    			continue;
	    		echo "<tr><td>";
	    		echo _TRC_TRACK. ($key) ."</td><td>". round($val[0], 1) ." km</td><td>";
	    		echo round($val[0] / ($val[1] - $dist[$key-1][2]) * 3600, 1)
	    			." km/h</td><td>";
	    		echo time_format($val[1] - $dist[$key-1][2], _TIME_FORMAT_LC4) ." (".
	    			($val[1] - $dist[$key-1][2]) ." s)</td><td>(".
    				strftime(_DATE_FORMAT_LC3, $dist[$key-1][2] + $timezone*3600) ." - ".
    				strftime(_DATE_FORMAT_LC3, $val[1] + $timezone*3600) .")";
	    		echo "</td></tr>\n";
	    		if($val[2]) {
	    			echo "<tr class='odd'><td>";
	    			echo _TRC_HALT ."</td><td></td><td></td><td>". 
	    				time_format($val[2] - $val[1], _TIME_FORMAT_LC4) ." (". 
	    				($val[2] - $val[1]) ." s)</td><td>(".
	    				strftime(_DATE_FORMAT_LC3, $val[1] + $timezone*3600) ." - ".
	    				strftime(_DATE_FORMAT_LC3, $val[2] + $timezone*3600) .")";
	    			echo "</td></tr>\n";
	    		}
	    	}
	    	echo "</td></tr>\n";
    	}
    	
    	// summary
		echo "<tr><th>". _TRC_TOTAL ."</th>\n";
    	echo "<th>". round(array_sum_multidim($dist, NULL, 0), 2) ." km</th>\n";

		// total trip time and average speed calculation
		$track_time = NULL;
		foreach($dist as $key=>$val)
			$track_time += $val[1] - $val[2];
		$speed = round(array_sum_multidim($dist, NULL, 0) / $track_time * 3600, 2);
		
    	echo "<th>". round($speed, 2) ." km/h</th>\n";
    	echo "<th>". time_format($track_time, _TIME_FORMAT_LC4)
    		." ($track_time s)</th>\n";
    	echo "</tr></table><br />\n";
    }

    function viewGpxTableHeader($url, $sort, $order) {
		global $cfg;
    	if(!$cfg['public_host'] || check_password($cfg['admin_password']))
    		$icon_columns = 6;
    	else
    		$icon_columns = 4;
		if($cfg['public_host'] && !$cfg['enable_gpx_download'] 
			&& !check_password($cfg['admin_password']))
			$icon_columns--;
    	
		echo "<form name='view_gpx_form'>\n";
		echo "<table class='data'>";
        echo "<tr class='head'>";
		echo "<th></th>\n";
		HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
		echo "<th>"._CMN_DESCRIPTION."</th>";
		HTML::viewTabColHead($url, 5, $sort, $order, _CMN_LENGTH);
		HTML::viewTabColHead($url, 2, $sort, $order, _CMN_FILE_SIZE);
		echo "<th>"._CMN_FILE_NAME."</th>";
		if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
			HTML::viewTabColHead($url, 1, $sort, $order, _CMN_GPX_ID);
			HTML::viewTabColHead($url, 4, $sort, $order, _CMN_INSERTED);
		}
		echo "<th colspan=$icon_columns></th></tr>\n";
	}

    function viewGpxTableRow($gpx) {
		global $cfg;
		echo "<tr>
			<td><input type='checkbox' name='bfiles[]' value='$gpx[id]' /></td>
			<td>". strftime(_DATE_FORMAT_LC, strtotime($gpx['mints']) + $gpx['timezone']*3600) ."</td>
			<td><a href='?task=details&id=$gpx[id]'>$gpx[description]</a></td>
			<td>". round($gpx['length']/1000, 1) ." km</td>
			<td>". round($gpx['size']/1024, 1) ." kB</td>
			<td>$gpx[name]</td>";
		if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
			echo "<td>$gpx[id]</td>
				<td>". strftime(_DATE_FORMAT_LC, strtotime($gpx['insert_ts'])) ."</td>";
		}
			echo "<td><a href='map.php?id=$gpx[id]'><img src='images/icon_osm_32.png' title='"._TRC_SHOW_MAP."' border='0' width=16 height=16 /></a></td>
			<td><a href='?task=details&id=$gpx[id]'><img src='images/b_view.png' title='"._MENU_GPX_DETAILS."' border='0' /></a></td>
			<td><a href='?task=view&id=$gpx[id]'><img src='images/b_browse.png' title='"._MENU_TRKPT_VIEW."' border='0' /></a></td>";
		if(!$cfg['public_host'] || $cfg['enable_gpx_download'] 
			|| check_password($cfg['admin_password'])) {
			echo "<td><a href='files/$gpx[name]'><img src='images/b_export.png' title='"._MENU_GPX_DOWNL."' border='0' /></a></td>";
		}
		if(!$cfg['public_host'] || check_password($cfg['admin_password'])) {
			echo "<td><a href='?task=edit&id=$gpx[id]'><img src='images/b_edit.png' title='"._MENU_GPX_EDIT."' border='0' /></a></td>
				<td><a href='?task=delete&id=$gpx[id]'><img src='images/b_drop.png' title='"._MENU_GPX_DELETE."' border='0' /></a></td>";
		}
		echo "</tr>\n";
	}

    function viewGpxTableFooter() {
		echo "<tr><td colspan='8'><a href='javascript:showOnMap();'><img src='images/icon_osm_32.png' title='"._TRC_SHOW_ITEMS_ON_MAP."' border='0' width=16 height=16 hspace=5/>"._TRC_SHOW_ITEMS_ON_MAP."</a></td></tr>\n";
		echo "</table></form>\n";
	}

    function viewTraceTableHeader($url, $sort, $order) {
		echo "<table class='data'>";
        echo "<tr class='head'>";
        HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
        echo "<th>"._CMN_LAT."</th><th>"._CMN_LON."</th>";
        HTML::viewTabColHead($url, 4, $sort, $order, _CMN_FIX);
        HTML::viewTabColHead($url, 5, $sort, $order, _CMN_SAT);
        HTML::viewTabColHead($url, 6, $sort, $order, _CMN_HDOP);
        HTML::viewTabColHead($url, 7, $sort, $order, _CMN_PDOP);
		HTML::viewTabColHead($url, 2, $sort, $order, _CMN_ALT);
		echo "<th>"._CMN_COURSE."</th><th>"._CMN_SPEED."</th>";
        HTML::viewTabColHead($url, 1, $sort, $order, _CMN_GPX_ID);
		echo "</tr>\n";
	}

    function viewTraceTableRow($tp) {
    	$lat = $tp['latitude']/1000000;
    	$lon = $tp['longitude']/1000000;
		echo "<tr><td>". strftime(_DATE_FORMAT_LC3, strtotime($tp['timestamp']) + $tp['timezone']*3600) ."</td>
			<td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lat</td>
			<td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lon</td>
			<td>$tp[fix]</td><td>$tp[sat]</td>
			<td>$tp[hdop]</td><td>$tp[pdop]</td><td>$tp[altitude]</td>
			<td>$tp[course]</td><td>$tp[speed]</td>
			<td>". HTML::getGpxLink($tp) ."</td></tr>\n";
	}

    function viewTraceTableFooter() {
		echo "</table>\n";
	}

    function viewBatchImportTableHeader() {
		echo "<form name='batch_import_form' class='filter'><table class='data'>";
        echo "<tr class='head'><th> </th><th>#</th>
        	<th>"._CMN_FILE_NAME."</th><th width='550px'>"._CMN_STATUS."</th>
			<th> </th></tr>\n";
	}

    function viewBatchImportTableRow($id, $bgpx) {
		echo "<tr><td><input type='checkbox' name='bfiles[]' value='${bgpx}' /></td>
			<td>${id}</td><td>$bgpx</td>
			<td><span id='status_${id}'></span></td>
			<td><span id='status_icon_${id}'></span></td></tr>\n";
	}

    function viewBatchImportTableFooter($path) {
    	global $cfg;
		echo "<tr><th><input type='checkbox' name='bgpx_all' value='1' onclick='checkall(this.form.bgpx_all.checked);' /></th><th></th><th colspan=3>"._CMN_SELECT_ALL."</td></tr>\n";
		echo "</table>\n";
		HTML::viewTimeZoneSelect($cfg['timezone_offset']);
		echo _CMN_DESCRIPTION .': <input type="text" name="description" size=80 /><br/>';
		echo "<input type='button' name='start' value='"._TRC_START_IMPORT."' onclick='javascript:startImport(\"".$path."\", 0, \"gpx\");' /></form><br/>\n";
	}

    function viewImportForm($id, $bgpx, $path, $desc, $tz) {
		echo "<form name='batch_import_form' class='filter'>";
		echo "<input type='hidden' name='bfiles[]' value='${bgpx}' />${bgpx} : ";
		echo "<span id='status_${id}'></span> <span id='status_icon_${id}'></span><br/>\n";
		echo "<input type='hidden' name='tz' value='${tz}' /><br/>";
		echo "<input type='hidden' name='description' value='${desc}' /><br/>";
		echo "<input type='button' name='start' value='"._CMN_CONTINUE."' onclick='javascript:startImport(\"".$path."\", 1, \"gpx\");' /></form><br/>\n";
    }

	function viewImportProgress() {
    	echo "<div><span id='dynamicContent_Wait' style='visibility:hidden'><img src='images/loader_rect_black.gif'/> "._TRC_WAIT_WHILE_IMPORTING."</span>";
    	echo "<span id='dynamicContent' style='font-weight:bold;'></span>\n";
    	echo "<div id='dynamicContent_Done' style='visibility:hidden'>"._TRC_IMPORT_DONE."</div>\n";
	}

    function fileUploadForm($url, $maxfilesize) {
    	global $cfg;
        echo "<form enctype='multipart/form-data' method='post' action='$url' class='filter'>\n";
        echo "<fieldset><legend>"._CMN_SINGLE_FILE."</legend>\n";
		echo _TRC_CHOOSE_UPL_FILE ."\n";
		echo " (". _CMN_MAX_FILE_SIZE . round($maxfilesize/1024) ." kB)<br />\n";
		echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.$maxfilesize.'">';
		echo '<input type="file" name="userfile" size=40><br />';
		HTML::viewTimeZoneSelect($cfg['timezone_offset']);
		echo _CMN_DESCRIPTION .': <input type="text" name="description" size=80><br/>';
        echo "<input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</fieldset>\n";
        echo "</form>\n";
        
        echo "<form method='get' action='' class='filter'>\n";
        echo "<fieldset><legend>"._CMN_BATCH."</legend>\n";
		echo _TRC_BATCH_IMPORT_INFO ."<br/>\n";
		echo '<input type="hidden" name="task" value="batchimport">';
        echo "<input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</fieldset>\n";
        echo "</form>\n";
	}

	function searchGpxForm($url) {
        echo "<form method='get' action='$url' class='filter'>\n";
        echo "<table border=0><tr><td colspan=4>";
		echo _TRC_CHOOSE_SEARCH_FILTER ."<br />\n";
		echo _TRC_SEARCH_PARAMS_LOGIC_AND ."<br />\n";
		echo _TRC_USE_DP_FOR_SEARCH ."<br />\n";
		echo _CMN_MOUSEOVER_FOR_TOOLTIP ."<br />\n";
		echo '<input type="hidden" name="task" value="gpx">';
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
		echo '<td>'. _CMN_DESCRIPTION .': </td><td colspan=3><input type="text" name="description" size="32"></td>';
		echo "</tr><tr>";
        echo "<td colspan=4><input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</td></tr></table>";
        echo "</form>\n";
	}

	function searchTrkPtForm($url) {
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
        echo "<td colspan=4><input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</td></tr></table>";
        echo "</form>\n";
	}

    function editForm($url, $id, $gpx) {
        echo "<form method='post' action='$url' class='filter'>\n";
    	echo "<b>". _CMN_FILE_NAME .":</b> ". $gpx['name'] ."<br />\n";
    	echo "<b>". _CMN_FILE_SIZE .":</b> ". (round($gpx['size']/1024, 1)) ." kB<br />\n";
    	echo "<b>". _CMN_INSERTED .":</b> ". strftime(_DATE_FORMAT_LC2, strtotime($gpx['timestamp'])) ."<br />\n";
        echo _CMN_DESCRIPTION .": <input type='text' name='description' value='".$gpx['description']."' size=80 /><br/>\n";
        echo "<input type='submit' name='submit_btn' value='"._CMN_SAVE."' onClick='submit();' />\n";
        echo "<input type='hidden' name='submit' value='edit' />\n";
        echo "\n";
        echo "</form>\n";
    }

    function deleteForm($url, $id) {
        echo "<form method='post' action='$url' class='filter'>\n";
        echo "<h3 style='font-weight:bold;color:red;'>"._CMN_WARNING."</h3>\n";
		echo "<p>"._MENU_GPX." # $id:<br />"._TRC_REALLY_DELETE."</p>\n";
		echo "<p>"._TRC_CONFIRM_DELETE."</p>\n";
        echo "<input type='text' name='confirm' value='"._CMN_NO."' />\n";
        echo "<input type='submit' name='submit_btn' value='"._MENU_GPX_DELETE."' onClick='submit();' />\n";
        echo "<input type='hidden' name='submit' value='delete' />\n";
        echo "\n";
        echo "</form>\n";
    }
}
?>

<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

class HTML_photos {
    function viewPhotoDetails($ph, $prev, $next) {
        global $cfg;
        $lat = $ph['latitude']/1000000;
        $lon = $ph['longitude']/1000000;
        echo "<table width='100%'><tr><td valign='top'>\n";

        echo "<table class='data'>\n";
        echo "<tr><td>"._CMN_PHOTO_ID."</td><td>$ph[id]</td></tr>";
        if(!$cfg['embedded_mode'])
            echo "<tr><td>"._CMN_GPX_ID."</td><td><a href='traces.php?task=details&id=$ph[gpx_id]'>$ph[gpx_id]</a></td></tr>";
        echo "<tr><td>"._CMN_DATE."</td><td>".strftime(_DATE_FORMAT_LC3, strtotime($ph['timestamp']))."</td></tr>";
        echo "<tr><td>"._CMN_LAT." / "._CMN_LON."</td>
            <td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lat / $lon</a></td></tr>";
        echo "<tr><td>"._CMN_VIEW_DIR."</td><td>$ph[image_dir]&deg;</td></tr>";
        echo "<tr><td>"._CMN_SPEED." - "._CMN_MOVE_DIR."</td><td>$ph[speed] km/h - $ph[move_dir]&deg;</td></tr>";
        echo "<tr><td>"._CMN_ALT."</td><td>$ph[altitude] m</td></tr>
            <tr><td>"._CMN_FILE_NAME."</td><td>$ph[file]</td></tr>
            <tr><td>"._CMN_FILE_SIZE."</td><td>".round($ph['size']/1024, 1)." kB</td></tr>
            <tr><td>"._CMN_TITLE."</td><td>$ph[title]</td></tr>
            <tr><td>"._CMN_DESCRIPTION."</td><td>$ph[description]</td></tr>";
        echo "</table><br/>\n";

        echo "</td><td align='center'>\n";
        if($prev)
            echo "<a title='"._CMN_PREV."' href='?task=details&id=$prev'>
                <img src='images/back_32.png' border=0 /></a>";
        if($next)
            echo "<a title='"._CMN_NEXT."' href='?task=details&id=$next'>
                <img src='images/next_32.png' border=0 /></a>";

        echo "</td><td align='right'>\n";
        $map = new SlippyMap();
        $map->setMapSize(350, 200);
        $map->setMapCenter($lat, $lon, 17);
        if(intval($cfg['local_tile_proxy'] && checkCapability('proxysimple')))
            $map->enableFeatures(array('proxy'=>TRUE));
        $map->enableFeatures(array('buffer'=>'0'));
        $map->enableFeatures(array('controls'=>'minimal'));
        $map->enableOverlays(new Layer('marker',TRUE));
        $map->embed();
        echo "</td></tr></table><br/>\n";

        if($cfg['photo_full_size'])
            echo "<a href='photos.php?task=full&id=${ph['id']}'>";
        echo "<img src='getphoto.php?id=${ph['id']}&x=${cfg['chart_width']}' border=1 />\n";
        if($cfg['photo_full_size'])
            echo "</a>";
    }

    function fullPhoto($ph) {
        global $cfg;
        echo "<img src='getphoto.php?id=${ph['id']}&x=-1' border=1 />\n";
    }

    function viewPhotoTableSimple($db_result) {
        global $cfg;
        echo "<table class='photo'>\n";
        do {
            echo "<tr>\n";
            for($i=1; $i<=5; $i++) {
                $row = mysql_fetch_array($db_result, MYSQL_ASSOC);
                if($row) {
                    echo "<td>";
                    echo "<a href='?task=details&id=${row['id']}'>";
                    echo "<img src='".$cfg['photo_thumbs_dir'].$cfg['thumbs_prefix']. $row['file']."' />";
                    echo "</a><br/>";
                    echo "<a title='${row['file']}' href='?task=details&id=${row['id']}'>".
                    	trim_str($row['file'], 16)."</a></td>";
                }else
                    echo "<td>&nbsp;</td>";
            }
            echo "</tr>\n";
        } while($row);
        echo "</table>\n";
    }

    function viewPhotoTableHeader($url, $sort, $order) {
        global $cfg;
        if(!$cfg['public_host'] || check_password($cfg['admin_password']))
            $icon_columns = 2;
        else
            $icon_columns = 1;

        echo "<table class='data'>";
        echo "<tr class='head'>
            <th>"._CMN_THUMB."</th>";
        HTML::viewTabColHead($url, 4, $sort, $order, _CMN_FILE_NAME);
        HTML::viewTabColHead($url, 5, $sort, $order, _CMN_FILE_SIZE);
        HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
        echo "<th>"._CMN_LAT."</th><th>"._CMN_LON."</th>";
        HTML::viewTabColHead($url, 2, $sort, $order, _CMN_ALT);
        echo "<th>"._CMN_PHOTO_ID."</th>";
        // TODO insert the direction/orientation.
        HTML::viewTabColHead($url, 1, $sort, $order, _CMN_GPX_ID);
        echo "<th colspan=$icon_columns></th></tr>\n";
    }

    function viewPhotoTableRow($ph) {
        global $cfg;
        $lat = $ph['latitude']/1000000;
        $lon = $ph['longitude']/1000000;
        echo "<tr>
            <td><a href='?task=details&id=$ph[id]'>
                <img src='".$cfg['photo_thumbs_dir'].$cfg['thumbs_prefix']."${ph['file']}' />
                </a></td>
            <td><a title='{$ph['file']}' href='?task=details&id=${ph['id']}'>".
            	trim_str($ph['file'], 16)."</a></td>
            <td>". round($ph['size']/1024, 1) ." kB</td>
            <td>$ph[timestamp]</td>
            <td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lat</a></td>
            <td><a href='map.php?lat=$lat&lon=$lon&zoom=17&marker=1'>$lon</a></td>
            <td>$ph[altitude] m</td>
            <td>$ph[id]</td>
            <td>". HTML::getGpxLink($ph) ."</td>
            <td><a href='?task=details&id=$ph[id]'><img src='images/b_view.png' title='"._MENU_PHOTO_DETAILS."' border='0' /></a></td>";
        if(!$cfg['public_host'] || check_password($cfg['admin_password']))
            echo "<td><a href='?task=delete&id=$ph[id]'><img src='images/b_drop.png' title='"._MENU_PHOTO_DELETE."' border='0' /></a></td>";
        echo "</tr>\n";
    }

    function viewPhotoTableFooter() {
        echo "</table>\n";
    }

    function fileUploadForm($url, $maxfilesize) {
        echo "<form method='get' action='' class='filter'>\n";
        echo "<fieldset><legend>"._CMN_BATCH."</legend>\n";
        echo _TRC_BATCH_IMPORT_INFO ."<br/>\n";
        echo '<input type="hidden" name="task" value="batchimport">';
        echo "<input type='button' name='submit_btn' value='"._CMN_CONTINUE."' onClick='submit();'>\n";
        echo "</fieldset>\n";
        echo "</form>\n";
    }

    function viewBatchImportTableHeader() {
        echo "<form name='batch_import_form' class='filter'><table class='data' width='100%'>";
        echo "<tr class='head'><th> </th><th>#</th>
            <th>"._CMN_FILE_NAME."</th><th width='90%'>"._CMN_STATUS."</th>
            <th> </th></tr>\n";
    }

    function viewBatchImportTableRow($id, $bphoto) {
        echo "<tr><td><input type='checkbox' name='bfiles[]' value='${bphoto}' /></td>
            <td>${id}</td><td>$bphoto</td>
            <td><span id='status_${id}'></span></td>
            <td><span id='status_icon_${id}'></span></td></tr>\n";
    }

    function viewBatchImportTableFooter($path, $gpx_files) {
        global $cfg;
        echo "<tr><th><input type='checkbox' name='bgpx_all' value='1' onclick='checkall(this.form.bgpx_all.checked);' /></th><th></th><th colspan=3>"._CMN_SELECT_ALL."</td></tr>\n";
        echo "</table>\n";

        echo "<fieldset><legend>"._CMN_TITLE."</legend>";
        echo "<input type='radio' name='title_opt' value='iptc_title' checked />"._PHOTO_IPTC_TITLE."<br/>\n";
        echo "<input type='radio' name='title_opt' value='file_name' />"._CMN_FILE_NAME."<br/>\n";
        echo "<input type='radio' name='title_opt' value='own' />"._CMN_OTHER.": \n";
        echo "<input type='text' name='title' size=25><br/>\n";
        echo "</fieldset>";
        echo "<fieldset><legend>"._CMN_DESCRIPTION."</legend>";
        echo "<input type='radio' name='desc_opt' value='iptc_desc' checked />"._PHOTO_IPTC_DESC."<br/>\n";
        echo "<input type='radio' name='desc_opt' value='iptc_title' />"._PHOTO_IPTC_TITLE."<br/>\n";
        echo "<input type='radio' name='desc_opt' value='own' />"._CMN_OTHER.": \n";
        echo "<input type='text' name='description' size=80><br />\n";
        echo "</fieldset>\n";

        echo _CMN_GPX_ID." ("._CMN_OPTIONAL."):\n";
        echo "<select name='gpx_id' size='1' onchange='toggleGeoTaggingFields();'>\n";
        echo "<option value=0>"._CMN_NONE."</option>\n";
        foreach($gpx_files as $gpx) {
            echo "<option value=${gpx['id']}>#${gpx['id']}: ${gpx['description']} (${gpx['name']})</option>\n";
        }
        echo "</select><br />\n";

        echo "<fieldset><legend>"._CMN_GEO_TAGGING."</legend>";
        echo _CMN_GEO_TAGGING_MAN ."<br />\n";
        HTML::viewTimeZoneSelect($cfg['timezone_offset']);
        echo " (". _CMN_TIMEZONE_CAM .")<br />\n";
        echo _PHOTO_TIME_OFFSET." ("._CMN_OPTIONAL."): ";
        echo "<input type='text' name='offset' value=0 size=4> ("._PHOTO_TIME_OFFSET_MAN.")<br />\n";
        echo "</fieldset>\n";
        echo "<script type='text/javascript'>toggleGeoTaggingFields();</script>";

        echo "<input type='button' name='start' value='"._TRC_START_IMPORT."' onclick='javascript:startImport(\"".$path."\", 0, \"photo\");' /></form><br/>\n";
    }

    function viewImportProgress() {
        echo "<div><span id='dynamicContent_Wait' style='visibility:hidden'><img src='images/loader_rect_black.gif'/> "._TRC_WAIT_WHILE_IMPORTING."</span>";
        echo "<span id='dynamicContent' style='font-weight:bold;'></span>\n";
        echo "<div id='dynamicContent_Done' style='visibility:hidden'>"._TRC_IMPORT_DONE."</div>\n";
    }

    function deleteForm($url, $id) {
        echo "<form method='post' action='$url' class='filter'>\n";
        echo "<h3 style='font-weight:bold;color:red;'>"._CMN_WARNING."</h3>\n";
        echo "<p>"._MENU_PHOTO." # $id:<br />"._PHOTO_REALLY_DELETE."</p>\n";
        echo "<p>"._TRC_CONFIRM_DELETE."</p>\n";
        echo "<input type='text' name='confirm' value='"._CMN_NO."' />\n";
        echo "<input type='submit' name='submit_btn' value='"._MENU_PHOTO_DELETE."' onClick='submit();' />\n";
        echo "<input type='hidden' name='submit' value='delete' />\n";
        echo "\n";
        echo "</form>\n";
    }
}
?>
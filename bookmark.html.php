<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

include("./config.inc.php");

class HTML_bookmarks {
    function viewBookmarksTableHeader($url, $sort, $order) {
		global $cfg;
    	if(!$cfg['public_host'] || check_password($cfg['admin_password']))
    		$icon_columns = 2;
    	else
    		$icon_columns = 1;
    	
		echo "<table class='data'>";
        echo "<tr class='head'>";
        HTML::viewTabColHead($url, 1, $sort, $order, _CMN_BM_ID);
        HTML::viewTabColHead($url, 2, $sort, $order, _CMN_BM_NAME);
        HTML::viewTabColHead($url, 3, $sort, $order, _CMN_DATE);
		echo "<th colspan=$icon_columns></th></tr>\n";
	}

    function viewBookmarksTableRow($bm) {
		global $cfg;
		echo "<tr><td>$bm[id]</td>
			<td><a href='$bm[url]'>$bm[name]</a></td>
			<td>$bm[timestamp]</td>
			<td><a href='$bm[url]'><img src='images/icon_osm_32.png' title='"._TRC_SHOW_MAP."' border='0' width=16 height=16 /></a></td>";
    	if(!$cfg['public_host'] || check_password($cfg['admin_password']))
			echo "<td><a href='?task=delete&id=$bm[id]'><img src='images/b_drop.png' title='"._MENU_BOOKM_DELETE."' border='0' /></a></td>";
		echo "</tr>\n";
	}

    function viewBookmarksTableFooter() {
		echo "</table>\n";
	}
}
?>
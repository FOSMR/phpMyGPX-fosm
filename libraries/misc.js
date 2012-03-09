/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

var DEBUG = 0;

// map.php
function addBookmark() {
	bookmarkName = prompt(i18n_strings['_MAP_JS_BOOKM_NAME']);
	if(bookmarkName) {
		var bookmarkScript = "bookmark.php?task=add&name=" + 
			encodeURIComponent(bookmarkName) + "&url=";
		var bookmarkLink = String(document.getElementById('bookmarklink').value);
		document.location.href = bookmarkScript + encodeURIComponent(bookmarkLink);
	}
}

// traces.php waypoints.php
function copyDate() {
	document.getElementsByName('date_to')[0].value = 
		document.getElementsByName('date_from')[0].value;
}

// traces.php
function changeChartType(type) {
	if (type == 'dist') {
		type_old = 'time'
	}
	if (type == 'time') {
		type_old = 'dist'
	}
	var chart_count = 1;
	while(document.getElementById("chart_" + chart_count)) {
		var chart_src = document.getElementById("chart_" + chart_count).src;
		var chart_src_new = chart_src.replace(type_old, type);
		document.getElementById("chart_" + chart_count).src = chart_src_new;
		
		var chart_link = document.getElementById("chart_link_" + chart_count).href;
		var chart_link_new = chart_link.replace(type_old, type);
		document.getElementById("chart_link_" + chart_count).href = chart_link_new;
		chart_count++;
	}
}

// traces.php
function showOnMap() {
	var idcount = 0;
	var mapurl = 'map.php?';
	var filecount = document.view_gpx_form.elements['bfiles[]'].length; //'
	if (!filecount) {
		if (document.view_gpx_form.elements['bfiles[]'].checked) { //'
			idcount ++;
			mapurl += 'id=' + document.view_gpx_form.elements['bfiles[]'].value + '&'; //'
		}
	} else {
		for (i=0; i< filecount; ++i) {
			if (document.view_gpx_form.elements['bfiles[]'][i].checked) { //'
				idcount ++;
				mapurl += 'id' + idcount + '=' + document.view_gpx_form.elements['bfiles[]'][i].value + '&'; //'
			}
		}
	}
	if (idcount) {
		location.href = mapurl;
	} else {
		alert(i18n_strings['_CMN_NO_ITEM_SELECTED']);
	}
}

// waypoints.html.php
function showMapIcons() {
	document.getElementById('icon_layer').style.visibility = 'visible';
}
function selectMapIcon(path, file) {
	document.getElementById('icon_layer').style.visibility = 'hidden';
	document.getElementById('map_icon').src = path + file;
	document.getElementsByName('map_icon_url')[0].value = path + file;
}

// photos.php
function toggleGeoTaggingFields() {
	if (document.batch_import_form.elements['gpx_id'].value != 0) {
		document.batch_import_form.elements['tz'].disabled = false;
		document.batch_import_form.elements['offset'].disabled = false;
	} else {
		document.batch_import_form.elements['tz'].disabled = true;
		document.batch_import_form.elements['offset'].disabled = true;
	}
}

// html.classes.php
function changeResultLimit(limit, url) {
	location.href = url + '&l=' + limit;
}

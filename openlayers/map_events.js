/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

function mapMovedCallback() {
	/* insert event triggered code here */
	var pos = map.getCenter().clone();
	var lonlat = pos.transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	var edit_bounds = map.getExtent();
	edit_bounds.transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	
	// define dynamic form elements and update them as the map is moved
	
	// for big map on 'map.php'
	if (document.getElementById('bookmarklink')) {
		var bookmarklink = document.getElementById('bookmarklink');
		var searchGPXlink = document.getElementById('searchGPXlink');
		var searchTRKPTlink = document.getElementById('searchTRKPTlink');
		var searchWPTlink = document.getElementById('searchWPTlink');
		var josmlink = document.getElementById('josmlink');
		var osblink = document.getElementById('osblink');
		var keeprightlink = document.getElementById('keeprightlink');
		
		bookmarklink.value = "map.php?lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&zoom=" + this.getZoom();
		searchGPXlink.href = "traces.php?task=gpx&option=search&lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&lat_range=" + edit_bounds.getHeight() + "&lon_range=" + edit_bounds.getWidth();
		searchTRKPTlink.href = "traces.php?task=view&option=search&lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&lat_range=" + edit_bounds.getHeight() + "&lon_range=" + edit_bounds.getWidth();
		searchWPTlink.href = "waypoints.php?task=view&option=search&lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&lat_range=" + edit_bounds.getHeight() + "&lon_range=" + edit_bounds.getWidth();
		josmlink.href = "http://localhost:8111/load_and_zoom?left=" + edit_bounds.left + "&right=" + edit_bounds.right + "&bottom=" + edit_bounds.bottom + "&top=" + edit_bounds.top;
		osblink.href = "http://openstreetbugs.org/?lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&z=" + map.getZoom();
		keeprightlink.href = "http://keepright.ipax.at/report_map.php?lat=" + lonlat.lat + "&lon=" + lonlat.lon + "&zoom=" + map.getZoom();
	}
	
	// for small map on 'edit_config.php'
	if (document.getElementsByName('home_zoom')[0]) {
		var home_lat = document.getElementsByName('home_latitude')[0];
		home_lat.value = lonlat.lat;
		var home_lon = document.getElementsByName('home_longitude')[0];
		home_lon.value = lonlat.lon;
		var home_zoom = document.getElementsByName('home_zoom')[0];
		home_zoom.value = map.getZoom();
	}
}

function mapLeftClickCallback(evt) {
	// (hint: this.events.getMousePosition(evt) gives same result as evt.xy)
	var px = map.getLayerPxFromViewPortPx(evt.xy);
	var lonlat = map.getLonLatFromViewPortPx(evt.xy);
	var lonlat_tr = lonlat.transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	
	// for small map on 'waypoints.php'
	if (document.getElementsByName('wpt_lat')[0]) {
		// update lat and lon in form field
		var wpt_lat = document.getElementsByName('wpt_lat')[0];
		wpt_lat.value = lonlat_tr.lat;
		var wpt_lon = document.getElementsByName('wpt_lon')[0];
		wpt_lon.value = lonlat_tr.lon;
		
		// move marker to new position
		map.getLayersByName("Markers")[0].markers[0].moveTo(px);
	}
}

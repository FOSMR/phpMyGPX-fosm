/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

//complex object of type OpenLayers.Map
var map;
var photolayer;
var colorpalette = Array ('#9900ff', '#ff00ff', '#ff0099', '#ff0033', '#ff3300',
						  '#ff9900', '#ffff00', '#99ff00', '#33ff00', '#00ff33',
						  '#00ff99', '#00ffff', '#0099ff', '#0033ff', '#3300ff');

function createMap(lat, lon, zoom, 
					maxlat, maxlon, minlat, minlon, 
					controls, 
					gpxFile, hiking, marker, poi, poiminzoom, tilebuffer, proxy) {
	
	//Initialise the 'map' object
	map = new OpenLayers.Map ("map", {
		maxExtent: new OpenLayers.Bounds(-20037508.34,-20037508.34,20037508.34,20037508.34),
		maxResolution: 156543.0399,
		numZoomLevels: 19,
		units: 'm',
		projection: new OpenLayers.Projection("EPSG:900913"),
		displayProjection: new OpenLayers.Projection("EPSG:4326"),
		controls:[
			new OpenLayers.Control.Navigation(),
			new OpenLayers.Control.Attribution()
		]
	});

	// Add map controls depending on selected mode
	if (controls == 'minimal') {
		map.addControl(new OpenLayers.Control.PanZoom());
	} else {
		map.addControl(new OpenLayers.Control.PanZoomBar());
		map.addControl(new OpenLayers.Control.LayerSwitcher());
		map.addControl(new OpenLayers.Control.ScaleLine({geodesic: true}));
		
		// Initialize seperatly - we store the input value in an extra args array there
		this.permalink = new OpenLayers.Control.Permalink('permalink');
		map.addControl(this.permalink);
	}

	// Define the map layer
	// Note that we use a predefined layer that will be
	// kept up to date with URL changes
	// Here we define just one layer, but providing a choice
	// of several layers is also quite simple
	// Other defined layers are OpenLayers.Layer.OSM.Mapnik, OpenLayers.Layer.OSM.Maplint and OpenLayers.Layer.OSM.CycleMap
	
	layerFOSM = new OpenLayers.Layer.OSM.FOSM("FOSM", {buffer:tilebuffer});
	map.addLayer(layerFOSM);
	
	layerMapnik = new OpenLayers.Layer.OSM.Mapnik("Mapnik", {buffer:tilebuffer});
	map.addLayer(layerMapnik);
	
	if (hiking) {
		layerMapnikBW = new OpenLayers.Layer.OSM.MapnikBW("Mapnik b/w", {buffer:tilebuffer});
		map.addLayer(layerMapnikBW);
	}
	
	layerTilesAtHome = new OpenLayers.Layer.OSM.Osmarender("Osmarender", {buffer:tilebuffer});
	map.addLayer(layerTilesAtHome);
	
	layerCycleMap = new OpenLayers.Layer.OSM.CycleMap("CycleMap", {buffer:tilebuffer});
	map.addLayer(layerCycleMap);
	
	layerMapQuest = new OpenLayers.Layer.OSM.MapQuest("MapQuest OSM", {buffer:tilebuffer});
	map.addLayer(layerMapQuest);
	
	layerMapQuestAerial = new OpenLayers.Layer.OSM.MapQuestAerial("MapQuest Aerial", {buffer:tilebuffer});
	map.addLayer(layerMapQuestAerial);
	
	if (hiking) {
		layerHiking = new OpenLayers.Layer.OSM.Hiking("Hiking Paths", {buffer:tilebuffer, visibility:false});
		map.addLayer(layerHiking);
	}
	
	if (hiking) {
		layerHikeBike = new OpenLayers.Layer.OSM.HikeBike("Hike & Bike Map", {buffer:tilebuffer});
		map.addLayer(layerHikeBike);
		
		layerHillshading = new OpenLayers.Layer.OSM.Hillshading("Hillshading (NASA SRTM3 v2)", {buffer:tilebuffer});
		map.addLayer(layerHillshading);
		
		//layerLit = new OpenLayers.Layer.OSM.Lit("By Night (lit=yes/no)");
		//map.addLayer(layerLit);
	}
	
	if (proxy) {
		layerMapnikLocalProxy = new OpenLayers.Layer.OSM.MapnikLocalProxy("Mapnik (local proxy)", {buffer:tilebuffer});
		map.addLayer(layerMapnikLocalProxy);
		
		layerTilesAtHomeLocalProxy = new OpenLayers.Layer.OSM.OsmarenderLocalProxy("Osmarender (local proxy)", {buffer:tilebuffer});
		map.addLayer(layerTilesAtHomeLocalProxy);
		
		layerFOSMLocalProxy = new OpenLayers.Layer.OSM.FOSMLocalProxy("FOSM (local proxy)", {buffer:tilebuffer});
		map.addLayer(layerFOSMLocalProxy);
		
		// use proxy for base layer
		//map.setBaseLayer(layerMapnikLocalProxy);
		map.setBaseLayer(layerFOSMLocalProxy);
		
		if (hiking) {
			layerHikeBikeLocalProxy = new OpenLayers.Layer.OSM.HikeBikeLocalProxy("Hike & Bike (local proxy)", {buffer:tilebuffer});
			map.addLayer(layerHikeBikeLocalProxy);
		}
	}
		
	if (marker) {
		layerMarkers = new OpenLayers.Layer.Markers("Markers");
		map.addLayer(layerMarkers);
	}
		
	if (gpxFile) {
		// Add the Layer with GPX Track
		/*
		var lgpx = new OpenLayers.Layer.GML("GPX-Track", "./files/" + gpxFile , {
		    format: OpenLayers.Format.GPX,
		    style: {strokeColor: "#6600ff", strokeWidth: 5, strokeOpacity: 0.5},
		    projection: new OpenLayers.Projection("EPSG:4326")
		});
		*/
		if (typeof(gpxFile)=='object' && (gpxFile instanceof Array) && gpxFile.length>0) {
			for (var i=0; i<gpxFile.length; i++) {
				var gpxID = gpxFile[i].match(/id=(\d+)/);
				var lgpx = new OpenLayers.Layer.GPX("GPX-Track (#" + gpxID[1] + ")", 
							gpxFile[i] , colorpalette[i%colorpalette.length]);
				map.addLayer(lgpx);
			}
		}
		else {
			var gpxID = gpxFile.match(/id=(\d+)/);
			var lgpx = new OpenLayers.Layer.GPX("GPX-Track (#" + gpxID[1] + ")", 
						gpxFile , colorpalette[0]);
			map.addLayer(lgpx);
		}
	}
	
	if (poi) {
		// add the layer for POIs and photos
		/*
		var pois = new OpenLayers.Layer.Text("POIs/Photos",
			{ location:"./pois.php",
			  projection: map.displayProjection
			});
		map.addLayer(pois);
		*/
		// Add overlay layer for photos
		photolayer = new PhotoLayer('pois.php', map, {minzoom:poiminzoom});
	}
	
	if (maxlat && maxlon && minlat && minlon) {
	
		bounds = new OpenLayers.Bounds();
		bounds.extend(new OpenLayers.LonLat(minlon, minlat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()));
		bounds.extend(new OpenLayers.LonLat(maxlon, maxlat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()));
		map.zoomToExtent(bounds);
	}
	else {
		// Set center to home location from config file
		var center = new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());
		
		if (!map.getCenter()) {
			map.setCenter(center, zoom);
		}
	}
	
	if (marker) {
		var size = new OpenLayers.Size(21,25);
		var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
		var icon = new OpenLayers.Icon('./openlayers/img/marker.png',size,offset);
		layerMarkers.addMarker(new OpenLayers.Marker(map.getCenter(), icon));
	}
	
	// show all available browser events
	//alert (map.events.BROWSER_EVENTS);
	
	// register click event within map for editing locations
	map.events.register("click", map, mapLeftClickCallback);
	
	// register event that records new lon/lat coordinates in form fields after panning
	map.events.register("moveend", map, mapMovedCallback);
	
	// call event handler as if one had moved the map
	map.events.triggerEvent("moveend");
}


function plusfacteur (a) {
        return a * (20037508.34 / 180);
}
function moinsfacteur (a) {
        return a / (20037508.34 / 180);
}
function y2lat (a) {
        return 180/Math.PI * (2 * Math.atan(Math.exp(moinsfacteur(a)*Math.PI/180)) - Math.PI/2);
}
function lat2y (a) {
        return plusfacteur(180/Math.PI * Math.log(Math.tan(Math.PI/4+a*(Math.PI/180)/2)));
}
function x2lon (a) {
        return moinsfacteur(a);
}
function lon2x (a) {
        return plusfacteur(a);
}
function lonLatToMercator (ll) {
        return new OpenLayers.LonLat (lon2x (ll.lon), lat2y (ll.lat));
}

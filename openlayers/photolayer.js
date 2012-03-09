/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) Florian Lohoff
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

PhotoLayer = new OpenLayers.Class({

	url: null,
	layer: null,
	parser: null,
	request: null,
	clicked: null,
	current: null,
	minzoom: 14,

	initialize: function(url, map, options) {
		this.url = url;
		this.map = map;

		OpenLayers.Util.extend(this, options);

		this.parser = new OpenLayers.Format.JSON();
		this.layer = new OpenLayers.Layer.Markers("Photos");

		this.layer.events.register("visibilitychanged", this, this.refresh);
		this.layer.events.register("moveend", this, this.refresh);

		this.map.addLayer(this.layer);

		this.photos = new PhotoLayer.Photos(map, this.layer);
	},

	onSuccess: function(result) {

		if (result.responseText.search(/^error/) != -1) {
			OpenLayers.Console.error("Data returned by server contains error: " + result.responseText);
			this.onFailure(result);
			return;
		}

		this.layer.clearMarkers();

		var photos = this.parser.read(result.responseText);

		if (photos && photos[0]) {
			for (var i = 0; i < photos.length; i++) {
				this.photos.addphoto(photos[i].lon, photos[i].lat, photos[i].photoid, photos[i].time, photos[i].width, photos[i].height);
			}
		}

		document.getElementById('spinning').style.display="none";

		this.request = null;
	},

	onFailure: function(result) {
		OpenLayers.Console.error("Failed to fetch image data: " + result);
		document.getElementById('spinning').style.display="none";
	},

	refresh: function(params) {
		var zoom = this.map.getZoom ();
		var visible = this.layer.getVisibility();

		if (this.request) {
			/* If request is running abort it */
			this.request.transport.abort();
		}

		if (zoom < this.minzoom || !visible) {
			this.layer.clearMarkers();
			return;
		}

		document.getElementById('spinning').style.display="block";

		var bounds = this.map.getExtent().toArray();

		this.request = new OpenLayers.Ajax.Request(this.url, {
			method: "get",
			parameters: {
				'b': y2lat(bounds[1]),
				't': y2lat(bounds[3]),
				'l': x2lon(bounds[0]),
				'r': x2lon(bounds[2]),
				'task': 'getPhotos',
				'zoom': zoom,
				'data': this.data
			},
		onSuccess: OpenLayers.Function.bind(this.onSuccess, this),
		onFailure: OpenLayers.Function.bind(this.onFailure, this)
		});
	}
});

PhotoLayer.Photos = new OpenLayers.Class({
	photolayer: null,
	lonlat: null,
	icon: null,
	feature: null,
	popup: null,

	layer: null,
	map: null,

	width: null,
	height: null,

	initialize: function(map, layer) {
		this.map=map;
		this.layer=layer;

		var size = new OpenLayers.Size(24,24);
		var offset = new OpenLayers.Pixel(-(size.w/2), -(size.h/2));
		this.icon = new OpenLayers.Icon ('images/camera1.png', size, offset);

	},

	addphoto: function(lon, lat, id, time, width, height) {
		var lonlat = new OpenLayers.LonLat(lon, lat);

		var feature = new OpenLayers.Feature(this.layer, lonlat, {icon: this.icon.clone() });
		feature.closeBox = false;
		feature.photoid = id;
		feature.width = width;
		feature.height = height;
		feature.popupClass = OpenLayers.Class(OpenLayers.Popup.FramedCloud);
		feature.data.popupContentHTML = '<img src="getphoto.php?x=0&id=' + id + '" />' +
			'<br>' + time;
		feature.photos = this;

		var marker = feature.createMarker();
		marker.events.register("mouseover", feature, this.mouseover);
		marker.events.register("mousedown", feature, this.mouseclick);
		marker.events.register("mouseout", feature, this.mouseout);
		this.layer.addMarker(marker);
	},

	showpopup: function(photos, feature) {
		if (photos.current != null)
			photos.current.hide();
		if (feature.popup == null) {
			feature.popup = feature.createPopup();
			photos.map.addPopup(feature.popup);
		} else {
			feature.popup.toggle ();
		}
		photos.current = feature.popup;
	},

	mouseout: function(evt) {
		if (this.photos.current)
			this.photos.current.hide();
		OpenLayers.Event.stop(evt);
	},

	mouseover: function(evt) {
		this.photos.showpopup(this.photos, this);
		OpenLayers.Event.stop(evt);
	},

	mouseclick: function(evt) {
		window.open ("photos.php?task=details&id=" + this.photoid + "&width=" + this.width + "&height=" + this.height); 
		OpenLayers.Event.stop(evt);
	}
});

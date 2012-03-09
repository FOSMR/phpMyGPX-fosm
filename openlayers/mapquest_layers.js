/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2011 Sebastian Klemm
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.MapQuest
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.MapQuest = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://otile1.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
			"http://otile2.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
			"http://otile3.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png",
			"http://otile4.mqcdn.com/tiles/1.0.0/osm/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 18,
			isBaseLayer: true,
			attribution: "Tiles Courtesy of <a href='http://www.mapquest.com/' target='_blank'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.MapQuest"
});

/**
 * Class: OpenLayers.Layer.OSM.MapQuestAerial
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.MapQuestAerial = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://oatile1.mqcdn.com/naip/${z}/${x}/${y}.png",
			"http://oatile2.mqcdn.com/naip/${z}/${x}/${y}.png",
			"http://oatile3.mqcdn.com/naip/${z}/${x}/${y}.png",
			"http://oatile4.mqcdn.com/naip/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 12,
			isBaseLayer: true,
			attribution: "Tiles Courtesy of <a href='http://www.mapquest.com/' target='_blank'>MapQuest</a> <img src='http://developer.mapquest.com/content/osm/mq_logo.png'>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.MapQuestAerial"
});

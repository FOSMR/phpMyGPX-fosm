/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.HikeBike
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.HikeBike = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://toolserver.org/tiles/hikebike/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 18,
			isBaseLayer: true,
			attribution: "Map data by <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> (<a href='http://creativecommons.org/licenses/by-sa/2.0/'>CC-by-SA</a>); Rendering by <a href='http://hikebikemap.de'>Hike & Bike Map</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},
	
	CLASS_NAME: "OpenLayers.Layer.OSM.HikeBike"
});

/**
 * Class: OpenLayers.Layer.OSM.Hillshading
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.Hillshading = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://toolserver.org/~cmarqu/hill/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 17,
			isBaseLayer: false,
			visibility: false,
			attribution: "Hillshading by <a href='http://hikebikemap.de'>Hike & Bike Map</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},
	
	CLASS_NAME: "OpenLayers.Layer.OSM.Hillshading"
});

/**
 * Class: OpenLayers.Layer.OSM.Lit
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.Lit = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://toolserver.org/tiles/lighting/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 16,
			isBaseLayer: false,
			visibility: false,
			opacity: 0.75,
			attribution: "Night view by <a href='http://hikebikemap.de'>Hike & Bike Map</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},
	
	CLASS_NAME: "OpenLayers.Layer.OSM.Lit"
});

/**
 * Class: OpenLayers.Layer.OSM.MapnikBW
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.MapnikBW = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://toolserver.org/tiles/bw-mapnik/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 19,
			isBaseLayer: true,
			attribution: "Map data by <a href='http://www.openstreetmap.org/'>OpenStreetMap</a> (<a href='http://creativecommons.org/licenses/by-sa/2.0/'>CC-by-SA</a>); Rendering by <a href='http://toolserver.org/'>Toolserver</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},
	
	CLASS_NAME: "OpenLayers.Layer.OSM.MapnikBW"
});

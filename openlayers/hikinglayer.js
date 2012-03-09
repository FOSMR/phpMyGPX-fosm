/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) Sarah Hoffmann
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.Hiking
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.Hiking = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://tile.lonvia.de/hiking/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 17,
			isBaseLayer: false,
			transitionEffect: "null",
			opacity: 0.7,
			attribution: "<a href='http://hiking.lonvia.de/en/help/about'>About hiking paths</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.Hiking"
});

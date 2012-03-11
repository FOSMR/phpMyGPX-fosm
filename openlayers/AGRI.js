/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2012 Tim Challis
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.FOSM
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.AGRI = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://agri.openstreetmap.org/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 18,
			isBaseLayer: true,
			attribution: "Data CCA-2.5Au by <a href='http://agri.openstreetmap.org/' target='_blank'>Australian Geographic Reference Image</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.AGRI"
});

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
OpenLayers.Layer.OSM.FOSM = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
			"http://map.4x4falcon.com/default/${z}/${x}/${y}.png"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 18,
			isBaseLayer: true,
			attribution: "Data CC-By-SA by <a href='http://fosm.org/' target='_blank'>fosm.org</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.FOSM"
});

/**
 * Class: OpenLayers.Layer.OSM.FOSMLocalProxy
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.FOSMLocalProxy = OpenLayers.Class(OpenLayers.Layer.OSM, {
    /**
     * Constructor: OpenLayers.Layer.OSM.FOSM
     *
     * Parameters:
     * name - {String}
     * options - {Object} Hashtable of extra options to tag onto the layer
     */
    initialize: function(name, options) {
        var url = [
            "proxysimple.php?z=${z}&x=${x}&y=${y}&r=FOSM"
        ];
        options = OpenLayers.Util.extend({ numZoomLevels: 19,
 		attribution: "Data CC-By-SA by <a href='http://fosm.org/' target='_blank'>fosm.org</a>"},
		options);
        var newArguments = [name, url, options];
        OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
    },

    CLASS_NAME: "OpenLayers.Layer.OSM.FOSMLocalProxy"
});

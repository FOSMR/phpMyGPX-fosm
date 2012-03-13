/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2011 Sebastian Klemm
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.NearMap
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.NearMap = OpenLayers.Class(OpenLayers.Layer.OSM, {
	initialize: function(name, options) {
		var url = [
		    "https://web0.nearmap.com/maps/nml=Vert&z=${z}&x=${x}&y=${y}&hl=en",
		    "https://web1.nearmap.com/maps/nml=Vert&z=${z}&x=${x}&y=${y}&hl=en",
		    "https://web2.nearmap.com/maps/nml=Vert&z=${z}&x=${x}&y=${y}&hl=en",
		    "https://web3.nearmap.com/maps/nml=Vert&z=${z}&x=${x}&y=${y}&hl=en"
		];
		options = OpenLayers.Util.extend({ numZoomLevels: 18,
			isBaseLayer: true,
			attribution: "Data CC-By-SA by <a href='http://nearmap.com/' target='_blank'>NearMap</a>"},
			options);
		var newArguments = [name, url, options];
		OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
	},

	CLASS_NAME: "OpenLayers.Layer.OSM.NearMap"
});

/**
 * Class: OpenLayers.Layer.OSM.NearMapLocalProxy
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.NearMapLocalProxy = OpenLayers.Class(OpenLayers.Layer.OSM, {
    /**
     * Constructor: OpenLayers.Layer.OSM.NearMap
     *
     * Parameters:
     * name - {String}
     * options - {Object} Hashtable of extra options to tag onto the layer
     */
    initialize: function(name, options) {
        var url = [
            "proxysimple.php?z=${z}&x=${x}&y=${y}&r=NearMap"
        ];
        options = OpenLayers.Util.extend({ numZoomLevels: 19,
 		attribution: "Data CC-By-SA by <a href='http://nearmap.com/' target='_blank'>NearMap</a>"},
		options);
        var newArguments = [name, url, options];
        OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
    },

    CLASS_NAME: "OpenLayers.Layer.OSM.NearMapLocalProxy"
});

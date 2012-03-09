/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
 * Class: OpenLayers.Layer.OSM.MapnikLocalProxy
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.MapnikLocalProxy = OpenLayers.Class(OpenLayers.Layer.OSM, {
    /**
     * Constructor: OpenLayers.Layer.OSM.Mapnik
     *
     * Parameters:
     * name - {String}
     * options - {Object} Hashtable of extra options to tag onto the layer
     */
    initialize: function(name, options) {
        var url = [
            "proxysimple.php?z=${z}&x=${x}&y=${y}&r=mapnik"
        ];
        options = OpenLayers.Util.extend({ numZoomLevels: 19 }, options);
        var newArguments = [name, url, options];
        OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
    },

    CLASS_NAME: "OpenLayers.Layer.OSM.MapnikLocalProxy"
});

/**
 * Class: OpenLayers.Layer.OSM.OsmarenderLocalProxy
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.OsmarenderLocalProxy = OpenLayers.Class(OpenLayers.Layer.OSM, {
    /**
     * Constructor: OpenLayers.Layer.OSM.OsmarenderLocalProxy
     *
     * Parameters:
     * name - {String}
     * options - {Object} Hashtable of extra options to tag onto the layer
     */
    initialize: function(name, options) {
        var url = [
            "proxysimple.php?z=${z}&x=${x}&y=${y}&r=osma"
        ];
        options = OpenLayers.Util.extend({ numZoomLevels: 18 }, options);
        var newArguments = [name, url, options];
        OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
    },

    CLASS_NAME: "OpenLayers.Layer.OSM.OsmarenderLocalProxy"
});

/**
 * Class: OpenLayers.Layer.OSM.HikeBikeLocalProxy
 *
 * Inherits from:
 *  - <OpenLayers.Layer.OSM>
 */
OpenLayers.Layer.OSM.HikeBikeLocalProxy = OpenLayers.Class(OpenLayers.Layer.OSM, {
    /**
     * Constructor: OpenLayers.Layer.OSM.HikeBikeLocalProxy
     *
     * Parameters:
     * name - {String}
     * options - {Object} Hashtable of extra options to tag onto the layer
     */
    initialize: function(name, options) {
        var url = [
            "proxysimple.php?z=${z}&x=${x}&y=${y}&r=hikebike"
        ];
        options = OpenLayers.Util.extend({ numZoomLevels: 18 }, options);
        var newArguments = [name, url, options];
        OpenLayers.Layer.OSM.prototype.initialize.apply(this, newArguments);
    },

    CLASS_NAME: "OpenLayers.Layer.OSM.HikeBikeLocalProxy"
});

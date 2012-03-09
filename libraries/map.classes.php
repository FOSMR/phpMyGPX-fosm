<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

class SlippyMap {
	private $width = 0;
	private $height = 0;
	private $lat = 0;
	private $lon = 0;
	private $zoom = 0;
	private $bbox = array('t'=>0, 'r'=>0, 'b'=>0, 'l'=>0);
	private $controls = 'normal';
	private $buffer = 1;
	private $proxy = 0;
	private $photominzoom = 14;
	private $gpx = null;
	private $baselayers = null;	// mapnik, osma, cycle
	private $overlays = null;	// gpx, markers, photos, hiking
	
	public function SlippyMap() {
		global $cfg;
		$this->width = intval($cfg['page_width']);
		$this->height = intval($cfg['map_height']);
		$this->lat = floatval($cfg['home_latitude']);
		$this->lon = floatval($cfg['home_longitude']);
		$this->zoom = intval($cfg['home_zoom']);
		if(isset($cfg['map_tile_buffer']))
			$this->buffer = intval($cfg['map_tile_buffer']);
		if(isset($cfg['photo_min_zoom']))
			$this->photominzoom = intval($cfg['photo_min_zoom']);
	}
	
	public function setMapSize($w, $h) {
		$this->width = intval($w);
		$this->height = intval($h);
	}
	
	public function setMapCenter($lat, $lon, $z) {
		$this->lat = floatval($lat);
		$this->lon = floatval($lon);
		$this->zoom = intval($z);
	}
	
	public function setBoundingBox($t, $r, $b, $l) {
		$this->bbox['t'] = floatval($t);
		$this->bbox['r'] = floatval($r);
		$this->bbox['b'] = floatval($b);
		$this->bbox['l'] = floatval($l);
	}
	
	public function enableBaseLayers($bl) {
		if(is_array($bl)) {
			foreach($bl as $layer) {
				$this->baselayers[] = $layer;
			}
		}else
			$this->baselayers[] = $bl;
	}
	
	public function enableOverlays($ol) {
		if(is_array($ol)) {
			foreach($ol as $layer) {
				$this->overlays[] = $layer;
			}
		}else
			$this->overlays[] = $ol;
	}
	
	public function enableFeatures($ft) {
		if(0 && is_array($ft)) {
			foreach($ft as $feature) {
				$this->_setFeatureState(key($feature), $feature[key($feature)]);
			}
		}else
			$this->_setFeatureState(key($ft), $ft[key($ft)]);
	}
	
	private function _setFeatureState($name, $state) {
		switch($name) {
			case 'controls':
				$this->controls = strip_tags($state);
				break;
			case 'buffer':
				$this->buffer = (int) $state;
				break;
			case 'proxy':
				$this->proxy = (bool) $state;
				break;
			case 'gpx':
				$this->gpx = $state;
				break;
		}
	}
	
	private function _isSelectedOverlay($name) {
		if($this->overlays) {
			foreach($this->overlays as $ol) {
				if($ol->getName() == $name) {
					if($ol->isSelected())
						return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	
	
	public function embed() {
		$this->embedJSincludes();
		$this->embedMapcontainer();
		$this->embedJSinitMap();
	}
	
	public function embedJSincludes() {
		global $cfg;
		
		if($cfg['use_local_libs']) {
			echo '<script src="'._PATH.'openlayers/OpenLayers.js"></script>'."\n";
			echo '<script src="'._PATH.'openlayers/OpenStreetMap.js"></script>'."\n";
		}else {
			echo '<script src="http://www.openlayers.org/api/OpenLayers.js"></script>'."\n";
			echo '<script src="http://www.openstreetmap.org/openlayers/OpenStreetMap.js"></script>'."\n";
		}
		
		if($this->proxy)
			echo '<script src="'._PATH.'openlayers/OSM_LocalTileProxy.js"></script>'."\n";
		if($this->gpx)
			echo '<script src="'._PATH.'openlayers/GPX.js"></script>'."\n";
		if($this->_isSelectedOverlay('photos'))
			echo '<script src="'._PATH.'openlayers/photolayer.js"></script>'."\n";
		if($this->_isSelectedOverlay('hiking')) {
			echo '<script src="'._PATH.'openlayers/hikinglayer.js"></script>'."\n";
			echo '<script src="'._PATH.'openlayers/hikebikelayer.js"></script>'."\n";
		}
		echo '<script src="'._PATH.'openlayers/mapquest_layers.js"></script>'."\n";
		echo '<script src="'._PATH.'openlayers/map_events.js"></script>'."\n";
		echo '<script src="'._PATH.'openlayers/map.js"></script>'."\n";
	}
	
	public function embedMapcontainer() {
		echo "<!-- define a DIV into which the map will appear -->\n";
		echo '<div id="mapcontainer">'."\n";
		echo '<div style="width:'.$this->width.'px; height:'.$this->height.'px;" id="map"><div id="spinning"></div></div>'."\n";
		echo "</div>\n";
	}
	
	public function embedJSinitMap() {
		echo '<script type="text/javascript">'."\n";
		// create Array for GPX files
		if (is_array($this->gpx)) {
			$gpx = "Array(";
			for ($i=0; $i<count($this->gpx);$i++) {
				$gpx .= "'". strip_tags($this->gpx[$i]) ."'";
				if ($i < count($this->gpx)-1)
					$gpx .= ",";
			}
			$gpx .= ")";
		}
		else {
			$gpx = "'". strip_tags($this->gpx) ."'";
		}
		echo "createMap(
				$this->lat , $this->lon , $this->zoom ,
				".$this->bbox['t']." , ".$this->bbox['r']." , 
				".$this->bbox['b']." , ".$this->bbox['l']." , 
				'".strip_tags($this->controls)."' ,
				$gpx ,
				".intval($this->_isSelectedOverlay('hiking'))." ,
				".intval($this->_isSelectedOverlay('marker'))." ,
				".intval($this->_isSelectedOverlay('photos'))." ,
				".intval($this->photominzoom)." ,
				".intval($this->buffer)." ,
				".intval($this->proxy)." );\n";
		echo "</script>\n";
	}
}

class Layer {
	private $name = null;
	private $enabled = FALSE;
	private $selected = FALSE;
	
	public function Layer($n, $select) {
		$this->name = $n;
		$this->enabled = TRUE;
		if($select)
			$this->selected = TRUE;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function isSelected() {
		return $this->selected;
	}
}

class Overlay extends Layer {
}
?>
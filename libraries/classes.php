<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009, 2010 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

class Track {
	var $id = 0;    
    var $name = NULL;
    var $cmt = null;
    var $desc = null;

    function getId() {
        return $this->id;
    }
    function getName() {
        return $this->name;
    }
    function getCmt() {
        return $this->cmt;
    }
    function getDesc() {
        return $this->desc;
    }

    function setId($val) {
        $this->id = $val;
    }
    function setName($val) {
        $this->name = $val;
    }
    function setCmt($val) {
        $this->cmt = $val;
    }
    function setDesc($val) {
        $this->desc = $val;
    }
}

class TrackList {
	var $length = 0;
	var $tracks = NULL;
	
	function TrackList() {
		$this->tracks = array();
	}
	function add($trk) {
		$this->tracks[] = $trk;
		$this->length++;
	}
	function item($i) {
		if($i < sizeof($this->tracks))
			return $this->tracks[$i];
		else
			return 0;
	}
}

class TrackSegment {
	var $id = 0;    

    function getId() {
        return $this->id;
    }

    function setId($val) {
        $this->id = $val;
    }
}

class TrackSegmentList {
	var $length = 0;
	var $tracksegments = NULL;
	
	function TrackSegmentList() {
		$this->tracksegments = array();
	}
	function add($trksegm) {
		$this->tracksegments[] = $trksegm;
		$this->length++;
	}
	function item($i) {
		if($i < sizeof($this->tracksegments))
			return $this->tracksegments[$i];
		else
			return 0;
	}
}

class TrackPoint {
	var $id = 0;    
    var $lat = null;
    var $lon = null;
    var $time = null;
    var $ele = null;
    var $fix = null;
    var $sat = null;
    var $hdop = null;
    var $pdop = null;
    var $course = null;
    var $speed = null;

    function getId() {
        return $this->id;
    }
    function getLat() {
        return $this->lat;
    }
    function getLon() {
        return $this->lon;
    }
    function getTime() {
        return $this->time;
    }
    function getEle() {
        return $this->ele;
    }
    function getFix() {
        return $this->fix;
    }
    function getSat() {
        return $this->sat;
    }
    function getHDOP() {
        return $this->hdop;
    }
    function getPDOP() {
        return $this->pdop;
    }
    function getCourse() {
        return $this->course;
    }
    function getSpeed() {
        return $this->speed;
    }


    function setId($val) {
        $this->id = $val;
    }
    function setLat($val) {
        $this->lat = $val;
    }
    function setLon($val) {
        $this->lon = $val;
    }
    function setTime($val) {
        $this->time = $val;
    }
    function setEle($val) {
        $this->ele = $val;
    }
    function setFix($val) {
        $this->fix = $val;
    }
    function setSat($val) {
        $this->sat = $val;
    }
    function setHDOP($val) {
        $this->hdop = $val;
    }
    function setPDOP($val) {
        $this->pdop = $val;
    }
    function setCourse($val) {
        $this->course = $val;
    }
    function setSpeed($val) {
        $this->speed = $val;
    }
	
    function setIntPos($lat, $lon) {
        $this->lat = round($lat * 1000000);
        $this->lon = round($lon * 1000000);
    }
    function posToInt() {
        $this->lat = round($this->lat * 1000000);
        $this->lon = round($this->lon * 1000000);
    }
    
	function insert($gpx_id) {
		global $cfg;
        if($this->lat && $this->lon) {
	        $query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}gpx_import` SET 
	        	`altitude` = '$this->ele', 
	        	`latitude` = '$this->lat', 
	        	`longitude` = '$this->lon',
	        	`gpx_id` = '$gpx_id',
	        	`timestamp` = '$this->time',
	        	`fix` = '$this->fix',
	        	`sat` = '$this->sat',
	        	`hdop` = '$this->hdop',
	        	`pdop` = '$this->pdop',
	        	`course` = '$this->course',
	        	`speed` = '$this->speed' ;";
	        $result = db_query($query);
	        // no primary key available!
	        $affr = mysql_affected_rows();
        	return $affr;
        } else
        	return FALSE;
	}
}

class TrackPointList {
	var $length = 0;
	var $trackpoints = NULL;
	
	function TrackPointList() {
		$this->trackpoints = array();
	}
	function add($trkpt) {
		$this->trackpoints[] = $trkpt;
		$this->length++;
	}
	function item($i) {
		if($i < sizeof($this->trackpoints))
			return $this->trackpoints[$i];
		else
			return 0;
	}
}

class WayPoint {
	var $id = 0;    
    var $lat = null;
    var $lon = null;
    var $ele = null;
    var $time = null;
    var $name = null;
    var $cmt = null;
    var $desc = null;
    var $fix = null;
    var $sat = null;
    var $hdop = null;
    var $pdop = null;
    var $gpx_id = null;

    function getId() {
        return $this->id;
    }
    function getLat() {
        return $this->lat;
    }
    function getLon() {
        return $this->lon;
    }
    function getEle() {
        return $this->ele;
    }
    function getTime() {
        return $this->time;
    }
    function getName() {
        return $this->name;
    }
    function getCmt() {
        return $this->cmt;
    }
    function getDesc() {
        return $this->desc;
    }
    function getFix() {
        return $this->fix;
    }
    function getSat() {
        return $this->sat;
    }
    function getHDOP() {
        return $this->hdop;
    }
    function getPDOP() {
        return $this->pdop;
    }
    function getGpxId() {
        return $this->gpx_id;
    }


    function setId($val) {
        $this->id = $val;
    }
    function setLat($val) {
        $this->lat = $val;
    }
    function setLon($val) {
        $this->lon = $val;
    }
    function setEle($val) {
        $this->ele = $val;
    }
    function setTime($val) {
        $this->time = $val;
    }
    function setName($val) {
        $this->name = $val;
    }
    function setCmt($val) {
        $this->cmt = $val;
    }
    function setDesc($val) {
        $this->desc = $val;
    }
    function setFix($val) {
        $this->fix = $val;
    }
    function setSat($val) {
        $this->sat = $val;
    }
    function setHDOP($val) {
        $this->hdop = $val;
    }
    function setPDOP($val) {
        $this->pdop = $val;
    }
    function setGpxId($val) {
        $this->gpx_id = $val;
    }
	
    function posToInt() {
        $this->lat = round($this->lat * 1000000);
        $this->lon = round($this->lon * 1000000);
    }
    
	function insert($gpx_id) {
		global $cfg;
        if($this->lat && $this->lon) {
	        $query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}waypoints` SET 
	        	`altitude` = '$this->ele', 
	        	`latitude` = '$this->lat', 
	        	`longitude` = '$this->lon',
	        	`gpx_id` = '$gpx_id',
	        	`timestamp` = '$this->time',
	        	`name` = '$this->name',
	        	`cmt` = '$this->cmt',
	        	`desc` = '$this->desc' ;";
	        $result = db_query($query);
	        $liid = mysql_insert_id();
	        return $liid;
        } else
        	return FALSE;
	}
}

class WayPointList {
	var $length = 0;
	var $waypoints = NULL;
	
	function WayPointList() {
		$this->waypoints = array();
	}
	function add($wpt) {
		$this->waypoints[] = $wpt;
		$this->length++;
	}
	function item($i) {
		if($i < sizeof($this->waypoints))
		#if($i < $this->length)
			return $this->waypoints[$i];
		else
			return 0;
	}
}

class GpxDocument extends DomDocument{
    var $number_wpts = NULL;
    var $number_trkpts = NULL;
    var $number_trksegs = NULL;
    var $number_trks = NULL;

	function validateGPX() {
		global $DEBUG;
		$errep = error_reporting();
		if($DEBUG)
			error_reporting(255);
		else
			error_reporting(0);
		$valid_10 = $this->schemaValidate('./libraries/gpx_10.xsd');
		if($DEBUG && $valid_10)
			out("valid GPX 1.0", 'OUT_DEBUG');
		$valid_11 = $this->schemaValidate('./libraries/gpx_11.xsd');
		if($DEBUG && $valid_11)
			out("valid GPX 1.1", 'OUT_DEBUG');
		error_reporting($errep);
		return ($valid_10 || $valid_11);
	}
	
	function importGPX($description, $timezone, $option) {
		global $DEBUG, $cfg;
		set_time_limit($cfg['import_time_limit']);
		$status = array();
		$status['error'] = -1; 
		
		// insert gpx into database
	    $query = "INSERT IGNORE INTO `${cfg['db_table_prefix']}gpx_files` SET 
	    	`name` = '".basename(urldecode($this->documentURI))."', 
	    	`size` = '".filesize(urldecode($this->documentURI))."',
	    	`latitude` = '0', 
	    	`longitude` = '0',
	    	`timestamp` = NOW(),
	    	`timezone` = '$timezone',
	    	`public` = '1',
	    	`description` = '$description',
	    	`inserted` = '0' ;";
	    $result = db_query($query);
	    $gpx_id = mysql_insert_id();
	    
	    if(!$gpx_id) {
	    	$status['msg'] = _TRC_DUPLICATE_FILENAME;
	    	return $status;
	    }
	    
		// parse gpx file and import trackpoints
		$trkptList = $this->getTrackpoints(0,0);
		
		// insert trackpoints into database
		foreach ($trkptList->trackpoints as $trkpt) {
			// check for timestamps
			if($trkpt->getTime()) {
				$trkpt->posToInt();
				$affr = $trkpt->insert($gpx_id);
				if(!$affr) {
					$status['msg'] = _TRC_NO_UNIQUE_TIMESTAMP;
					break;
				}
			}else {
				$status['msg'] = _TRC_MISS_TIMESTAMP;
				break;
			}
		}
		
		// check number of inserted trackpoints
		$query = "SELECT COUNT(*) 
				FROM `${cfg['db_table_prefix']}gpx_import` 
	        	WHERE `gpx_id` = '$gpx_id'; ";
		$result = db_query($query);
		$num_trkpt = mysql_result($result, 0);
		
		// parse gpx file and import waypoints
		$wptList = $this->getWaypoints(0,0);
		
		// insert waypoints into database
		foreach ($wptList->waypoints as $wpt) {
			$wpt->posToInt();
			$liid = $wpt->insert($gpx_id);
		}
		
		// check number of inserted waypoints
		$query = "SELECT COUNT(*) 
				FROM `${cfg['db_table_prefix']}waypoints` 
	        	WHERE `gpx_id` = '$gpx_id'; ";
		$result = db_query($query);
		$num_wpt = mysql_result($result, 0);
		
		// prepare status message
		if(!$num_trkpt && !$num_wpt) {
			// delete already inserted gpx file from database
	        $query = "DELETE IGNORE 
	        	FROM `${cfg['db_table_prefix']}gpx_files` 
	        	WHERE `id` = '$gpx_id' ;";
	        $result = db_query($query);
	        
	        if(!$status['msg'])
	        	$status['msg'] = "0 ". _DB_TRKPTS_AVAILABLE;
	    }else {
			$status['error'] = 0;
			$status['msg'] = "$num_trkpt "._TRC_TRKPTS_PROCESSED.
				" $num_wpt "._TRC_WPTS_PROCESSED;
	    }
	    
	    $status['lid'] = $gpx_id; 
	    return $status;
	}
	
    function getNumberOfWpts() {
		$nodes = $this->getElementsByTagName ('wpt');
		$this->number_wpts = $nodes->length;
        return $this->number_wpts;
    }
    function getNumberOfTrkpts() {
		$nodes = $this->getElementsByTagName ('trkpt');
		$this->number_trkpts = $nodes->length;
        return $this->number_trkpts;
    }
    function getNumberOfTrksegs() {
		$nodes = $this->getElementsByTagName ('trkseg');
		$this->number_trksegs = $nodes->length;
        return $this->number_trksegs;
    }
    function getNumberOfTrks() {
		$nodes = $this->getElementsByTagName ('trk');
		$this->number_trks = $nodes->length;
        return $this->number_trks;
    }
    
    function getWaypoints() {
    	$waypoints = new WayPointList();
    	
    	# extract wpt data
	    #$nodes = new DomNodeList();
		$nodes = $this->getElementsByTagName ('wpt');
		foreach ($nodes as $item) {
	    	$wpt = new WayPoint();
			if($item->hasAttributes()) {
				#if($item->hasAttribute('lat'))
					$wpt->setLat($item->getAttribute('lat'));
				#if($item->hasAttribute('lon'))
					$wpt->setLon($item->getAttribute('lon'));
			}
			if($item->hasChildNodes()) {
				#$chNodes = new DomNodeList();
				$chNodes = $item->childNodes;
				
				foreach ($chNodes as $subitem) {
					switch ($subitem->nodeName) {
						case 'ele':
							$wpt->setEle($subitem->textContent);
							break;
						case 'time':
							$wpt->setTime($subitem->textContent);
							break;
						case 'name':
							$wpt->setName($subitem->textContent);
							break;
						case 'cmt':
							$wpt->setCmt($subitem->textContent);
							break;
						case 'desc':
							$wpt->setDesc($subitem->textContent);
							break;
						case 'fix':
							$wpt->setFix($subitem->textContent);
							break;
						case 'sat':
							$wpt->setSat($subitem->textContent);
							break;
						case 'hdop':
							$wpt->setHDOP($subitem->textContent);
							break;
						case 'pdop':
							$wpt->setPDOP($subitem->textContent);
							break;
					}
				}
			}
    		$waypoints->add($wpt);
    	}
    	return $waypoints;
    }
    
    function getTrackpoints($track, $tracksegment) {
    	$trackpoints = new TrackPointList();
    	
    	# extract trkpt data
	    #$nodes = new DomNodeList();
		$nodes = $this->getElementsByTagName ('trkpt');
		foreach ($nodes as $item) {
		    $trkpt = new TrackPoint();
			if($item->hasAttributes()) {
				#if($nodes->item($i)->hasAttribute('lat'))
					$trkpt->setLat($item->getAttribute('lat'));
				#if($nodes->item($i)->hasAttribute('lon'))
					$trkpt->setLon($item->getAttribute('lon'));
			}
			if($item->hasChildNodes()) {
				#$chNodes = new DomNodeList();
				$chNodes = $item->childNodes;
				
				foreach ($chNodes as $subitem) {
					switch ($subitem->nodeName) {
						case 'ele':
							$trkpt->setEle($subitem->textContent);
							break;
						case 'time':
							$trkpt->setTime($subitem->textContent);
							break;
						case 'fix':
							$trkpt->setFix($subitem->textContent);
							break;
						case 'sat':
							$trkpt->setSat($subitem->textContent);
							break;
						case 'hdop':
							$trkpt->setHDOP($subitem->textContent);
							break;
						case 'pdop':
							$trkpt->setPDOP($subitem->textContent);
							break;
						case 'course':
							$trkpt->setCourse($subitem->textContent);
							break;
						case 'speed':
							$trkpt->setSpeed($subitem->textContent);
							break;
						case 'extensions':
							$this->getTrackPointsExtensions($trkpt,$subitem);
							break;
					}
				}
			}
    		$trackpoints->add($trkpt);
    	}
    	return $trackpoints;
    }

    # read speed from extensions-node and write it into the trackpoint
    function getTrackPointsExtensions($trkpt,$item) {
	if($item->hasChildNodes()) {
		$chNodes = $item->childNodes;
		foreach ($chNodes as $subitem) {
			switch ($subitem->nodeName) {
				case 'nmea:speed':
				case 'speed':
					$trkpt->setSpeed($subitem->textContent);
					break;
				}
			}
		}
    }


    function getTracksegments($track) {
    	$tracksegments = new TrackSegmentList();
    	
    	# extract trkseg data
		$nodes = $this->getElementsByTagName ('trkseg');
		foreach ($nodes as $item) {
	    	$trkseg = new TrackSegment();
			# really nothing to do
    		$tracksegments->add($trkseg);
    	}
    	return $tracksegments;
    }

    function getTracks() {
    	$tracks = new TrackList();
    	
    	# extract trk data
		$nodes = $this->getElementsByTagName ('trk');
		foreach ($nodes as $item) {
	    	$trk = new Track();
			if($item->hasChildNodes()) {
				$chNodes = new DomNodeList();
				$chNodes = $item->childNodes;
				
				foreach ($chNodes as $subitem) {
					switch ($subitem->nodeName) {
						case 'name':
							$trk->setName($subitem->textContent);
							break;
						case 'cmt':
							$trk->setCmt($subitem->textContent);
							break;
						case 'desc':
							$ttr->setDesc($item->textContent);
							break;
					}
				}
			}
    		$tracks->add($trk);
    	}
    	return $tracks;
    }
}

class Trip {
	function getDistancesArray($gpx_id) {
		global $DEBUG, $cfg;
		
		$query = "SELECT `latitude`, `longitude`, UNIX_TIMESTAMP(`timestamp`) AS 'utime' 
			FROM `${cfg['db_table_prefix']}gpx_import` WHERE `gpx_id` = '$gpx_id' 
			ORDER BY `timestamp`; ";
		$result = db_query($query);
		if($DEBUG)	out($query, 'OUT_DEBUG');
		
		if(mysql_num_rows($result)) {
			$dist = NULL;
			$pt = array('i'=>0, 'x'=>0, 'y'=>0, 'xold'=>0, 'yold'=>0, 't'=>0, 'told'=>0);
		    $oGC = new GeoCalc();
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$pt['i']++;
				$pt['told'] = $pt['t'];
				$pt['xold'] = $pt['x'];
				$pt['yold'] = $pt['y'];
				$pt['y'] = $row['latitude'] /1000000;
				$pt['x'] = $row['longitude'] /1000000;
				$pt['t'] = $row['utime'];
				
				// set trip start time
				if($pt['i'] == 1)
					$distances[] = array(0, 0, $pt['t']);
				 
				if($pt['xold'] && $pt['yold']) {
					$distP2P = $oGC->GCDistance($pt['y'], $pt['x'], $pt['yold'], $pt['xold']);
					// illegal distance value
					if(!$distP2P || is_nan($distP2P)) {
						if($DEBUG) {
							out($row['timestamp']." :  xo=".$pt['xold']." yo=".$pt['yold'].
								" x=".$pt['x']." y=".$pt['y']." d=".$distP2P, 'OUT_DEBUG');
						}
						continue;
					}
					// distance between 2 trackpoints greater than threshold
					if($distP2P > $cfg['dist_threshold']) {
						if($DEBUG)
							out("dist to big (suspect): ".$distP2P, 'OUT_DEBUG');
					}
					// time between 2 trackpoints greater than threshold
					elseif(($pt['t'] - $pt['told']) > $cfg['time_threshold']) {
						$distances[] = array($dist, $pt['told'], $pt['t']);
						$dist = 0;
					}
					// sum point-to-point distances
					else {
						$dist += $distP2P;
					}
				}
			}
		
			$distances[] = array($dist, $pt['t'], 0);
		}
		return $distances;
	}

	function writeDistanceDB($gpx_id) {
		global $DEBUG, $cfg;
		
		// calculate distance between all the trackpoints
		$distances = Trip::getDistancesArray($gpx_id);
		$total = intval(1000 * array_sum_multidim($distances, NULL, 0));
		
		// insert track length into database
	    $query = "UPDATE `${cfg['db_table_prefix']}gpx_files` 
	    	SET `length` = '$total' WHERE `id` = '$gpx_id'; ";
	    $result = db_query($query);
	    return $total;
	}
}
?>
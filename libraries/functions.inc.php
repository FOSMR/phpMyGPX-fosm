<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// self-made function for formatted error output and script break
function stop($message) {
	out($message, 'OUT_ERROR');
	include("./foot.inc");
	exit();
}
// self-made function for formatted output via 'echo()'
function out($message, $type) {
	// definitions of constants for 'type'
	$OUT_ERROR = 0;
	$OUT_DEBUG = 1;
	$OUT_INFO = 2;
	$OUT_WARNING = 3;

    // format strings for different messages
    $outstr[0] = array('<h3 style="color:red">', "</h3>\n<a href=\"Javascript:history.back()\">zur&uuml;ck</a>");
    $outstr[1] = array("\n<span style=\"background-color:#CCCCCC\">", "</span><br>\n");
    $outstr[2] = array("<br>\n<b><i>", "</i></b><br>\n");
    $outstr[3] = array("\n<b style=\"color:red\">", "</b><br>\n");

	if(!is_int($type)) $type = $$type;
	echo $outstr[$type][0] . $message . $outstr[$type][1];
}


// self-made function like 'scandir()' from PHP5
function scan_dir($dir, $sorting_order, $type) {
	$filelist = scan_dir_f($dir, $sorting_order, $type, 0);
	return $filelist;
}

// self-made extended scandir function with filetype filter
function scan_dir_f($dir, $sorting_order, $type, $filter) {
	// definitions of constants for 'type'
	$FILETYPE_ALL = 0;
	$FILETYPE_DIR = 1;
	$FILETYPE_FILE = 2;

	if(!is_int($type)) $type = $$type;
	clearstatcache();
	$dirhandle  = opendir($dir);
	while (false !== ($file = readdir($dirhandle))) {
    	if($file != "." && $file != "..") {
	   		switch($type) {
	   			case 0:
	    			$files[] = $file;
		    		break;
	   			case 1:
	    			if(is_dir($dir.$file)) $files[] = $file;
		    		break;
	   			case 2:
	    			if(is_file($dir.$file)) {
                        $ext = substr($file, strrpos($file, '.')+1);
                        if(!$filter || strtolower($ext) == strtolower($filter))
                        	$files[] = $file;
                    }
		    		break;
	    	}
	   	}
	}
	closedir($dirhandle);
	if(isset($files)) {	# prevents php warning
        if($sorting_order == 1) rsort($files);
        else                    sort($files);
    }
	return $files;
}


// Simple function to replicate PHP5 'microtime(true)' behaviour
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


// cuts a string after a certain number of characters and appends "..."
function trim_str($str, $len) {
	if(strlen($str) > $len) {	
		if(!intval($len))	$len = 8;
		$trim_str = substr($str, 0, $len) . "...";
		return $trim_str;
	} else
		return $str;
}

// converts a date or timestamp string to UNIX timestamp
function str_to_time($str) {
	if(strlen($str) == 10 || strlen($str) == 19) {	# "2000-12-31[ 23:59:59]" date[time] or timestamp (MySQL 4.1) format
		$date = mktime(substr($str,11,2),substr($str,14,2),substr($str,17,2), substr($str,5,2),substr($str,8,2),substr($str,0,4));
	}
	if(strlen($str) == 14) {	# "20001231235959" timestamp format
		$date = mktime(substr($str,8,2),substr($str,10,2),substr($str,12,2), substr($str,4,2),substr($str,6,2),substr($str,0,4));
	}
	return $date;
}

// format a time in seconds according to given format (like strftime())
// accepted format strings are %H for hours, %M for minutes, %S for seconds
function time_format($time, $format) {
	$hours = floor($time / 3600);
	$remainder = $time % 3600;
	$minutes = floor($remainder / 60);
	$seconds = $remainder % 60;
	$time_string = str_replace('%H', $hours, $format);
	$time_string = str_replace('%M', $minutes, $time_string);
	$time_string = str_replace('%S', $seconds, $time_string);
	return $time_string;
}

// convert encoding
function encode_UTF8($string) {
	if(function_exists('mb_convert_encoding')) {
		$encoded = mb_convert_encoding($string, "UTF-8");
	}else {
		if(function_exists('mb_convert_encoding'))
			$encoded = iconv("ISO-8859-1", "UTF-8", $string);
		else
			return FALSE;
	}
	return $encoded;
}


// calculates sum of values of multi dimensional arrays
function array_sum_multidim($mdarray, $level=NULL, $element) {
	$sum = NULL;
	if(is_array($mdarray)) {
		foreach($mdarray as $key=>$val) {
			$sum += $val[intval($element)];
		}
	}
	return $sum;
}

// extract data from multidiemsional array
function array_extract_multidim($mdarray, $level=NULL, $element) {
	foreach($mdarray as $key => $value) {
		$odarray[] = $value[$element];
	}
	return $odarray;
}

// infect data into multidiemsional array
function array_infect_multidim($mdarray, $level=NULL, $element, $infect) {
	foreach($mdarray as $key => &$value) {
		$value[$element] = $infect[$key];
	}
	return $mdarray;
}

// calculates a centered moving average with given period
function moving_average($inBuffer, $period) {
	moving_average_m($inBuffer, $period, 0);
}
function moving_average_m($inBuffer, $period, $mode) {
	// definitions of pseudo constants for 'mode' (handling of margins)
	$MODE_CUTOFF = 0;	// elements are cut off, result is sliced
	$MODE_SHRINK = 1;	// elements are cut off, array is index is recreated
	$MODE_COPY = 2;		// elements are same as in source array
	$MODE_ALL = 3;		// elements are all calculated
	
	if(!is_int($mode)) $mode = $$mode;
	if($period <= 0 || is_nan($period))
		return FALSE;
	// check for odd period
	if($period%2 == 0)
		$period++;
	$margins = ($period-1)/2;
	$outBuffer = array();
	$outBuffer = array_fill(0, sizeof($inBuffer), 0);
	
	for($j=0; $j<sizeof($inBuffer); $j++) {
		if($j<$margins || $j>=(sizeof($inBuffer)-$margins)) {
			if($mode == 2)
				$outBuffer[$j] = $inBuffer[$j];
			if($mode == 3) {
				$period_short = 0;
				for($i=$margins*(-1); $i<=$margins; $i++) {
					if(($j+$i) >= 0 && ($j+$i) < sizeof($inBuffer)) {
						$outBuffer[$j] += $inBuffer[$j+$i];
						$period_short++;
					}
				}
				$outBuffer[$j] /= $period_short;
			}
		}
		else {
			for($i=$margins*(-1); $i<=$margins; $i++) {
				$outBuffer[$j] += $inBuffer[$j+$i];
			}
			$outBuffer[$j] /= $period;
		}
	}
	if($mode == 1) {
		$sliced = array_slice($outBuffer, 0);	// re-index
		$outBuffer = $sliced;
	}
	return $outBuffer;
}

function fetchUrlWithoutHanging($url, $numberOfSeconds, $referrer) {
   // Set maximum number of seconds (can have floating-point) to wait for feed before displaying page without feed
   if($numberOfSeconds == 0) $numberOfSeconds=4;

   // Suppress error reporting so Web site visitors are unaware if the feed fails
   error_reporting(0);

   // decode html entities, especially '&amp;'
   $url = html_entity_decode($url);

   // Extract resource path and domain from URL ready for fsockopen
   $url = str_replace("http://","",$url);
   $urlComponents = explode("/",$url);
   $domain = $urlComponents[0];
   $resourcePath = str_replace($domain,"",$url);

   // Establish a connection
   $socketConnection = fsockopen($domain, 80, $errno, $errstr, $numberOfSeconds);

   if (!$socketConnection) {
       // You may wish to remove the following debugging line on a live Web site
       #print("<!-- Network error: $errstr ($errno) -->");
   }
   else {
       #$xml = '';
       $http_get = array();
       if(!$referrer)
       		$referrer = $_SERVER["HTTP_REFERER"];
       fputs($socketConnection, "GET /$resourcePath HTTP/1.0\r\nHost: $domain\r\nReferer: $referrer\r\n\r\n");

       // Loop until end of file
       while (!feof($socketConnection)) {
           #$xml .= fgets($socketConnection, 128);
           array_push($http_get, fgets($socketConnection));
       }
       fclose ($socketConnection);
   }
   return($http_get);
}


// data base handling, especially queries
function db_connect($db) {
    $link = db_connect_h("localhost", $db, "php-system", "php-system");
    return $link;
}
function db_connect_u($db, $user, $pw) {
	$link = db_connect_h("localhost", $db, $user, $pw);
    return $link;
}
function db_connect_h($host, $db, $user, $pw) {
    $link = mysql_connect($host, $user, $pw)
        or die($outstr[0][0]. _CMN_DB_CONNECT_ERR . mysql_error() .$outstr[0][1]);
    mysql_select_db($db)
        or die($outstr[0][0]. _CMN_DB_SELECT_ERR . mysql_error() .$outstr[0][1]);
    return $link;
}
function db_escape_string($string) {
	if(get_magic_quotes_gpc())
		$string = stripslashes($string);
	return mysql_real_escape_string($string);
}
function db_query($query) {
    $result = mysql_query($query) 
    	or die ($outstr[0][0]. _CMN_DB_QUERY_ERR . mysql_error() .$outstr[0][1]);
    return $result;
}
function db_close($result, $link) {
    if($result !== TRUE) mysql_free_result($result);
    mysql_close($link);
}


function check_SQL_NULL(&$item) {
	if($item)	$item = "'".$item."'";
	else		$item = 'NULL';
}

// parses string for memory size values
// taken from PHP documentation
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

// get maximum file size for uploads, checking some directives in php.ini
function check_max_filesize($cfg_size) {
	$post_size = return_bytes(ini_get('post_max_size'));
	$upl_size = return_bytes(ini_get('upload_max_filesize'));
	$size = return_bytes($cfg_size);
	
	if($upl_size && ($upl_size < $size)) {
		$size = $upl_size;
	}
	if($post_size && ($post_size < $size)) {
		$size = $post_size;
	}
	return $size;
}

function get_lang($lang) {
	// checks for language file
	if(!file_exists( _PATH.'languages/'.$lang.'.php' ) ||
		filesize( _PATH.'languages/'.$lang.'.php' ) < 100) {
		$lang = 'english';
	}
	return $lang;
}

function get_accepted_lang() {
	$code = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);
	switch($code) {
		case 'de':
			$lang = 'german';
			break;
		case 'en':
			$lang = 'english';
			break;
		case 'fr':
			$lang = 'french';
			break;
		case 'nl':
			$lang = 'dutch';
			break;
		case 'es':
			$lang = 'spanish';
			break;
		default:
			$lang = 'english';
			break;
	}
	return $lang;
}

function check_password($pass) {
	$pwd_hash = get_session_var('pwd_hash');
	if($pwd_hash == md5($pass))
		return TRUE;
	else
		return FALSE;
}

function get_session_var($element) {
	if($element) {
		return $_SESSION[$element];
	}else {
		return $_SESSION;
	}
}

function checkCapability($feature) {
	switch ($feature) {
		case 'proxysimple':
		case 'CURL':
			if(function_exists('curl_init'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'DOM':
			if(class_exists('DOMDocument'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'EXIF':
			if(function_exists('exif_read_data'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'GD2':
			if(function_exists('gd_info'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'mbstring':
			if(function_exists('mb_get_info'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'mysql':
			if(function_exists('mysql_connect'))
				return TRUE;
			else
				return FALSE;				
			break;
		case 'mysqli':
			if(class_exists('MySQLi'))
				return TRUE;
			else
				return FALSE;				
			break;
		default:
			return FALSE;
	}
}

function getUrlParam($method, $type, $var) {
	// definitions of pseudo constants for 'method' (HTTP method)
	$HTTP_GET = 1;	$HTTP_POST = 2;	
	if(!is_int($method)) $method = $$method;
	switch ($method) {
		case 2:
			if(isset($_POST[$var]))
				$value = $_POST[$var];
			else
				return NULL;
			break;
		default:
		case 1:
			if(isset($_GET[$var]))
				$value = $_GET[$var];
			else
				return NULL;
			break;
	}
	switch ($type) {
		case 'STRING':
			return strip_tags($value);
			break;
		case 'FLOAT':
			return floatval($value);
			break;
		default:
		case 'INT':
			return intval($value);
			break;
	}
}

// dummy function
function settimezone() {
	if(function_exists("date_default_timezone_set") && 
		function_exists("date_default_timezone_get"))
		@date_default_timezone_set(@date_default_timezone_get());
}
?>

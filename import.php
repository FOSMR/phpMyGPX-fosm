<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

define( '_VALID_OSM', TRUE );
define( '_PATH', './' );
$DEBUG = FALSE;
if($DEBUG) error_reporting(E_ALL);
include("./config.inc.php");
include("./libraries/functions.inc.php");
include("./libraries/classes.php");
include("./libraries/image.classes.php");
include("./libraries/GeoCalc.class.php");

setlocale (LC_TIME, $cfg['config_locale']);
include("./languages/".get_lang($cfg['config_language']).".php");

if($DEBUG) {
    foreach($_POST as $akey => $val)
        out("<b>$akey</b> = $val", "OUT_DEBUG");
}

$id 			= getUrlParam('HTTP_GET', 'INT', 'id');
$file 			= getUrlParam('HTTP_GET', 'STRING', 'file');
$type 			= getUrlParam('HTTP_GET', 'STRING', 'type');
$title_opt 		= getUrlParam('HTTP_GET', 'STRING', 'title_opt');
$title 			= getUrlParam('HTTP_GET', 'STRING', 'title');
$desc_opt 		= getUrlParam('HTTP_GET', 'STRING', 'desc_opt');
$description 	= getUrlParam('HTTP_GET', 'STRING', 'description');
$timezone		= getUrlParam('HTTP_GET', 'INT', 'tz');
$offset			= getUrlParam('HTTP_GET', 'INT', 'offset');
$gpx_id			= getUrlParam('HTTP_GET', 'INT', 'gpx_id');

// connect to database
$link = db_connect_h($cfg['db_host'], $cfg['db_name'], $cfg['db_user'], $cfg['db_password']);

$status = array('error'=>-1, 'lid'=>0, 'msg'=>'');

if($type) {
	// set headers for XML Http Request response
	header('Content-type: text/xml');
	header('Cache-Control: must-revalidate, pre-check=0, no-store, no-cache, max-age=0, post-check=0');

	
	switch ($type) {
		// import GPX XML files		
		case 'gpx':
			if($DEBUG) {
				sleep(2);
				$status = array('error'=>'-1', 'lid'=>'99', 'msg'=>'just testing...');
			}else {
				if(file_exists($file)) {
			        // init and load gpx document
					$doc = new GpxDocument("1.0", "UTF-8");
					if($doc) {
						@$doc->load($file);
						// validate XML
						#$cfg['validate_gpx_xml'] = FALSE;
						if(!$cfg['validate_gpx_xml'] || $doc->validateGPX()) {
							// import all trackpoints and waypoints
							$status = $doc->importGPX($description, $timezone, NULL);
							if(!$status['error']) {
								// calculate track length and write it to database
								Trip::writeDistanceDB($status['lid']);
								// move file to gpx folder if import was successful
								if(copy($file, './files/'.basename($file))) {
									if($cfg['chmod_on_import']) {
										@chown($file, 0644);
										@chown('./files/'.basename($file), 0644);
									}
									unlink($file);
								}else
									$status['msg'] = _IMPORT_COPY_FAILED;
							}
						}else
							$status['msg'] = _TRC_NO_VALID_XML;
							
					}else
						$status['msg'] = _TRC_NO_PHP_DOM_EXT;
					
				}else
					$status['msg'] = _IMPORT_FILE_ERROR;
			}
			break;
		
		// import JPG photo files
		case 'photo':
			if($DEBUG) {
				sleep(2);
				$status = array('error'=>'-1', 'lid'=>'77', 'msg'=>'just testing...');
			}else {
				if(file_exists($file)) {
			        // init and load photo file
					$doc = new ImageFile();
					if($doc) {
						$doc->load($file);
						// import
						$status = $doc->importPhoto($gpx_id, $title_opt, $title, $desc_opt, $description, $timezone, $offset, NULL);
						// move file to photo folder if import was successful
						if(!$status['error']) {
							if(!$cfg['photo_copy_files']) {
								unlink($file);
							}else {
								if(copy($file, $cfg['photo_images_dir'].basename($file))) {
									if($cfg['chmod_on_import']) {
										@chown($file, 0644);
										@chown($cfg['photo_images_dir'].basename($file), 0644);
									}
									unlink($file);
								}else
									$status['msg'] = _IMPORT_COPY_FAILED;
							}
						}
						
					}else
						$status['msg'] = _PHOTO_NO_PHP_GD2_EXT;
				
				}else
					$status['msg'] = _IMPORT_FILE_ERROR;
			}
			break;
	}
	
	
	// creating XML Http Request response
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<phpmygpx>\n";
	echo "  <import 
				type=\"".$type."\" 
				id=\"".$id."\" 
				file=\"".$file."\" 
				status=\"".$status['error']."\" 
				lid=\"".$status['lid']."\" 
				msg=\"".rawurlencode($status['msg'])."\" 
			/>\n";
	echo "</phpmygpx>\n";
}
?>
<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2011 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*
* @file
* @brief This file contains the default values of all config vars.
*
* Editing this file does not have any effects except for fresh installations!
* To change your current configuration, please edit "config.inc.php" one dir level up!
*/

//! MySQL server address, in general 'localhost'
$cfg['db_host']				= 'localhost';
//! name of database to be used
$cfg['db_name'] 			= 'osm';
//! table prefix for all tables, can be an empty string
$cfg['db_table_prefix'] 	= '';
//! MySQL user name
$cfg['db_user'] 			= 'username';
//! MySQL user password
$cfg['db_password']			= 'password';

//! admin password for public hosting
$cfg['admin_password']		= 'pass';
//! disable write access to database
$cfg['public_host']			= TRUE;
//! disable menus etc. to use within web sites
$cfg['embedded_mode']		= FALSE;
//! use bundled OpenLayers + OSM JS libraries
$cfg['use_local_libs']		= TRUE;
//! enable local cache proxy for map tiles
$cfg['local_tile_proxy']	= TRUE;
//! check for software updates
$cfg['check_updates']		= TRUE;

//! enable all photo related features
$cfg['photo_features']      = TRUE;
//! copy photo files on imports
$cfg['photo_copy_files']	= TRUE;
//! create thumbnails when importing photos
$cfg['photo_create_thumbs']	= TRUE;
//! directory where photos are stored (relative to phpmygpx root dir)
$cfg['photo_images_dir']	= './photos/';
//! directory where thumbnails are stored (relative to phpmygpx root dir)
$cfg['photo_thumbs_dir']	= './photos/thumbs/';
//! filename prefix for thumbnail files
$cfg['photo_thumbs_prefix'] = '';
//! thumbnail width (pixel)
$cfg['photo_thumb_width']	= 150;
//! filename prefix for photos with lower resolution
$cfg['photo_low_resolution_prefix']	= '';
//! low resolution width (pixel), set to 0 if not existent!
$cfg['photo_low_resolution_width']	= 0;
//! enable viewing photos in full size
$cfg['photo_full_size']		= TRUE;
//! JPEG compression/quality level [0...100]
$cfg['photo_jpeg_quality']	= 80;
//! minimal zoom to show photo icons on map
$cfg['photo_min_zoom']      = 14;

//! show link to 'phpMyAdmin' database tool
$cfg['pma_app_show_link']   = FALSE;
//! web server path to 'phpMyAdmin'
$cfg['pma_app_path']        = '../phpMyAdmin';

//! enable all gpx related features
$cfg['gpx_features']      = TRUE;
//! max exec time of import script (seconds, 0=unlimited)
$cfg['import_time_limit']	= 60;
//! validate XML structure of GPX files on import
$cfg['validate_gpx_xml']	= TRUE;
//! try to chmod files to 0644 on import
$cfg['chmod_on_import']		= FALSE;
//! max time diff (trackpoints/camera) for photo import (seconds)
$cfg['max_timediff_import']	= 30;

//! max file size (bytes) for uploading (4 MB)
$cfg['max_file_size']		= 4194304;
//! image size (pixel) of track preview
$cfg['image_size']			= 170;
//! image size (pixel)
$cfg['image_big_size']		= 600;
//! map height (pixel)
$cfg['map_height']			= 500;
//! page width (pixel)
$cfg['page_width']			= 900;
//! chart width (pixel), should be the same as 'page_width'
$cfg['chart_width']			= 900;
//! chart height (pixel)
$cfg['chart_height']		= 250;
//! chart width (pixel)
$cfg['chart_big_width']		= 1200;
//! chart height (pixel)
$cfg['chart_big_height']	= 600;
//! chart type: altitude against 'time' or 'dist'
$cfg['chart_altitude_type']	= 'time';

//! lifetime of preferences cookie (hours)
$cfg['pref_cookie_lifetime']	= 720;
//! max number of result table rows to display
$cfg['result_table_limit']		= 25;
//! max number of pois to draw on map
$cfg['result_datalayer_limit']	= 150;
//! max number of trackpoints per GPX to draw on map
$cfg['map_gpx_max_trkpts']		= 1000;

/// number of prefetched tiles on each side of the map
//* This is passed to OpenLayers.Layer.Grid.buffer */
$cfg['map_tile_buffer']			= 1;
//! show download links for GPX files
$cfg['enable_gpx_download'] = TRUE;
//! show execution time of scripts
$cfg['show_exec_time']      = TRUE;

//! frontend language; see "languages" directory
$cfg['config_language']     = 'german';
//! locale, value depends on OS (Linux, Win)
$cfg['config_locale']		= 'de_DE.UTF-8';
//! timezone offset to GMT [-12...12] hours
$cfg['timezone_offset']		= 1;

//! default map center latitude (degrees)
$cfg['home_latitude']		= 51.00;
//! default map center longitude (degrees)
$cfg['home_longitude']		= 10.00;
//! default zoom for map home location [1...17]
$cfg['home_zoom']			= 6;

//! threshold for distance calculation (in kilometers)
$cfg['dist_threshold'] 		= .5;
//! threshold for distance calculation (in seconds)
$cfg['time_threshold'] 		= 600;
//! moving average filter param for filtering altitude data
$cfg['alt_data_filter_mva']	= 15;
?>

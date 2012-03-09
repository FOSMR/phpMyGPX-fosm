<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2009-2012 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_VALID_OSM') or die('Restricted access');


DEFINE('_LANGUAGE','en');
DEFINE('_TRANSLATOR_NAME', 'Sebastian Klemm');
DEFINE('_TRANSLATOR_EMAIL', 'osm@erlkoenigkabale.eu');

// Site page note found
DEFINE('_404', 'We\'re sorry but the page you requested could not be found.');
DEFINE('_404_RTS', 'Return to site');

// common
DEFINE('_APP_NAME','phpMyGPX');
DEFINE('_HTML_TITLE','phpMyGPX ::: track point managment');

DEFINE('_DATE_FORMAT_LC',"%Y-%m-%d"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d %B %Y %H:%M");
DEFINE('_DATE_FORMAT_LC3',"%Y-%m-%d %H:%M:%S");
DEFINE('_TIME_FORMAT_LC4',"%H:%M:%S h");

DEFINE('_NOT_AUTH','You are not authorized to view this resource.');
DEFINE('_DO_LOGIN','You need to login.');
DEFINE('_VALID_AZ09',"Please enter a valid %1%.  No spaces, more than %2% characters and contain 0-9,a-z,A-Z");
DEFINE('_CMN_YES','Yes');
DEFINE('_CMN_NO','No');
DEFINE('_CMN_SHOW','Show');
DEFINE('_CMN_HIDE','Hide');

DEFINE('_CMN_NAME','Name');
DEFINE('_CMN_DESCRIPTION','Description');
DEFINE('_CMN_SAVE','Save');
DEFINE('_CMN_APPLY','Apply');
DEFINE('_CMN_CANCEL','Cancel');
DEFINE('_CMN_PRINT','Print');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','E-mail');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Parent');
DEFINE('_CMN_ORDERING','Ordering');
DEFINE('_CMN_ACCESS','Access Level');
DEFINE('_CMN_SELECT','Select');
DEFINE('_CMN_SELECT_ALL','Select all');
DEFINE('_CMN_STATUS','Status');
DEFINE('_CMN_SEARCH_RESULTS','%1% search results:');

DEFINE('_CMN_FIRST','First');
DEFINE('_CMN_LAST','Last');
DEFINE('_CMN_NEXT','Next');
DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Previous');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','No Sorting');
DEFINE('_CMN_SORT_ASC','Sort Ascending');
DEFINE('_CMN_SORT_DESC','Sort Descending');

DEFINE('_CMN_NEW','New');
DEFINE('_CMN_NONE','None');
DEFINE('_CMN_LEFT','Left');
DEFINE('_CMN_RIGHT','Right');
DEFINE('_CMN_CENTER','Center');
DEFINE('_CMN_TOP','Top');
DEFINE('_CMN_BOTTOM','Bottom');
DEFINE('_CMN_FROM',' from ');
DEFINE('_CMN_TO',' to ');

DEFINE('_CMN_DELETE','Delete');

DEFINE('_CMN_FOLDER','Folder');
DEFINE('_CMN_SUBFOLDER','Sub-folder');
DEFINE('_CMN_WRITABLE','Writable');
DEFINE('_CMN_NOT_WRITABLE','NOT writable');
DEFINE('_CMN_AVAILABLE','Available');
DEFINE('_CMN_MISSING','Missing');
DEFINE('_CMN_OPTIONAL','Optional');
DEFINE('_CMN_REQUIRED','Required');


DEFINE('_CMN_SCRIPT_EXEC_TIME','Page generated in ');
DEFINE('_CMN_MOUSEOVER_FOR_TOOLTIP','For hints, place your mouse pointer over an input field.');
DEFINE('_CMN_NOT_IMPLEMENTED','This feature isn\'t implemented yet.');
DEFINE('_CMN_BACK','Back');
DEFINE('_CMN_CONTINUE','Continue');
DEFINE('_CMN_WARNING','Warning!');
DEFINE('_CMN_PAGE','Page');
DEFINE('_CMN_BATCH','Batch processing');
DEFINE('_CMN_SINGLE_FILE','Single file');
DEFINE('_CMN_MAX_FILE_SIZE','maximum file size: ');
DEFINE('_CMN_NO_ITEM_SELECTED','No item selected!');
DEFINE('_CMN_COPY_DATE','Copy date');
DEFINE('_CMN_OTHER','other');
DEFINE('_CMN_VIEW','View');
DEFINE('_CMN_VIEW_SIMPLE','simple');
DEFINE('_CMN_VIEW_DETAIL','detailed');

// error descriptions taken from http://de.php.net/manual/en/features.file-upload.errors.php
DEFINE('_CMN_UPLOAD_ERR_SIZE','The uploaded file exceeds the upload_maximum file size.');
DEFINE('_CMN_UPLOAD_ERR_PARTIAL','The uploaded file was only partially uploaded.');
DEFINE('_CMN_UPLOAD_ERR_NO_FILE','No file was uploaded.');
DEFINE('_CMN_UPLOAD_ERR_NO_TMP_DIR','Missing a temporary folder.');
DEFINE('_CMN_UPLOAD_ERR_CANT_WRITE','Failed to write file to disk.');

// database related errors, taken from PHP manual
DEFINE('_CMN_DB_CONNECT_ERR','Could not connect: ');
DEFINE('_CMN_DB_SELECT_ERR','Could not select database: ');
DEFINE('_CMN_DB_QUERY_ERR','Invalid query: ');

DEFINE('_CMN_GEO_TAGGING','Geo-Tagging');
DEFINE('_CMN_GEO_TAGGING_MAN','For automatic geo-tagging a GPX file has to be selected.');
DEFINE('_CMN_TIMEZONE','Timezone');
DEFINE('_CMN_TIMEZONE_CAM','Timezone of camera\'s clock');
DEFINE('_CMN_LOCATION','Location');
DEFINE('_CMN_BBOX','Bounding box');
DEFINE('_CMN_RANGE','Range');
DEFINE('_CMN_INSERTED','inserted');
DEFINE('_CMN_PUBLIC','public');
DEFINE('_CMN_VISIBLE','visible');
DEFINE('_CMN_TITLE','Title');
DEFINE('_CMN_ICON','Icon');
DEFINE('_CMN_THUMB','Thumbnail');
DEFINE('_CMN_PHOTO_ID','Photo ID');
DEFINE('_CMN_USER_ID','User ID');
DEFINE('_CMN_GPX_ID','GPX ID');
DEFINE('_CMN_BM_ID','Bm ID');
DEFINE('_CMN_BM_NAME','Bookmark name');
DEFINE('_CMN_FILE_NAME','File name');
DEFINE('_CMN_FILE_SIZE','File size');
DEFINE('_CMN_LENGTH','Length');
DEFINE('_CMN_COMMENT','Comment');
DEFINE('_CMN_DATE','Date');
DEFINE('_CMN_ZOOM','Zoom level');
DEFINE('_CMN_LAT','Latitude');
DEFINE('_CMN_LON','Longitude');
DEFINE('_CMN_ALT','Altitude');
DEFINE('_CMN_VIEW_DIR','Viewing direction');
DEFINE('_CMN_MOVE_DIR','Moving direction');
DEFINE('_CMN_COURSE','Course');
DEFINE('_CMN_SPEED','Speed');
DEFINE('_CMN_FIX','Sat Fix');
DEFINE('_CMN_SAT','Satellites');
DEFINE('_CMN_HDOP','HDOP');
DEFINE('_CMN_PDOP','PDOP');


/** installation */
DEFINE('_INST_OSM_SETUP','phpMyGPX-Setup: ');
DEFINE('_INST_WELCOME','Welcome');
DEFINE('_INST_CHECKS','Environment checks');
DEFINE('_INST_CONFIG','Configuration');
DEFINE('_INST_DB_INST','Database installation');
DEFINE('_INST_DONE','Installation done');

DEFINE('_INST_GUIDED','You will be guided through all steps of installation process. Just follow the given instructions.');
DEFINE('_INST_MAN_LOGIN','If you have <b>root access</b> to your database, just enter the password below.<br>
For later usage an user with less privileges will be used for security reasons and will be created by this install routine. His login has to be set in the config file.<br><br>
If your database is <b>shared hosted</b>, you may have only one user account. In this case, please use his account data for <b>both</b> the config file <b>and</b> this installation script.'); 

DEFINE('_INST_DB_ACCOUNT','MySQL account data ');
DEFINE('_INST_DB_HOST','Host name');
DEFINE('_INST_DB_NAME','Database name');
DEFINE('_INST_DB_TABLE_PREFIX','Table name prefix');
DEFINE('_INST_DB_USER','User name');
DEFINE('_INST_DB_PASSWORD','Password');
DEFINE('_INST_DB_ROOT_ACCOUNT','Root MySQL account data ');
DEFINE('_INST_DB_ROOT_ACCOUNT_MAN','If you have <b>root access</b> to your database, just enter username and password below, otherwise leave fields empty.<br>
For later usage an user with less privileges will be used for security reasons and will be created by this install routine.');
DEFINE('_INST_DB_ROOT','Root name');
DEFINE('_INST_DB_ROOTPASS','Root password');
DEFINE('_INST_CFG_ADMIN_ACCESS','Admin access');
DEFINE('_INST_CFG_ADMIN_ACCESS_MAN','If your server is accessible to the public, you should check this box and give an password for administration!');
DEFINE('_INST_CFG_PUBLIC_HOST','Publicly accessible host');
DEFINE('_INST_CFG_ADMIN_PASSWORD','Admin password');
DEFINE('_INST_CFG_HOME_LOCATION','Home location');
DEFINE('_INST_CFG_HOME_LOCATION_MAN','Please choose the home location of your map (just zoom, drag and drop the preview on the right).');

DEFINE('_INST_LANGUAGE','Language');
DEFINE('_INST_LANGUAGE_CHOOSE','Please choose your preferred language.');
DEFINE('_INST_MODE','Installation mode');
DEFINE('_INST_MODE_NEW','New/fresh installation');
DEFINE('_INST_MODE_UPGR3','Upgrade to version 0.3');
DEFINE('_INST_MODE_UPGR_LATEST','Upgrade to latest version');
DEFINE('_INST_MODE_NEW_DESC',' (database and all tables will be created, if not existent)');
DEFINE('_INST_MODE_UPGR3_DESC',' (existing tables will be altered and missing ones will be created)');
DEFINE('_INST_PROG_CHECKS','Folder permissions and server capabilities will be checked...');
DEFINE('_INST_PROG_PHOTOS_DISABLED','Photo features are disabled because of missing EXIF and mbstring extensions.');
DEFINE('_INST_PROG_CHECKED','All tests successfully done.');
DEFINE('_INST_PROG_CONFIG_FOUND','An old config file was found and its values will be adopted.');
DEFINE('_INST_PROG_CONFIG_UPDATED','The config file was updated and saved.');
DEFINE('_INST_DB_CREATE_SETUP','Create and setup database ');
DEFINE('_INST_PROG_INST','Your MySQL database and all tables will be created...');
DEFINE('_INST_DB_CONN_ERROR','Connection to database server failed. ');
DEFINE('_INST_UPGR3_ADD_BOOKM_TBL','Table for bookmarks was created.');
DEFINE('_INST_UPGR3_ADD_WAYPTS_TBL','Table for waypoints was created.');
DEFINE('_INST_UPGR5_ADD_POIS_TBL','Table for POIs/photos was created.');
DEFINE('_INST_PROG_DB','Database was created.');
DEFINE('_INST_PROG_RENAMED','Installation folder was renamed for security reasons.');
DEFINE('_INST_PROG_RENAME_ERROR','Please DO remove the installation folder for security reasons!');
DEFINE('_INST_PROG_DONE','<b>CONGRATULATIONS!</b> You successfully installed the application!');
DEFINE('_INST_PROG_TEST','Last test successfully done.');
DEFINE('_INST_ERROR','An error occured. Try to solve the problem and reload this script!');
DEFINE('_INST_DB_ERROR','Error in query: ');
DEFINE('_INST_DB_STAT','Statistics for database ');

/** html.classes.php */
DEFINE('_MENU_GPX','GPX file');
DEFINE('_MENU_GPX_VIEW','view GPX');
DEFINE('_MENU_GPX_DETAILS','details');
DEFINE('_MENU_GPX_IMAGE','image');
DEFINE('_MENU_GPX_UPL','upload GPX');
DEFINE('_MENU_GPX_BATCH_IMPORT','GPX batch import');
DEFINE('_MENU_GPX_IMPORT','import');
DEFINE('_MENU_GPX_EXPORT','export');
DEFINE('_MENU_GPX_DOWNL','download');
DEFINE('_MENU_GPX_EDIT','edit');
DEFINE('_MENU_GPX_DELETE','delete');
DEFINE('_MENU_GPX_SEARCH','search GPX');
DEFINE('_MENU_TRKPT','Trackpoints');
DEFINE('_MENU_TRKPT_VIEW','view Trackpoints');
DEFINE('_MENU_TRKPT_SEARCH','search Trackpoints');
DEFINE('_MENU_WPT','Waypoints');
DEFINE('_MENU_WPT_VIEW','view Waypoints');
DEFINE('_MENU_WPT_EDIT','edit Waypoint');
DEFINE('_MENU_WPT_DELETE','delete Waypoint');
DEFINE('_MENU_WPT_SEARCH','search Waypoints');
DEFINE('_MENU_PHOTO','Photo');
DEFINE('_MENU_PHOTO_VIEW','view photos');
DEFINE('_MENU_PHOTO_DETAILS','photo\'s details');
DEFINE('_MENU_PHOTO_UPL','upload photos');
DEFINE('_MENU_PHOTO_BATCH_IMPORT','photo batch import');
DEFINE('_MENU_PHOTO_IMPORT','import photos');
DEFINE('_MENU_PHOTO_DELETE','delete photos');
DEFINE('_MENU_VIEW','view');
DEFINE('_MENU_UPL','upload');
DEFINE('_MENU_SEARCH','search');
DEFINE('_MENU_NEW','new');

DEFINE('_MENU_HOME','Home');
DEFINE('_MENU_ABOUT','About...');
DEFINE('_MENU_BOOKMARK','Bookmarks');
DEFINE('_MENU_MAP','Map');
DEFINE('_MENU_MISC','Misc');
DEFINE('_MENU_DB','database');
DEFINE('_MENU_DB_STAT','Statistics');
DEFINE('_MENU_LOGIN','LOGIN');
DEFINE('_MENU_LOGOUT','LOGOUT');

/** index.php */
DEFINE('_HOME_WELCOME_TO','Welcome to ');
DEFINE('_HOME_INTRO','To do: Intro');
DEFINE('_LOGIN_FAILED','Login failed. Your password is not correct.');
DEFINE('_LOGIN_SUCCESS','You have successfully Logged In');
DEFINE('_LOGOUT_SUCCESS','You have successfully Logged Out');
DEFINE('_LOGIN_DESCRIPTION','To access the Admin features of this site please Login:');

/** traces.php */
DEFINE('_TRC_NO_WPTS_IN_DB','No waypoints available.');
DEFINE('_TRC_NO_TRKPTS_IN_DB','No trackpoints available.');
DEFINE('_TRC_NO_GPX_IN_DB','No GPX files in database available.');
DEFINE('_TRC_GPX_DOES_NOT_EXIST','This GPX file does not exist!');
DEFINE('_TRC_DETAILS_OF_GPX','Statistics and details of GPX file # ');
DEFINE('_TRC_APPROX_DIST','approx. distance');
DEFINE('_TRC_TRIP_TIME','trip time');
DEFINE('_TRC_AVG_SPEED','average speed');
DEFINE('_TRC_TRACK','Track ');
DEFINE('_TRC_HALT','Halt: ');
DEFINE('_TRC_TOTAL','Total');
DEFINE('_TRC_DETAILS_CHART_SPLIT','The elevation chart was split due to breaks in the track:');
DEFINE('_TRC_SHOW_MAP','Show map');
DEFINE('_TRC_SHOW_OSM_MAP','Show map on OSM');
DEFINE('_TRC_SHOW_ITEMS_ON_MAP','Show selected items on map');
DEFINE('_TRC_USE_DP_FOR_SEARCH','Please use decimal points for float numbers.');
DEFINE('_TRC_SEARCH_PARAMS_LOGIC_AND','Search parameters are evaluated with logic AND.');
DEFINE('_TRC_CHOOSE_SEARCH_FILTER','Choose filter for searching: ');
DEFINE('_TRC_CHOOSE_UPL_FILE','Choose a file to upload: ');
DEFINE('_TRC_BATCH_IMPORT_INFO','To do a batch import, copy your files (via FTP) to the "/upload/" folder before proceeding.');
DEFINE('_TRC_BATCH_IMPORTING_DIR','Files will be imported from this folder: <i>"%1%"</i>');
DEFINE('_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING','Please choose the files to be imported: ');
DEFINE('_TRC_START_IMPORT','Start batch import');
DEFINE('_TRC_WAIT_WHILE_IMPORTING','Please wait while importing: ');
DEFINE('_TRC_IMPORT_DONE','Import done.');
DEFINE('_TRC_MAY_TAKE_SECONDS','This may take some seconds.');
DEFINE('_TRC_UPL_ERROR','File upload error: ');
DEFINE('_TRC_UPL_SUCCESS','File successfully uploaded: ');
DEFINE('_TRC_READING_FILE','Reading file "<i>%1%</i>"...');
DEFINE('_TRC_NO_VALID_XML','Sorry, it doesn\'t seem to be a valid XML format!');
DEFINE('_TRC_MISS_TIMESTAMP','Can\'t import this GPX file because of missing timestamps!');
DEFINE('_TRC_DUPLICATE_FILENAME','File name must be unique! Are you re-importing?');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Timestamps must be unique! Are you re-importing?');
DEFINE('_TRC_NO_PHP_DOM_EXT','PHP DOM extension is not installed!');
DEFINE('_TRC_WPTS_PROCESSED',' Waypoints processed.');
DEFINE('_TRC_TRKPTS_PROCESSED',' Trackpoints processed.');
DEFINE('_TRC_REALLY_DELETE','Do you really want to DELETE this GPX file <br />and all included track points?<br />There\'s NO undo function!');
DEFINE('_TRC_CONFIRM_DELETE','To confirm deletion please type "Yes".');
DEFINE('_TRC_NO_CONFIRM_DELETE','You aborted deleting.');
DEFINE('_TRC_WPT_DELETED','%1% waypoints deleted.');
DEFINE('_TRC_TRKPT_DELETED','%1% trackpoints deleted.');
DEFINE('_TRC_GPX_DELETED','%1% GPX files deleted.');
DEFINE('_TRC_GPX_EDITED','GPX file edited.');
DEFINE('_TRC_EXPORT_AS_GPX','export as file in GPX format');

/** traces.html.php */

/** waypoints.php */
DEFINE('_WPT_EDITED','Waypoint edited.');
DEFINE('_WPT_REALLY_DELETE','Do you really want to DELETE this waypoint?<br />There\'s NO undo function!');

/** bookmark.php */
DEFINE('_BOOKM_NONE_IN_DB','No bookmarks in database available.');
DEFINE('_MENU_BOOKM_VIEW','View bookmarks');
DEFINE('_MENU_BOOKM_ADD','Add bookmark');
DEFINE('_MENU_BOOKM_DELETE','Delete bookmark');
DEFINE('_BOOKM_ADDED','Bookmark was added.');
DEFINE('_BOOKM_NO_URL','There\'s no URL for this bookmark.');
DEFINE('_BOOKM_DELETED','Bookmark was deleted.');

/** photos.php */
DEFINE('_PHOTO_NONE_IN_DB','No photos available.');
DEFINE('_PHOTO_DOES_NOT_EXIST','This photo file does not exist!');
DEFINE('_PHOTO_NO_PHP_GD2_EXT','PHP GD extension is not installed!');
DEFINE('_PHOTO_IPTC_TITLE','IPTC field "title"');
DEFINE('_PHOTO_IPTC_DESC','IPTC field "description"');
DEFINE('_PHOTO_TIME_OFFSET','Time offset');
DEFINE('_PHOTO_TIME_OFFSET_MAN','Time offset [GPS - camera] in seconds');
DEFINE('_PHOTO_LOCATION_FROM_EXIF','Location read from EXIF header: ');
DEFINE('_PHOTO_LOCATION_FROM_TRKPT','Location read from GPX: ');
DEFINE('_PHOTO_NO_LOCATION','No shooting location found!');
DEFINE('_PHOTO_NO_EXIF','No GPS information found in EXIF header!');
DEFINE('_PHOTO_NO_VALID_JPG','Not a valid JPEG file!');
DEFINE('_PHOTO_REALLY_DELETE','Do you really want to DELETE this photo file?<br />There\'s NO undo function!');
DEFINE('_PHOTO_DELETED','Photo was deleted.');

/** import.php */
DEFINE('_IMPORT_NO_AJAX','Your browser doesn\'t support AJAX!');
DEFINE('_IMPORT_PHP_ERROR','Sorry, this should not happen! You might want to submit a bug report and include the following lines:');
DEFINE('_IMPORT_FILE_ERROR','File open error!');
DEFINE('_IMPORT_COPY_FAILED','Copying this file to destination folder failed!');
DEFINE('_IMPORT_FAILED','Import failed!');
DEFINE('_IMPORT_SUCCESS','Import successful.');

/** database.php */
DEFINE('_DB_GPX_AVAILABLE',' GPX files found in database.');
DEFINE('_DB_WPTS_AVAILABLE',' waypoints found in database.');
DEFINE('_DB_TRKPTS_AVAILABLE',' trackpoints found in database.');
DEFINE('_DB_DAYS_AVAILABLE',' days found in database.');
DEFINE('_DB_BOOKM_AVAILABLE',' bookmarks found in database.');
DEFINE('_DB_PHOTOS_AVAILABLE',' photos found in database.');
DEFINE('_DB_PHOTOS_SIZE',' total size of photo files.');
DEFINE('_DB_GPX_SIZE',' total size of GPX files.');
DEFINE('_DB_TOTAL_DISTANCE',' total distance');

/** about.php */
DEFINE('_ABOUT_CREDITS','Credits');
DEFINE('_ABOUT_LICENSE','License');
DEFINE('_UPDATE_CHECK_DISABLED','Check for updates has been disabled.');
DEFINE('_UPDATE_AVAIL','An update of this software is available.');
DEFINE('_NO_UPDATE_AVAIL','No update available.');
DEFINE('_UPDATE_SERVER_ERROR404','The update server returned error 404 (Document not found).');
DEFINE('_UPDATE_SERVER_CONN_ERROR','Connection to update server failed.');

/** map.php */
DEFINE('_MAP_CURRENT_AREA',' (of current map area)');
#DEFINE('_MAP_AREA_TRKPT','view all trackpoints of current map area');
DEFINE('_MAP_JOSM_EDIT','edit with JOSM');
DEFINE('_MAP_ADD_BOOKM','create bookmark');
DEFINE('_MAP_JS_BOOKM_NAME','Name of the bookmark: ');

/** graph.php */
DEFINE('_CHART_ELEVATION_TITLE', 'Elevation chart');
DEFINE('_CHART_AXIS_ELE', 'elevation');
DEFINE('_CHART_AXIS_SPEED', 'speed');
DEFINE('_CHART_AXIS_TIME', 'time');
DEFINE('_CHART_AXIS_DIST', 'distance');

// DO NOT edit anything below this line!
include(_PATH ."version.inc.php");
?>

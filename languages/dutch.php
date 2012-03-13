<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009-2012 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_VALID_OSM') or die('Beperkte toegang');


DEFINE('_LANGUAGE','nl');
DEFINE('_TRANSLATOR_NAME', 'Leon Vrancken');
DEFINE('_TRANSLATOR_EMAIL', 'lvrancken@gmail.com');

// Site page note found
DEFINE('_404', 'Het spijt ons maar de door u opgevraagde pagina kan niet worden gevonden.');
DEFINE('_404_RTS', 'Terug naar de site');

// common
DEFINE('_APP_NAME','phpMyGPX-fosm');
DEFINE('_HTML_TITLE','phpMyGPX-fosm ::: Trackpoint-beheer');

DEFINE('_DATE_FORMAT_LC',"%d.%m.%Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d. %B %Y %H:%M");
DEFINE('_DATE_FORMAT_LC3',"%d.%m.%Y %H:%M:%S");
DEFINE('_TIME_FORMAT_LC4',"%H:%M:%S h");

DEFINE('_NOT_AUTH','U bent niet gemachtigd om deze informatie te bekijken.');
DEFINE('_DO_LOGIN','U moet zich aanmelden.');
DEFINE('_VALID_AZ09',"Geef een geldig %s. Geen spaties, minstens %d tekens en gebruik enkel 0-9,a-z,A-Z.");
DEFINE('_CMN_YES','Ja');
DEFINE('_CMN_NO','Neen');
DEFINE('_CMN_SHOW','Tonen');
DEFINE('_CMN_HIDE','Verbergen');

DEFINE('_CMN_NAME','Naam');
DEFINE('_CMN_DESCRIPTION','Omschrijving');
DEFINE('_CMN_SAVE','Bewaren');
DEFINE('_CMN_APPLY','Toepassen');
DEFINE('_CMN_CANCEL','Annuleren');
DEFINE('_CMN_PRINT','Afdrukken');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','E-mail');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Bovenliggend');
DEFINE('_CMN_ORDERING','Volgorde');
DEFINE('_CMN_ACCESS','Toegangsniveau');
DEFINE('_CMN_SELECT','Selecteren');
DEFINE('_CMN_SELECT_ALL','Alles selecteren');
DEFINE('_CMN_STATUS','Status');
DEFINE('_CMN_SEARCH_RESULTS','%1% zoekresultaten:');

DEFINE('_CMN_FIRST','Eerste');
DEFINE('_CMN_LAST','Laatste');
DEFINE('_CMN_NEXT','Volgende');
DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Vorige');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','Ongesorteerd');
DEFINE('_CMN_SORT_ASC','Oplopend sorteren');
DEFINE('_CMN_SORT_DESC','Aflopend sorteren');

DEFINE('_CMN_NEW','Nieuw');
DEFINE('_CMN_NONE','Niets');
DEFINE('_CMN_LEFT','Links');
DEFINE('_CMN_RIGHT','Rechts');
DEFINE('_CMN_CENTER','Midden');
DEFINE('_CMN_TOP','Boven');
DEFINE('_CMN_BOTTOM','Onder');
DEFINE('_CMN_FROM',' van ');
DEFINE('_CMN_TO',' tot ');

DEFINE('_CMN_DELETE','Verwijderen');

DEFINE('_CMN_FOLDER','Map');
DEFINE('_CMN_SUBFOLDER','Onderliggende map');
DEFINE('_CMN_WRITABLE','Schrijfrechten OK');
DEFINE('_CMN_NOT_WRITABLE','Geen schrijfrechten');
DEFINE('_CMN_AVAILABLE','Beschikbaar');
DEFINE('_CMN_MISSING','Ontbreekt');
DEFINE('_CMN_OPTIONAL','Optioneel');
DEFINE('_CMN_REQUIRED','Vereist');


DEFINE('_CMN_SCRIPT_EXEC_TIME','Pagina gegenereerd in ');
DEFINE('_CMN_MOUSEOVER_FOR_TOOLTIP','Plaats de muisaanwijzer op het invoerveld voor een hint.');
DEFINE('_CMN_NOT_IMPLEMENTED','Deze functie is nog niet ge&iuml;mplementeerd.');
DEFINE('_CMN_BACK','Terug');
DEFINE('_CMN_CONTINUE','Verder');
DEFINE('_CMN_WARNING','Opgelet!');
DEFINE('_CMN_PAGE','Pagina');
DEFINE('_CMN_BATCH','Bulkverwerking');
DEFINE('_CMN_SINGLE_FILE','Enkel bestand');
DEFINE('_CMN_MAX_FILE_SIZE','maximum file size: ');
DEFINE('_CMN_NO_ITEM_SELECTED','No item selected!');
DEFINE('_CMN_COPY_DATE','Copy date');
DEFINE('_CMN_OTHER','ander');
DEFINE('_CMN_VIEW','Bekijken');
DEFINE('_CMN_VIEW_SIMPLE','eenvoudig');
DEFINE('_CMN_VIEW_DETAIL','gedetailleerd');

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
DEFINE('_CMN_LOCATION','Plaats');
DEFINE('_CMN_BBOX','Bereik (Bounding box)');
DEFINE('_CMN_RANGE','Bereik');
DEFINE('_CMN_INSERTED','ingevoerd');
DEFINE('_CMN_PUBLIC','openbaar');
DEFINE('_CMN_VISIBLE','zichtbaar');
DEFINE('_CMN_TITLE','Titel');
DEFINE('_CMN_ICON','Icon');
DEFINE('_CMN_THUMB','Miniatuur');
DEFINE('_CMN_PHOTO_ID','Foto-ID');
DEFINE('_CMN_USER_ID','Gebruikers-ID');
DEFINE('_CMN_GPX_ID','GPX-ID');
DEFINE('_CMN_BM_ID','Bw.-ID');
DEFINE('_CMN_BM_NAME','Bladwijzernaam');
DEFINE('_CMN_FILE_NAME','Bestandsnaam');
DEFINE('_CMN_FILE_SIZE','Bestandsgrootte');
DEFINE('_CMN_LENGTH','Lengte');
DEFINE('_CMN_COMMENT','Opmerkingen');
DEFINE('_CMN_DATE','Datum');
DEFINE('_CMN_ZOOM','Zoom-niveau');
DEFINE('_CMN_LAT','Breedtegraad');
DEFINE('_CMN_LON','Lengtegraad');
DEFINE('_CMN_ALT','Hoogte');
DEFINE('_CMN_VIEW_DIR','Viewing direction');
DEFINE('_CMN_MOVE_DIR','Moving direction');
DEFINE('_CMN_COURSE','Koers');
DEFINE('_CMN_SPEED','Snelheid');
DEFINE('_CMN_FIX','Sat-Fix');
DEFINE('_CMN_SAT','Satellieten');
DEFINE('_CMN_HDOP','HDOP');
DEFINE('_CMN_PDOP','PDOP');


/** installation */
DEFINE('_INST_OSM_SETUP','phpMyGPX-fosm-Setup: ');
DEFINE('_INST_WELCOME','Welkom');
DEFINE('_INST_CHECKS','Omgevingscontrole');
DEFINE('_INST_CONFIG','Configuratie');
DEFINE('_INST_DB_INST','Database-installatie');
DEFINE('_INST_DONE','Installatie voltooid');

DEFINE('_INST_GUIDED','U wordt begeleid bij alle stappen van het installatieproces. Volg deze instructies.');
DEFINE('_INST_MAN_LOGIN','Indien u <b>root toegang</b> heeft op uw database, geef dan hieronder het paswoord in.<br>
Uit veiligheidsoverwegingen wordt er tijdens deze installatieprocedure een gebruiker met minder toegangsrechten aangemaakt. Deze login moet achteraf in het configuratiebestand ingegeven worden.<br><br>
Indien uw database <b>"shared hosted"</b> is, dan hebt u waarschijnlijk maar 1 gebruikersaccount. In dit geval gebruikt u de gegevens van dit account voor <b>zowel</b> het configuratiebestand <b>alsook</b> voor dit installatiescript.');

DEFINE('_INST_DB_ACCOUNT','Toegangsgegevens MySQL-database ');
DEFINE('_INST_DB_HOST','Host-naam');
DEFINE('_INST_DB_NAME','Database-naam');
DEFINE('_INST_DB_TABLE_PREFIX','Tabelnaam-prefix');
DEFINE('_INST_DB_USER','Gebruikersnaam');
DEFINE('_INST_DB_PASSWORD','Paswoord');
DEFINE('_INST_DB_ROOT_ACCOUNT','Root-accountgegevens voor MySQL ');
DEFINE('_INST_DB_ROOT_ACCOUNT_MAN','Indien u <b>root toegang</b> heeft op uw database, geef dan hieronder het paswoord in, anderszijds laat u het veld leeg.<br>
Uit veiligheidsoverwegingen wordt er tijdens deze installatieprocedure een gebruiker met minder toegangsrechten aangemaakt.');
DEFINE('_INST_DB_ROOT','Root-naam');
DEFINE('_INST_DB_ROOTPASS','Root-paswoord');
DEFINE('_INST_CFG_ADMIN_ACCESS','Admin-toegang');
DEFINE('_INST_CFG_ADMIN_ACCESS_MAN','Indien u een publieke server heeft, vink dan dit vakje aan en geef een administratie-paswoord!');
DEFINE('_INST_CFG_PUBLIC_HOST','Publieke server');
DEFINE('_INST_CFG_ADMIN_PASSWORD','Admin-paswoord');
DEFINE('_INST_CFG_NEARMAP_ACCESS','NearMap access');	//Untranslated!!
DEFINE('_INST_CFG_NEARMAP_ACCESS_MAN','Do you wish to enable access to NearMap photomap layers?<br>You will need to provide the authentication details below in order to use them:');	//Untranslated!!
DEFINE('_INST_CFG_NEARMAP_SUPPORT','Enable NearMap layers?');	//Untranslated!!
DEFINE('_INST_CFG_NEARMAP_USER','NearMap user ID');	//Untranslated!!
DEFINE('_INST_CFG_NEARMAP_PWD','NearMap password');	//Untranslated!!
DEFINE('_INST_CFG_HOME_LOCATION','Startpunt');
DEFINE('_INST_CFG_HOME_LOCATION_MAN','Kies de standaard startcoordinaten van uw kaart door de uitsnede hiernaast te verschuiven en in te zoomen.');

DEFINE('_INST_LANGUAGE','Taal');
DEFINE('_INST_LANGUAGE_CHOOSE','Kies uw voorkeurtaal aub.');
DEFINE('_INST_LOCALE','en_US');	     //Untranslated!!
DEFINE('_INST_MODE','Installatiemethode');
DEFINE('_INST_MODE_NEW','Nieuwe installatie');
DEFINE('_INST_MODE_UPGR3','Upgrade naar versie 0.3');
DEFINE('_INST_MODE_UPGR_LATEST','Upgrade naar laatste versie');
DEFINE('_INST_MODE_NEW_DESC',' (Database en tabellen worden gecre&euml;erd indien onbestaand.)');
DEFINE('_INST_MODE_UPGR3_DESC',' (bestaande tabellen worden aangepast en ontbrekende gecre&euml;erd)');
DEFINE('_INST_PROG_CHECKS','Map-toegangsrechten en servervaardigheden worden nu getest...');
DEFINE('_INST_PROG_PHOTOS_DISABLED','Photo features are disabled because of missing EXIF and mbstring extensions.');
DEFINE('_INST_PROG_CHECKED','Alle testen werden succesvol uitgevoerd.');
DEFINE('_INST_PROG_CONFIG_FOUND','Een bestaand configuratiebestand werd gevonden waarvan de instellingen werden overgenomen.');
DEFINE('_INST_PROG_CONFIG_UPDATED','Het configuratiebestand werd aangepast en bewaard.');
DEFINE('_INST_DB_CREATE_SETUP','Database cre&euml;ren en instellen ');
DEFINE('_INST_PROG_INST','Uw MySQL-database en alle tabellen worden nu gecre&euml;erd...');
DEFINE('_INST_DB_CONN_ERROR','Verbinding maken met database-server is mislukt. ');
DEFINE('_INST_CREATE_USER','Operational database user created. '); //Untranslated!!
DEFINE('_INST_UPGR3_ADD_BOOKM_TBL','Bladwijzer-tabel werd gecre&euml;erd.');
DEFINE('_INST_UPGR3_ADD_WAYPTS_TBL','Waypoints-tabel werd gecre&euml;erd.');
DEFINE('_INST_UPGR5_ADD_POIS_TBL','Tabel voor POIs/foto\'s werd gecre&euml;erd.');
DEFINE('_INST_PROG_DB','Database werd gecre&euml;erd.');
DEFINE('_INST_USER_ACCESS','Operational user access granted. '); //Untranslated!!
DEFINE('_INST_PROG_RENAMED','Uit veiligheidsoverwegingen werd de installatiemap hernoemd.');
DEFINE('_INST_PROG_RENAME_ERROR','Verwijder de installatiemap omwille van veiligheidsredenen!');
DEFINE('_INST_PROG_DONE','<b>PROFICIAT!</b> U heeft de toepassing succesvol ge&iuml;nstalleerd!');
DEFINE('_INST_PROG_TEST','De afsluitende test werd succesvol uitgevoerd.');
DEFINE('_INST_ERROR','Er is een fout opgetreden. Probeer het probleem op te lossen en herlaadt dit script!');
DEFINE('_INST_DB_ERROR','Ongeldige query: ');
DEFINE('_INST_DB_STAT','Database-statistiek ');

/** html.classes.php */
DEFINE('_MENU_GPX','GPX-bestand');
DEFINE('_MENU_GPX_VIEW','GPX bekijken');
DEFINE('_MENU_GPX_DETAILS','GPX details');
DEFINE('_MENU_GPX_IMAGE','Beeld');
DEFINE('_MENU_GPX_UPL','GPX uploaden');
DEFINE('_MENU_GPX_BATCH_IMPORT','GPX importeren in bulk');
DEFINE('_MENU_GPX_IMPORT','GPX importeren');
DEFINE('_MENU_GPX_EXPORT','GPX exporteren');
DEFINE('_MENU_GPX_DOWNL','GPX downloaden');
DEFINE('_MENU_GPX_EDIT','GPX bewerken');
DEFINE('_MENU_GPX_DELETE','GPX verwijderen');
DEFINE('_MENU_GPX_SEARCH','GPX zoeken');
DEFINE('_MENU_TRC_EDIT','Edit Trace Description'); //Untranslated!!
DEFINE('_MENU_TRKPT','Trackpoints');
DEFINE('_MENU_TRKPT_VIEW','Trackpoints bekijken');
DEFINE('_MENU_TRKPT_SEARCH','Trackpoints zoeken');
DEFINE('_MENU_WPT','Waypoints');
DEFINE('_MENU_WPT_VIEW','Waypoints bekijken');
DEFINE('_MENU_WPT_EDIT','Waypoint bewerken');
DEFINE('_MENU_WPT_SAVE','save Waypoint');	//Untranslated!!
DEFINE('_MENU_WPT_DELETE','Waypoint verwijderen');
DEFINE('_MENU_WPT_SEARCH','Waypoints zoeken');
DEFINE('_MENU_PHOTO','Foto');
DEFINE('_MENU_PHOTO_VIEW','Bekijk foto\'s');
DEFINE('_MENU_PHOTO_DETAILS','Fotodetails');
DEFINE('_MENU_PHOTO_UPL','Upload foto\'s');
DEFINE('_MENU_PHOTO_BATCH_IMPORT','Foto\'s importeren in bulk');
DEFINE('_MENU_PHOTO_IMPORT','Foto\'s importeren');
DEFINE('_MENU_PHOTO_DELETE','Foto\'s verwijderen');
DEFINE('_MENU_VIEW','bekijken');
DEFINE('_MENU_UPL','uploaden');
DEFINE('_MENU_SEARCH','zoeken');
DEFINE('_MENU_NEW','nieuw');

DEFINE('_MENU_HOME','Home');
DEFINE('_MENU_ABOUT','Info...');
DEFINE('_MENU_UPDATE','Update...');	// Untranslated!!
DEFINE('_MENU_BOOKMARK','Bladwijzers');
DEFINE('_MENU_MAP','Kaart');
DEFINE('_MENU_MISC','Extra');
DEFINE('_MENU_DB','Database');
DEFINE('_MENU_DB_STAT','Statistiek');
DEFINE('_MENU_LOGIN','AANMELDEN');
DEFINE('_MENU_LOGOUT','AFMELDEN');

/** index.php */
DEFINE('_HOME_WELCOME_TO','Welkom bij ');
DEFINE('_HOME_INTRO','To do: Intro');
DEFINE('_LOGIN_FAILED','Login-fout. Het paswoord is niet correct.');
DEFINE('_LOGIN_SUCCESS','U bent succesvol aangemeld.');
DEFINE('_LOGOUT_SUCCESS','U bent succesvol afgemeld.');
DEFINE('_LOGIN_DESCRIPTION','Om toegang te krijgen tot het administratieve gedeelte van deze site moet u zich aanmelden:');

/** traces.php */
DEFINE('_TRC_NO_WPTS_IN_DB','Er zijn geen waypoints in de database aanwezig.');
DEFINE('_TRC_NO_TRKPTS_IN_DB','Er zijn geen trackpoints in de database aanwezig.');
DEFINE('_TRC_NO_GPX_IN_DB','Er zijn geen GPX-bestanden in de database aanwezig.');
DEFINE('_TRC_GPX_DOES_NOT_EXIST','Dit GPX-bestand bestaat niet!');
DEFINE('_TRC_DETAILS_OF_GPX','Statistische details voor GPX-bestand nr. ');
DEFINE('_TRC_APPROX_DIST','Afstand ca.');
DEFINE('_TRC_TRIP_TIME','Totale trajecttijd');
DEFINE('_TRC_AVG_SPEED','Gemiddelde snelheid');
DEFINE('_TRC_TRACK','Traject ');
DEFINE('_TRC_HALT','Pauze: ');
DEFINE('_TRC_TOTAL','Totaal');
DEFINE('_TRC_DETAILS_CHART_SPLIT','De hoogtegrafiek werd wegens trajectpauzes onderverdeeld:');
DEFINE('_TRC_SHOW_MAP','Toon kaart');
DEFINE('_TRC_SHOW_OSM_MAP','Toon OSM-kaart');
DEFINE('_TRC_SHOW_ITEMS_ON_MAP','Show selected items on map');
DEFINE('_TRC_USE_DP_FOR_SEARCH','Gebruik een punt als decimaalteken.');
DEFINE('_TRC_SEARCH_PARAMS_LOGIC_AND','De zoekparameters worden middels een logische EN-relatie met elkaar gecombineerd.');
DEFINE('_TRC_CHOOSE_SEARCH_FILTER','Geef een zoekbegrip in: ');
DEFINE('_TRC_CHOOSE_UPL_FILE','Kies een uploadbestand: ');
DEFINE('_TRC_BATCH_IMPORT_INFO','Voor het importeren in bulk dient u uw bestanden (via FTP) naar de "/upload/"-map te kopi&euml;ren.');
DEFINE('_TRC_BATCH_IMPORTING_DIR','Bestanden worden uit deze map ge&iuml;mporteerd: <i>"%1%"</i>');
DEFINE('_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING','Selecteer de bestanden voor importeren in bulk: ');
DEFINE('_TRC_START_IMPORT','Start importeren in bulk');
DEFINE('_TRC_WAIT_WHILE_IMPORTING','Even geduld aub, de bestanden worden ge&iuml;mporteerd: ');
DEFINE('_TRC_IMPORT_DONE','Importeren is klaar.');
DEFINE('_TRC_MAY_TAKE_SECONDS','Dit kan enkele seconden duren.');
DEFINE('_TRC_UPL_ERROR','Fout tijdens het uploaden: ');
DEFINE('_TRC_UPL_SUCCESS','Bestand werd succesvol ge&uuml;ploaded: ');
DEFINE('_TRC_READING_FILE','Lees bestand "<i>%1%</i>"...');
DEFINE('_TRC_NO_VALID_XML','Sorry, dit is geen geldig XML-formaat!');
DEFINE('_TRC_MISS_TIMESTAMP','Dit GPX-bestand kan wegens een ontbrekende tijdstempel niet ge&iuml;mporteerd worden!');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Bestandsnaam moeten uniek zijn! Werd dit bestand reeds ge&iuml;mporteerd?');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Tijdstempels moeten uniek zijn! Werd dit bestand reeds ge&iuml;mporteerd?');
DEFINE('_TRC_NO_PHP_DOM_EXT','De PHP DOM uitbreiding is niet ge&iuml;nstalleerd!');
DEFINE('_TRC_WPTS_PROCESSED',' waypoints werden verwerkt.');
DEFINE('_TRC_TRKPTS_PROCESSED',' trackpoints werden verwerkt.');
DEFINE('_TRC_REALLY_DELETE','Wilt u echt het GPX-bestand inclusief alle trackpoints verwijderen?<br />Er is geen herstelprocedure!');
DEFINE('_TRC_CONFIRM_DELETE','Typ "Ja" om het verwijderen te bevestigen.');
DEFINE('_TRC_NO_CONFIRM_DELETE','U hebt niets verwijderd.');
DEFINE('_TRC_WPT_DELETED','%1% waypoints werden verwijderd.');
DEFINE('_TRC_TRKPT_DELETED','%1% trackpoints werden verwijderd.');
DEFINE('_TRC_GPX_DELETED','%1% GPX-bestand werd verwijderd.');
DEFINE('_TRC_GPX_EDITED','GPX-bestand werd bewerkt.');
DEFINE('_TRC_EXPORT_AS_GPX','als GPX-bestand exporteren');

/** traces.html.php */

/** waypoints.php */
DEFINE('_WPT_EDITED','Waypoint werd bewerkt.');
DEFINE('_WPT_REALLY_DELETE','Wilt u echt dit waypoint verwijderen?<br />Er is geen herstelprocedure!');

/** bookmark.php */
DEFINE('_BOOKM_NONE_IN_DB','Geen bladwijzers in database voorhanden.');
DEFINE('_MENU_BOOKM_VIEW','Bladwijzers tonen');
DEFINE('_MENU_BOOKM_ADD','Bladwijzers toevoegen');
DEFINE('_MENU_BOOKM_DELETE','Bladwijzers verwijderen');
DEFINE('_BOOKM_ADDED','Bladwijzers werden toegevoegd.');
DEFINE('_BOOKM_NO_URL','Er is geen URL voor deze bladwijzer ingevuld.');
DEFINE('_BOOKM_DELETED','Bladwijzer verwijderd.');

/** photos.php */
DEFINE('_PHOTO_NONE_IN_DB','Geen foto\'s in database voorhanden.');
DEFINE('_PHOTO_DOES_NOT_EXIST','Dit foto-bestand bestaat niet!');
DEFINE('_PHOTO_NO_PHP_GD2_EXT','PHP GD uitbreiding is niet ge&iuml;nstalleerd!');
DEFINE('_PHOTO_IPTC_TITLE','IPTC-veld "titel"');
DEFINE('_PHOTO_IPTC_DESC','IPTC-veld "omschrijving"');
DEFINE('_PHOTO_TIME_OFFSET','Time offset');
DEFINE('_PHOTO_TIME_OFFSET_MAN','Time offset [GPS - camera] in seconds');
DEFINE('_PHOTO_LOCATION_FROM_EXIF','Location read from EXIF header: ');
DEFINE('_PHOTO_LOCATION_FROM_TRKPT','Location read from GPX: ');
DEFINE('_PHOTO_NO_LOCATION','No shooting location found!');
DEFINE('_PHOTO_NO_EXIF','Er werd geen GPS-informatie in de EXIF-header gevonden!');
DEFINE('_PHOTO_NO_VALID_JPG','Geen geldig JPEG-bestand!');
DEFINE('_PHOTO_REALLY_DELETE','Wilt u echt dit fotobestand verwijderen?<br />Er is geen herstelprocedure!');
DEFINE('_PHOTO_DELETED','Foto verwijderd.');

/** import.php */
DEFINE('_IMPORT_NO_AJAX','Uw browser ondersteunt geen AJAX!');
DEFINE('_IMPORT_PHP_ERROR','Sorry, this should not happen! You might want to submit a bug report and include the following lines:');
DEFINE('_IMPORT_FILE_ERROR','Bestand kan niet geopend worden!');
DEFINE('_IMPORT_COPY_FAILED','Het kopi&euml;ren van dit bestand is mislukt!');
DEFINE('_IMPORT_FAILED','Importeren van dit bestand is mislukt!');
DEFINE('_IMPORT_SUCCESS','Importeren van dit bestand is gelukt.');

/** database.php */
DEFINE('_DB_GPX_AVAILABLE',' GPX-bestanden gevonden in database.');
DEFINE('_DB_WPTS_AVAILABLE',' waypoints gevonden in database.');
DEFINE('_DB_TRKPTS_AVAILABLE',' trackpoints gevonden in database.');
DEFINE('_DB_DAYS_AVAILABLE',' dagen gevonden in database.');
DEFINE('_DB_BOOKM_AVAILABLE',' bladwijzers gevonden in database.');
DEFINE('_DB_PHOTOS_AVAILABLE',' foto\'s gevonden in database.');
DEFINE('_DB_PHOTOS_SIZE',' totale omvang van alle fotobestanden.');
DEFINE('_DB_GPX_SIZE',' totale omvang van alle GPX-bestanden.');
DEFINE('_DB_TOTAL_DISTANCE',' totale trajectlengte');

/** about.php */
DEFINE('_ABOUT_CREDITS','Dankbetuigingen');
DEFINE('_ABOUT_LICENSE','Licentie');
DEFINE('_UPDATE_CHECK_DISABLED','Controleren op updates is uitgeschakeld.');
DEFINE('_UPDATE_AVAIL','Er is een update van deze software beschikbaar: ');
DEFINE('_NO_UPDATE_AVAIL','Er is geen update beschikbaar.');
DEFINE('_BASED_ON','Based upon:');	//Untranslated!!
DEFINE('_UNFORKED_APP_NAME','phpMyGPX');
DEFINE('_UNFORKED_APP_CURRENCY','<em>Base package currency:</em>'); // Untranslated!!
DEFINE('_NO_UNFORKED_UPDATE_AVAIL','Base phpMyGPX unchanged.'); // Untranslated!!
DEFINE('_UNFORKED_UPDATE_AVAIL','A new base phpMyGPX is available: '); // Untranslated!!
DEFINE('_PROCEED_WITH_UPDATE','Proceed with update?'); // Untranslated!!
DEFINE('_UPDATE_SERVER_ERROR404','De update-server antwoordt met foutcode 404 (Document niet gevonden).');
DEFINE('_UPDATE_SERVER_CONN_ERROR','Verbinding met de update-server is mislukt.');

/** map.php */
DEFINE('_MAP_CURRENT_AREA',' (van huidige kaart)');
#DEFINE('_MAP_AREA_TRKPT','Toon alle trackpoints van huidige kaart');
DEFINE('_MAP_JOSM_EDIT','Met JOSM editeren');
DEFINE('_MAP_ADD_BOOKM','Bladwijzers cre&euml;ren');
DEFINE('_MAP_JS_BOOKM_NAME','Bladwijzernaam: ');

/** graph.php */
DEFINE('_CHART_ELEVATION_TITLE', 'Hoogtegrafiek');
DEFINE('_CHART_AXIS_ELE', 'Hoogte');
DEFINE('_CHART_AXIS_SPEED', 'Snelheid');
DEFINE('_CHART_AXIS_TIME', 'Tijd');
DEFINE('_CHART_AXIS_DIST', 'Afstand');

// DO NOT edit anything below this line!
include(_PATH ."version.inc.php");
?>

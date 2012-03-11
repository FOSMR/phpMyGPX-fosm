<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009-2012 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_VALID_OSM') or die('Beschr&auml;nkter Zugang.');


DEFINE('_LANGUAGE','de');
DEFINE('_TRANSLATOR_NAME', 'Sebastian Klemm');
DEFINE('_TRANSLATOR_EMAIL', 'osm@erlkoenigkabale.eu');

// Site page note found
DEFINE('_404', 'Die angefragte Seite konnte nicht gefunden werden.');
DEFINE('_404_RTS', 'Zur&uuml;ck zur Site');

// common
DEFINE('_APP_NAME','phpMyGPX-fosm');
DEFINE('_HTML_TITLE','phpMyGPX-fosm ::: Trackpoint-Verwaltung');

DEFINE('_DATE_FORMAT_LC',"%d.%m.%Y"); //Verwendet das PHP strftime Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d. %B %Y %H:%M");
DEFINE('_DATE_FORMAT_LC3',"%d.%m.%Y %H:%M:%S");
DEFINE('_TIME_FORMAT_LC4',"%H:%M:%S h");

DEFINE('_NOT_AUTH','Du bist nicht berechtigt, diesen Bereich zu sehen.');
DEFINE('_DO_LOGIN','Du musst dich anmelden.');
DEFINE('_VALID_AZ09','%1% ist nicht zul&auml;ssig. Bitte keine Leerzeichen, mindestens %2% Stellen, 0-9,a-z,A-Z k&ouml;nnen enthalten sein.');
DEFINE('_CMN_YES','Ja');
DEFINE('_CMN_NO','Nein');
DEFINE('_CMN_SHOW','Anzeigen');
DEFINE('_CMN_HIDE','Verstecken');

DEFINE('_CMN_NAME','Name');
DEFINE('_CMN_DESCRIPTION','Beschreibung');
DEFINE('_CMN_SAVE','Speichern');
DEFINE('_CMN_APPLY','Anwenden');
DEFINE('_CMN_CANCEL','Abbrechen');
DEFINE('_CMN_PRINT','Drucken');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','E-Mail');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','&Uuml;bergeordnetes(r)');
DEFINE('_CMN_ORDERING','Reihenfolge');
DEFINE('_CMN_ACCESS','Zugriffslevel');
DEFINE('_CMN_SELECT','Ausw&auml;hlen');
DEFINE('_CMN_SELECT_ALL','Alle ausw&auml;hlen');
DEFINE('_CMN_STATUS','Status');
DEFINE('_CMN_SEARCH_RESULTS','%1% Suchergebnisse:');

DEFINE('_CMN_FIRST','Erste');
DEFINE('_CMN_LAST','Letzte');
DEFINE('_CMN_NEXT','N&auml;chste');
DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Vorherige');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','Nicht sortieren');
DEFINE('_CMN_SORT_ASC','Aufsteigend sortieren');
DEFINE('_CMN_SORT_DESC','Absteigend sortieren');

DEFINE('_CMN_NEW','Neu');
DEFINE('_CMN_NONE','Nichts');
DEFINE('_CMN_LEFT','Links');
DEFINE('_CMN_RIGHT','Rechts');
DEFINE('_CMN_CENTER','Mitte');
DEFINE('_CMN_TOP','Oben');
DEFINE('_CMN_BOTTOM','Unten');
DEFINE('_CMN_FROM',' von ');
DEFINE('_CMN_TO',' bis ');

DEFINE('_CMN_DELETE','L&ouml;schen');

DEFINE('_CMN_FOLDER','Verzeichnis');
DEFINE('_CMN_SUBFOLDER','Unterverzeichnis');
DEFINE('_CMN_WRITABLE','Schreibrechte vorhanden');
DEFINE('_CMN_NOT_WRITABLE','Keine Schreibrechte');
DEFINE('_CMN_AVAILABLE','Vorhanden');
DEFINE('_CMN_MISSING','Fehlt');
DEFINE('_CMN_OPTIONAL','Optional');
DEFINE('_CMN_REQUIRED','Pflichtfeld');


DEFINE('_CMN_SCRIPT_EXEC_TIME','Seite generiert in ');
DEFINE('_CMN_MOUSEOVER_FOR_TOOLTIP','F&uuml;r weitere Hilfe positionieren Sie den Mauszeiger &uuml;ber einem Eingabefeld.');
DEFINE('_CMN_NOT_IMPLEMENTED','Diese Funktion ist noch nicht implementiert.');
DEFINE('_CMN_BACK','Zur&uuml;ck');
DEFINE('_CMN_CONTINUE','Weiter');
DEFINE('_CMN_WARNING','Warnung!');
DEFINE('_CMN_PAGE','Seite');
DEFINE('_CMN_BATCH','Stapelverarbeitung');
DEFINE('_CMN_SINGLE_FILE','Einzelne Datei');
DEFINE('_CMN_MAX_FILE_SIZE','maximale Dateigr&ouml;&szlig;e: ');
DEFINE('_CMN_NO_ITEM_SELECTED','Es wurde kein Element ausgewählt!');
DEFINE('_CMN_COPY_DATE','Datum &uuml;bernehmen');
DEFINE('_CMN_OTHER','andere');
DEFINE('_CMN_VIEW','Ansicht');
DEFINE('_CMN_VIEW_SIMPLE','einfach');
DEFINE('_CMN_VIEW_DETAIL','ausf&uuml;hrlich');

// error descriptions taken from http://de.php.net/manual/de/features.file-upload.errors.php
DEFINE('_CMN_UPLOAD_ERR_SIZE','Die hochgeladene Datei überschreitet die maximale Dateigr&ouml;&szlig;e.');
DEFINE('_CMN_UPLOAD_ERR_PARTIAL','Die Datei wurde nur teilweise hochgeladen.');
DEFINE('_CMN_UPLOAD_ERR_NO_FILE','Es wurde keine Datei hochgeladen.');
DEFINE('_CMN_UPLOAD_ERR_NO_TMP_DIR','Fehlendes tempor&auml;res Verzeichnis.');
DEFINE('_CMN_UPLOAD_ERR_CANT_WRITE','Konnte Datei nicht schreiben.');

// database related errors, taken from PHP manual
DEFINE('_CMN_DB_CONNECT_ERR','Keine Verbindung m&ouml;glich: ');
DEFINE('_CMN_DB_SELECT_ERR','Auswahl der Datenbank fehlgeschlagen: ');
DEFINE('_CMN_DB_QUERY_ERR','Ung&uuml;ltige Abfrage: ');

DEFINE('_CMN_GEO_TAGGING','Geo-Tagging');
DEFINE('_CMN_GEO_TAGGING_MAN','Zum automatischen Geo-Tagging muss eine GPX-Datei ausgew&auml;hlt werden.');
DEFINE('_CMN_TIMEZONE','Zeitzone');
DEFINE('_CMN_TIMEZONE_CAM','Zeitzone der Kamera-Uhr');
DEFINE('_CMN_LOCATION','Platz/Ort');
DEFINE('_CMN_BBOX','Bereich (Bounding box)');
DEFINE('_CMN_RANGE','Bereich');
DEFINE('_CMN_INSERTED','eingetragen');
DEFINE('_CMN_PUBLIC','&ouml;ffentlich');
DEFINE('_CMN_VISIBLE','sichtbar');
DEFINE('_CMN_TITLE','Titel');
DEFINE('_CMN_ICON','Symbol');
DEFINE('_CMN_THUMB','Vorschaubild');
DEFINE('_CMN_PHOTO_ID','Foto-ID');
DEFINE('_CMN_USER_ID','Benutzer-ID');
DEFINE('_CMN_GPX_ID','GPX-ID');
DEFINE('_CMN_BM_ID','Lz.-ID');
DEFINE('_CMN_BM_NAME','Lesezeichen-Name');
DEFINE('_CMN_FILE_NAME','Dateiname');
DEFINE('_CMN_FILE_SIZE','Dateigr&ouml;&szlig;e');
DEFINE('_CMN_LENGTH','L&auml;nge');
DEFINE('_CMN_COMMENT','Bemerkungen');
DEFINE('_CMN_DATE','Datum');
DEFINE('_CMN_ZOOM','Zoomstufe');
DEFINE('_CMN_LAT','Breite');
DEFINE('_CMN_LON','L&auml;nge');
DEFINE('_CMN_ALT','H&ouml;he');
DEFINE('_CMN_VIEW_DIR','Blickrichtung');
DEFINE('_CMN_MOVE_DIR','Bewegungsrichtung');
DEFINE('_CMN_COURSE','Kurs');
DEFINE('_CMN_SPEED','Geschw.');
DEFINE('_CMN_FIX','Sat-Fix');
DEFINE('_CMN_SAT','Satelliten');
DEFINE('_CMN_HDOP','HDOP');
DEFINE('_CMN_PDOP','PDOP');


/** installation */
DEFINE('_INST_OSM_SETUP','phpMyGPX-fosm-Setup: ');
DEFINE('_INST_WELCOME','Willkommen');
DEFINE('_INST_CHECKS','Umgebung &uuml;berpr&uuml;fen');
DEFINE('_INST_CONFIG','Konfiguration');
DEFINE('_INST_DB_INST','Datenbank-Installation');
DEFINE('_INST_DONE','Installation beendet');

DEFINE('_INST_GUIDED','Sie werden nun durch die einzelnen Schritte der Installation geleitet. Folgen Sie dazu einfach den gegebenen Anweisungen.');
DEFINE('_INST_MAN_LOGIN','Falls Sie einen <b>root-Zugang</b> zur Datenbank haben, geben Sie einfach dessen Passwort im Formular unten an.<br>
F&uuml;r die sp&auml;tere Nutzung wird aus Sicherheitsgr&uuml;nden ein Nutzer mit stark eingeschr&auml;nkten Rechten benutzt und w&auml;hrend der Installation eingerichtet. Dessen Zugangsdaten m&uuml;ssen in der Konfigurationsdatei eingetragen worden sein.<br><br>
Wenn Sie eine <b>"Shared-Hosting"</b>-Datenbank nutzen, haben Sie wahrscheinlich nur einen einzigen Benutzerzugang. In diesem Fall tragen Sie bitte dessen Zugangsdaten <b>sowohl</b> in der Konfigurationsdatei als <b>auch</b> auf dieser Seite im Formular unten ein.');

DEFINE('_INST_DB_ACCOUNT','Zugangsdaten f&uuml;r MySQL-Datenbank ');
DEFINE('_INST_DB_HOST','Hostname');
DEFINE('_INST_DB_NAME','Datenbankname');
DEFINE('_INST_DB_TABLE_PREFIX','Tabellennamen-Prefix');
DEFINE('_INST_DB_USER','Benutzername');
DEFINE('_INST_DB_PASSWORD','Passwort');
DEFINE('_INST_DB_ROOT_ACCOUNT','Root-Zugangsdaten f&uuml;r MySQL-Datenbank ');
DEFINE('_INST_DB_ROOT_ACCOUNT_MAN','Falls Sie einen <b>root-Zugang</b> zur Datenbank haben, geben Sie dessen Zugangsdaten hier an, andernfalls leer lassen.<br>
F&uuml;r die sp&auml;tere Nutzung wird aus Sicherheitsgr&uuml;nden ein Nutzer mit stark eingeschr&auml;nkten Rechten benutzt und w&auml;hrend der Installation eingerichtet.');
DEFINE('_INST_DB_ROOT','Root-Benutzername');
DEFINE('_INST_DB_ROOTPASS','Root-Passwort');
DEFINE('_INST_CFG_ADMIN_ACCESS','Administrations-Zugang');
DEFINE('_INST_CFG_ADMIN_ACCESS_MAN','Falls Ihr Server frei zug&auml;nglich ist, sollten Sie dies hier ankreuzen und ein Passwort f&uuml;r die Verwaltung vergeben!');
DEFINE('_INST_CFG_PUBLIC_HOST','Frei zug&auml;nglicher Server');
DEFINE('_INST_CFG_ADMIN_PASSWORD','Admin-Passwort');
DEFINE('_INST_CFG_HOME_LOCATION','Startpunkt');
DEFINE('_INST_CFG_HOME_LOCATION_MAN','Wählen Sie die Standard-Startkoordinaten der Karte durch Verschieben und Zoomen des nebenstehenden Ausschnittes.');

DEFINE('_INST_LANGUAGE','Sprache');
DEFINE('_INST_LANGUAGE_CHOOSE','Bitte w&auml;hlen Sie Ihre bevorzugte Sprache aus.');
DEFINE('_INST_LOCALE','de_DE.UTF-8');
DEFINE('_INST_MODE','Installationsmethode');
DEFINE('_INST_MODE_NEW','Neuinstallation');
DEFINE('_INST_MODE_UPGR3','Upgrade zu Version 0.3');
DEFINE('_INST_MODE_UPGR_LATEST','Upgrade auf neueste Version');
DEFINE('_INST_MODE_NEW_DESC',' (Datenbank und alle Tabellen werden neu erstellt, falls nicht vorhanden)');
DEFINE('_INST_MODE_UPGR3_DESC',' (existierende Tabellen werden angepasst bzw. fehlende erstellt)');
DEFINE('_INST_PROG_CHECKS','Es werden nun Verzeichnis-Zugriffsrechte und Server-F&auml;higkeiten gepr&uuml;ft...');
DEFINE('_INST_PROG_PHOTOS_DISABLED','Die Fotoverwaltung kann aufgrund der fehlenden EXIF und mbstring Erweiterungen nicht benutzt werden.');
DEFINE('_INST_PROG_CHECKED','Alle Tests wurden erfolgreich durchgef&uuml;hrt.');
DEFINE('_INST_PROG_CONFIG_FOUND','Eine alte Konfigurationsdatei wurde gefunden und deren Einstellungen wurden &uuml;bernommen.');
DEFINE('_INST_PROG_CONFIG_UPDATED','Die Konfigurationsdatei wurde aktualisiert und gespeichert.');
DEFINE('_INST_DB_CREATE_SETUP','Datenbank erstellen und einrichten ');
DEFINE('_INST_PROG_INST','Die MySQL-Datenbank einschlie&szlig;lich aller notwendigen Tabellen wird nun angelegt...');
DEFINE('_INST_DB_CONN_ERROR','Verbindung zum Datenbank-Server fehlgeschlagen. ');
DEFINE('_INST_CREATE_USER','Operational database user created. '); //Untranslated!!
DEFINE('_INST_UPGR3_ADD_BOOKM_TBL','Lesezeichen-Tabelle wurde erfolgreich angelegt.');
DEFINE('_INST_UPGR3_ADD_WAYPTS_TBL','Wegpunkt-Tabelle  wurde erfolgreich angelegt.');
DEFINE('_INST_UPGR5_ADD_POIS_TBL','POI/Foto-Tabelle  wurde erfolgreich angelegt.');
DEFINE('_INST_PROG_DB','Datenbank wurde erfolgreich angelegt.');
DEFINE('_INST_USER_ACCESS','Operational user access granted. '); //Untranslated!!
DEFINE('_INST_PROG_RENAMED','Installations-Verzeichnis wurde zur Sicherheit umbenannt.');
DEFINE('_INST_PROG_RENAME_ERROR','Bitte l&ouml;schen Sie aus Sicherheitsgr&uuml;nden nun unbedingt das Installations-Verzeichnis!');
DEFINE('_INST_PROG_DONE','<b>GL&Uuml;CKWUNSCH!</b> Sie haben Ihre Anwendung erfolgreich installiert!');
DEFINE('_INST_PROG_TEST','Der abschlie&szlig;ende Test wurde erfolgreich durchgef&uuml;hrt.');
DEFINE('_INST_ERROR','Es sind Fehler aufgetreten. Beheben Sie die Ursache und versuchen Sie dann erneut dieses Script aufzurufen!');
DEFINE('_INST_DB_ERROR','Ung&uuml;ltige Abfrage: ');
DEFINE('_INST_DB_STAT','Statistik f&uuml;r Datenbank ');

/** html.classes.php */
DEFINE('_MENU_GPX','GPX-Datei');
DEFINE('_MENU_GPX_VIEW','GPX ansehen');
DEFINE('_MENU_GPX_DETAILS','GPX Details');
DEFINE('_MENU_GPX_IMAGE','Bild');
DEFINE('_MENU_GPX_UPL','GPX hochladen');
DEFINE('_MENU_GPX_BATCH_IMPORT','GPX-Massenimport');
DEFINE('_MENU_GPX_IMPORT','GPX importieren');
DEFINE('_MENU_GPX_EXPORT','GPX exportieren');
DEFINE('_MENU_GPX_DOWNL','GPX herunterladen');
DEFINE('_MENU_GPX_EDIT','GPX bearbeiten');
DEFINE('_MENU_GPX_DELETE','GPX l&ouml;schen');
DEFINE('_MENU_GPX_SEARCH','GPX suchen');
DEFINE('_MENU_TRC_EDIT','Edit Trace Description'); //Untranslated!!
DEFINE('_MENU_TRKPT','Trackpunkte');
DEFINE('_MENU_TRKPT_VIEW','Trackpunkte ansehen');
DEFINE('_MENU_TRKPT_SEARCH','Trackpunkte suchen');
DEFINE('_MENU_WPT','Wegpunkte');
DEFINE('_MENU_WPT_VIEW','Wegpunkte ansehen');
DEFINE('_MENU_WPT_EDIT','Wegpunkt bearbeiten');
DEFINE('_MENU_WPT_DELETE','Wegpunkt l&ouml;schen');
DEFINE('_MENU_WPT_SEARCH','Wegpunkte suchen');
DEFINE('_MENU_PHOTO','Foto');
DEFINE('_MENU_PHOTO_VIEW','Fotos ansehen');
DEFINE('_MENU_PHOTO_DETAILS','Foto-Details');
DEFINE('_MENU_PHOTO_UPL','Fotos hochladen');
DEFINE('_MENU_PHOTO_BATCH_IMPORT','Foto-Massenimport');
DEFINE('_MENU_PHOTO_IMPORT','Fotos importieren');
DEFINE('_MENU_PHOTO_DELETE','Fotos l&ouml;schen');
DEFINE('_MENU_VIEW','ansehen');
DEFINE('_MENU_UPL','hochladen');
DEFINE('_MENU_SEARCH','suchen');
DEFINE('_MENU_NEW','neu');

DEFINE('_MENU_HOME','Startseite');
DEFINE('_MENU_ABOUT','&Uuml;ber...');
DEFINE('_MENU_UPDATE','Update...');	// Untranslated!!
DEFINE('_MENU_BOOKMARK','Lesezeichen');
DEFINE('_MENU_MAP','Karte');
DEFINE('_MENU_MISC','Extra');
DEFINE('_MENU_DB','Datenbank');
DEFINE('_MENU_DB_STAT','Statistik');
DEFINE('_MENU_LOGIN','LOGIN');
DEFINE('_MENU_LOGOUT','LOGOUT');

/** index.php */
DEFINE('_HOME_WELCOME_TO','Willkommen bei ');
DEFINE('_HOME_INTRO','To do: Intro');
DEFINE('_LOGIN_FAILED','Login fehlgeschlagen. Das Passwort ist falsch.');
DEFINE('_LOGIN_SUCCESS','Du hast dich erfolgreich angemeldet');
DEFINE('_LOGOUT_SUCCESS','Du hast dich erfolgreich abgemeldet');
DEFINE('_LOGIN_DESCRIPTION','Bitte anmelden, um auf den administrativen Bereich der Website zuzugreifen.');

/** traces.php */
DEFINE('_TRC_NO_WPTS_IN_DB','Keine Wegpunkte in Datenbank vorhanden.');
DEFINE('_TRC_NO_TRKPTS_IN_DB','Keine Trackpunkte in Datenbank vorhanden.');
DEFINE('_TRC_NO_GPX_IN_DB','Keine GPX-Dateien in Datenbank vorhanden.');
DEFINE('_TRC_GPX_DOES_NOT_EXIST','Diese GPX-Datei existiert nicht!');
DEFINE('_TRC_DETAILS_OF_GPX','Statistische Details f&uuml;r GPX-Datei Nr. ');
DEFINE('_TRC_APPROX_DIST','Wegl&auml;nge ca.');
DEFINE('_TRC_TRIP_TIME','Fahrzeit');
DEFINE('_TRC_AVG_SPEED','Durchschnittsgeschwindigkeit');
DEFINE('_TRC_TRACK','Abschnitt ');
DEFINE('_TRC_HALT','Pause: ');
DEFINE('_TRC_TOTAL','Gesamt');
DEFINE('_TRC_DETAILS_CHART_SPLIT','Das H&ouml;henprofil wurde wegen Pausen im Track unterteilt:');
DEFINE('_TRC_SHOW_MAP','Karte anzeigen');
DEFINE('_TRC_SHOW_OSM_MAP','OSM-Karte anzeigen');
DEFINE('_TRC_SHOW_ITEMS_ON_MAP','Ausgew&auml;hlte Elemente auf Karte zeigen');
DEFINE('_TRC_USE_DP_FOR_SEARCH','Bitte benutzen Sie einen Punkt als Dezimaltrennzeichen.');
DEFINE('_TRC_SEARCH_PARAMS_LOGIC_AND','Mehrere Suchparameter werden mittels logischem UND verkn&uuml;pft.');
DEFINE('_TRC_CHOOSE_SEARCH_FILTER','W&auml;hlen Sie passende Such-Filter aus: ');
DEFINE('_TRC_CHOOSE_UPL_FILE','W&auml;hlen Sie eine Datei zum hochladen aus: ');
DEFINE('_TRC_BATCH_IMPORT_INFO','Um mehrere Dateien zu importieren, sind diese vorher in das "/upload/" Verzeichnis des Webservers (via FTP) zu kopieren.');
DEFINE('_TRC_BATCH_IMPORTING_DIR','Dateien werden aus diesem Verzeichnis importiert: <i>"%1%"</i>');
DEFINE('_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING','Bitte die Dateien zum importieren w&auml;hlen: ');
DEFINE('_TRC_START_IMPORT','Massenimport starten');
DEFINE('_TRC_WAIT_WHILE_IMPORTING','Bitte warten während Dateien importiert werden: ');
DEFINE('_TRC_IMPORT_DONE','Import abgeschlossen.');
DEFINE('_TRC_MAY_TAKE_SECONDS','Dies kann einige Sekunden dauern.');
DEFINE('_TRC_UPL_ERROR','Fehler beim hochladen: ');
DEFINE('_TRC_UPL_SUCCESS','Datei wurde erfolgreich hochgeladen: ');
DEFINE('_TRC_READING_FILE','Lese Datei "<i>%1%</i>"...');
DEFINE('_TRC_NO_VALID_XML','Dies ist leider kein g&uuml;ltiges XML-Format!');
DEFINE('_TRC_MISS_TIMESTAMP','Diese GPX-Datei enth&auml;lt keine Zeitstempel und kann deshalb nicht importiert werden!');
DEFINE('_TRC_DUPLICATE_FILENAME','Dateinamen m&uuml;ssen einmalig sein! Wurde diese Datei bereits zuvor importiert?');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Zeitstempel m&uuml;ssen einmalig sein! Wurde diese Datei bereits zuvor importiert?');
DEFINE('_TRC_NO_PHP_DOM_EXT','Die PHP DOM Erweiterung ist nicht installiert!');
DEFINE('_TRC_WPTS_PROCESSED',' Wegpunkte wurden verarbeitet.');
DEFINE('_TRC_TRKPTS_PROCESSED',' Trackpunkte wurden verarbeitet.');
DEFINE('_TRC_REALLY_DELETE','Soll die angegebene GPX-Datei <br />einschlie&szlig;lich aller darin enthaltenen Wegpunkte<br />UNWIEDERBRINGLICH VERNICHTET werden?');
DEFINE('_TRC_CONFIRM_DELETE','Zum endg&uuml;ltigen L&ouml;schen tippen Sie unten bitte "Ja" ein.');
DEFINE('_TRC_NO_CONFIRM_DELETE','Sie haben das L&ouml;schen abgebrochen.');
DEFINE('_TRC_WPT_DELETED','%1% Wegpunkte wurden gel&ouml;scht.');
DEFINE('_TRC_TRKPT_DELETED','%1% Trackpunkte wurden gel&ouml;scht.');
DEFINE('_TRC_GPX_DELETED','%1% GPX-Datei wurde gel&ouml;scht.');
DEFINE('_TRC_GPX_EDITED','GPX-Datei wurde bearbeitet.');
DEFINE('_TRC_EXPORT_AS_GPX','als GPX-Datei exportieren');

/** traces.html.php */

/** waypoints.php */
DEFINE('_WPT_EDITED','Wegpunkt wurde bearbeitet.');
DEFINE('_WPT_REALLY_DELETE','Soll der angegebene Wegpunkt UNWIEDERBRINGLICH VERNICHTET werden?');

/** bookmark.php */
DEFINE('_BOOKM_NONE_IN_DB','Keine Lesezeichen in Datenbank vorhanden.');
DEFINE('_MENU_BOOKM_VIEW','Lesezeichen anzeigen');
DEFINE('_MENU_BOOKM_ADD','Lesezeichen hinzuf&uuml;gen');
DEFINE('_MENU_BOOKM_DELETE','Lesezeichen l&ouml;schen');
DEFINE('_BOOKM_ADDED','Lesezeichen wurde hinzugef&uuml;gt.');
DEFINE('_BOOKM_NO_URL','Es wurde keine URL f&uuml;r das Lesezeichen angegeben.');
DEFINE('_BOOKM_DELETED','Lesezeichen wurde gel&ouml;scht.');

/** photos.php */
DEFINE('_PHOTO_NONE_IN_DB','Keine Fotos in Datenbank vorhanden.');
DEFINE('_PHOTO_DOES_NOT_EXIST','Diese Bild-Datei existiert nicht!');
DEFINE('_PHOTO_NO_PHP_GD2_EXT','Die PHP GD Erweiterung ist nicht installiert!');
DEFINE('_PHOTO_IPTC_TITLE','IPTC-Feld "Titel"');
DEFINE('_PHOTO_IPTC_DESC','IPTC-Feld "Beschreibung"');
DEFINE('_PHOTO_TIME_OFFSET','Zeit-Offset');
DEFINE('_PHOTO_TIME_OFFSET_MAN','Uhren-Differenz [GPS - Kamera] in Sekunden');
DEFINE('_PHOTO_LOCATION_FROM_EXIF','Aufnahmestandort aus EXIF-Header gelesen: ');
DEFINE('_PHOTO_LOCATION_FROM_TRKPT','Aufnahmestandort aus GPX gelesen: ');
DEFINE('_PHOTO_NO_LOCATION','Kein Aufnahmestandort gefunden!');
DEFINE('_PHOTO_NO_EXIF','Kein EXIF-Header mit GPS-Informationen vorhanden!');
DEFINE('_PHOTO_NO_VALID_JPG','Keine g&uuml;ltige JPEG-Datei!');
DEFINE('_PHOTO_REALLY_DELETE','Soll die angegebene Bild-Datei <br />UNWIEDERBRINGLICH VERNICHTET werden?');
DEFINE('_PHOTO_DELETED','Foto wurde gel&ouml;scht.');

/** import.php */
DEFINE('_IMPORT_NO_AJAX','Ihr Browser ist nicht AJAX-f&auml;hig!');
DEFINE('_IMPORT_PHP_ERROR','Entschulding, dieser Fehler sollte nicht passieren! Sie können einen Fehlerbericht senden und folgende Zeilen einfügen:');
DEFINE('_IMPORT_FILE_ERROR','Datei konnte nicht ge&ouml;ffnet werden!');
DEFINE('_IMPORT_COPY_FAILED','Kopieren dieser Datei fehlgeschlagen!');
DEFINE('_IMPORT_FAILED','Import dieser Datei fehlgeschlagen!');
DEFINE('_IMPORT_SUCCESS','Import dieser Datei erfolgreich.');

/** database.php */
DEFINE('_DB_GPX_AVAILABLE',' GPX-Dateien vorhanden.');
DEFINE('_DB_WPTS_AVAILABLE',' Wegpunkte vorhanden.');
DEFINE('_DB_TRKPTS_AVAILABLE',' Trackpunkte vorhanden.');
DEFINE('_DB_DAYS_AVAILABLE',' Tage sind vorhanden.');
DEFINE('_DB_BOOKM_AVAILABLE',' Lesezeichen sind vorhanden.');
DEFINE('_DB_PHOTOS_AVAILABLE',' Fotos sind vorhanden.');
DEFINE('_DB_PHOTOS_SIZE',' Speicherplatz von Foto-Dateien belegt.');
DEFINE('_DB_GPX_SIZE',' Speicherplatz von GPX-Dateien belegt.');
DEFINE('_DB_TOTAL_DISTANCE',' Gesamtwegl&auml;nge');

/** about.php */
DEFINE('_ABOUT_CREDITS','Danksagungen');
DEFINE('_ABOUT_LICENSE','Lizenz');
DEFINE('_UPDATE_CHECK_DISABLED','Die Suche nach Programm-Updates wurde deaktiviert.');
DEFINE('_UPDATE_AVAIL','Die folgende Programm-Aktualisierung ist verf&uuml;gbar: ');
DEFINE('_NO_UPDATE_AVAIL','Es ist keine Programm-Aktualisierung verf&uuml;gbar.');
DEFINE('_BASED_ON','Based upon:');	//Untranslated!!
DEFINE('_UNFORKED_APP_NAME','phpMyGPX');
DEFINE('_UNFORKED_APP_CURRENCY','<em>Base package currency:</em>'); // Untranslated!!
DEFINE('_NO_UNFORKED_UPDATE_AVAIL','Base phpMyGPX unchanged.'); // Untranslated!!
DEFINE('_UNFORKED_UPDATE_AVAIL','A new base phpMyGPX is available: '); // Untranslated!!
DEFINE('_PROCEED_WITH_UPDATE','Proceed with update?'); // Untranslated!!
DEFINE('_UPDATE_SERVER_ERROR404','Der Update-Server antwortete mit Fehler 404 (Dokument nicht gefunden).');
DEFINE('_UPDATE_SERVER_CONN_ERROR','Verbindung zum Update-Server fehlgeschlagen.');

/** map.php */
DEFINE('_MAP_CURRENT_AREA',' (f&uuml;r diesen Kartenausschnitt)');
#DEFINE('_MAP_AREA_TRKPT','zeige alle Wegpunkte des Kartenausschnitts');
DEFINE('_MAP_JOSM_EDIT','mit JOSM editieren');
DEFINE('_MAP_ADD_BOOKM','Lesezeichen erstellen');
DEFINE('_MAP_JS_BOOKM_NAME','Name des Lesezeichens: ');

/** graph.php */
DEFINE('_CHART_ELEVATION_TITLE', 'Hoehenprofil');
DEFINE('_CHART_AXIS_ELE', 'Hoehe');
DEFINE('_CHART_AXIS_SPEED', 'Geschw.');
DEFINE('_CHART_AXIS_TIME', 'Zeit');
DEFINE('_CHART_AXIS_DIST', 'Distanz');

// DO NOT edit anything below this line!
include(_PATH ."version.inc.php");
?>

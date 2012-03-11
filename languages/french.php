<?php
/**
* @version $Id$
* @package phpmygpx-fosm
* @copyright Copyright (C) 2009-2012 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_VALID_OSM') or die('Accès refusé');


DEFINE('_LANGUAGE','fr');
DEFINE('_TRANSLATOR_NAME', 'arno renevier');
DEFINE('_TRANSLATOR_EMAIL', 'arno@renevier.net');

// Site page note found
DEFINE('_404', 'Désolé, la page demandée n\'a pas pu être trouvée.');
DEFINE('_404_RTS', 'Retourner au site');

// common
DEFINE('_APP_NAME','phpMyGPX-fosm');
DEFINE('_HTML_TITLE','phpMyGPX-fosm ::: gestion des données');

DEFINE('_DATE_FORMAT_LC',"%d.%m.%Y"); //Uses PHP's strftime Command Format
DEFINE('_DATE_FORMAT_LC2',"%A, %d. %B %Y %H:%M");
DEFINE('_DATE_FORMAT_LC3',"%d.%m.%Y %H:%M:%S");
DEFINE('_TIME_FORMAT_LC4',"%H:%M:%S h");

DEFINE('_NOT_AUTH','Vous n\'êtes pas autorisés à voir cette ressource.');
DEFINE('_DO_LOGIN','Vous devez vous connecter.');
DEFINE('_VALID_AZ09',"%1% n'est pas valide.  Il doit contenir plus de %2% caractères, et uniquement 0-9,a-z,A-Z");
DEFINE('_CMN_YES','Oui');
DEFINE('_CMN_NO','Non');
DEFINE('_CMN_SHOW','Montrer');
DEFINE('_CMN_HIDE','Cacher');

DEFINE('_CMN_NAME','Nom');
DEFINE('_CMN_DESCRIPTION','Description');
DEFINE('_CMN_SAVE','Sauvegarder');
DEFINE('_CMN_APPLY','Appliquer');
DEFINE('_CMN_CANCEL','Annuler');
DEFINE('_CMN_PRINT','Imprimer');
DEFINE('_CMN_PDF','PDF');
DEFINE('_CMN_EMAIL','Email');
DEFINE('_ICON_SEP','|');
DEFINE('_CMN_PARENT','Parent');
DEFINE('_CMN_ORDERING','Tri');
DEFINE('_CMN_ACCESS','Niveau d\'accès');
DEFINE('_CMN_SELECT','Sélectionner');
DEFINE('_CMN_SELECT_ALL','Tout sélectionner');
DEFINE('_CMN_STATUS','Status');
DEFINE('_CMN_SEARCH_RESULTS','%1% résultats de recherche:');

DEFINE('_CMN_FIRST','Premier');
DEFINE('_CMN_LAST','Dernier');
DEFINE('_CMN_NEXT','Suivant');
DEFINE('_CMN_NEXT_ARROW'," &gt;&gt;");
DEFINE('_CMN_PREV','Précédent');
DEFINE('_CMN_PREV_ARROW',"&lt;&lt; ");

DEFINE('_CMN_SORT_NONE','Pas de tri');
DEFINE('_CMN_SORT_ASC','Ordre Ascendant');
DEFINE('_CMN_SORT_DESC','Ordre Descendant');

DEFINE('_CMN_NEW','Nouveau');
DEFINE('_CMN_NONE','Aucun');
DEFINE('_CMN_LEFT','Gauche');
DEFINE('_CMN_RIGHT','Droite');
DEFINE('_CMN_CENTER','Centre');
DEFINE('_CMN_TOP','Haut');
DEFINE('_CMN_BOTTOM','Bas');
DEFINE('_CMN_FROM',' du ');
DEFINE('_CMN_TO',' au ');

DEFINE('_CMN_DELETE','Supprimer');

DEFINE('_CMN_FOLDER','Dossier');
DEFINE('_CMN_SUBFOLDER','Sous dossier');
DEFINE('_CMN_WRITABLE','Accès en écriture');
DEFINE('_CMN_NOT_WRITABLE','PAS d\'accès en écriture');
DEFINE('_CMN_AVAILABLE','Disponible');
DEFINE('_CMN_MISSING','Manquant');
DEFINE('_CMN_OPTIONAL','Optionnel');
DEFINE('_CMN_REQUIRED','Requis');


DEFINE('_CMN_SCRIPT_EXEC_TIME','Page générée en ');
DEFINE('_CMN_MOUSEOVER_FOR_TOOLTIP','Pour des astuces, placez votre souris au dessus d\'un champ d\'édition.');
DEFINE('_CMN_NOT_IMPLEMENTED','Cette fonctionnalité n\'est pas encore implémentée.');
DEFINE('_CMN_BACK','Retour');
DEFINE('_CMN_CONTINUE','Continuer');
DEFINE('_CMN_WARNING','Attention!');
DEFINE('_CMN_PAGE','Page');
DEFINE('_CMN_BATCH','Opération de groupe');
DEFINE('_CMN_SINGLE_FILE','Fichier unique');
DEFINE('_CMN_MAX_FILE_SIZE','maximum file size: ');
DEFINE('_CMN_NO_ITEM_SELECTED','No item selected!');
DEFINE('_CMN_COPY_DATE','Copy date');
DEFINE('_CMN_OTHER','autre');
DEFINE('_CMN_VIEW','Voir');
DEFINE('_CMN_VIEW_SIMPLE','simple');
DEFINE('_CMN_VIEW_DETAIL','détaillé');

// error descriptions taken from http://de.php.net/manual/fr/features.file-upload.errors.php
DEFINE('_CMN_UPLOAD_ERR_SIZE','Le fichier téléchargé excède la taille de UPLOAD_MAX_FILESIZE.');
DEFINE('_CMN_UPLOAD_ERR_PARTIAL','Le fichier n\'a été que partiellement téléchargé.');
DEFINE('_CMN_UPLOAD_ERR_NO_FILE','Aucun fichier n\'a été téléchargé.');
DEFINE('_CMN_UPLOAD_ERR_NO_TMP_DIR','Un dossier temporaire est manquant.');
DEFINE('_CMN_UPLOAD_ERR_CANT_WRITE','Échec de l\'écriture du fichier sur le disque.');

// database related errors, taken from PHP manual
DEFINE('_CMN_DB_CONNECT_ERR','Impossible de se connecter: ');
DEFINE('_CMN_DB_SELECT_ERR','Impossible de sélectionner la base de données: ');
DEFINE('_CMN_DB_QUERY_ERR','Requête invalide: ');

DEFINE('_CMN_GEO_TAGGING','Geo-Tagging');
DEFINE('_CMN_GEO_TAGGING_MAN','For automatic geo-tagging a GPX file has to be selected.');
DEFINE('_CMN_TIMEZONE','Timezone');
DEFINE('_CMN_TIMEZONE_CAM','Timezone of camera\'s clock');
DEFINE('_CMN_LOCATION','Localisation');
DEFINE('_CMN_BBOX','Boîte englobante');
DEFINE('_CMN_RANGE','Portée');
DEFINE('_CMN_INSERTED','inséré');
DEFINE('_CMN_PUBLIC','publique');
DEFINE('_CMN_VISIBLE','visible');
DEFINE('_CMN_TITLE','Titre');
DEFINE('_CMN_ICON','Icon');
DEFINE('_CMN_THUMB','Miniature');
DEFINE('_CMN_PHOTO_ID','ID de la photo');
DEFINE('_CMN_USER_ID','ID utilisateur');
DEFINE('_CMN_GPX_ID','ID GPX');
DEFINE('_CMN_BM_ID','ID mp');
DEFINE('_CMN_BM_NAME','nom du marque-page');
DEFINE('_CMN_FILE_NAME','Nom du fichier');
DEFINE('_CMN_FILE_SIZE','Taille du fichier');
DEFINE('_CMN_LENGTH','Longueur');
DEFINE('_CMN_COMMENT','Commentaire');
DEFINE('_CMN_DATE','Date');
DEFINE('_CMN_ZOOM','Niveau de zoom');
DEFINE('_CMN_LAT','Latitude');
DEFINE('_CMN_LON','Longitude');
DEFINE('_CMN_ALT','Altitude');
DEFINE('_CMN_VIEW_DIR','Direction de la photo');
DEFINE('_CMN_MOVE_DIR','Direction du mouvement');
DEFINE('_CMN_COURSE','Mouvement');
DEFINE('_CMN_SPEED','Vitesse');
DEFINE('_CMN_FIX','Pt Sat');
DEFINE('_CMN_SAT','Satellites');
DEFINE('_CMN_HDOP','HDOP');
DEFINE('_CMN_PDOP','PDOP');


/** installation */
DEFINE('_INST_OSM_SETUP','phpMyGPX-fosm-Installation: ');
DEFINE('_INST_WELCOME','Bienvenue');
DEFINE('_INST_CHECKS','Vérifications de l\'environnement');
DEFINE('_INST_CONFIG','Configuration');
DEFINE('_INST_DB_INST','Installation de la base de données');
DEFINE('_INST_DONE','Installation effectuée');

DEFINE('_INST_GUIDED','Vous allez être guidés tout au long de l\'installation. Suivez tout simplement les instructions.');
DEFINE('_INST_MAN_LOGIN','Si vous avez un <b>accès root</b> à votre base de données, entrez simplement le mot de passe ci-dessous.<br>
Pour les utilisations futures, un compte avec moins de privilèges sera créé pour des raisons de sécurité. Son login doit être renseigné dans le fichier de configuration.<br><br>
Si votre base de donnée est <b>partagée</b>, vous avez peut-être uniquement un compte utilisateur. Dans ce cas, merci d\'utiliser les données de ce compte <b>à la fois</b> pour le fichier de configuration <b>et</b> pour le script d\'installation.');

DEFINE('_INST_DB_ACCOUNT','Données du compte MySQL');
DEFINE('_INST_DB_HOST','Nom d\'hôte');
DEFINE('_INST_DB_NAME','Nom de la base de données');
DEFINE('_INST_DB_TABLE_PREFIX','Nom du préfixe de table');
DEFINE('_INST_DB_USER','Nom d\'utilisateur');
DEFINE('_INST_DB_PASSWORD','Mot de passe');
DEFINE('_INST_DB_ROOT_ACCOUNT','Données du compte root MySQL');
DEFINE('_INST_DB_ROOT_ACCOUNT_MAN','Si vous avez un <b>accès root</b> à votre base de données, entrez simplement le mot de passe ci-dessous, sinon, laisser les champs vides.<br>
Pour les utilisations futures, un compte avec moins de privilèges sera créé pour des raisons de sécurité');
DEFINE('_INST_DB_ROOT','Nom du root');
DEFINE('_INST_DB_ROOTPASS','Mot de passe root');
DEFINE('_INST_CFG_ADMIN_ACCESS','Accès administrateur');
DEFINE('_INST_CFG_ADMIN_ACCESS_MAN','Si l\'accès de votre serveur n\'est pas public, vous devriez cocher cette case, et définir un mot de passe pour l\'administration!');
DEFINE('_INST_CFG_PUBLIC_HOST','Hôte avec accès public');
DEFINE('_INST_CFG_ADMIN_PASSWORD','Mot de passe administrateur');
DEFINE('_INST_CFG_HOME_LOCATION','Lieu principal');
DEFINE('_INST_CFG_HOME_LOCATION_MAN','Veuillez choisir le lieu principal de votre carte (zoomez puis glisser-déposez la prévisualisation sur la droite).');

DEFINE('_INST_LANGUAGE','Langue');
DEFINE('_INST_LANGUAGE_CHOOSE','Veuillez choisir votre langue.');
DEFINE('_INST_LOCALE','en_US');	     //Untranslated!!
DEFINE('_INST_MODE','Mode d\'installation');
DEFINE('_INST_MODE_NEW','Nouvelle installation');
DEFINE('_INST_MODE_UPGR3','Mise à jour vers la version 0.3');
DEFINE('_INST_MODE_UPGR_LATEST','Mise à jour vers la dernière version');
DEFINE('_INST_MODE_NEW_DESC',' (La base et toute les tables vont être crées si elles n\'existent pas)');
DEFINE('_INST_MODE_UPGR3_DESC',' (Les tables qui existent vont être modifiées et celles qui manquent vont être crées)');
DEFINE('_INST_PROG_CHECKS','Les permissions des répertoires et la configuration du serveur vont être vérifiés...');
DEFINE('_INST_PROG_PHOTOS_DISABLED','Photo features are disabled because of missing EXIF and mbstring extensions.');
DEFINE('_INST_PROG_CHECKED','Tous les tests ont réussi.');
DEFINE('_INST_PROG_CONFIG_FOUND','Un ancien fichier de configuration a été trouvé, et les données qu\'il contient vont être utilisées.');
DEFINE('_INST_PROG_CONFIG_UPDATED','Le fichier de configuration a été mis à jour et sauvegardé.');
DEFINE('_INST_DB_CREATE_SETUP','Créer et configurer la base ');
DEFINE('_INST_PROG_INST','Votre base MySQL et toutes les tables vont être crées...');
DEFINE('_INST_DB_CONN_ERROR','La connexion à la base de données a échoué. ');
DEFINE('_INST_CREATE_USER','Operational database user created. '); //Untranslated!!
DEFINE('_INST_UPGR3_ADD_BOOKM_TBL','La table des marque-pages a été crée.');
DEFINE('_INST_UPGR3_ADD_WAYPTS_TBL','La table des points de cheminement a été crée.');
DEFINE('_INST_UPGR5_ADD_POIS_TBL','La table des photos et points d\'intérêt a été crée.');
DEFINE('_INST_PROG_DB','La base de données a été crée.');
DEFINE('_INST_USER_ACCESS','Operational user access granted. '); //Untranslated!!
DEFINE('_INST_PROG_RENAMED','Le dossier d\'installation a été renommé pour des raisons de sécurité.');
DEFINE('_INST_PROG_RENAME_ERROR','Pour des raisons de sécurité, veuillez SUPPRIMER le dossier d\'installation!');
DEFINE('_INST_PROG_DONE','<b>FÉLICITATIONS!</b> Vous avez installé l\'application avec succès&nbsp;!');
DEFINE('_INST_PROG_TEST','Dernier test réussi.');
DEFINE('_INST_ERROR','Une erreur s\'est produite. Essayez de résoudre le problème, et relancer ce script&nbsp;!');
DEFINE('_INST_DB_ERROR','Erreur dans la requête: ');
DEFINE('_INST_DB_STAT','Statistiques pour la base ');

/** html.classes.php */
DEFINE('_MENU_GPX','fichier GPX'); //XXX
DEFINE('_MENU_GPX_VIEW','voir le GPX');
DEFINE('_MENU_GPX_DETAILS','détails');
DEFINE('_MENU_GPX_IMAGE','image');
DEFINE('_MENU_GPX_UPL','upload du GPX');
DEFINE('_MENU_GPX_BATCH_IMPORT','Import GPX groupé');
DEFINE('_MENU_GPX_IMPORT','importer');
DEFINE('_MENU_GPX_EXPORT','exporter');
DEFINE('_MENU_GPX_DOWNL','télécharger');
DEFINE('_MENU_GPX_EDIT','éditer');
DEFINE('_MENU_GPX_DELETE','supprimer');
DEFINE('_MENU_GPX_SEARCH','chercher dans le GPX');
DEFINE('_MENU_TRC_EDIT','Edit Trace Description'); //Untranslated!!
DEFINE('_MENU_TRKPT','points de repérage');
DEFINE('_MENU_TRKPT_VIEW','voir les points de repérage');
DEFINE('_MENU_TRKPT_SEARCH','chercher dans les points de repérage');
DEFINE('_MENU_WPT','points de cheminement');
DEFINE('_MENU_WPT_VIEW','voir les points de cheminement');
DEFINE('_MENU_WPT_EDIT','éditer le point de cheminement');
DEFINE('_MENU_WPT_DELETE','supprimer le point de cheminement');
DEFINE('_MENU_WPT_SEARCH','chercher dans les points de cheminement');
DEFINE('_MENU_PHOTO','Photo');
DEFINE('_MENU_PHOTO_VIEW','voir les photos');
DEFINE('_MENU_PHOTO_DETAILS','détails de la photo');
DEFINE('_MENU_PHOTO_UPL','upload de photos');
DEFINE('_MENU_PHOTO_BATCH_IMPORT','import groupé de photos');
DEFINE('_MENU_PHOTO_IMPORT','importer des photos');
DEFINE('_MENU_PHOTO_DELETE','supprimer des photos');
DEFINE('_MENU_VIEW','voir');
DEFINE('_MENU_UPL','upload');
DEFINE('_MENU_SEARCH','chercher');
DEFINE('_MENU_NEW','nouveau');

DEFINE('_MENU_HOME','Accueil');
DEFINE('_MENU_ABOUT','À propos...');
DEFINE('_MENU_UPDATE','Update...');	// Untranslated!!
DEFINE('_MENU_BOOKMARK','Marque-pages');
DEFINE('_MENU_MAP','Carte');
DEFINE('_MENU_MISC','Divers');
DEFINE('_MENU_DB','base de données');
DEFINE('_MENU_DB_STAT','Statistiques');
DEFINE('_MENU_LOGIN','CONNEXION');
DEFINE('_MENU_LOGOUT','DÉCONNEXION');

/** index.php */
DEFINE('_HOME_WELCOME_TO','Bienvenue sur ');
DEFINE('_HOME_INTRO','À faire: Intro');
DEFINE('_LOGIN_FAILED','Connexion échouée. Votre mot de passe n\'est pas correct.');
DEFINE('_LOGIN_SUCCESS','Vous êtes maintenant connecté.');
DEFINE('_LOGOUT_SUCCESS','Vous êtes maintenant déconnecté');
DEFINE('_LOGIN_DESCRIPTION','Pour accéder à l\'interface d\'administration du site, veuillez vous connecter&nbps;:');

/** traces.php */
DEFINE('_TRC_NO_WPTS_IN_DB','Aucun point de cheminement disponible.');
DEFINE('_TRC_NO_TRKPTS_IN_DB','Aucun point de repérage disponible.');
DEFINE('_TRC_NO_GPX_IN_DB','Pas de fichiers GPX disponible dans la base de données.');
DEFINE('_TRC_GPX_DOES_NOT_EXIST','Ce fichier GPX n\'existe pas!');
DEFINE('_TRC_DETAILS_OF_GPX','Statistiques et détails du fichier GPX # ');
DEFINE('_TRC_APPROX_DIST','distance approx.');
DEFINE('_TRC_TRIP_TIME','temps de trajet');
DEFINE('_TRC_AVG_SPEED','vitesse moyenne');
DEFINE('_TRC_TRACK','trace ');
DEFINE('_TRC_HALT','Arrêt: ');
DEFINE('_TRC_TOTAL','Total');
DEFINE('_TRC_DETAILS_CHART_SPLIT','Le diagramme de dénivelé est divisé à cause de coupures dans la trace:');
DEFINE('_TRC_SHOW_MAP','Voir la carte');
DEFINE('_TRC_SHOW_OSM_MAP','Voir la carte sur OSM');
DEFINE('_TRC_SHOW_ITEMS_ON_MAP','Show selected items on map');
DEFINE('_TRC_USE_DP_FOR_SEARCH','Veuillez utiliser des points pour les décimales des nombres à virgules.');
DEFINE('_TRC_SEARCH_PARAMS_LOGIC_AND','Les paramètres de recherche sont combinés avec l\'opérateur logique AND.');
DEFINE('_TRC_CHOOSE_SEARCH_FILTER','Choisissez un filtre de recherche: ');
DEFINE('_TRC_CHOOSE_UPL_FILE','Choisissez un fichier à uploader: ');
DEFINE('_TRC_BATCH_IMPORT_INFO','Pour réaliser un import groupé, copiez tout d\'abord vos fichiers (par FTP) dans le répertoire "/upload/".');
DEFINE('_TRC_BATCH_IMPORTING_DIR','Les fichiers vont être importés depuis ce dossier: <i>"%1%"</i>');
DEFINE('_TRC_CHOOSE_FILES_FOR_BATCH_IMPORTING','Veuillez choisir les fichiers à importer: ');
DEFINE('_TRC_START_IMPORT','Commencer l\'import groupé');
DEFINE('_TRC_WAIT_WHILE_IMPORTING','Veuillez patienter pendant l\'import: ');
DEFINE('_TRC_IMPORT_DONE','Import réalisé.');
DEFINE('_TRC_MAY_TAKE_SECONDS','Cela peut prendre plusieurs secondes.');
DEFINE('_TRC_UPL_ERROR','Erreur lors de l\'upload du fichier: ');
DEFINE('_TRC_UPL_SUCCESS','Fichier uploadé avec succès: ');
DEFINE('_TRC_READING_FILE','Lecture du fichier "<i>%1%</i>"...');
DEFINE('_TRC_NO_VALID_XML','Désolé, çà n\'a pas d\'être du XML valide!');
DEFINE('_TRC_MISS_TIMESTAMP','Impossible d\'importer ce fichier GPX à cause de l\'estampille temporelle manquante!');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','Les noms du fichier doit être unique! Êtes-vous en train de réimporter?');
DEFINE('_TRC_NO_UNIQUE_TIMESTAMP','L\'estampille temporelle doit être unique! Êtes-vous en train de réimporter?');
DEFINE('_TRC_NO_PHP_DOM_EXT','L\'extension PHP DOM n\'est pas installée!');
DEFINE('_TRC_WPTS_PROCESSED',' Points de cheminement en cours de traitement.');
DEFINE('_TRC_TRKPTS_PROCESSED',' Points de repérage en cours de traitement.');
DEFINE('_TRC_REALLY_DELETE','Voulez-vous vraiment SUPPRIMER votre fichier GPX <br /> et tous les fichiers inclus?<br />Il n\'y a pas d\'annulation possible!');
DEFINE('_TRC_CONFIRM_DELETE','Pour confirmer la suppression, veuillez taper "Oui".');
DEFINE('_TRC_NO_CONFIRM_DELETE','Vous avez annulé la suppression.');
DEFINE('_TRC_WPT_DELETED','%1% points de cheminement supprimés.');
DEFINE('_TRC_TRKPT_DELETED','%1% points de repérage supprimés.');
DEFINE('_TRC_GPX_DELETED','%1% fichiers GPX supprimés.');
DEFINE('_TRC_GPX_EDITED','fichier GPX modifié.');
DEFINE('_TRC_EXPORT_AS_GPX','exporter dans un fichier au format GPX');

/** traces.html.php */

/** waypoints.php */
DEFINE('_WPT_EDITED','Point de cheminement modifié.');
DEFINE('_WPT_REALLY_DELETE','Voulez-vous vraiment SUPPRIMER cet point de cheminement?<br />Il n\'y a pas d\'annulation possible!');

/** bookmark.php */
DEFINE('_BOOKM_NONE_IN_DB','Pas de marque-page disponible dans la base de données.');
DEFINE('_MENU_BOOKM_VIEW','Voir les marque-pages');
DEFINE('_MENU_BOOKM_ADD','Ajouter un marque-page');
DEFINE('_MENU_BOOKM_DELETE','Supprimer un marque-page');
DEFINE('_BOOKM_ADDED','Marque-page ajouté.');
DEFINE('_BOOKM_NO_URL','Il n\'y pas d\'URL pour ce marque-page.');
DEFINE('_BOOKM_DELETED','Le marque-page a été supprimé.');

/** photos.php */
DEFINE('_PHOTO_NONE_IN_DB','Pas de photo disponible.');
DEFINE('_PHOTO_DOES_NOT_EXIST','Cette photo n\'existe pas!');
DEFINE('_PHOTO_NO_PHP_GD2_EXT','L\'extension PHP GD n\'est pas installée!');
DEFINE('_PHOTO_IPTC_TITLE','champ IPTC "titre"');
DEFINE('_PHOTO_IPTC_DESC','champ IPTC "description"');
DEFINE('_PHOTO_TIME_OFFSET','Time offset');
DEFINE('_PHOTO_TIME_OFFSET_MAN','Time offset [GPS - camera] in seconds');
DEFINE('_PHOTO_LOCATION_FROM_EXIF','Location read from EXIF header: ');
DEFINE('_PHOTO_LOCATION_FROM_TRKPT','Location read from GPX: ');
DEFINE('_PHOTO_NO_LOCATION','No shooting location found!');
DEFINE('_PHOTO_NO_EXIF','Pas de coordonnées GPS dans les données EXIF!');
DEFINE('_PHOTO_NO_VALID_JPG','Ce n\'est pas un fichier JPEG valide!');
DEFINE('_PHOTO_REALLY_DELETE','Voulez vous vraiment SUPPRIMER cette photo?<br />Il n\'y a PAS d\'annulation possible!');
DEFINE('_PHOTO_DELETED','La photo a été supprimée.');

/** import.php */
DEFINE('_IMPORT_NO_AJAX','Votre navigateur ne supporte pas AJAX!');
DEFINE('_IMPORT_PHP_ERROR','Sorry, this should not happen! You might want to submit a bug report and include the following lines:');
DEFINE('_IMPORT_FILE_ERROR','Erreur lors de l\'ouverture du fichier!');
DEFINE('_IMPORT_COPY_FAILED','La copie de ce fichier a échoué!');
DEFINE('_IMPORT_FAILED','L\'import a échoué!');
DEFINE('_IMPORT_SUCCESS','L\'import a réussi.');

/** database.php */
DEFINE('_DB_GPX_AVAILABLE',' Fichiers GPX trouvés dans la base de données.');
DEFINE('_DB_WPTS_AVAILABLE',' Points de cheminement trouvés dans la base de données.');
DEFINE('_DB_TRKPTS_AVAILABLE',' Points de repérage trouvés dans la base de données.');
DEFINE('_DB_DAYS_AVAILABLE',' Jours trouvés dans la base de données.');
DEFINE('_DB_BOOKM_AVAILABLE',' marque-pages trouvés dans la base de données.');
DEFINE('_DB_PHOTOS_AVAILABLE',' photos trouvées.');
DEFINE('_DB_PHOTOS_SIZE',' taille totale des photos.');
DEFINE('_DB_GPX_SIZE',' taille totale des fichiers GPX.');
DEFINE('_DB_TOTAL_DISTANCE',' au total');

/** about.php */
DEFINE('_ABOUT_CREDITS','Crédits');
DEFINE('_ABOUT_LICENSE','Licence');
DEFINE('_UPDATE_CHECK_DISABLED','La vérification des mises à jour a été désactivée.');
DEFINE('_UPDATE_AVAIL','Une mise à jour du logiciel est disponible.');
DEFINE('_NO_UPDATE_AVAIL','Pas de mise à jour disponible.');
DEFINE('_BASED_ON','Based upon:');	//Untranslated!!
DEFINE('_UNFORKED_APP_NAME','phpMyGPX');
DEFINE('_UNFORKED_APP_CURRENCY','<em>Base package currency:</em>'); // Untranslated!!
DEFINE('_NO_UNFORKED_UPDATE_AVAIL','Base phpMyGPX unchanged.'); // Untranslated!!
DEFINE('_UNFORKED_UPDATE_AVAIL','A new base phpMyGPX is available: '); // Untranslated!!
DEFINE('_PROCEED_WITH_UPDATE','Proceed with update?'); // Untranslated!!
DEFINE('_UPDATE_SERVER_ERROR404','Le serveur de mise à jour a renvoyé une erreur 404 (Document non trouvé).');
DEFINE('_UPDATE_SERVER_CONN_ERROR','La connexion au serveur de mise à jour a échoué.');

/** map.php */
DEFINE('_MAP_CURRENT_AREA',' (sur la zone actuelle de la carte)');
#DEFINE('_MAP_AREA_TRKPT','Voir tous les points de repérage sur la zone actuelle de la carte');
DEFINE('_MAP_JOSM_EDIT','éditer avec JOSM');
DEFINE('_MAP_ADD_BOOKM','créer un marque-page');
DEFINE('_MAP_JS_BOOKM_NAME','Nom du marque-page: ');

/** graph.php */
DEFINE('_CHART_ELEVATION_TITLE', 'Diagramme de dénivelé');
DEFINE('_CHART_AXIS_ELE', 'élévation');
DEFINE('_CHART_AXIS_SPEED', 'vitesse');
DEFINE('_CHART_AXIS_TIME', 'temps');
DEFINE('_CHART_AXIS_DIST', 'distance');

// DO NOT edit anything below this line!
include(_PATH ."version.inc.php");
?>

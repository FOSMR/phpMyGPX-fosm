/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008 Sebastian Klemm.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

var DEBUG = 0;

function checkall(state) {
	var filecount = getNumberOfFiles();
	if (filecount) {
		for (i=0; i< filecount; ++i) {
			document.batch_import_form.elements['bfiles[]'][i].checked = state;	//'
		}
	} else {
		document.batch_import_form.elements['bfiles[]'].checked = state;	//'
	}
}

function getNumberOfFiles() {
	var count = 0;
	try {
		var count = document.batch_import_form.elements['bfiles[]'].length; //'
	} catch (e) {}
	return count;
}

function startImport(path, isSingleFile, type) {
	var filecount = getNumberOfFiles();
	
	document.getElementById('dynamicContent_Wait').style.visibility = "visible";
	document.getElementById('dynamicContent_Done').style.visibility = "hidden";
	var url = "import.php?type=" + type;
	if (type == 'photo') {
		var gpx_id = document.batch_import_form.elements['gpx_id'].value;
		var offset = document.batch_import_form.elements['offset'].value;
		var title = document.batch_import_form.elements['title'].value;
		for (i=0; i< document.batch_import_form.elements['title_opt'].length; ++i) {
			if (document.batch_import_form.elements['title_opt'][i].checked) {
				title_opt = document.batch_import_form.elements['title_opt'][i].value;
			}
		}
		for (i=0; i< document.batch_import_form.elements['desc_opt'].length; ++i) {
			if (document.batch_import_form.elements['desc_opt'][i].checked) {
				desc_opt = document.batch_import_form.elements['desc_opt'][i].value;
			}
		}
		url += "&gpx_id=" + parseInt(gpx_id);
		url += "&title_opt=" + encodeURIComponent(title_opt);
		url += "&title=" + encodeURIComponent(title);
		url += "&desc_opt=" + encodeURIComponent(desc_opt);
		url += "&offset=" + parseInt(offset);
	}
	var timezone = document.batch_import_form.elements['tz'].value;
	var description = document.batch_import_form.elements['description'].value;
	url += "&tz=" + encodeURIComponent(timezone);
	url += "&description=" + encodeURIComponent(description);
	
	if (!isSingleFile && filecount) {
		for (i=0; i< filecount; ++i) {
			if (document.batch_import_form.elements['bfiles[]'][i].checked) { //'
				var filename = document.batch_import_form.elements['bfiles[]'][i].value;	//'
				prepareRequest(url, path, filename, i)
			}
		}
	} else {
		var filename = document.batch_import_form.elements['bfiles[]'].value;	//'
		prepareRequest(url, path, filename, 0)
	} 
	document.getElementById('dynamicContent').innerHTML = "";
	document.getElementById('dynamicContent_Wait').style.visibility = "hidden";
	document.getElementById('dynamicContent_Done').style.visibility = "visible";
	document.forms[0].start.disabled = true;
}

// prepare the XML Http request
function prepareRequest(url, path, filename, i) {
	var url2 = "&file=" + encodeURIComponent(path+filename) + "&id=" + (i+1);
	document.getElementById('dynamicContent').innerHTML = filename;
	
	setRequest('GET', url+url2, null, false);
	// for synchronous requests we must call this on our own
	interpretRequest();
}

// set and send XML Http request
function setRequest(method, url, body, async) {
	if (DEBUG) {
		alert(url);
		return;
	}
	
	// Request erzeugen
	if (window.XMLHttpRequest) {
		request = new XMLHttpRequest(); // Mozilla, Safari, Opera
	} else if (window.ActiveXObject) {
		try {
			request = new ActiveXObject('Msxml2.XMLHTTP'); // IE 5
		} catch (e) {
			try {
				request = new ActiveXObject('Microsoft.XMLHTTP'); // IE 6
			} catch (e) {}
		}
	}

	// check if browser is AJAX capable
	if (!request) {
		alert(i18n_strings['_IMPORT_NO_AJAX']);
		return false;
	} else {
		// open request
		request.open(method, url, async);
		// requestheader for POST
		if (method == 'POST') {
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		}
		// satisfy some mozilla browsers
		request.overrideMimeType('text/xml');
		// send request
		request.send(body);
		// interpret request (callback for async requests)
		if (async) {
			request.onreadystatechange = interpretRequest;
		}
	}
}

// interpret XML Http request
function interpretRequest() {
	switch (request.readyState) {
		case 4:
			if (request.status != 200) {
				alert("Request Error / Fehler:\n"+request.status);
			} else {
				// request answer is XML format
				var xmlDoc	= request.responseXML;
				
				// show PHP error messages of import script
				if (!xmlDoc.getElementsByTagName('import')[0]) {
					alert(i18n_strings['_IMPORT_PHP_ERROR'] + request.responseText);
					return;
				}
				
				// read XML answer
				var type	= xmlDoc.getElementsByTagName('import')[0].getAttribute('type');
				var id		= xmlDoc.getElementsByTagName('import')[0].getAttribute('id');
				var file	= xmlDoc.getElementsByTagName('import')[0].getAttribute('file');
				var db_id	= xmlDoc.getElementsByTagName('import')[0].getAttribute('lid');
				var status	= xmlDoc.getElementsByTagName('import')[0].getAttribute('status');
				var message	= xmlDoc.getElementsByTagName('import')[0].getAttribute('msg');
				
				id = parseInt(id);
				db_id = parseInt(db_id);
				status = parseInt(status);
				message = decodeURIComponent(message);
				if (status == 0) {
					icon = "tick_12.png";
				}else {
					icon = "cancel_12.png";
				}
				
				document.getElementById('status_' + String(id)).innerHTML = message;
				if (status == 0 && type == 'gpx') {
					document.getElementById('status_' + String(id)).innerHTML += 
					" <a href='traces.php?task=details&id="+ String(db_id) +"'>(GPX-ID)</a>";
				}
				if (status == 0 && type == 'photo') {
					document.getElementById('status_' + String(id)).innerHTML += 
					" <a href='photos.php?task=details&id="+ String(db_id) +"'>(ID)</a>";
				}
				document.getElementById('status_icon_' + String(id)).innerHTML = 
					"<img src='./images/"+ icon +"'>";
			}
			break;
		default:
			break;
	}
}
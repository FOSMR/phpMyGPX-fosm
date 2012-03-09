<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo _HTML_TITLE; ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo _PATH; ?>styles.css">
<script src="<?php echo _PATH; ?>libraries/i18n.js.php?lang=<?php echo $cfg['config_language']; ?>"></script>
<script src="<?php echo _PATH; ?>libraries/misc.js"></script>
</head>

<body>
<?php
if($DEBUG)	out("DEBUG-Modus ist aktiv!!!", 'OUT_DEBUG');

$page_width = intval($cfg['page_width']);
if(!$page_width)
	$page_width = intval($cfg['chart_width']);
echo "<div style='margin: 0 auto; width:${page_width}px;'>\n";
?>

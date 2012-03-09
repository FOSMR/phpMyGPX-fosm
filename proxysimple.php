<?php
/**
* @version $Id$
* @package phpmygpx
* @copyright Copyright (C) 2008-2011 Lizard, Sebastian Klemm
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

/**
* ProxySimplePHP (C) by Lizard
* http://wiki.openstreetmap.org/wiki/ProxySimplePHP
*
* This supports URLS of the form http://www.youdomain.tld/tiles.php?z=15&x=17024&y=10792
* ...but for URLs suitable for a slippy map (structured as per Slippy map tilenames) 
* you will need a rewrite-rule, for example in .htaccess :
*   RewriteEngine on
*   RewriteRule ^tiles/([0-9]+)/([0-9]+)/([0-9]+).png$ tiles.php?z=$1&x=$2&y=$3 [L]
*/

    $ttl = 3600 * 24; 		// browser cache timeout in seconds
    $proxy_ttl = $ttl * 30;	// proxy cache timeout
  
    $x = intval($_GET['x']);
    $y = intval($_GET['y']);
    $z = intval($_GET['z']);
    $r = strip_tags($_GET['r']);
	switch ($r)
	{
	  case 'hikebike':
	  	$r = 'hikebike';
	  	break;
	  case 'mapnik':
	  	$r = 'mapnik';
	  	break;
	  case 'osma':
	  default:
	  	$r = 'osma';
	  	break;
	}

    $file = "tiles/${r}/${z}_${x}_${y}.png";
    if (!is_file($file) || filemtime($file) < time()-$proxy_ttl)
    {
      $server = array();
      switch ($r)
      {
      	case 'hikebike':
	      $server[] = 'toolserver.org';
	
	      $url = 'http://'.$server[0].'/tiles/hikebike';
	      $url .= "/".$z."/".$x."/".$y.".png";
	      break;
	    
      	case 'mapnik':
	      $server[] = 'a.tile.openstreetmap.org';
	      $server[] = 'b.tile.openstreetmap.org';
	      $server[] = 'c.tile.openstreetmap.org';
	
	      $url = 'http://'.$server[array_rand($server)];
	      $url .= "/".$z."/".$x."/".$y.".png";
	      break;
	    
      	case 'osma':
      	default:
	      $server[] = 'a.tah.openstreetmap.org';
	      $server[] = 'b.tah.openstreetmap.org';
	      $server[] = 'c.tah.openstreetmap.org';
	
	      $url = 'http://'.$server[array_rand($server)].'/Tiles/tile';
	      $url .= "/".$z."/".$x."/".$y.".png";
	      break;
      }
      $ch = curl_init($url);
      $fp = fopen($file, "w");
      curl_setopt($ch, CURLOPT_FILE, $fp);
      curl_setopt($ch, CURLOPT_USERAGENT, 'phpMyGPX (ProxySimplePHP)');
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_exec($ch);
      curl_close($ch);
      fflush($fp);
      fclose($fp);
    }

    $exp_gmt = gmdate("D, d M Y H:i:s", time() + $ttl * 60) ." GMT";
    $mod_gmt = gmdate("D, d M Y H:i:s", filemtime($file)) ." GMT";
    header("Expires: " . $exp_gmt);
    header("Last-Modified: " . $mod_gmt);
    header("Cache-Control: public, max-age=" . $ttl * 60);
    // for MSIE 5
    header("Cache-Control: pre-check=" . $ttl * 60, FALSE);  
    header ('Content-Type: image/png');
    readfile($file);
?>

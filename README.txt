Readme phpMyGPX
===============

Homepage: http://phpmygpx.tuxfamily.org/
(C) 2009-2011 Sebastian Klemm (osm@erlkoenigkabale.eu)


What's this?
------------
phpMyGPX is an application to manage your own GPX files locally or online.
GPX is a xml file format containing track points and routes collected by GPS
receivers and beeing very popular with navigation, geo caching and OpenStreetMap,
of course.

The name isn't more than a working title, it doesn't mean anything great. I just
had no idea in the beginning, so don't be curious about it...
Furthermore it was not written to be published at all, but I thougt it might be
still useful for anybody and wanted to share it. And I remembered the rule
"Release early, release often!" - so don't complain of all the missing features
you did expect.
Icons are taken from the open source applications phpMyAdmin 2.9 (phpmyadmin.net)
and Joomla 1.5 (joomla.org), which both are GNU/GPL licensed, but if you
want to create better ones you can just contribute them.


Requirements
------------
- LAMP environment or equivalent, it could be your local (offline) computer with:
- a web server, e.g. Apache2 from httpd.apache.org
- PHP 5 (with DOM, GD2 and MySQL extensions enabled) from www.php.net
  * optional: PHP Exif (and mbstring on windows hosts) extensions for photo features
  * optional: PHP cURL extension for the tile cache proxy
- MySQL 4.1 or 5 from www.mysql.com (it should work with 3.2x, too, but not tested)
- and a web browser, of course, e.g. Mozilla Firefox


Configuration
-------------
As of version 0.5 there's no need to manually edit the config file because of 
an installation/upgrade wizard. Nevertheless you might want to tweak some 
features of the software, this can be easily done:
All configuration is held in "config.inc.php" file. Just change the variables
to suit your needs.

If you want to use phpMyGPX on a public web server, you should set
$cfg['public_host'] = TRUE and $cfg['admin_password'] = 'yoursecret'
This prevents anonymous visitors from changing anything in data base e.g.
adding and deleting trackpoints but allows them to view your data. To do so
just login with your admin password.


Installation
------------
Extract the downloaded archive and copy it to a directory on your web server.

Then point your prefered web browser to the newly created directory, for example
http://your-server/phpmygpx/
You will be guided thru the installation process. After the data base is created,
you can use the application and start with uploading gpx files.


Upgrading
---------
In general, you should backup your config.inc.php file and your GPX files
(in 'files' folder). After that, just extract the archive containing the upgrade
to your current phpMyGPX folder.
Then, point your browser to http://your-server/phpmygpx/installation/
and check the "upgrade" installation mode. This makes sure that possible changes to
the data base layout can be done, although your existing data tables will be kept.
Even the config file will be updated by the upgrade wizard, if neccessary.


Languages
---------
At the moment, these languages are available:
- English
- German
- Dutch (thanks to Leon Vrancken)
- French (thanks to Arno Renevier, http://syp.renevier.net)
- Spanish (thanks to Andrés Gómez Casanova)

You can choose your prefered frontend language by setting the 
"$cfg['config_language']" variable in the "config.inc.php" file.
Just have a look at the "/languages" directory to find out which languages are
provided and take the name of the file without the ".php" extension.

Adding more languages is quite easy:
Copy a file with a language you know in the "/languages" directory rename it to
your new language and translate all defined constants. Then you can change the
"$cfg['config_language']" variable to your newly created language. That's it!

Would be great to receive your improved or new language files by email, thanks!


License
-------
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

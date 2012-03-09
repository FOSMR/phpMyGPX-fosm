#!/bin/bash

RELEASE_DIR="/home/sebastian/download/temp/phpmygpx"
REPO_URL="http://192.168.10.3/svn/repos/phpmygpx/trunk/phpMyGPX"

echo "Making release package of phpMyGPX..."

cd $RELEASE_DIR
svn -q --force export $REPO_URL ./
rm -f *.bfproject .cvsignore *.sh
REVISION=`svn info $REPO_URL |grep '^Revision:' | sed -e 's/^Revision: //'`
echo "Export of SVN revison $REVISION done."

# Update SVN revision and release date strings in version file
DATE=`date +%Y-%m-%d`
sed -i -e "s/%DATE%/$DATE/" version.inc.php
sed -i -e "s/%REVISION%/$REVISION/" version.inc.php

# Fix folder permissions
chmod 777 files/ photos/ photos/thumbs/ tiles/ tiles/mapnik/ tiles/osma/ tiles/hikebike/ upload/

echo "Creating tar.bz2 archive..."
cd ..
tar -cjf phpMyGPX-0.6.1-SVN$REVISION.tar.bz2 phpmygpx
echo "Done."
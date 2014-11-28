Helpers
=======

These scripts support the [TOSBack2 Web Front-End](https://github.com/subsystem7/tosback2web)

download_icons.php
------------------
This script attempts to download all of the .ico files for the crawled sites and places them in an icon folder in the web_front_end

extract.php
-----------
This script extracts each XML index file created from the audit process, converts them
to JSON, and then writes out a javascript JSON variable named "sites" that is included
in the JavaScript based TOSBack2 front-end.
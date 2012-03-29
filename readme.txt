To install:

Get the base sql file and configure application/config/database.php with your database config.
Make sure the following dirs are writable:

application/logs
application/cache
images/posts

PHP also needs to be able to send mail.  Use postfix for best results.  It also needs imagemagick installed.  

Go into application/config and edit the database.php to reflect your database.  An example table structure can be found in campusbullet-blank.sql.

Set up a CRON job to run every night at midnight that executes cron.php from the commandline, which uses CURL to execute a PHP backup script.

CHANGE YOUR CURL KEY!!! application/config/masterlist.php AND cron.php!

Default admin username and password (change it after installation!!): campusbullet/studmuffin1234
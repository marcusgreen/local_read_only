### Version 1.02 of  Moodle local_read_only plugin Oct 2020
My thanks to sorincocorada  for reporting that quiz backups were broken.
https://github.com/marcusgreen/local_read_only/issues/6
This was because because execute would not allow write to
backup_ids_temp. Created a filter to allow execute statements based
on a permitted array. Fixed name of user_lastaccess table. Made
error message clearer if there was no update to config.php

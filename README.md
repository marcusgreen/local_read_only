### Description:

A Moodle local plugin that acts as a read-only database driver where database updates are silently discarded. Some essential tables are still written to to allow things like login, file downloads and new log records. (See list later on). User who have the site_admin role are exempt and updates will work for them as if the standard database driver was enabled.
### Installation:

1) git clone https://github.com/marcusgreen/local_read_only /pathtomoodle/local/read_only/

2) Edit your config.php and find the line that reads
```
require_once(__DIR__ . '/lib/setup.php');
```
Add the following on the line immediatly before that line
```
include_once(__DIR__.'/local/read_only/db.php');
```

3) Go to yourmoodle.com/admin and go through the standard plugin install and accept defaults

Credit:

Marcus Green & Hittesh Ahuja

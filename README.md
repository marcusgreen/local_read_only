### Installation:

1) git clone https://github.com/marcusgreen/local_read_only /pathtomoodle/local/read_only/

2) Edit your config.php and find the line that reads
require_once(__DIR__ . '/lib/setup.php');
Add the following on the line immediatly before that line
include_once(__DIR__.'/local/read_only/db.php');

3) Go to yourmoodle.com/admin and go through the standard plugin install and accept defaults

Credit:

Marcus Green & Hittesh Ahuja

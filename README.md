Installation:

1) git clone https://github.com/marcusgreen/local_read_only /pathtomoodle/local/read_only/

2) cp /pathtomoodle/local/read_only/classes/mysqliro_native_moodle_database.php /pathtomoodle/lib/dml/

3) Install and configure plugin at your.moodle.site/admin/settings.php?section=local_read_only

4) Edit your config.php and set $CFG->dbtype    = 'mysqliro';  

This fourth step is the one which actually makes your site read only, not the setting in the Moodle Site Admin.


Find out more:
Read-Only Moodle presentation at MoodleMoot UK 2019 - https://assets.moodlemoot.org/sites/91/20190424131255/3.-Read-Only-Moodle-Marcus-Green-_-Titus-Learning.pdf


Credit:

Marcus Green & Hittesh Ahuja

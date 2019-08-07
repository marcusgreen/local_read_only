<?php 
global $CFG;
if ($CFG->dbtype === 'mysqli') {
    require_once('mysqliro_native_moodle_database.php');
    $DB = mysqliro_native_moodle_database::init();
}

if ($CFG->dbtype === 'pgsql') {
    require_once('pgsqlro_native_moodle_database.php');
    $DB = pgsqlro_native_moodle_database::init();
}

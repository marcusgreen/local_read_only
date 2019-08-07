<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/*
Bring into config.php as
include_once(__DIR__.'/local/read_only/mysqliro_native_moodle_database.php');
*/

define('MOODLE_INTERNAL', true);
/* for codechecker conformance */
defined('MOODLE_INTERNAL') || die;


$driverdir = dirname(__FILE__, 3) . '/lib/dml';
require_once($driverdir.'/moodle_database.php');
require_once($driverdir.'/pgsql_native_moodle_recordset.php');
require_once($driverdir.'/pgsql_native_moodle_database.php');
require_once($driverdir.'/pgsql_native_moodle_temptables.php');


class pgsqlro_native_moodle_database extends pgsql_native_moodle_database {
    public static function init() {
        global $CFG, $DB;
        $CFG->dbtype = 'mysqliro';
        $DB = new pgsqlro_native_moodle_database();
        $DB->connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname, $CFG->prefix);
        return $DB;
    }
    public function get_writable_tables() {

        $writabletables = array(
            'sessions',
            'logstore_standard_log',
            'user_last_access',
            'backup_controllers',
            'backup_logs',
            'userbackup_logs',
            'backup_ids_temp',
            'backup_courses',
            'files'
        );
        return $writabletables;
    }
    public function get_drivername(){
        return 'mysqliro';
    }
    public function set_field($table, $newfield, $newvalue, array $conditions=null) {
        if ($this->is_readonly($table)) {
            return true;
        }
        return parent::set_field($table, $newfield, $newvalue, $conditions);
    }
    public function is_readonly($table) {
        $writabletables = $this->get_writable_tables();
        $enablereadonly = get_config('local_read_only', 'enable_readonly');
        if (!CLI_SCRIPT && $enablereadonly && !in_array($table, $writabletables) && !is_siteadmin()) {
            return true;
        }
    }
    public function insert_record_raw($table, $params, $returnid = true, $bulk = false, $customsequence = false) {
        if ($this->is_readonly($table)) {
            return true;
        }
        return parent::insert_record_raw($table, $params, $returnid, $bulk, $customsequence);
    }
    public function update_record_raw($table, $params, $bulk = false) {
        if ($this->is_readonly($table)) {
            return true;
        }
        return parent::update_record_raw($table, $params, $bulk);
    }
    public function delete_records_select($table, $select, array $params = null) {
        if ($this->is_readonly($table)) {
            return true;
        }
        return parent::delete_records_select($table, $select, $params);
    }
}

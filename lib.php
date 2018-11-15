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
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/read_only/classes/forms/local_read_only_alert_banner_form.php');
require_once($CFG->dirroot . '/local/read_only/classes/capabilities_processor.php');

//SET DBTYPE HERE to see if it persists


/**
 * Class local_read_only
 */

function local_read_only_before_standard_top_of_body_html() {
    global $PAGE;
    if(get_config('local_read_only', 'enable_readonly')==1){
    $output = $PAGE->get_renderer('local_read_only');
            return $output->render_alert_banner();
    }
}
function is_lib_dml_writable(){
    global $CFG;
    return is_writable($CFG->dirroot.'/lib/dml');
}
function is_config_php_writable(){
    global $CFG;
    return is_writable($CFG->dirroot.'/config.php');
}
function copy_mysqli_db_class_files(){
    global $CFG;
    if(is_lib_dml_writable()){
        echo "Copying files...";
        @copy(dirname(dirname(__FILE__)).'/read_only/classes/mysqliro_native_moodle_database.php',$CFG->dirroot.'/lib/dml/mysqliro_native_moodle_database.php');
    }


}
function process_capabilities_json_file($file_contents){

}
function remove_mysqli_db_class_files(){
    global $CFG;
    if(is_lib_dml_writable()){
        echo "Removing files...";
        unlink($CFG->dirroot.'/lib/dml/mysqliro_native_moodle_database.php');
    }

}
function show_settings_page($section){
    global $CFG;
    if($section == 'local_read_only_status'){
        $status_form = new local_read_only_alert_banner();
        $status_form->display();
    }

}

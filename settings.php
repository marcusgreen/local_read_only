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
global $PAGE, $CFG,$USER;
require_once($CFG->dirroot . '/local/read_only/lib.php');

require_login();


$do = optional_param('do', "config", PARAM_ALPHA);


 if ($hassiteconfig) {
    $ADMIN->add('local_read_only', new admin_category('read_only',
        get_string('pluginname', 'local_read_only')
    ));
     $section = optional_param('section', "", PARAM_RAW);
     //echo "SECTION:".$section;
     //show_settings_page($section);
    //Status Settings Page
    $temp = new admin_settingpage('local_read_only_status', 'Status');
    $table = new html_table();
    $table->head = array('Step/Component', get_string('status'),
        get_string('description'));
    $table->data = array();
    $row = array();
    // 'lib/dml' writable
    $row[0] = "Is 'lib/dml' writable";
    if (!is_lib_dml_writable()) {
        $status = html_writer::tag('span', get_string('no'), array('class' => 'statuscritical'));

    } else {
        $status = html_writer::tag('span', get_string('yes'), array('class' => 'statusok'));

    }
    $row[1] = $status;
    $row[2] = "We need the 'lib/dml' folder to be writable so the mysqliro db file can sit there";
    $table->data[] = $row;
    // 'config.php' writable
    $row = array();
    $row[0] = "Is 'config.php' file writable ? ";
    if (!is_config_php_writable()) {
        $status = html_writer::tag('span', get_string('no'), array('class' => 'statuscritical'));

    } else {
        $status = html_writer::tag('span', get_string('yes'), array('class' => 'statusok'));

    }
    $row[1] = $status;
    $row[2] = "Desc";
    $table->data[] = $row;
    $temp->add(new admin_setting_configempty('local_read_only_status_table', '', html_writer::table($table)));





    $ADMIN->add('read_only', $temp);
    //Alert Banner Message Page
    $temp = new admin_settingpage('local_read_only_alert_banner', 'Alert Banner');
    $temp->add(new admin_setting_confightmleditor('local_read_only/alert_message','alert_message','',null));
    $ADMIN->add('read_only', $temp);

    //Capabilities
    $temp = new admin_settingpage('local_read_only_capabilities', 'Capabilities');


    $temp->add(new admin_setting_configcheckbox('local_read_only/enable_readonly',
        get_string('enable_read_only', 'local_read_only'),
        get_string('enable_read_only_desc', 'local_read_only'), ''));


    $temp->add(new admin_setting_configcheckbox('local_read_only/enable_readonly',
        get_string('enable_read_only', 'local_read_only'),
        get_string('enable_read_only_desc', 'local_read_only'), ''));
    $ADMIN->add('read_only', $temp);


}

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
global $PAGE, $CFG, $USER;
require_once($CFG->dirroot . '/local/read_only/lib.php');

$do = optional_param('do', "config", PARAM_ALPHA);


if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_read_only',
        get_string('pluginname', 'local_read_only')
    );
    if ($ADMIN->fulltree) {

        $settings->add(new admin_setting_configcheckbox(
            'local_read_only/enable_readonly',
            get_string('enable_read_only', 'local_read_only'),
            get_string('enable_read_only_desc', 'local_read_only'),
            ''
        ));

         // Alert Banner Message.
         $settings->add(new admin_setting_confightmleditor('local_read_only/alert_message',
          'alert_message', '', get_string('default_alert', 'local_read_only')));
    }
    $ADMIN->add('localplugins', $settings);
}

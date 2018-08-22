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

/**
 * Class local_read_only_renderer
 */
class local_read_only_renderer extends plugin_renderer_base {
    public function render_prereq_message() {
        $data = array();
        return $this->render_from_template(
            'local_read_only/prerequisites_message', $data);
    }

    public function render_alert_banner() {
        $alert_msg_config = get_config('local_read_only', 'alertbanner');
        $data = array('message' => $alert_msg_config);
        return $this->render_from_template(
            'local_read_only/alert_banner', $data);
    }

    public function render_server_status() {
        global $CFG;
        $server_status = array();
        //Does file exist.
        $server_status['class_file_exists'] = file_exists($CFG->dirroot . '/lib/dml/mysqliro_native_moodle_database.php');
        $server_status['dbtype_read_only'] = ($CFG->config_php_settings['dbtype'] ==
        'mysqliro' ? 'yes' : 'no');

        $data = array('writable' => 'yes');
        return $this->render_from_template(
            'local_read_only/server_status', $server_status);
    }

    public function display_upload_capabilities($capabilities) {
        var_dump($capabilities);
        if (!empty($capabilities)) {
            $cap_array = json_decode($capabilities, true);
        }
        $caplist = $cap_array['read_only_capabilities'];
        return $this->render_from_template(
            'local_read_only/capabilities_table', ['caps' => $caplist]);

    }

    public function display_config_tab($currenttab) {
        global $OUTPUT;
        $row = array();
        if ($currenttab == '') {
            $currenttab = 'status';
        }

        $row[] = new tabobject('status', 'ownsettingspage.php?show=status',
            'Status', 'Status', false);
        $row[] = new tabobject('alertbanner', 'ownsettingspage.php?show=alertbanner',
            'Alert Banner', 'Alert Banner', true);
        $row[] = new tabobject('cap', 'ownsettingspage.php?show=cap',
            'Capabilities', 'Capabilities', false);
        echo $OUTPUT->tabtree($row, $currenttab);
    }

}
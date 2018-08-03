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
require_once($CFG->libdir . "/formslib.php");

class local_read_only_alert_banner_form extends moodleform {
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('editor', 'alertbanner', get_string('alert_message_label', 'local_read_only'));
        $mform->setType('alertbanner', PARAM_RAW);
        $this->add_action_buttons();
    }

}
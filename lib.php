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

//SET DBTYPE HERE to see if it persists


/**
 * Class local_read_only
 */

function local_read_only_before_standard_top_of_body_html(){
    global $PAGE, $CFG;
    if ((isset($PAGE) &&  ($PAGE->pagetype==="login-index"))) {
            if (get_config('local_read_only', 'enable_readonly') === "1") {
                $output = $PAGE->get_renderer('local_read_only');
                return $output->render_alert_banner();
            } 
    }
}





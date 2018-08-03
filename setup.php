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
require_once(__DIR__.'/../../config.php');
 global $PAGE, $CFG,$OUTPUT;
require_once($CFG->libdir.'/adminlib.php');
//admin_externalpage_setup('localread_only');

$PAGE->set_url($CFG->dirroot.'/local/read_only/setup.php',[]);
$PAGE->set_heading("Heading");
$PAGE->set_title("Tritle");
if (!$context = context_system::instance() || !is_siteadmin()) {
    print_error('nocontext');
}
$PAGE->set_context($context);
require_login(context_system::instance());
echo $OUTPUT->header();
 $tabs = array();
$tabs[] = new tabobject('turnitinsettings', 'settings2.php',
    get_string('config', 'plagiarism_turnitin'), get_string('config', 'plagiarism_turnitin'), false);
print_tabs(array($tabs));
echo $OUTPUT->footer();

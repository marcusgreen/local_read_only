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
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir.'/csvlib.class.php');

require_once($CFG->dirroot . '/local/read_only/classes/forms/local_read_only_alert_banner_form.php');
require_once($CFG->dirroot . '/local/read_only/classes/forms/local_read_only_cap_form.php');

//admin_externalpage_setup('managelocalplugins', '', array(), '');
$PAGE->navbar->add('Read Only Setup');
$PAGE->set_pagelayout('standard');
//$PAGE->set_context(context_system::instance());
$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/local/smart_klass/dashboard.php'));
$PAGE->set_title('Heading');
echo $OUTPUT->header();
$renderer = $PAGE->get_renderer('local_read_only');
$show = optional_param('show', '', PARAM_RAW);

$tabs = array();
$tabs[] = new tabobject('turnitinsettings', 'ownsettingspage.php?show=status',
    'Status', 'Status', false);
$tabs[] = new tabobject('turnitinsettings', 'ownsettingspage.php?show=alertbanner',
    'Alert Banner', 'Alert Banner', true);
$tabs[] = new tabobject('turnitinsettings', 'ownsettingspage.php?show=cap',
    'Capabilities', 'Capabilities', false);
$tabs[] = new tabobject('turnitinsettings', 'ownsettingspage.php',
    get_string('config', 'plagiarism_turnitin'), get_string('config', 'plagiarism_turnitin'), false);
//print_tabs(array($tabs));
    $renderer->display_config_tab($show);
switch ($show) {
    case 'status':
        echo $renderer->render_server_status();
        break;
    case 'cap':
        $uploadcapform = new local_read_only_cap_form('/moodlesandboxhittesh/local/read_only/ownsettingspage.php?show=cap');
        //$content = $uploadcapform->get_file_content('userfile');
        if ($uploadcapform->is_cancelled()) {

        } else if ($fromform = $uploadcapform->get_data()) {
                $iid = csv_import_reader::get_new_iid('userfile');
                $cir = new csv_import_reader($iid, 'userfile');
            $content = $uploadcapform->get_file_content('jsonfile');
            $readcount = $cir->load_csv_content($content, $formdata->encoding, $formdata->delimiter_name);
            $csvloaderror = $cir->get_error();
            unset($content);

            if (!is_null($csvloaderror)) {
                print_error('csvloaderror', '', $returnurl, $csvloaderror);
            }

            //display uploaded content
            echo $renderer->display_upload_capabilities($content);
            break;
         }
         $uploadcapform->display();
        break;
    case 'alertbanner':
        $alertbnannerform = new local_read_only_alert_banner_form('/moodlesandboxhittesh/local/read_only/ownsettingspage.php?show=alertbanner');
        $existingtext = get_config('local_read_only', 'alertbanner');
        $data = new stdClass();
        $data->alertbanner['text'] = $existingtext;
        $alertbnannerform->set_data($data);
        $alertbnannerform->display();
        if ($alertbnannerform->is_cancelled()) {

        } else if ($fromform = $alertbnannerform->get_data()) {
            //In this case you process validated data. $mform->get_data() returns data posted in form.
            set_config('alertbanner',$fromform->alertbanner['text'],'local_read_only');
        }

        break;
}
echo $OUTPUT->footer();
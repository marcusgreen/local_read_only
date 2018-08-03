<?php
/**
 * Created by PhpStorm.
 * User: ha386
 * Date: 16/07/2018
 * Time: 11:11
 */

class local_readonly_settings {

    public function show_settings_tab(){
        $tabs = array();
        $tabs[] = new tabobject('turnitinsettings', 'settings.php',
            get_string('config', 'plagiarism_turnitin'), get_string('config', 'plagiarism_turnitin'), false);
        $tabs[] = new tabobject('turnitinsettings', 'settings.php',
            get_string('config', 'plagiarism_turnitin'), get_string('config', 'plagiarism_turnitin'), false);

    }
}
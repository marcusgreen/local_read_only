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

class capabilties_management {

    public $table;
    public $mdl_cap_table ;
    public function __construct() {
        $this->table = 'local_read_only_capabilities';
        $this->mdl_cap_table = 'role_capabilities';
    }

    public function restore(){

    }
    public function process_capabilities($json_content){
        var_dump($json_content);
        var_dump(json_decode($json_content));
    }
    public function add_capability($capabilityrecord){

        global $DB;
        $DB->insert_record($this->table,$capabilityrecord);

    }

}
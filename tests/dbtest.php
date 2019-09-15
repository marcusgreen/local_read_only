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
/**
 * Test harness for local_read_only.
 *
 * @copyright  2019 Marcus Green
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define('CLI_SCRIPT', true);

require __DIR__ . '/../../../config.php';

/*
 * Test harness for local_read_only. It is hard to get phpunit
 * to test its own database with a replacement driver so this
 * does basic tests using the block table.
 *
 * @copyright  2019 Marcus Green
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->libdir.'/clilib.php');


test_read_only();
	 function test_read_only() {
		 global $DB;
		 /** disable read_only */
		set_config('enable_readonly', false, 'local_read_only');

		$dbman = $DB->get_manager();
		$table = new xmldb_table('test_table');
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
		$table->add_field('testfield', XMLDB_TYPE_CHAR, '50', null, null, null, null, 'id');
		$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
	
		if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

		 define(CLI, false);

		$result = $DB->delete_records('test_table');
		$test_record = (object) [
			'testfield' => 'testvalue',
		];

		$id = $DB->insert_record('test_table', $test_record);
		 
		 set_config('enable_readonly', true, 'local_read_only');
		
		$DB->execute("DELETE from {test_table}");
		 $test_result = $DB->get_records('test_table', ['testfield' => 'testvalue']);
		 if (empty($test_result)) {
			 cli_writeln('$DB->execute with delete test passed');
		  } else{
              cli_writeln('$DB->execute with delete test failed');
          }
		 
		$DB->execute("INSERT INTO {test_table} (test_field)",['updated']);
		$test_result = $DB->get_records('test_table', ['testfield' => 'updated']);

		if (empty($test_result)) {
			cli_writeln('$DB->execute with insert test passed');
		 } else{
			cli_writeln('$DB->execute with insert test failed');
		 }
	 	 
		$DB->execute("UPDATE  {test_table}  SET test_field ='updated'");
		$test_result = $DB->get_records('test_table', ['testfield' => 'updated']);
		if (empty($test_result)) {
			cli_writeln('$DB->execute with update test passed');
		 } else{
             cli_writeln('$DB->execute with update test failed');
         }


		$test_record->id = $id;
		$test_record->testfield = 'update';		 
	 	$DB->update_record('test_table', $test_record);
		$test_result = $DB->get_records('test_table', ['testfield' => 'update']);

	 	if (empty($test_result)) {
			cli_writeln('$DB->update_record test passed');
		 } else{
			cli_writeln('$DB->update_record test passed');
		 }
		$DB->set_field('test_table', 'testfield', 'updated',['testfield' => 'update2']);
		$test_result = $DB->get_records('test_table', ['testfield' => 'update2']);
		if (empty($test_result)) {
			cli_writeln('$DB->set_field test passed');
		}else{
			cli_writeln('$DB->set_field test failed');

		}
		$test_record->test_field = 'testrecord2';
		$DB->insert_record('test_table', $test_record);
		$record = $DB->get_records('test_table', ['testfield' => 'testrecord2']);
		if (empty($newblock)) {
			cli_writeln('$DB->insert_record test passed');
		} else{
			cli_writeln('$DB->insert_record test failed');
		}

		$result = $DB->delete_records('test_table',['id'=>$id]);
		$result = $DB->get_records('test_table');
		/* delete should not have worked so should contain record */
		if (!empty($result)) {
			cli_writeln('$DB->delete_record test passed');
		} else{
			cli_writeln('$DB->delete_record test failed');
		}

		 $record = $DB->get_record('test_table',['testfield'=>'testvalue']);
		 $record->test_field = 'updated';
		 $DB->update_record('test_table', $record);
		 $record = $DB->get_record('test_table',['testfield'=>'updated']);
		 if ($record == false) {
			cli_writeln('Update writeable table test passed');
		} else{
			cli_writeln('Update writeable table test failed');
		}

		 set_config('enable_readonly', true, 'local_read_only');

		 $result = $DB->delete_records('test_table');
		 $dbman->drop_table($table);

	 }

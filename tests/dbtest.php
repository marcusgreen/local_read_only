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
		set_config('enable_readonly', false, 'local_read_only');

		$dbman = $DB->get_manager();
		$table = new xmldb_table('test_table');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);
		$table->add_field('testfield', XMLDB_TYPE_CHAR, '50', null, null, null, null, 'id');
		$table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
		if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

		 global $DB;
		 define(CLI, false);
		 $test_record = (object) [
			'testfield' => 'testrecord',

		];

		$result = $DB->delete_records('test_table');

		$result = $DB->get_records('test_table');


		 $id = $DB->insert_record('test_table', $test_record);
		 $result = $DB->get_records('test_table');

		 
	 	set_config('enable_readonly', true, 'local_read_only');

	 	//is_siteadmin(true);
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
		$newblock3 = $DB->get_records('block', ['name' => 'testblock3']);
		if (empty($newblock3)) {
			cli_writeln('$DB->set_field test passed');
		}else{
			cli_writeln('$DB->set_field test failed');

		}
		$block->name = 'testblock2';
		$result = $DB->insert_record('block', $block);
		$newblock = $DB->get_records('block', ['name' => 'testblock2']);
		if (empty($newblock)) {
			cli_writeln('$DB->insert_record test passed');
		} else{
			cli_writeln('$DB->insert_record test failed');
		}

		$block->name = 'testblock';
		$result = $DB->delete_records('block', (array) $block);
		$testblock = $DB->get_records('block', ['name' => 'testblock']);
		/* no delete so should contain record */
		if (empty($newblock)) {
			cli_writeln('$DB->delete_record test passed');
		} else{
			cli_writeln('$DB->delete_record test failed');
		}

		 $user = $DB->get_record('user',['username'=>'guest']);
		 $user->lastname = 'updated';
		 $DB->update_record('user', $user);
		 $user = $DB->get_record('user',['username'=>'guest']);
		 if ($user->lastname =='updated') {
			cli_writeln('Update writeable table test passed');
		} else{
			cli_writeln('Update writeable table test failed');
		}
		$user->lastname = '';
		$DB->update_record('user', $user);

		 set_config('enable_readonly', true, 'local_read_only');

		 $result = $DB->delete_records('block', ['name' => 'testblock']);
		 $dbman->drop_table($table);


	 }

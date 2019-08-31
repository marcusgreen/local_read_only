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
		set_config('enable_readonly', false, 'local_read_only');

		 global $DB;
		 define(CLI, false);
		 $block = (object) [
			'name' => 'testblock',
			'cron' => 1,
			'lastcron' => 1,
			'visible' => 1,
		];

		$result = $DB->delete_records('block', ['name' => 'testblock']);
		$result = $DB->delete_records('block', ['name' => 'updated']);

	 	$result = $DB->insert_record('block', $block);
		 
	 	set_config('enable_readonly', true, 'local_read_only');

	 	//is_siteadmin(true);
	 	$block->id = $result;
		$block->name = 'updated';
		 
	 	$result = $DB->update_record('block', $block);
	 	$updatedblock = $DB->get_records('block', ['name' => 'updated']);
	 	if (empty($updatedblock)) {
			cli_writeln('$DB->update_record test passed');
		 } else{
			cli_writeln('$DB->update_record test passed');
		 }
		$DB->set_field('block', 'name', 'updated',['name' => 'testblock']);
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
		 set_config('enable_readonly', true, 'local_read_only');
		 $result = $DB->delete_records('block', ['name' => 'testblock']);

	 }

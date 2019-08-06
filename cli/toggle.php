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
 * Toggle read_only status on and off from the command line
 *
 * @package    local
 * @subpackage read_only
 * @copyright  2019 Marcus Green
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/clilib.php');
$status = get_config('local_read_only', 'enable_readonly');
$instruction = 'type on to enable';
if ($status) {
    $instruction = 'type off to disable';
}

$onoff = ($status) ? "on" : "off";
cli_writeln('read_only is currently: ' . $onoff);

$input = strtolower(cli_input($instruction, false));
if ($input == 'off') {
    set_config('enable_readonly', false, 'local_read_only');
} else ($input == 'on') {
    set_config('enable_readonly', true, 'local_read_only');
} else {
    cli_writeln('nothing was changed');
}

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
$setting = 'enable_readonly';
$plugin = 'local_read_only';

$status = get_config($plugin, $setting);

$params = cli_get_params([], []);


$enable = $params[1][0] ?? '';

if (($enable !== 'on') &&  ($enable !=='off')) {
	$instruction = 'type on to enable';
	if ($status) {
		$instruction = 'type off to disable';
	}

	$onoff = ($status) ? 'on' : 'off';
	cli_writeln('read_only is currently: ' . $onoff);
	$enable = strtolower(cli_input($instruction, false));
}

if ($enable == 'off') {
    set_config($setting, false, $plugin);
    cli_writeln('read_only is now: off');
} else if ($enable == 'on') {
    set_config($setting, true, $plugin);
    cli_writeln('read_only is now: on');
} else {
	cli_writeln('nothing was changed');
	cli_writeln('on or off to toggle the database read only state');
	ascii_logo();
}

 function ascii_logo($padding=2, $return=false) {

	$lines = [
		"                                                   ",
		"    _____                _    ____        _        ",
		"   |  __ \              | |  / __ \      | |       ",
		"   | |__) |___  __ _  __| | | |  | |_ __ | |_   _  ",
		"   |  _  // _ \/ _` |/ _` | | |  | | '_ \| | | | | ",
		"   | | \ \  __/ (_| | (_| | | |__| | | | | | |_| | ",
		"   |_|  \_\___|\__,_|\__,_|  \____/|_| |_|_|\__, | ",
		"                                             __/ | ",
		"                                            |___/  ",
	];

    $logo = '';

    foreach ($lines as $line) {
        $logo .= str_repeat(' ', $padding);
        $logo .= $line;
        $logo .= PHP_EOL;
    }

    if ($return) {
        return $logo;
    } else {
        cli_write($logo);
    }
}

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
 * Post installation and migration code.
 *
 *
 * @package    local_read_only
 * @copyright  University of Bath <kttp://bath.ac.uk>
 * @author     Oscar Ruesga <ha386@bath.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//defined('MOODLE_INTERNAL') || die;
define(CLI_SCRIPT, true);
function xmldb_local_read_only_install() {
	edit_config();
    return true;
}
edit_config();

/** 
 * Insert require_once link to the readonly code in config.php
 * just before the call to setup.
 */
function edit_config() {
	global $CFG;

	$file_path = '/../../../config.php';
	$insert_marker = "require_once(__DIR__ . '/lib/setup.php');";
	$text = "\ninclude_once(__DIR__.'/local/read_only/db.php');\n\n";

	$contents = file_get_contents(__DIR__.$file_path);

//	if(!is_writable(__DIR__.$file_path)){
	// if(1 == 1){
	// 	echo '<textarea rows="20" cols="70">'.$contents .'</textarea>';
	// }else{
	// 	echo 'is writeable';
	// }
	// exit();
	if (false !== strpos($contents, $text)) {
		return 'target not found';
	}
	$replacement = $text . $insert_marker;
	$new_contents = str_replace($insert_marker, $replacement, $contents);
	file_put_contents($file_path, $new_contents);
}


$num_bytes = insert_into_file($file_path, $insert_marker, $text);

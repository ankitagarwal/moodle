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
 * Ajax responder page.
 *
 * @package    report_loglive
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('AJAX_SCRIPT', true);
require_once('../../config.php');

$id      = optional_param('id', 0, PARAM_INT);
$page    = optional_param('page', 0, PARAM_INT);
$since    = optional_param('since', 0, PARAM_INT);

// Capability checks.
if (empty($id)) {
    require_login();
    $context = context_system::instance();
} else {
    $course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
    require_login($course);
    $context = context_course::instance($course->id);
}
require_capability('report/loglive:view', $context);

$manager = new \report_loglive\manager();
$reader = $manager->get_selected_reader();
if (!$since) {
    $since = $since - $manager->cutoff;
}
echo $manager->get_livelogs_json($reader, $id, $since, $page);
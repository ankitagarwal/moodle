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
 * This page lets users provide evidence of a prior learning to a competency in any of their active learning plans.
 *
 * @package    tool_lp
 * @copyright  2015 Dave Cooper 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toollpcompetencies');

$userid = optional_param('userid', false, PARAM_INT);

// Default to the current user.
if (!$userid) {
    $userid = $USER->id;
}

$context = context_user::instance($userid);
$PAGE->set_context($context);

$title = get_string('evidencepage', 'tool_lp');
$pagetitle = get_string('evidencepage', 'tool_lp');

$form = new \tool_lp\form\learning_evidence(null);

if ($form->is_cancelled()) {
    // TODO - What do we do?
}

// Set up the page.
$url = new moodle_url('/admin/tool/lp/learningevidence.php');
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

$data = $form->get_data();

if ($data) {
    // Save the changes and we probably want to continue back to some page.
    print_object($data);
    require_sesskey();
    // TODO - this function needs to be defined.
    \tool_lp\api::create_evidence($data);
} else {
    $form->display();
}

echo $OUTPUT->footer();

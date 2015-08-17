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
 * Allows the user to manage custom timezones.
 *
 * @copyright 2015 onwards Ankit Agarwal
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package calendar
 */

require_once('../config.php');
require_once($CFG->libdir.'/bennu/bennu.inc.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/calendar/managesubscriptions_form.php');

// Required use.
$filename = required_param('filename', PARAM_PATH);
$subscriptionid = required_param('subscriptionid', PARAM_INT);
$courseid = optional_param('course', SITEID, PARAM_INT);

$filepath = $CFG->tempdir . '/' . $filename;
$content = file_get_contents($filepath);

// Setup page.
$url = new moodle_url('/calendar/timezonemappings.php');
if ($courseid != SITEID) {
    $url->param('course', $courseid);
}
$url->param('filename', $filename);
$url->param('subscriptionid', $subscriptionid);

$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->navbar->add(get_string('managesubscriptions', 'calendar'));

if ($courseid != SITEID && !empty($courseid)) {
    $course = $DB->get_record('course', array('id' => $courseid));
    $courses = array($course->id => $course);
} else {
    $course = get_site();
    $courses = calendar_get_default_courses();
}
require_course_login($course);
if (!calendar_user_can_add_event($course)) {
    print_error('errorcannotimport', 'calendar');
}

$PAGE->set_title("$course->shortname: ".get_string('calendar', 'calendar').": ".get_string('subscriptions', 'calendar'));
$PAGE->set_heading($course->fullname);

if (empty($content)) {
    // Should never happen.
    throw new coding_exception("Something went wrong. Please try again");
}

$ical = new iCalendar();
$ical->unserialize($content);

// First find invalid timezones if present.
$events = $ical->components['VEVENT'];
$invalidtzs = calendar_find_invalid_timezones($events);
if (empty($invalidtzs)) {
    // Should never happen.
    throw new coding_exception("Something went wrong. Please try again");
}

$mform = new \core_calendar\timezonemapping_form('', array('subscriptionid' => $subscriptionid, 'filename' => $filename,
        'invalidtzs' => $invalidtzs));

if ($mform->is_cancelled()) {
    // Cleanup.
    calendar_delete_subscription($subscriptionid);
    @unlink($filepath);
    redirect(new moodle_url('/calendar/'));
}

if ($mform->is_submitted() &&  $data = $mform->get_data()) {
    $records = array();
    foreach ($data as $key => $validtz) {
        if (strpos($key, 'timezone_') === 0) {
            $invalidtz = str_replace('timezone_', '', $key);
            $record = new stdClass();
            $record->subscriptionid = $subscriptionid;
            $record->invalidtz = $invalidtz;
            $record->validtz = $validtz;
            $records[] = $record;
        }
    }
    $DB->insert_records('calendar_bad_tz_mapping', $records);
    $importresults = calendar_import_icalendar_events($ical, $courseid, $subscriptionid);
    // Redirect to prevent refresh issues.
    redirect(new moodle_url('/calendar/'), $importresults);
}

// Output page.
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
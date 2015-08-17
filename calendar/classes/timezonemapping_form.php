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
 * Form for timezone mapping.
 *
 * @copyright 2015 onwards Ankit Agarwal
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package calendar
 */

namespace core_calendar;

// Always include formslib.
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    // It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

class timezonemapping_form extends \moodleform {

    /**
     * Form definition.
     */
    public function definition() {
        $invalidtzs = $this->_customdata['invalidtzs'];
        $filename = $this->_customdata['filename'];
        $subscriptionid = $this->_customdata['subscriptionid'];

        $mform = $this->_form;

        // Hidden fields.
        $mform->addElement('hidden', 'subscriptionid', $subscriptionid);
        $mform->setConstant('subscriptionid', $subscriptionid);
        $mform->setType('subscriptionid', PARAM_INT);

        $mform->addElement('hidden', 'filename', $filename);
        $mform->setConstant('filename', $filename);
        $mform->setType('filename', PARAM_PATH);

        $validtzs = \core_date::get_list_of_timezones();
        foreach ($invalidtzs as $invalidtz) {
            $mform->addElement('select', 'timezone_' . $invalidtz, $invalidtz, $validtzs);
            $mform->addRule('timezone_' . $invalidtz, get_string('required'), 'required');
        }
        $this->add_action_buttons(true, get_string('savechanges'));
    }
}

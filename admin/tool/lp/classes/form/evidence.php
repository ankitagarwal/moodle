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
 * This file contains the form to provide evidence of prior learning to a competency.
 *
 * @package   tool_lp
 * @copyright 2015 Dave Cooper
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_lp\form;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

use moodleform;
use tool_lp\api;

require_once($CFG->libdir.'/formslib.php');

class evidence extends moodleform {

    /**
     * Define the form - called by parent constructor
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('evidencename', PARAM_TEXT);

        $mform->addElement('editor', 'description', get_string('description'));
        $mform->setType('evidencedescription', PARAM_TEXT);

        $mform->addElement('filepicker', 'evidencefileattachments', get_string('evidencefileattachments', 'tool_lp'), null, array('accepted_types' => '*'));

        $mform->addElement('text', 'link', get_string('evidencelink'));
        $mform->setType('evidencelink', PARAM_TEXT);

        $this->add_action_buttons();
    }
}

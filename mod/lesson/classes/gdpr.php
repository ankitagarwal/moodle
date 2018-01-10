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
 * GDPR class. The methods are just for example they would and must be changed.
 *
 * @package    mod_lesson
 * @copyright  2018 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_lesson;

/**
 * GDPR class.
 *
 * @package    mod_lesson
 * @copyright  2018 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class gdpr extends \core\gdpr\base{
    /**
     * Returns what types of personal data is stored by the plugin(for ex - grades, social, user interaction etc)
     * If nothing is stored, null should be returned.
     * @return []|null
     */
    public static function get_stored_datatypes() {
        return [self::DATATYPE_GRADE];
    }

    /** Get all user related data for a given user and given data type. */
    public function get_userdata($userid = null, $datatype = null) {
        // Do some nasty stuff.
    }
}

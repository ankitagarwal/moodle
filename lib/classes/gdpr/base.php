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
 * GDPR abstract class. The methods are just for example they would and must be changed.
 *
 * @package    core_gdpr
 * @copyright  2018 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace core\gdpr;

/**
 * GDPR abstract class.
 *
 * @package    core_gdpr
 * @copyright  2018 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class base {
    const DATATYPE_GRADE = "grades";
    const DATATYPE_SOCIAL = "social";
    /**
     * Returns what types of personal data is stored by the plugin(for ex - grades, social, user interaction etc)
     * If nothing is stored, null should be returned.
     * @return []|null
     */
    abstract public static function get_stored_datatypes();

    /** Does this plugin store any user data at all.  */
    public function stores_userdata() {
        return (empty(self::get_stored_datatypes()) ? false : true);
    }

    /** Get all user related data for a given user and given data type. */
    abstract public function get_userdata($userid = null, $datatype = null);
}

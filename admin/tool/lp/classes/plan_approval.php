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
 * Class for loading/storing plan_approval from the DB.
 *
 * @package    tool_lp
 * @copyright  2015 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_lp;

/**
 * Class for loading/storing plan_approval from the DB.
 *
 * @copyright  2015 onwards Ankit Agarwal
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class plan_approval extends persistent {

    /** Approval requested action */
    const ACTION_APPROVAL_REQUESTED = 0;

    /** Plan approved action */
    const ACTION_APPROVED = 1;

    /** Plan rejected action */
    const ACTION_REJECTED = 2;

    /** @var int $planid The plan id */
    private $planid = 0;

    /** @var int $userid The user id */
    private $userid = 0;

    /** @var int $action Approval request or approved action */
    private $action = 0;

    /**
     * Method that provides the table name matching this class.
     *
     * @return string
     */
    public function get_table_name() {
        return 'tool_lp_plan_approval';
    }

    /**
     * Get the plan id
     *
     * @return int The plan id
     */
    public function get_planid() {
        return $this->planid;
    }

    /**
     * Set the plan id
     *
     * @param int $planid The plan id
     */
    public function set_planid($planid) {
        $this->planid = $planid;
    }

    /**
     * Get the userid index.
     *
     * @return string The userid index
     */
    public function get_userid() {
        return $this->userid;
    }

    /**
     * Set the userid index.
     *
     * @param string $userid The userid index
     */
    public function set_userid($userid) {
        $this->userid = $userid;
    }

    /**
     * Get the plan id.
     *
     * @return int The template id
     */
    public function get_action() {
        return $this->action;
    }

    /**
     * Set the plan id.
     *
     * @param int $action The template id
     */
    public function set_action($action) {
        $this->action = $action;
    }

    /**
     * Populate this class with data from a DB record.
     *
     * @param \stdClass $record A DB record.
     * @return template_competency
     */
    public function from_record($record) {
        if (isset($record->id)) {
            $this->set_id($record->id);
        }
        if (isset($record->planid)) {
            $this->set_planid($record->planid);
        }
        if (isset($record->userid)) {
            $this->set_userid($record->userid);
        }
        if (isset($record->action)) {
            $this->set_action($record->action);
        }
        if (isset($record->timecreated)) {
            $this->set_timecreated($record->timecreated);
        }
        return $this;
    }

    /**
     * Create a DB record from this class.
     *
     * @return \stdClass
     */
    public function to_record() {
        $record = new \stdClass();
        $record->id = $this->get_id();
        $record->planid = $this->get_planid();
        $record->userid = $this->get_userid();
        $record->action = $this->get_action();
        $record->timecreated = $this->get_timecreated();

        return $record;
    }
}
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
 * This file contains the unittests for core scss.
 *
 * @package   core
 * @category  phpunit
 * @copyright 2016 onwards Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * This file contains the unittests for core scss.
 *
 * @package   core
 * @category  phpunit
 * @copyright 2016 onwards Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_csss_testcase extends advanced_testcase {

    /**
     * Data provider for test_strip_invalid_scss_files
     * @return array
     */
    public function strip_invalid_scss_files_provider() {
        return [
            "Non file import 1" => [
                "content" => "@import 'moodle'
                Zombie",
                "cleaned" => "@import 'moodle'
                Zombie",
                "debugexpected" => 0
            ],
            "Non file import 2" => [
                "content" => "@import \"moodle\"
                Zombie",
                "cleaned" => "@import \"moodle\"
                Zombie",
                "debugexpected" => 0
            ],
            "Non file import 3" => [
                "content" => "@import         'moodle'
                Zombie",
                "cleaned" => "@import         'moodle'
                Zombie",
                "debugexpected" => 0
            ],
            "Non file import 4" => [
                "content" => "@import         \"moodle\"
                Zombie",
                "cleaned" => "@import         \"moodle\"
                Zombie",
                "debugexpected" => 0
            ],

            "File import 1" => [
                "content" => "@import '..\\test.php'
                Zombie",
                "cleaned" => "
                Zombie",
                "debugexpected" => 1
            ],
            "File import 2" => [
                "content" => "@import \"..\\test.php\"
                Zombie",
                "cleaned" => "
                Zombie",
                "debugexpected" => 1
            ],
            "File import 3" => [
                "content" => "@import         '..\\test.xml'
                Zombie",
                "cleaned" => "
                Zombie",
                "debugexpected" => 1
            ],
            "File import 4" => [
                "content" => "@import         \"..\\test.py\"
                Zombie",
                "cleaned" => "
                Zombie",
                "debugexpected" => 1
            ],

            "Valid file import 1" => [
                "content" => "@import '..\\..\\test.scss'
                Zombie",
                "cleaned" => "@import '..\\..\\test.scss'
                Zombie",
                "debugexpected" => 0
            ],
            "Valid file import 2" => [
                "content" => "@import \"..\\..\\test.scss\"
                Zombie",
                "cleaned" => "@import \"..\\..\\test.scss\"
                Zombie",
                "debugexpected" => 0
            ],
            "Valid file import 3" => [
                "content" => "@import         '..\\..\\test.scss'
                Zombie",
                "cleaned" => "@import         '..\\..\\test.scss'
                Zombie",
                "debugexpected" => 0
            ],
            "Valid file import 4" => [
                "content" => "@import         \"..\\..\\test.scss\"
                Zombie",
                "cleaned" => "@import         \"..\\..\\test.scss\"
                Zombie",
                "debugexpected" => 0
            ],

            "Multiple file import 1" => [
                "content" => "@import '..\\..\\test.scss'
                @import '..\\..\\test2.scss'",
                "cleaned" => "@import '..\\..\\test.scss'
                @import '..\\..\\test2.scss'",
                "debugexpected" => 0
            ],
            "\"Multiple file import 2" => [
                "content" => "@import '..\\..\\test.scss'
                @import '..\\..\\test2.php'",
                "cleaned" => "@import '..\\..\\test.scss'
                ",
                "debugexpected" => 1
            ],
            "Multiple file import 3" => [
                "content" => "@import '..\\..\\test.ipynb'
                @import '..\\..\\test2.scss'",
                "cleaned" => "
                @import '..\\..\\test2.scss'",
                "debugexpected" => 1
            ],
            "Multiple file import 4" => [
                "content" => "@import '..\\..\\test.php'
                @import '..\\..\\test2.py'",
                "cleaned" => "
                ",
                "debugexpected" => 2
            ],
        ];
    }

    /**
     * @dataProvider strip_invalid_scss_files_provider
     */
    public function test_strip_invalid_scss_files($content, $cleaned, $debugexpected) {
        $scss = new core_scss();
        $stripped = $scss->strip_invalid_scss_files($content);
        if ($debugexpected) {
            $this->assertDebuggingCalledCount($debugexpected);
        }
        $this->assertSame($cleaned, $stripped);
    }
}
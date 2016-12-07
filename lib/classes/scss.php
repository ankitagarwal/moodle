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
 * Moodle implementation of SCSS.
 *
 * @package    core
 * @copyright  2016 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Moodle SCSS compiler class.
 *
 * @package    core
 * @copyright  2016 Frédéric Massart
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_scss extends \Leafo\ScssPhp\Compiler {

    /** @var string The path to the SCSS file. */
    protected $scssfile;
    /** @var array Bits of SCSS content to prepend. */
    protected $scssprepend = array();
    /** @var array Bits of SCSS content. */
    protected $scsscontent = array();

    /**
     * Add variables.
     *
     * @param array $scss Associative array of variables and their values.
     * @return void
     */
    public function add_variables(array $variables) {
        $this->setVariables($variables);
    }

    /**
     * Append raw SCSS to what's to compile.
     *
     * @param string $scss SCSS code.
     * @return void
     */
    public function append_raw_scss($scss) {
        $this->scsscontent[] = $this->strip_invalid_scss_files($scss);
    }

    /**
     * Prepend raw SCSS to what's to compile.
     *
     * @param string $scss SCSS code.
     * @return void
     */
    public function prepend_raw_scss($scss) {
        $this->scssprepend[] = $this->strip_invalid_scss_files($scss);
    }

    /**
     * Set the file to compile from.
     *
     * The purpose of this method is to provide a way to import the
     * content of a file without messing with the import directories.
     *
     * @param string $filepath The path to the file.
     * @return void
     */
    public function set_file($filepath) {
        $this->scssfile = $filepath;
        $this->setImportPaths([dirname($filepath)]);
    }

    /**
     * Compiles to CSS.
     *
     * @return string
     */
    public function to_css() {
        $content = implode(';', $this->scssprepend);
        if (!empty($this->scssfile)) {
            $content .= file_get_contents($this->scssfile);
        }
        $content .= implode(';', $this->scsscontent);
        $content = $this->strip_invalid_scss_files($content);
        return $this->compile($content);
    }

    /**
     * Remove files that are being imported and are not scss.
     *
     * @param string $content scss content.
     *
     * @return string cleaned scss content.
     */
    public function strip_invalid_scss_files($content) {
        if (preg_match_all('!@import\s+[\'"](.+?)\.(.+?)[\'"]!', $content, $matches, PREG_SET_ORDER)){
            foreach ($matches as $match) {
                $url = end($match);
                if (strpos($url, ".scss") === false) {
                    // Sneaky stuff, don't let non scss file in.
                    $content = str_replace($match[0], "", $content);

                    // Throw a developer notice.
                    debugging("Cann't import scss file - " . $url, DEBUG_DEVELOPER);
                }
            }
        }
        return $content;
    }

}

<?php

namespace core_cohort\external;
defined('MOODLE_INTERNAL') || die();

use renderer_base;

/**
 * Class for exporting a cohort summary from an stdClass.
 *
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cohort_summary_exporter extends \core\external\exporter {

    protected static function define_related() {
        // Cohorts can exist on a category context.
        return array('context' => '\\context');
    }

    public static function define_properties() {
        return array(
            'id' => array(
                'type' => PARAM_INT,
            ),
            'name' => array(
                'type' => PARAM_TEXT,
            ),
            'idnumber' => array(
                'type' => PARAM_RAW,        // ID numbers are plain text.
                'default' => '',
                'null' => NULL_ALLOWED
            ),
            'description' => array(
                'type' => PARAM_TEXT,
                'default' => '',
                'null' => NULL_ALLOWED
            ),
            'descriptionformat' => array(
                'type' => PARAM_INT,
                'default' => FORMAT_HTML,
                'null' => NULL_ALLOWED
            ),
            'visible' => array(
                'type' => PARAM_BOOL,
            ),
            'theme' => array(
                'type' => PARAM_THEME,
                'null' => NULL_ALLOWED
            )
        );
    }

    public static function define_other_properties() {
        return array(
            'contextname' => array(
                // The method context::get_context_name() already formats the string, and may return HTML.
                'type' => PARAM_RAW
            ),
        );
    }

    protected function get_other_values(renderer_base $output) {
        return array(
            'contextname' => $this->related['context']->get_context_name()
        );
    }
}

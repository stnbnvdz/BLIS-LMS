<?php


namespace core_cohort\output;

use lang_string;

/**
 * Class to prepare a cohort name for display.
 *
 * @package   core_cohort
 * @copyright 2016 Marina Glancy
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cohortname extends \core\output\inplace_editable {
    /**
     * Constructor.
     *
     * @param stdClass $cohort
     */
    public function __construct($cohort) {
        $cohortcontext = \context::instance_by_id($cohort->contextid);
        $editable = has_capability('moodle/cohort:manage', $cohortcontext);
        $displayvalue = format_string($cohort->name, true, array('context' => $cohortcontext));
        parent::__construct('core_cohort', 'cohortname', $cohort->id, $editable,
            $displayvalue,
            $cohort->name,
            new lang_string('editcohortname', 'cohort'),
            new lang_string('newnamefor', 'cohort', $displayvalue));
    }

    /**
     * Updates cohort name and returns instance of this object
     *
     * @param int $cohortid
     * @param string $newvalue
     * @return static
     */
    public static function update($cohortid, $newvalue) {
        global $DB;
        $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);
        $cohortcontext = \context::instance_by_id($cohort->contextid);
        \external_api::validate_context($cohortcontext);
        require_capability('moodle/cohort:manage', $cohortcontext);
        $newvalue = clean_param($newvalue, PARAM_TEXT);
        if (strval($newvalue) !== '') {
            $record = (object)array('id' => $cohort->id, 'name' => $newvalue, 'contextid' => $cohort->contextid);
            cohort_update_cohort($record);
            $cohort->name = $newvalue;
        }
        return new static($cohort);
    }
}

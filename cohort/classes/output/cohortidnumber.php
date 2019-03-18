<?php


namespace core_cohort\output;

use lang_string;

/**
 * Class to prepare a cohort idnumber for display.
 *
 * @package   core_cohort
 * @copyright 2016 Marina Glancy
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class cohortidnumber extends \core\output\inplace_editable {
    /**
     * Constructor.
     *
     * @param stdClass $cohort
     */
    public function __construct($cohort) {
        $cohortcontext = \context::instance_by_id($cohort->contextid);
        $editable = has_capability('moodle/cohort:manage', $cohortcontext);
        $displayvalue = s($cohort->idnumber); // All idnumbers are plain text.
        parent::__construct('core_cohort', 'cohortidnumber', $cohort->id, $editable,
            $displayvalue,
            $cohort->idnumber,
            new lang_string('editcohortidnumber', 'cohort'),
            new lang_string('newidnumberfor', 'cohort', $displayvalue));
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
        $record = (object)array('id' => $cohort->id, 'idnumber' => $newvalue, 'contextid' => $cohort->contextid);
        cohort_update_cohort($record);
        $cohort->idnumber = $newvalue;
        return new static($cohort);
    }
}

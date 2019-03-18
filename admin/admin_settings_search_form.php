<?php

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir.'/formslib.php';

/**
 * Admin settings search form
 *
 * @package    admin
 * @copyright  2016 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_settings_search_form extends moodleform {
    function definition () {
        $mform = $this->_form;

        //$mform->addElement('header', 'settingsheader', get_string('search', 'admin'));
        $elements = [];
        $elements[] = $mform->createElement('text', 'query', get_string('query', 'admin'));
        $elements[] = $mform->createElement('submit', 'search', get_string('search'));
        $mform->addGroup($elements);
        $mform->setType('query', PARAM_RAW);
        $mform->setDefault('query', optional_param('query', '', PARAM_RAW));
    }
}

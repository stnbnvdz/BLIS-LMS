<?php

namespace core_admin\form;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class purge_caches extends \moodleform {
    /**
     * Define a "Purge all caches" button, and a fieldset with checkboxes for selectively purging separate caches.
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('hidden', 'returnurl', $this->_customdata['returnurl']);
        $mform->setType('returnurl', PARAM_LOCALURL);
        $mform->addElement('submit', 'all', get_string('purgecaches', 'admin'));
        $mform->addElement('header', 'purgecacheheader', get_string('purgeselectedcaches', 'admin'));
        $checkboxes = [
            $mform->createElement('advcheckbox', 'theme', '', get_string('purgethemecache', 'admin')),
            $mform->createElement('advcheckbox', 'lang', '', get_string('purgelangcache', 'admin')),
            $mform->createElement('advcheckbox', 'js', '', get_string('purgejscache', 'admin')),
            $mform->createElement('advcheckbox', 'filter', '', get_string('purgefiltercache', 'admin')),
            $mform->createElement('advcheckbox', 'muc', '', get_string('purgemuc', 'admin')),
            $mform->createElement('advcheckbox', 'other', '', get_string('purgeothercaches', 'admin'))
        ];
        $mform->addGroup($checkboxes, 'purgeselectedoptions');
        $mform->addElement('submit', 'purgeselectedcaches', get_string('purgeselectedcaches', 'admin'));
    }

    /**
     * If the "Purge selected caches" button was pressed, ensure at least one cache was selected.
     *
     * @param array $data
     * @param array $files
     * @return array Error messages
     */
    public function validation($data, $files) {
        $errors = [];
        if (isset($data['purgeselectedcaches']) && empty(array_filter($data['purgeselectedoptions']))) {
            $errors['purgeselectedoptions'] = get_string('purgecachesnoneselected', 'admin');
        }
        return $errors;
    }
}

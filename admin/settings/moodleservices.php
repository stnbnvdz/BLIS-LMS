
<?php

/**
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    // Create Moodle Services information.
    $moodleservices->add(new admin_setting_heading('moodleservicesintro', '',
        new lang_string('moodleservices_help', 'admin')));

    // Moodle Partners information.
    if (empty($CFG->disableserviceads_partner)) {
        $moodleservices->add(new admin_setting_heading('moodlepartners',
            new lang_string('moodlepartners', 'admin'),
            new lang_string('moodlepartners_help', 'admin')));
    }

    // Moodle app information.
    $moodleservices->add(new admin_setting_heading('moodleapp',
        new lang_string('moodleapp', 'admin'),
        new lang_string('moodleapp_help', 'admin')));

    // Branded Moodle app information.
    if (empty($CFG->disableserviceads_branded)) {
        $moodleservices->add(new admin_setting_heading('moodlebrandedapp',
            new lang_string('moodlebrandedapp', 'admin'),
            new lang_string('moodlebrandedapp_help', 'admin')));
    }
}



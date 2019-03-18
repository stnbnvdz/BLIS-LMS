<?php

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_category_settings', '', get_string('pluginname_desc', 'enrol_category')));


    //--- enrol instance defaults ----------------------------------------------------------------------------

}

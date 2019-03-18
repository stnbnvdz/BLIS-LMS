<?php

require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');

redirect_if_major_upgrade_required();

// TODO Add sesskey check to edit
$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off
$reset  = optional_param('reset', null, PARAM_BOOL);

require_login();

$hassiteconfig = has_capability('moodle/site:config', context_system::instance());
if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect(new moodle_url('/admin/index.php'));
}

$strmymoodle = get_string('myhome');

if (isguestuser()) {  // Force them to see system default, no editing allowed
    // If guests are not allowed my moodle, send them to front page.
    if (empty($CFG->allowguestmymoodle)) {
        redirect(new moodle_url('/', array('redirect' => 0)));
    }

    $userid = null;
    $USER->editing = $edit = 0;  // Just in case
    $context = context_system::instance();
    $PAGE->set_blocks_editing_capability('moodle/my:configsyspages');  // unlikely :)
    $header = "$SITE->shortname: $strmymoodle (GUEST)";
    $pagetitle = $header;

} else {        // We are trying to view or edit our own My Moodle page
    $userid = $USER->id;  // Owner of the page
    $context = context_user::instance($USER->id);
    $PAGE->set_blocks_editing_capability('moodle/my:manageblocks');
    $header = fullname($USER);
    $pagetitle = $strmymoodle;
}

// Get the My Moodle page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page($userid, MY_PAGE_PRIVATE)) {
    print_error('mymoodlesetup');
}

// Start setting up the page
$params = array();
$PAGE->set_context($context);
$PAGE->set_url('/my/index.php', $params);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->set_subpage($currentpage->id);
$PAGE->set_title($pagetitle);
$PAGE->set_heading($header);

if (!isguestuser()) {   // Skip default home page for guests
    if (get_home_page() != HOMEPAGE_MY) {
        if (optional_param('setdefaulthome', false, PARAM_BOOL)) {
            set_user_preference('user_home_page_preference', HOMEPAGE_MY);
        } else if (!empty($CFG->defaulthomepage) && $CFG->defaulthomepage == HOMEPAGE_USER) {
            $frontpagenode = $PAGE->settingsnav->add(get_string('frontpagesettings'), null, navigation_node::TYPE_SETTING, null);
            $frontpagenode->force_open();
            $frontpagenode->add(get_string('makethismyhome'), new moodle_url('/my/', array('setdefaulthome' => true)),
                    navigation_node::TYPE_SETTING);
        }
    }
}

/**
// Toggle the editing state and switches
if (empty($CFG->forcedefaultmymoodle) && $PAGE->user_allowed_editing()) {
    if ($reset !== null) {
        if (!is_null($userid)) {
            require_sesskey();
            if (!$currentpage = my_reset_page($userid, MY_PAGE_PRIVATE)) {
                print_error('reseterror', 'my');
            }
            redirect(new moodle_url('/my'));
        }
    } else if ($edit !== null) {             // Editing state was specified
        $USER->editing = $edit;       // Change editing state
    } else {                          // Editing state is in session
        if ($currentpage->userid) {   // It's a page we can edit, so load from session
            if (!empty($USER->editing)) {
                $edit = 1;
            } else {
                $edit = 0;
            }
        } else {
            // For the page to display properly with the user context header the page blocks need to
            // be copied over to the user context.
            if (!$currentpage = my_copy_page($USER->id, MY_PAGE_PRIVATE)) {
                print_error('mymoodlesetup');
            }
            $context = context_user::instance($USER->id);
            $PAGE->set_context($context);
            $PAGE->set_subpage($currentpage->id);
            // It's a system page and they are not allowed to edit system pages
            $USER->editing = $edit = 0;          // Disable editing completely, just to be safe
        }
    }

    // Add button for editing page
    $params = array('edit' => !$edit);

    $resetbutton = '';
    $resetstring = get_string('resetpage', 'my');
    $reseturl = new moodle_url("$CFG->wwwroot/my/index.php", array('edit' => 1, 'reset' => 1));

    if (!$currentpage->userid) {
        // viewing a system page -- let the user customise it
        $editstring = get_string('updatemymoodleon');
        $params['edit'] = 1;
    } else if (empty($edit)) {
        $editstring = get_string('updatemymoodleon');
    } else {
        $editstring = get_string('updatemymoodleoff');
        $resetbutton = $OUTPUT->single_button($reseturl, $resetstring);
    }

    $url = new moodle_url("$CFG->wwwroot/my/index.php", $params);
    $button = $OUTPUT->single_button($url, $editstring);
    $PAGE->set_button($resetbutton . $button);

} else {
    $USER->editing = $edit = 0;
}
*/
echo $OUTPUT->header();

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();

// Trigger dashboard has been viewed event.
$eventparams = array('context' => $context);
$event = \core\event\dashboard_viewed::create($eventparams);
$event->trigger();

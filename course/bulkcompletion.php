<?php

require_once(__DIR__.'/../config.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/completionlib.php');

$id = required_param('id', PARAM_INT); // Course id.
$cmids = optional_param_array('cmid', [], PARAM_INT);

// Perform some basic access control checks.
if ($id) {

    if ($id == SITEID) {
        // Don't allow editing of 'site course' using this form.
        print_error('cannoteditsiteform');
    }

    if (!$course = $DB->get_record('course', array('id' => $id))) {
        print_error('invalidcourseid');
    }
    require_login($course);

} else {
    require_login();
    print_error('needcourseid');
}

// Set up the page.
navigation_node::override_active_url(new moodle_url('/course/completion.php', array('id' => $course->id)));
$PAGE->set_course($course);
$PAGE->set_url('/course/bulkcompletion.php', array('id' => $course->id));
$PAGE->set_title($course->shortname);
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('admin');

// Check access.
if (!core_completion\manager::can_edit_bulk_completion($id)) {
    require_capability('moodle/course:manageactivities', context_course::instance($course->id));
}

// Get all that stuff I need for the renderer.
$manager = new \core_completion\manager($id);
$bulkcompletiondata = $manager->get_activities_and_headings();

$renderer = $PAGE->get_renderer('core_course', 'bulk_activity_completion');

// Print the form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('bulkactivitycompletion', 'completion'));

echo $renderer->navigation($course, 'bulkcompletion');

$PAGE->requires->yui_module('moodle-core-formchangechecker',
        'M.core_formchangechecker.init',
        array(array(
            'formid' => 'theform'
        ))
);
$PAGE->requires->string_for_js('changesmadereallygoaway', 'moodle');


echo $renderer->bulkcompletion($bulkcompletiondata);

echo $OUTPUT->footer();

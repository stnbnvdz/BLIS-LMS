<?php

require_once("../config.php");
require_once($CFG->dirroot. '/course/lib.php');

$categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
$site = get_site();

if ($categoryid) {
    $PAGE->set_category_by_id($categoryid);
    $PAGE->set_url(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
    $PAGE->set_pagetype('course-index-category');
    // And the object has been loaded for us no need for another DB call
    $category = $PAGE->category;
} else {
    // Check if there is only one category, if so use that.
    if (core_course_category::count_all() == 1) {
        $category = core_course_category::get_default();

        $categoryid = $category->id;
        $PAGE->set_category_by_id($categoryid);
        $PAGE->set_pagetype('course-index-category');
    } else {
        $PAGE->set_context(context_system::instance());
    }

    $PAGE->set_url('/course/index.php');
}

$PAGE->set_pagelayout('coursecategory');
$courserenderer = $PAGE->get_renderer('core', 'course');

if ($CFG->forcelogin) {
    require_login();
}

if ($categoryid && !$category->visible && !has_capability('moodle/category:viewhiddencategories', $PAGE->context)) {
    throw new moodle_exception('unknowncategory');
}

$PAGE->set_heading($site->fullname);
$content = $courserenderer->course_category($categoryid);

echo $OUTPUT->header();
echo $OUTPUT->skip_link_target();
echo $content;

// Trigger event, course category viewed.
$eventparams = array('context' => $PAGE->context, 'objectid' => $categoryid);
$event = \core\event\course_category_viewed::create($eventparams);
$event->trigger();

echo $OUTPUT->footer();

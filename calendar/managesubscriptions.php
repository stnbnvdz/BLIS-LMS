<?php

require_once('../config.php');
require_once($CFG->libdir.'/bennu/bennu.inc.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/calendar/lib.php');

// Required use.
$courseid = optional_param('course', null, PARAM_INT);
$categoryid = optional_param('category', null, PARAM_INT);
// Used for processing subscription actions.
$subscriptionid = optional_param('id', 0, PARAM_INT);
$pollinterval  = optional_param('pollinterval', 0, PARAM_INT);
$groupcourseid  = optional_param('groupcourseid', 0, PARAM_INT);
$action = optional_param('action', '', PARAM_INT);

$url = new moodle_url('/calendar/managesubscriptions.php');
if ($courseid != SITEID) {
    $url->param('course', $courseid);
}
if ($categoryid) {
    $url->param('categoryid', $categoryid);
}
navigation_node::override_active_url(new moodle_url('/calendar/view.php', array('view' => 'month')));
$PAGE->set_url($url);
$PAGE->set_pagelayout('admin');
$PAGE->navbar->add(get_string('managesubscriptions', 'calendar'));

if ($courseid != SITEID && !empty($courseid)) {
    // Course ID must be valid and existing.
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    $courses = array($course->id => $course);
} else {
    $course = get_site();
    $courses = calendar_get_default_courses();
}
require_login($course, false);

if (!calendar_user_can_add_event($course)) {
    print_error('errorcannotimport', 'calendar');
}

// Populate the 'group' select box based on the given 'groupcourseid', if necessary.
$groups = [];
if (!empty($groupcourseid)) {
    require_once($CFG->libdir . '/grouplib.php');
    $groupcoursedata = groups_get_course_data($groupcourseid);
    if (!empty($groupcoursedata->groups)) {
        foreach ($groupcoursedata->groups as $groupid => $groupdata) {
            $groups[$groupid] = $groupdata->name;
        }
    }
}
$customdata = [
    'courseid' => $course->id,
    'groups' => $groups,
];
$form = new \core_calendar\local\event\forms\managesubscriptions(null, $customdata);
$form->set_data(array(
    'course' => $course->id
));

$importresults = '';

$formdata = $form->get_data();
if (!empty($formdata)) {
    require_sesskey(); // Must have sesskey for all actions.
    $subscriptionid = calendar_add_subscription($formdata);
    if ($formdata->importfrom == CALENDAR_IMPORT_FROM_FILE) {
        // Blank the URL if it's a file import.
        $formdata->url = '';
        $calendar = $form->get_file_content('importfile');
        $ical = new iCalendar();
        $ical->unserialize($calendar);
        $importresults = calendar_import_icalendar_events($ical, null, $subscriptionid);
    } else {
        try {
            $importresults = calendar_update_subscription_events($subscriptionid);
        } catch (moodle_exception $e) {
            // Delete newly added subscription and show invalid url error.
            calendar_delete_subscription($subscriptionid);
            print_error($e->errorcode, $e->module, $PAGE->url);
        }
    }
    // Redirect to prevent refresh issues.
    redirect($PAGE->url, $importresults);
} else if (!empty($subscriptionid)) {
    // The user is wanting to perform an action upon an existing subscription.
    require_sesskey(); // Must have sesskey for all actions.
    if (calendar_can_edit_subscription($subscriptionid)) {
        try {
            $importresults = calendar_process_subscription_row($subscriptionid, $pollinterval, $action);
        } catch (moodle_exception $e) {
            // If exception caught, then user should be redirected to page where he/she came from.
            print_error($e->errorcode, $e->module, $PAGE->url);
        }
    } else {
        print_error('nopermissions', 'error', $PAGE->url, get_string('managesubscriptions', 'calendar'));
    }
}

$types = calendar_get_allowed_event_types($courseid);

$searches = [];
$params = [];

$usedefaultfilters = true;
if (!empty($courseid) && $courseid == SITEID && !empty($types['site'])) {
    $searches[] = "(eventtype = 'site')";
    $searches[] = "(eventtype = 'user' AND userid = :userid)";
    $params['userid'] = $USER->id;
    $usedefaultfilters = false;
}

if (!empty($courseid) && !empty($types['course'])) {
    $searches[] = "((eventtype = 'course' OR eventtype = 'group') AND courseid = :courseid)";
    $params += ['courseid' => $courseid];
    $usedefaultfilters = false;
}

if (!empty($categoryid) && !empty($types['category'])) {
    $searches[] = "(eventtype = 'category' AND categoryid = :categoryid)";
    $params += ['categoryid' => $categoryid];
    $usedefaultfilters = false;
}

if ($usedefaultfilters) {
    $searches[] = "(eventtype = 'user' AND userid = :userid)";
    $params['userid'] = $USER->id;

    if (!empty($types['site'])) {
        $searches[] = "(eventtype = 'site' AND courseid  = :siteid)";
        $params += ['siteid' => SITEID];
    }

    if (!empty($types['course'])) {
        $courses = calendar_get_default_courses(null, 'id', true);
        if (!empty($courses)) {
            $courseids = array_map(function ($c) {
                return $c->id;
            }, $courses);

            list($courseinsql, $courseparams) = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED, 'course');
            $searches[] = "((eventtype = 'course' OR eventtype = 'group') AND courseid {$courseinsql})";
            $params += $courseparams;
        }
    }

    if (!empty($types['category'])) {
        list($categoryinsql, $categoryparams) = $DB->get_in_or_equal(
                array_keys(\core_course_category::make_categories_list('moodle/category:manage')), SQL_PARAMS_NAMED, 'category');
        $searches[] = "(eventtype = 'category' AND categoryid {$categoryinsql})";
        $params += $categoryparams;
    }
}

$sql = "SELECT * FROM {event_subscriptions} WHERE " . implode(' OR ', $searches);;
$subscriptions = $DB->get_records_sql($sql, $params);

// Print title and header.
$PAGE->set_title("$course->shortname: ".get_string('calendar', 'calendar').": ".get_string('subscriptions', 'calendar'));
$PAGE->set_heading($course->fullname);

$renderer = $PAGE->get_renderer('core_calendar');

echo $OUTPUT->header();

// Filter subscriptions which user can't edit.
foreach($subscriptions as $subscription) {
    if (!calendar_can_edit_subscription($subscription)) {
        unset($subscriptions[$subscription->id]);
    }
}

// Display a table of subscriptions.
echo $renderer->subscription_details($courseid, $subscriptions, $importresults);
// Display the add subscription form.
$form->display();
echo $OUTPUT->footer();

<?php

require('../config.php');
require_once('editinstance_form.php');

$courseid   = required_param('courseid', PARAM_INT);
$type   = required_param('type', PARAM_COMPONENT);
$instanceid = optional_param('id', 0, PARAM_INT);
$return = optional_param('returnurl', 0, PARAM_LOCALURL);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($course->id, MUST_EXIST);

$plugin = enrol_get_plugin($type);
if (!$plugin) {
    throw new moodle_exception('invaliddata', 'error');
}

require_login($course);
require_capability('enrol/' . $type . ':config', $context);

$PAGE->set_url('/enrol/editinstance.php', array('courseid' => $course->id, 'id' => $instanceid, 'type' => $type));
$PAGE->set_pagelayout('admin');
$PAGE->set_docs_path('enrol/' . $type . '/edit');

if (empty($return)) {
    $return = new moodle_url('/enrol/instances.php', array('id' => $course->id));
}

if (!enrol_is_enabled($type)) {
    redirect($return);
}

if ($instanceid) {
    $instance = $DB->get_record('enrol', array('courseid' => $course->id, 'enrol' => $type, 'id' => $instanceid), '*', MUST_EXIST);

} else {
    require_capability('moodle/course:enrolconfig', $context);
    // No instance yet, we have to add new instance.
    navigation_node::override_active_url(new moodle_url('/enrol/instances.php', array('id' => $course->id)));

    $instance = (object)$plugin->get_instance_defaults();
    $instance->id       = null;
    $instance->courseid = $course->id;
    $instance->status   = ENROL_INSTANCE_ENABLED; // Do not use default for automatically created instances here.
}

$mform = new enrol_instance_edit_form(null, array($instance, $plugin, $context, $type, $return));

if ($mform->is_cancelled()) {
    redirect($return);

} else if ($data = $mform->get_data()) {

    if ($instance->id) {
        $reset = false;
        if (isset($data->status)) {
            $reset = ($instance->status != $data->status);
        }

        foreach ($data as $key => $value) {
            $instance->$key = $value;
        }

        $instance->timemodified   = time();

        $plugin->update_instance($instance, $data);

        if ($reset) {
            $context->mark_dirty();
        }

    } else {
        $fields = (array) $data;
        $plugin->add_instance($course, $fields);
    }

    redirect($return);
}

$PAGE->set_heading($course->fullname);
$PAGE->set_title(get_string('pluginname', 'enrol_' . $type));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'enrol_' . $type));
$mform->display();
echo $OUTPUT->footer();

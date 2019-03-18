<?php


require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');

admin_externalpage_setup('messageinbound_handlers');

$classname = optional_param('classname', '', PARAM_RAW);

$pageurl = new moodle_url('/admin/tool/messageinbound/index.php');

if (empty($classname)) {
    $renderer = $PAGE->get_renderer('tool_messageinbound');

    $records = $DB->get_recordset('messageinbound_handlers', null, 'enabled desc', 'classname');
    $instances = array();
    foreach ($records as $record) {
        $instances[] = \core\message\inbound\manager::get_handler($record->classname);
    }
    $records->close();

    echo $OUTPUT->header();
    echo $renderer->messageinbound_handlers_table($instances);
    echo $OUTPUT->footer();

} else {
    // Retrieve the handler and its record.
    $handler = \core\message\inbound\manager::get_handler($classname);
    $record = \core\message\inbound\manager::record_from_handler($handler);

    $formurl = new moodle_url($PAGE->url, array('classname' => $classname));
    $mform = new tool_messageinbound_edit_handler_form($formurl, array(
            'handler' => $handler,
    ));

    if ($mform->is_cancelled()) {
        redirect($PAGE->url);
    } else if ($data = $mform->get_data()) {

        // Update the record from the form.
        if ($handler->can_change_defaultexpiration()) {
            $record->defaultexpiration = (int) $data->defaultexpiration;
        }

        if ($handler->can_change_validateaddress()) {
            $record->validateaddress = !empty($data->validateaddress);
        }

        if ($handler->can_change_enabled()) {
            $record->enabled = !empty($data->enabled);
        }
        $DB->update_record('messageinbound_handlers', $record);
        redirect($PAGE->url);
    }

    // Add the breadcrumb.
    $pageurl->param('classname', $handler->classname);
    $PAGE->navbar->add($handler->name, $pageurl);
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('editinghandler', 'tool_messageinbound', $handler->name));
    $mform->set_data($record);
    $mform->display();
    echo $OUTPUT->footer();

}

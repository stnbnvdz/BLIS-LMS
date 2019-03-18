<?php


define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../config.php');

if ($CFG->forcelogin) {
    require_login();
}

$PAGE->set_context(context_system::instance());
$courserenderer = $PAGE->get_renderer('core', 'course');

echo json_encode($courserenderer->coursecat_ajax());

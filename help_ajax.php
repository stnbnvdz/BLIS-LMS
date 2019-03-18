<?php


define('NO_MOODLE_COOKIES', true);
define('AJAX_SCRIPT', true);
require_once(__DIR__ . '/config.php');

$identifier = required_param('identifier', PARAM_STRINGID);
$component  = required_param('component', PARAM_COMPONENT);
$lang       = optional_param('lang', 'en', PARAM_LANG);

// We don't actually modify the session here as we have NO_MOODLE_COOKIES set.
$SESSION->lang = $lang;
$PAGE->set_url('/help_ajax.php');
$PAGE->set_context(context_system::instance());

$data = get_formatted_help_string($identifier, $component, true);
echo json_encode($data);

<?php

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');

$action  = required_param('action', PARAM_ALPHANUMEXT);
$antivirus  = required_param('antivirus', PARAM_PLUGIN);
$confirm = optional_param('confirm', 0, PARAM_BOOL);

$PAGE->set_url('/admin/antiviruses.php', array('action' => $action, 'antivirus' => $antivirus));
$PAGE->set_context(context_system::instance());

require_login();
require_capability('moodle/site:config', context_system::instance());

$returnurl = "$CFG->wwwroot/$CFG->admin/settings.php?section=manageantiviruses";

// Get currently installed and enabled antivirus plugins.
$availableantiviruses = \core\antivirus\manager::get_available();
if (!empty($antivirus) and empty($availableantiviruses[$antivirus])) {
    redirect ($returnurl);
}

$activeantiviruses = explode(',', $CFG->antiviruses);
foreach ($activeantiviruses as $key => $active) {
    if (empty($availableantiviruses[$active])) {
        unset($activeantiviruses[$key]);
    }
}

if (!confirm_sesskey()) {
    redirect($returnurl);
}

switch ($action) {
    case 'disable':
        // Remove from enabled list.
        $key = array_search($antivirus, $activeantiviruses);
        unset($activeantiviruses[$key]);
        break;

    case 'enable':
        // Add to enabled list.
        if (!in_array($antivirus, $activeantiviruses)) {
            $activeantiviruses[] = $antivirus;
            $activeantiviruses = array_unique($activeantiviruses);
        }
        break;

    case 'down':
        $key = array_search($antivirus, $activeantiviruses);
        // Check auth plugin is valid.
        if ($key !== false) {
            // Move down the list.
            if ($key < (count($activeantiviruses) - 1)) {
                $fsave = $activeantiviruses[$key];
                $activeantiviruses[$key] = $activeantiviruses[$key + 1];
                $activeantiviruses[$key + 1] = $fsave;
            }
        }
        break;

    case 'up':
        $key = array_search($antivirus, $activeantiviruses);
        // Check auth is valid.
        if ($key !== false) {
            // Move up the list.
            if ($key >= 1) {
                $fsave = $activeantiviruses[$key];
                $activeantiviruses[$key] = $activeantiviruses[$key - 1];
                $activeantiviruses[$key - 1] = $fsave;
            }
        }
        break;

    default:
        break;
}

set_config('antiviruses', implode(',', $activeantiviruses));
core_plugin_manager::reset_caches();

redirect ($returnurl);

<?php

// Disable the use of sessions/cookies - we recreate $USER for every call.
define('NO_MOODLE_COOKIES', true);

// Disable debugging for this script.
// It is typically used to display images.
define('NO_DEBUG_DISPLAY', true);

require_once('config.php');

$relativepath = get_file_argument();
$token = optional_param('token', '', PARAM_ALPHANUM);
if (0 == strpos($relativepath, '/token/')) {
    $relativepath = ltrim($relativepath, '/');
    $pathparts = explode('/', $relativepath, 2);
    $token = $pathparts[0];
    $relativepath = "/{$pathparts[1]}";
}

require_user_key_login('core_files', null, $token);
require_once('pluginfile.php');

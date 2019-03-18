<?php

require('../config.php');
require_once($CFG->libdir.'/authlib.php');
require_once(__DIR__ . '/lib.php');
require_once('forgot_password_form.php');
require_once('set_password_form.php');

$token = optional_param('token', false, PARAM_ALPHANUM);

$PAGE->set_url('/login/forgot_password.php');
$systemcontext = context_system::instance();
$PAGE->set_context($systemcontext);

// setup text strings
$strforgotten = get_string('passwordforgotten');
$strlogin     = get_string('login');

$PAGE->navbar->add($strlogin, get_login_url());
$PAGE->navbar->add($strforgotten);
$PAGE->set_title($strforgotten);
$PAGE->set_heading($COURSE->fullname);

// if alternatepasswordurl is defined, then we'll just head there
if (!empty($CFG->forgottenpasswordurl)) {
    redirect($CFG->forgottenpasswordurl);
}

// if you are logged in then you shouldn't be here!
if (isloggedin() and !isguestuser()) {
    redirect($CFG->wwwroot.'/index.php', get_string('loginalready'), 5);
}

// Fetch the token from the session, if present, and unset the session var immediately.
$tokeninsession = false;
if (!empty($SESSION->password_reset_token)) {
    $token = $SESSION->password_reset_token;
    unset($SESSION->password_reset_token);
    $tokeninsession = true;
}

if (empty($token)) {
    // This is a new password reset request.
    // Process the request; identify the user & send confirmation email.
    core_login_process_password_reset_request();
} else {
    // A token has been found, but not in the session, and not from a form post.
    // This must be the user following the original rest link, so store the reset token in the session and redirect to self.
    // The session var is intentionally used only during the lifespan of one request (the redirect) and is unset above.
    if (!$tokeninsession && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $SESSION->password_reset_token = $token;
        redirect($CFG->wwwroot . '/login/forgot_password.php');
    } else {
        // Continue with the password reset process.
        core_login_process_password_set($token);
    }
}

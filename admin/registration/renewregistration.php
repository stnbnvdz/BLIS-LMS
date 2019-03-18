<?php

require('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$url = optional_param('url', '', PARAM_URL);
$token = optional_param('token', '', PARAM_TEXT);

admin_externalpage_setup('registrationmoodleorg');

if ($url !== HUB_MOODLEORGHUBURL) {
    // Allow other plugins to renew registration on hubs other than moodle.net . Plugins implementing this
    // callback need to redirect or exit. See https://docs.moodle.org/en/Hub_registration .
    $callbacks = get_plugins_with_function('hub_registration');
    foreach ($callbacks as $plugintype => $plugins) {
        foreach ($plugins as $plugin => $callback) {
            $callback('renew');
        }
    }
    throw new moodle_exception('errorotherhubsnotsupported', 'hub');
}

// Check that we are waiting a confirmation from this hub, and check that the token is correct.
\core\hub\registration::reset_site_identifier($token);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('renewregistration', 'hub'), 3, 'main');
$hublink = html_writer::tag('a', 'Moodle.net', array('href' => HUB_MOODLEORGHUBURL));

$deletedregmsg = get_string('previousregistrationdeleted', 'hub', $hublink);

$button = new single_button(new moodle_url('/admin/registration/index.php'),
                get_string('restartregistration', 'hub'));
$button->class = 'restartregbutton';

echo html_writer::tag('div', $deletedregmsg . $OUTPUT->render($button),
        array('class' => 'mdl-align'));

echo $OUTPUT->footer();



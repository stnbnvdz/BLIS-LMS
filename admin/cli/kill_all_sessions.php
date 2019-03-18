<?php

define('CLI_SCRIPT', true);

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/clilib.php');

list($options, $unrecognized) = cli_get_params(array('help' => false), array('h' => 'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized), 2);
}

if ($options['help']) {
    $help =
"Kill all Moodle sessions

Options:
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php admin/cli/kill_all_sessions.php
";

    echo $help;
    exit(0);
}

\core\session\manager::kill_all_sessions();

exit(0);

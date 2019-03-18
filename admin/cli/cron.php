<?php

define('CLI_SCRIPT', true);

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/clilib.php');      // cli only functions
require_once($CFG->libdir.'/cronlib.php');

// now get cli options
list($options, $unrecognized) = cli_get_params(array('help'=>false),
                                               array('h'=>'help'));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
"Execute periodic cron actions.

Options:
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php admin/cli/cron.php
";

    echo $help;
    die;
}

cron_run();

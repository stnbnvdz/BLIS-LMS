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
"Execute automated backups.

This script executes automated backups completely and is designed to be
called via cron.

Options:
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php admin/cli/automated_backups.php
";

    echo $help;
    die;
}
if (CLI_MAINTENANCE) {
    echo "CLI maintenance mode active, backup execution suspended.\n";
    exit(1);
}

if (moodle_needs_upgrading()) {
    echo "Moodle upgrade pending, backup execution suspended.\n";
    exit(1);
}

require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/gradelib.php');

if (!empty($CFG->showcronsql)) {
    $DB->set_debug(true);
}
if (!empty($CFG->showcrondebugging)) {
    set_debugging(DEBUG_DEVELOPER, true);
}

$starttime = microtime();

/// emulate normal session
cron_setup_user();

/// Start output log
$timenow = time();

mtrace("Server Time: ".date('r',$timenow)."\n\n");

// Run automated backups if required.
require_once($CFG->dirroot.'/backup/util/includes/backup_includes.php');
require_once($CFG->dirroot.'/backup/util/helper/backup_cron_helper.class.php');
backup_cron_automated_helper::run_automated_backup(backup_cron_automated_helper::RUN_IMMEDIATELY);

mtrace("Automated cron backups completed correctly");

$difftime = microtime_diff($starttime, microtime());
mtrace("Execution took ".$difftime." seconds");

<?php

// Force OPcache reset if used, we do not want any stale caches
// when detecting if upgrade necessary or when running upgrade.
if (function_exists('opcache_reset') and !isset($_SERVER['REMOTE_ADDR'])) {
    opcache_reset();
}

define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');       // various admin-only functions
require_once($CFG->libdir.'/upgradelib.php');     // general upgrade/install related functions
require_once($CFG->libdir.'/clilib.php');         // cli only functions
require_once($CFG->libdir.'/environmentlib.php');

// now get cli options
$lang = isset($SESSION->lang) ? $SESSION->lang : $CFG->lang;
list($options, $unrecognized) = cli_get_params(
    array(
        'non-interactive'   => false,
        'allow-unstable'    => false,
        'help'              => false,
        'lang'              => $lang,
        'verbose-settings'  => false
    ),
    array(
        'h' => 'help'
    )
);

if ($options['lang']) {
    $SESSION->lang = $options['lang'];
}

$interactive = empty($options['non-interactive']);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

if ($options['help']) {
    $help =
"Command line Moodle upgrade.
Please note you must execute this script with the same uid as apache!

Site defaults may be changed via local/defaults.php.

Options:
--non-interactive     No interactive questions or confirmations
--allow-unstable      Upgrade even if the version is not marked as stable yet,
                      required in non-interactive mode.
--lang=CODE           Set preferred language for CLI output. Defaults to the
                      site language if not set. Defaults to 'en' if the lang
                      parameter is invalid or if the language pack is not
                      installed.
--verbose-settings    Show new settings values. By default only the name of
                      new core or plugin settings are displayed. This option
                      outputs the new values as well as the setting name.
-h, --help            Print out this help

Example:
\$sudo -u www-data /usr/bin/php admin/cli/upgrade.php
"; //TODO: localize - to be translated later when everything is finished

    echo $help;
    die;
}

if (empty($CFG->version)) {
    cli_error(get_string('missingconfigversion', 'debug'));
}

require("$CFG->dirroot/version.php");       // defines $version, $release, $branch and $maturity
$CFG->target_release = $release;            // used during installation and upgrades

if ($version < $CFG->version) {
    cli_error(get_string('downgradedcore', 'error'));
}

$oldversion = "$CFG->release ($CFG->version)";
$newversion = "$release ($version)";

if (!moodle_needs_upgrading()) {
    cli_error(get_string('cliupgradenoneed', 'core_admin', $newversion), 0);
}

// Test environment first.
list($envstatus, $environment_results) = check_moodle_environment(normalize_version($release), ENV_SELECT_RELEASE);
if (!$envstatus) {
    $errors = environment_get_errors($environment_results);
    cli_heading(get_string('environment', 'admin'));
    foreach ($errors as $error) {
        list($info, $report) = $error;
        echo "!! $info !!\n$report\n\n";
    }
    exit(1);
}

// Test plugin dependencies.
$failed = array();
if (!core_plugin_manager::instance()->all_plugins_ok($version, $failed)) {
    cli_problem(get_string('pluginscheckfailed', 'admin', array('pluginslist' => implode(', ', array_unique($failed)))));
    cli_error(get_string('pluginschecktodo', 'admin'));
}

$a = new stdClass();
$a->oldversion = $oldversion;
$a->newversion = $newversion;

if ($interactive) {
    echo cli_heading(get_string('databasechecking', '', $a)) . PHP_EOL;
}

// make sure we are upgrading to a stable release or display a warning
if (isset($maturity)) {
    if (($maturity < MATURITY_STABLE) and !$options['allow-unstable']) {
        $maturitylevel = get_string('maturity'.$maturity, 'admin');

        if ($interactive) {
            cli_separator();
            cli_heading(get_string('notice'));
            echo get_string('maturitycorewarning', 'admin', $maturitylevel) . PHP_EOL;
            echo get_string('morehelp') . ': ' . get_docs_url('admin/versions') . PHP_EOL;
            cli_separator();
        } else {
            cli_problem(get_string('maturitycorewarning', 'admin', $maturitylevel));
            cli_error(get_string('maturityallowunstable', 'admin'));
        }
    }
}

if ($interactive) {
    echo html_to_text(get_string('upgradesure', 'admin', $newversion))."\n";
    $prompt = get_string('cliyesnoprompt', 'admin');
    $input = cli_input($prompt, '', array(get_string('clianswerno', 'admin'), get_string('cliansweryes', 'admin')));
    if ($input == get_string('clianswerno', 'admin')) {
        exit(1);
    }
}

if ($version > $CFG->version) {
    // We purge all of MUC's caches here.
    // Caches are disabled for upgrade by CACHE_DISABLE_ALL so we must set the first arg to true.
    // This ensures a real config object is loaded and the stores will be purged.
    // This is the only way we can purge custom caches such as memcache or APC.
    // Note: all other calls to caches will still used the disabled API.
    cache_helper::purge_all(true);
    upgrade_core($version, true);
}
set_config('release', $release);
set_config('branch', $branch);

// unconditionally upgrade
upgrade_noncore(true);

// log in as admin - we need doanything permission when applying defaults
\core\session\manager::set_user(get_admin());

// Apply default settings and output those that have changed.
cli_heading(get_string('cliupgradedefaultheading', 'admin'));
$settingsoutput = admin_apply_default_settings(null, false);

foreach ($settingsoutput as $setting => $value) {

    if ($options['verbose-settings']) {
        $stringvlaues = array(
                'name' => $setting,
                'defaultsetting' => var_export($value, true) // Expand objects.
        );
        echo get_string('cliupgradedefaultverbose', 'admin', $stringvlaues) . PHP_EOL;

    } else {
        echo get_string('cliupgradedefault', 'admin', $setting) . PHP_EOL;

    }
}

// This needs to happen at the end to ensure it occurs after all caches
// have been purged for the last time.
// This will build a cached version of the current theme for the user
// to immediately start browsing the site.
upgrade_themes();

echo get_string('cliupgradefinished', 'admin', $a)."\n";
exit(0); // 0 means success

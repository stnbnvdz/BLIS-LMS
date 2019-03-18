<?php

define('CLI_SCRIPT', true);

require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/clilib.php');

$longoptions = [
    'help' => false,
    'muc' => false,
    'theme' => false,
    'lang' => false,
    'js' => false,
    'filter' => false,
    'other' => false
];
list($options, $unrecognized) = cli_get_params($longoptions, ['h' => 'help']);

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized), 2);
}

if ($options['help']) {
    // The indentation of this string is "wrong" but this is to avoid a extra whitespace in console output.
    $help = <<<EOF
Invalidates Moodle internal caches

Specific caches can be defined (alone or in combination) using arguments. If none are specified,
all caches will be purged.

Options:
-h, --help            Print out this help
    --muc             Purge all MUC caches (includes lang cache)
    --theme           Purge theme cache
    --lang            Purge language string cache
    --js              Purge JavaScript cache
    --filter          Purge text filter cache
    --other           Purge all file caches and other miscellaneous caches (may include MUC
                      if using cachestore_file).

Example:
\$ sudo -u www-data /usr/bin/php admin/cli/purge_caches.php

EOF;

    echo $help;
    exit(0);
}

purge_caches(array_filter($options));

exit(0);

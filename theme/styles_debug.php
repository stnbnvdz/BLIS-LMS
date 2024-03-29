<?php

define('NO_DEBUG_DISPLAY', true);
define('NO_UPGRADE_CHECK', true);
define('NO_MOODLE_COOKIES', true);

require('../config.php');
require_once($CFG->dirroot.'/lib/csslib.php');

$themename = optional_param('theme', 'standard', PARAM_SAFEDIR);
$type      = optional_param('type', '', PARAM_SAFEDIR);
$subtype   = optional_param('subtype', '', PARAM_SAFEDIR);
$sheet     = optional_param('sheet', '', PARAM_SAFEDIR);
$usesvg    = optional_param('svg', 1, PARAM_BOOL);
$chunk     = optional_param('chunk', null, PARAM_INT);
$rtl       = optional_param('rtl', false, PARAM_BOOL);

if (file_exists("$CFG->dirroot/theme/$themename/config.php")) {
    // The theme exists in standard location - ok.
} else if (!empty($CFG->themedir) and file_exists("$CFG->themedir/$themename/config.php")) {
    // Alternative theme location contains this theme - ok.
} else {
    css_send_css_not_found();
}

$theme = theme_config::load($themename);
$theme->force_svg_use($usesvg);
$theme->set_rtl_mode($rtl);

if ($type === 'editor') {
    $csscontent = $theme->get_css_content_editor();
    css_send_uncached_css($csscontent);
}

$chunkurl = new moodle_url('/theme/styles_debug.php', array('theme' => $themename,
    'type' => $type, 'subtype' => $subtype, 'sheet' => $sheet, 'usesvg' => $usesvg, 'rtl' => $rtl));

// We need some kind of caching here because otherwise the page navigation becomes
// way too slow in theme designer mode. Feel free to create full cache definition later...
$key = "$type $subtype $sheet $usesvg $rtl";
$cache = cache::make_from_params(cache_store::MODE_APPLICATION, 'core', 'themedesigner', array('theme' => $themename));
if ($content = $cache->get($key)) {
    if ($content['created'] > time() - THEME_DESIGNER_CACHE_LIFETIME) {
        $csscontent = $content['data'];

        // We need to chunk the content.
        if ($chunk !== null) {
            $chunks = css_chunk_by_selector_count($csscontent, $chunkurl->out(false));
            $csscontent = ($chunk === 0) ? end($chunks) : $chunks[$chunk - 1];
        }

        css_send_uncached_css($csscontent);
    }
}

$csscontent = $theme->get_css_content_debug($type, $subtype, $sheet);
$cache->set($key, array('data' => $csscontent, 'created' => time()));

// We need to chunk the content.
if ($chunk !== null) {
    // The chunks are ordered so that the last chunk is the one containing the @import, and so
    // the first one to be included. All the other chunks are set in the array before that one.
    // See {@link css_chunk_by_selector_count()} for more details.
    $chunks = css_chunk_by_selector_count($csscontent, $chunkurl->out(false));
    $csscontent = ($chunk === 0) ? end($chunks) : $chunks[$chunk - 1];
}

css_send_uncached_css($csscontent);

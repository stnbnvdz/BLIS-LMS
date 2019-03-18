<?php

defined('MOODLE_INTERNAL') || die();

global $PAGE;

// Set up regions for individual pages.  This is done
// to avoid being able to move regions (when configuring)
// to non-existent block regions for the page .  This is because
// Moodle shows all regions available even if they aren't used
// on that specific page. Please note that frontpage and dashboard
// page use $frontlayoutregions to avoid losing existing regions that
// are renamed.

$frontlayoutregions = array('side-post',
        'middle',
        'frnt-footer',
        'frnt-market-a',
        'frnt-market-b',
        'frnt-market-c',
        'frnt-market-d',
        'frnt-market-e',
        'frnt-market-f',
        'frnt-market-g',
        'frnt-market-h',
        'frnt-market-i',
        'frnt-market-j',
        'frnt-market-k',
        'frnt-market-l',
        'frnt-market-m',
        'frnt-market-n',
        'frnt-market-o',
        'frnt-market-p',
        'frnt-market-q',
        'frnt-market-r',
        'frnt-market-s',
        'frnt-market-t',
        'news-slider-a',
        'course-section-a');

$courselayoutregions = array('side-post',
        'middle',
        'frnt-footer',
        'course-top-a',
        'course-top-b',
        'course-top-c',
        'course-top-d',
        'news-slider-a',
        'course-bottom-a',
        'course-bottom-b',
        'course-bottom-c',
        'course-bottom-d',
        'course-section-a');

$standardregions = array('side-post');


$regions = $standardregions;
if ( (is_object($PAGE)) && ($PAGE->pagelayout) ) {
    switch ($PAGE->pagelayout) {
        case "frontpage":
            $regions = $frontlayoutregions;
            break;
        case "mydashboard":
            $regions = $frontlayoutregions;
            break;
        case "course":
            $regions = $courselayoutregions;
            break;
    }
}

$THEME->name = 'adaptable';
$THEME->doctype = 'html5';
$THEME->parents = array('bootstrapbase');
$THEME->sheets = array( 'adaptable',
                        'blocks',
                        'button',
                        'course',
                        'extras',
                        'menu',
                        'responsive',
                        'custom');

$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();

$THEME->editor_sheets = array();

$usedashboard = false;
if ($CFG->version >= 2016052300) {
    $usedashboard = true;
}

if (floatval($CFG->version) >= 2013111803.02) {
    $THEME->enable_dock = false; //true
}

$THEME->plugins_exclude_sheets = array(
    'block' => array(
        'html',
    )
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'columns2.php',
        'regions' => array(),
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    // Main course page.
    'course' => array(
        'file' => 'course.php',
        'regions' => $regions,
        'defaultregion' => 'side-post',
        'options' => array('langmenu' => true),
    ),
    'coursecategory' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    // Part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post', 'course-section-a'),
        'defaultregion' => 'side-post',
    ),
    // The site home page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => $regions,
        'defaultregion' => 'side-post',
        'options' => array('nonavbar' => true),
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('nonavbar' => false),
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => ( ($usedashboard == true) ? 'dashboard.php' : 'columns2.php'),
        'regions' => ( ($usedashboard == true) ? $regions : array('side-post')),
        'defaultregion' => 'side-post',
        'options' => array('langmenu' => true),
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post'
    ),
    // Login page.
    'login' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('langmenu' => true, 'nonavbar' => true),
    ),
    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nocoursefooter' => true),
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array()
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true, 'nocoursefooter' => true, 'nocourseheader' => true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'columns1.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => false),
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'columns2.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-post', 'course-section-a'),
        'options' => array('nofooter' => true, 'nonavbar' => true),
        'defaultregion' => 'side-post',
    ),
);

$THEME->csspostprocess = 'theme_adaptable_process_css';
$THEME->blockrtlmanipulations = array(
    'side-pre' => 'side-post',
    'side-post' => 'side-pre'
);

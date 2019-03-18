<?php

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__.'/libs/admin_confightmleditor.php');
require_once(__DIR__.'/lib.php');

$settings = null;

if (is_siteadmin()) {
    // Adaptable theme settings page.
    global $PAGE;
    $ADMIN->add('themes', new admin_category('theme_adaptable', 'Adaptable'));

    include(dirname(__FILE__) . '/settings/array_definitions.php');
    include(dirname(__FILE__) . '/settings/colors.php');
    include(dirname(__FILE__) . '/settings/fonts.php');
    include(dirname(__FILE__) . '/settings/buttons.php');
    include(dirname(__FILE__) . '/settings/header.php');
    include(dirname(__FILE__) . '/settings/header_menus.php');
    include(dirname(__FILE__) . '/settings/header_user.php');
    include(dirname(__FILE__) . '/settings/header_social.php');
    include(dirname(__FILE__) . '/settings/header_navbar.php');
    include(dirname(__FILE__) . '/settings/header_navbar_menu.php');
    include(dirname(__FILE__) . '/settings/alert_box.php');
    include(dirname(__FILE__) . '/settings/block_settings.php');
    include(dirname(__FILE__) . '/settings/block_regions.php');
    include(dirname(__FILE__) . '/settings/marketing_blocks.php');
    include(dirname(__FILE__) . '/settings/frontpage_ticker.php');
    include(dirname(__FILE__) . '/settings/frontpage_slider.php');
    include(dirname(__FILE__) . '/settings/frontpage_courses.php');
    include(dirname(__FILE__) . '/settings/footer.php');
    include(dirname(__FILE__) . '/settings/layout.php');
    include(dirname(__FILE__) . '/settings/dash_block_regions.php');
    include(dirname(__FILE__) . '/settings/course_formats.php');
    include(dirname(__FILE__) . '/settings/mobile_settings.php');
    include(dirname(__FILE__) . '/settings/analytics.php');
    include(dirname(__FILE__) . '/settings/importexport_settings.php');
    include(dirname(__FILE__) . '/settings/custom_css.php');
}

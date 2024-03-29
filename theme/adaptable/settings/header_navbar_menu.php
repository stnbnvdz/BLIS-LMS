<?php

defined('MOODLE_INTERNAL') || die;

// Settings for tools menus.
$temp = new admin_settingpage('theme_adaptable_header_navbar_menu', get_string('navbarmenusettings', 'theme_adaptable'));

$temp->add(new admin_setting_heading('theme_adaptable_toolsmenu', get_string('toolsmenu', 'theme_adaptable'),
    format_text(get_string('toolsmenudesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

$temp->add(new admin_setting_heading('theme_adaptable_toolsmenu', get_string('toolsmenuheading', 'theme_adaptable'),
format_text(get_string('toolsmenuheadingdesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

$name = 'theme_adaptable/disablecustommenu';
$title = get_string('disablecustommenu', 'theme_adaptable');
$description = get_string('disablecustommenudesc', 'theme_adaptable');
$setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$name = 'theme_adaptable/enabletoolsmenus';
$title = get_string('enabletoolsmenus', 'theme_adaptable');
$description = get_string('enabletoolsmenusdesc', 'theme_adaptable');
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

// Number of tools menus.
$name = 'theme_adaptable/toolsmenuscount';
$title = get_string('toolsmenuscount', 'theme_adaptable');
$description = get_string('toolsmenuscountdesc', 'theme_adaptable');
$default = THEME_ADAPTABLE_DEFAULT_TOOLSMENUSCOUNT;
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices1to12);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// If we don't have a menuscount yet, default to the preset.
$toolsmenuscount = get_config('theme_adaptable', 'toolsmenuscount');

if (!$toolsmenuscount) {
    $toolsmenuscount = THEME_ADAPTABLE_DEFAULT_TOOLSMENUSCOUNT;
}

for ($toolsmenusindex = 1; $toolsmenusindex <= $toolsmenuscount; $toolsmenusindex ++) {
    $temp->add(new admin_setting_heading('theme_adaptable_menus' . $toolsmenusindex,
    get_string('toolsmenuheading', 'theme_adaptable') . $toolsmenusindex,
    format_text(get_string('toolsmenudesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

    $name = 'theme_adaptable/toolsmenu' . $toolsmenusindex . 'title';
    $title = get_string('toolsmenutitle', 'theme_adaptable') . ' ' . $toolsmenusindex;
    $description = get_string('toolsmenutitledesc', 'theme_adaptable');
    $default = get_string('toolsmenutitledefault', 'theme_adaptable');
    $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_RAW);
    $temp->add($setting);

    $name = 'theme_adaptable/toolsmenu' . $toolsmenusindex;
    $title = get_string('toolsmenu', 'theme_adaptable') . ' ' . $toolsmenusindex;
    $description = get_string('toolsmenudesc', 'theme_adaptable');
    $setting = new admin_setting_configtextarea($name, $title, $description, '', PARAM_RAW, '50', '10');
    $temp->add($setting);
    $name = 'theme_adaptable/toolsmenu' . $toolsmenusindex . 'field';
    $title = get_string('toolsmenufield', 'theme_adaptable');
    $description = get_string('toolsmenufielddesc', 'theme_adaptable');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_RAW);
    $temp->add($setting);
}


    $ADMIN->add('theme_adaptable', $temp);

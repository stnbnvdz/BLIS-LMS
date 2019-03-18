<?php

defined('MOODLE_INTERNAL') || die;

// Frontpage Ticker heading.
$temp = new admin_settingpage('theme_adaptable_frontpage_ticker', get_string('frontpagetickersettings', 'theme_adaptable'));
$temp->add(new admin_setting_heading('theme_adaptable_ticker', get_string('tickersettingsheading', 'theme_adaptable'),
    format_text(get_string('tickerdesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

$name = 'theme_adaptable/enableticker';
$title = get_string('enableticker', 'theme_adaptable');
$description = get_string('enabletickerdesc', 'theme_adaptable');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$name = 'theme_adaptable/enabletickermy';
$title = get_string('enabletickermy', 'theme_adaptable');
$description = get_string('enabletickermydesc', 'theme_adaptable');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Ticker Width (fullscreen / fixed width).
$name = 'theme_adaptable/tickerwidth';
$title = get_string('tickerwidth', 'theme_adaptable');
$description = get_string('tickerwidthdesc', 'theme_adaptable');
$options = array(
  '' => get_string('tickerwidth', 'theme_adaptable'),
  'width: 100%;' => get_string('tickerfullscreen', 'theme_adaptable')
);
$setting = new admin_setting_configselect($name, $title, $description, '', $options);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

  // Number of news ticker sectons.
$name = 'theme_adaptable/newstickercount';
$title = get_string('newstickercount', 'theme_adaptable');
$description = get_string('newstickercountdesc', 'theme_adaptable');
$default = THEME_ADAPTABLE_DEFAULT_TOOLSMENUSCOUNT;
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices1to12);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// If we don't have a menuscount yet, default to the preset.
$newstickercount = get_config('theme_adaptable', 'newstickercount');

if (!$newstickercount) {
    $newstickercount = THEME_ADAPTABLE_DEFAULT_NEWSTICKERCOUNT;
}

for ($newstickerindex = 1; $newstickerindex <= $newstickercount; $newstickerindex ++) {
    $name = 'theme_adaptable/tickertext' . $newstickerindex;
    $title = get_string('tickertext', 'theme_adaptable') . ' ' . $newstickerindex;
    $description = get_string('tickertextdesc', 'theme_adaptable');
    $default = '';
    $setting = new adaptable_setting_confightmleditor($name, $title, $description, $default);
    $temp->add($setting);

    $name = 'theme_adaptable/tickertext' . $newstickerindex . 'profilefield';
    $title = get_string('tickertextprofilefield', 'theme_adaptable');
    $description = get_string('tickertextprofilefielddesc', 'theme_adaptable');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_RAW);
    $temp->add($setting);
}

$ADMIN->add('theme_adaptable', $temp);

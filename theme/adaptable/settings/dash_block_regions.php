<?php


defined('MOODLE_INTERNAL') || die;

$usedashboard = false;
if ($CFG->version >= 2016052300) {
    $usedashboard = true;
}

if ($usedashboard) {

    // Frontpage Block Regions Section.
    $temp = new admin_settingpage('theme_adaptable_dash_block_regions',
        get_string('dashboardblockregionsettings', 'theme_adaptable'));

    $temp->add(new admin_setting_heading('theme_adaptable_heading', get_string('dashblocklayoutbuilder', 'theme_adaptable'),
        format_text(get_string('dashblocklayoutbuilderdesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

    $name = 'theme_adaptable/dashblocksenabled';
    $title = get_string('dashblocksenabled', 'theme_adaptable');
    $description = get_string('dashblocksenableddesc', 'theme_adaptable');
    $setting = new admin_setting_configcheckbox($name, $title, $description, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Block region builder.
    $noregions = 20; // Number of block regions defined in config.php.
    $totalblocks = 0;
    $imgpath = $CFG->wwwroot.'/theme/adaptable/pix/layout-builder/';
    $imgblder = '';
    for ($i = 1; $i <= 8; $i++) {
        $name = 'theme_adaptable/dashblocklayoutlayoutrow' . $i;
        $title = get_string('dashblocklayoutlayoutrow', 'theme_adaptable');
        $description = get_string('dashblocklayoutlayoutrowdesc', 'theme_adaptable');
        $default = $bootstrap12defaults[$i - 1];
        $choices = $bootstrap12;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        $settingname = 'dashblocklayoutlayoutrow' . $i;

        if (!isset($PAGE->theme->settings->$settingname)) {
            $PAGE->theme->settings->$settingname = '0-0-0-0';
        }

        if ($PAGE->theme->settings->$settingname != '0-0-0-0') {
            $imgblder .= '<img src="' . $imgpath . $PAGE->theme->settings->$settingname . '.png' . '" style="padding-top: 5px">';
        }

        $vals = explode('-', $PAGE->theme->settings->$settingname);
        foreach ($vals as $val) {
            if ($val > 0) {
                $totalblocks ++;
            }
        }
    }

    $temp->add(new admin_setting_heading('theme_adaptable_blocklayoutcheck', get_string('layoutcheck', 'theme_adaptable'),
        format_text(get_string('layoutcheckdesc', 'theme_adaptable'), FORMAT_MARKDOWN)));

    $checkcountcolor = '#00695C';
    if ($totalblocks > $noregions) {
        $mktcountcolor = '#D7542A';
    }
    $mktcountmsg = '<span style="color: ' . $checkcountcolor . '">';
    $mktcountmsg .= get_string('layoutcount1', 'theme_adaptable') . '<strong>' . $noregions . '</strong>';
    $mktcountmsg .= get_string('layoutcount2', 'theme_adaptable') . '<strong>' . $totalblocks . '/' . $noregions . '</strong>.';

    $temp->add(new admin_setting_heading('theme_adaptable_dashlayoutblockscount', '', $mktcountmsg));

    $temp->add(new admin_setting_heading('theme_adaptable_dashlayoutbuilder', '', $imgblder));

    $ADMIN->add('theme_adaptable', $temp);


}


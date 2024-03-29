<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin provides access to Moodle data in form of analytics and reports in real time.
 *
 *
 * @package    local_intelliboard
 * @copyright  2017 IntelliBoard, Inc
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @website    https://intelliboard.net/
 */

defined('MOODLE_INTERNAL') || die;

$settings = new admin_settingpage('local_intelliboard', new lang_string('pluginname', 'local_intelliboard'));

$ADMIN->add('root', new admin_category('intelliboardroot', new lang_string('intelliboardroot', 'local_intelliboard')));
$ADMIN->add('intelliboardroot', new admin_externalpage('intelliboardcontrolpanel', new lang_string('dashboard', 'local_intelliboard'),
        $CFG->wwwroot.'/local/intelliboard/index.php', 'local/intelliboard:manage'));

$ADMIN->add('intelliboardroot', new admin_externalpage('intelliboardmonitors', new lang_string('monitors', 'local_intelliboard'),
        $CFG->wwwroot.'/local/intelliboard/monitors.php', 'local/intelliboard:manage'));

$ADMIN->add('intelliboardroot', new admin_externalpage('intelliboardreports', new lang_string('reports', 'local_intelliboard'),
        $CFG->wwwroot.'/local/intelliboard/reports.php', 'local/intelliboard:manage'));
$ADMIN->add('intelliboardroot', new admin_externalpage('intelliboardcompetency', new lang_string('a1', 'local_intelliboard'),
        $CFG->wwwroot.'/local/intelliboard/competencies/index.php', 'local/intelliboard:competency'));



if (!$ADMIN->locate('intelliboard') and $ADMIN->locate('localplugins')){
    $ADMIN->add('localplugins', new admin_category('intelliboard', new lang_string('pluginname', 'local_intelliboard')));
    $ADMIN->add('intelliboard', $settings);

    if (isset($CFG->intelliboardsql) and $CFG->intelliboardsql == false) {
        //skip
    } else {
      $ADMIN->add('intelliboard', new admin_externalpage('intelliboardsql', new lang_string('sqlreports', 'local_intelliboard'),
      $CFG->wwwroot.'/local/intelliboard/sqlreports.php'));
    }
}

if($ADMIN->fulltree){
        $settings->add(new admin_setting_heading('local_intelliboard/account_title', new lang_string('account', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/te1';
        $title = new lang_string('te1', 'local_intelliboard');
        $description = new lang_string('te1_desc', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, $description, '');
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/tracking_title', new lang_string('tracking_title', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/enabled';
        $title = new lang_string('enabled', 'local_intelliboard');
        $description = new lang_string('enabled_desc', 'local_intelliboard');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/ajax';
        $title = new lang_string('ajax', 'local_intelliboard');
        $description = new lang_string('ajax_desc', 'local_intelliboard');
        $default = '30';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $settings->add($setting);

        $name = 'local_intelliboard/inactivity';
        $title = new lang_string('inactivity', 'local_intelliboard');
        $description = new lang_string('inactivity_desc', 'local_intelliboard');
        $default = '60';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $settings->add($setting);

        $name = 'local_intelliboard/trackadmin';
        $title = new lang_string('trackadmin', 'local_intelliboard');
        $description = new lang_string('trackadmin_desc', 'local_intelliboard');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/advanced', new lang_string('adv_settings', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/sso';
        $title = new lang_string('sso', 'local_intelliboard');
        $description = new lang_string('sso_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/intellicart';
        $title = new lang_string('intellicart', 'local_intelliboard');
        $description = new lang_string('intellicart_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/api';
        $title = new lang_string('api', 'local_intelliboard');
        $description = new lang_string('api_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);


        $name = 'local_intelliboard/ssodomain';
        $title = new lang_string('ssodomain', 'local_intelliboard');
        $description = new lang_string('ssodomain_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/debug';
        $title = new lang_string('debug', 'local_intelliboard');
        $description = new lang_string('debug_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/verifypeer';
        $title = new lang_string('verifypeer', 'local_intelliboard');
        $description = new lang_string('verifypeer_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/verifyhost';
        $title = new lang_string('verifyhost', 'local_intelliboard');
        $description = new lang_string('verifyhost_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/cipherlist';
        $title = new lang_string('cipherlist', 'local_intelliboard');
        $description = new lang_string('cipherlist_desc', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, $description, '');
        $settings->add($setting);

        $name = 'local_intelliboard/sslversion';
        $title = new lang_string('sslversion', 'local_intelliboard');
        $description = new lang_string('sslversion_desc', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, $description, '');
        $settings->add($setting);


        $settings->add(new admin_setting_heading('local_intelliboard/filters', new lang_string('filters', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/filter1';
        $title = new lang_string('filter1', 'local_intelliboard');
        $description = new lang_string('filter1_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter2';
        $title = new lang_string('filter2', 'local_intelliboard');
        $description = new lang_string('filter2_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter3';
        $title = new lang_string('filter3', 'local_intelliboard');
        $description = new lang_string('filter3_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter4';
        $title = new lang_string('filter4', 'local_intelliboard');
        $description = new lang_string('filter4_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter5';
        $title = new lang_string('filter5', 'local_intelliboard');
        $description = new lang_string('filter5_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter6';
        $title = new lang_string('filter6', 'local_intelliboard');
        $description = new lang_string('filter6_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter7';
        $title = new lang_string('filter7', 'local_intelliboard');
        $description = new lang_string('filter7_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/filter8';
        $title = new lang_string('filter8', 'local_intelliboard');
        $description = new lang_string('filter8_desc', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        $options = array(
            1=>new lang_string('completions_completed', 'local_intelliboard'),
            2=>new lang_string('completions_pass', 'local_intelliboard'),
            3=>new lang_string('completions_fail', 'local_intelliboard')
        );
        $defaultdisplayoptions = array(1,2);

        $name = 'local_intelliboard/completions';
        $title = new lang_string('completions', 'local_intelliboard');
        $desc = new lang_string('completions_desc', 'local_intelliboard');
        $setting = new admin_setting_configmultiselect($name, $title, $desc, $defaultdisplayoptions, $options);
        $settings->add($setting);

        $options = array();
        $defaultdisplayoptions = array();
        for($i=0;$i<20;$i++){
                $options[$i] = $i+1;
                if($i < 3){
                        $defaultdisplayoptions[$i] = $i;
                }
        }

        $name = 'local_intelliboard/filter9';
        $title = new lang_string('t49', 'local_intelliboard');
        $setting = new admin_setting_configmultiselect($name, $title, '', $defaultdisplayoptions, $options);
        $settings->add($setting);

        $roles = role_fix_names(get_all_roles(), null, ROLENAME_ORIGINALANDSHORT);
        $options = array();
        foreach ($roles as $role) {
                $options[$role->id] = $role->localname;
        }

        $name = 'local_intelliboard/filter10';
        $title = new lang_string('t50', 'local_intelliboard');
        $setting = new admin_setting_configmultiselect($name, $title, '', array(1,2,3,4), $options);
        $settings->add($setting);

        $name = 'local_intelliboard/filter11';
        $title = new lang_string('t51', 'local_intelliboard');
        $setting = new admin_setting_configmultiselect($name, $title, '', array(5), $options);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/n0', new lang_string('n10', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/n11';
        $title = new lang_string('n11', 'local_intelliboard');
        $default = new lang_string('n10', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/n10';
        $title = new lang_string('n101', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n8';
        $title = new lang_string('n8', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/coursessessionspage';
        $title = new lang_string('coursessessionspage', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n9';
        $title = new lang_string('n9', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n17';
        $title = new lang_string('n17', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n1';
        $title = new lang_string('n1', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n2';
        $title = new lang_string('n2', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n3';
        $title = new lang_string('n3', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n12';
        $title = new lang_string('n12', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n4';
        $title = new lang_string('n4', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n5';
        $title = new lang_string('n5', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n13';
        $title = new lang_string('n13', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n6';
        $title = new lang_string('n6', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n14';
        $title = new lang_string('n14', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n18';
        $title = new lang_string('n18', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n7';
        $title = new lang_string('n7', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n15';
        $title = new lang_string('n15', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/n16';
        $title = new lang_string('n16', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/group_aggregation';
        $title = new lang_string('group_aggregation', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/instructor_redirect';
        $title = new lang_string('instructor_redirect', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/instructor_course_shortname';
        $title = new lang_string('instructor_course_shortname', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/ts1', new lang_string('ts1', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/t0';
        $title = new lang_string('n11', 'local_intelliboard');
        $default = new lang_string('ts1', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/t1';
        $title = new lang_string('t1', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t01';
        $title = new lang_string('t01', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t02';
        $title = new lang_string('t02', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t03';
        $title = new lang_string('t03', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/this_year';
        $title = new lang_string('filter_this_year', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/last_year';
        $title = new lang_string('filter_last_year', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t04';
        $title = new lang_string('t04', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t05';
        $title = new lang_string('t05', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t06';
        $title = new lang_string('t06', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t08';
        $title = new lang_string('t08', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t07';
        $title = new lang_string('t07', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $roles_user = $DB->get_records_sql("SELECT r.id, r.name, r.shortname, r.description, r.sortorder, r.archetype
                                            FROM {role} r
                                              JOIN {role_context_levels} rcl ON rcl.roleid=r.id
                                            WHERE rcl.contextlevel=:contextlevel GROUP BY r.id, r.name, r.shortname, r.description, r.sortorder, r.archetype",array('contextlevel'=>CONTEXT_USER));

        $roles_user = role_fix_names($roles_user);
        $roles_user_arr = array('0'=>get_string('disable'));
        foreach($roles_user as $role){
            $roles_user_arr[$role->id] = $role->localname;
        }

        $name = 'local_intelliboard/t09';
        $title = new lang_string('t09', 'local_intelliboard');
        $desc = new lang_string('select_manager_role', 'local_intelliboard');
        $setting = new admin_setting_configselect($name, $title, $desc, 0, $roles_user_arr);
        $settings->add($setting);

        $name = 'local_intelliboard/student_redirect';
        $title = new lang_string('student_redirect', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/ts2', new lang_string('ts2', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/t2';
        $title = new lang_string('t2', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t5';
        $title = new lang_string('t5', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t6';
        $title = new lang_string('t6', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t7';
        $title = new lang_string('t7', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t8';
        $title = new lang_string('t8', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t9';
        $title = new lang_string('t9', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t31';
        $title = new lang_string('t31', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t32';
        $title = new lang_string('t32', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t10';
        $title = new lang_string('t10', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t33';
        $title = new lang_string('t33', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t34';
        $title = new lang_string('t34', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t11';
        $title = new lang_string('t11', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t35';
        $title = new lang_string('t35', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t36';
        $title = new lang_string('t36', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t37';
        $title = new lang_string('t37', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t38';
        $title = new lang_string('t38', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t52';
        $title = new lang_string('t52', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t12';
        $title = new lang_string('t12', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t13';
        $title = new lang_string('t13', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t14';
        $title = new lang_string('t14', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t15';
        $title = new lang_string('t15', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/ts3', new lang_string('ts3', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/t3';
        $title = new lang_string('t3', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $options = array("Blue","Light Blue","Orange","Green","Red","Gray");
        $name = 'local_intelliboard/t47';
        $title = new lang_string('t47', 'local_intelliboard');
        $setting = new admin_setting_configselect($name, $title,'',0,$options);
        $settings->add($setting);

        $name = 'local_intelliboard/t16';
        $title = new lang_string('t16', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t17';
        $title = new lang_string('t17', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t18';
        $title = new lang_string('t18', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t19';
        $title = new lang_string('t19', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t20';
        $title = new lang_string('t20', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t21';
        $title = new lang_string('t21', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t22';
        $title = new lang_string('t22', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/course_chart';
        $title = new lang_string('course_chart', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/course_activities';
        $title = new lang_string('course_activities', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/ts4', new lang_string('ts4', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/grades_alt_text';
        $title = new lang_string('grades_alt_text', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, '', '');
        $settings->add($setting);

        $name = 'local_intelliboard/t4';
        $title = new lang_string('t4', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t23';
        $title = new lang_string('t23', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t24';
        $title = new lang_string('t24', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t25';
        $title = new lang_string('t25', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t39';
        $title = new lang_string('t39', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t40';
        $title = new lang_string('t40', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t26';
        $title = new lang_string('t26', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t27';
        $title = new lang_string('t27', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t28';
        $title = new lang_string('t28', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t29';
        $title = new lang_string('t29', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);


        $name = 'local_intelliboard/t41';
        $title = new lang_string('t41', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t42';
        $title = new lang_string('t42', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t43';
        $title = new lang_string('t43', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t44';
        $title = new lang_string('t44', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t45';
        $title = new lang_string('t45', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/t46';
        $title = new lang_string('t46', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $settings->add(new admin_setting_heading('local_intelliboard/ts5', new lang_string('ts5', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/t48';
        $title = new lang_string('t48', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);



        $settings->add(new admin_setting_heading('local_intelliboard/competency', new lang_string('a0', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/a11';
        $title = new lang_string('n11', 'local_intelliboard');
        $default = new lang_string('a0', 'local_intelliboard');
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/competency_dashboard';
        $title = new lang_string('a29', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);


        $name = 'local_intelliboard/competency_reports';
        $title = new lang_string('a30', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/a36';
        $title = new lang_string('a36', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/a39';
        $title = new lang_string('a39', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/a4';
        $title = new lang_string('a4', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/a38';
        $title = new lang_string('a38', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/a31';
        $title = new lang_string('a31', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', true, true, false);
        $settings->add($setting);


        $settings->add(new admin_setting_heading('local_intelliboard/scalesettings', new lang_string('scalesettings', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/scale_raw';
        $title = new lang_string('scale_raw', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/scale_real';
        $title = new lang_string('scale_real', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/scales';
        $title = new lang_string('scales', 'local_intelliboard');
        $setting = new admin_setting_configcheckbox($name, $title, '', false, true, false);
        $settings->add($setting);

        $name = 'local_intelliboard/scale_total';
        $title = new lang_string('scale_total', 'local_intelliboard');
        $default = 0;
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/scale_value';
        $title = new lang_string('scale_value', 'local_intelliboard');
        $default = 0;
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/scale_percentage';
        $title = new lang_string('scale_percentage', 'local_intelliboard');
        $default = 0;
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        $name = 'local_intelliboard/scale_percentage_round';
        $title = new lang_string('scale_percentage_round', 'local_intelliboard');
        $default = 0;
        $setting = new admin_setting_configtext($name, $title, '', $default);
        $settings->add($setting);

        // BBB meetings
        $settings->add(new admin_setting_heading('local_intelliboard/bbbmeetings', get_string('bbbmeetings', 'local_intelliboard'), ''));

        $name = 'local_intelliboard/enablebbbmeetings';
        $title = get_string('enablebbbmeetings', 'local_intelliboard');
        $description = '';
        $setting = new admin_setting_configcheckbox($name, $title, $description, false, true, false);
        $settings->add($setting);

        // BBB API endpoint
        $name = 'local_intelliboard/bbbapiendpoint';
        $title = get_string('bbbapiendpoint', 'local_intelliboard');
        $description = '';
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $settings->add($setting);

        // BBB server secret
        $name = 'local_intelliboard/bbbserversecret';
        $title = get_string('bbbserversecret', 'local_intelliboard');
        $description = '';
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $settings->add($setting);
}

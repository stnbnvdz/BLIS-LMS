<?php

defined('MOODLE_INTERNAL') || die;

if ($CFG->version > 2018120300) {
    echo $OUTPUT->standard_after_main_region_html();
}

$hidepagefootermobile = $PAGE->theme->settings->hidepagefootermobile;
if (((theme_adaptable_is_mobile()) && ($hidepagefootermobile == 1)) || (theme_adaptable_is_desktop())) {
?>

<footer id="page-footer">

<?php
echo $OUTPUT->get_footer_blocks();

if ($PAGE->theme->settings->hidefootersocial == 1) { ?>
        <div class="container">
            <div class="row-fluid">
                <div class="span12 pagination-centered">
<?php
    echo $OUTPUT->socialicons();
?>
                </div>
            </div>
        </div>

<?php }

if ($PAGE->theme->settings->moodledocs) {
    $footnoteclass = 'span4';
} else {
    $footnoteclass = 'span8';
}

if ($PAGE->theme->settings->showfooterblocks) {
?>
    <div class="info container2 clearfix">
        <div class="container">
            <div class="row-fluid">
                <div class="<?php echo $footnoteclass; ?>">
<?php echo $OUTPUT->get_setting('footnote', 'format_html');
?>
                </div>

<?php
if ($PAGE->theme->settings->moodledocs) {
?>
                <div class="span4 helplink">
<?php
    echo $OUTPUT->page_doc_link(); ?>
                </div>
<?php
}
?>
                <div class="span4">
                    <?php echo $OUTPUT->standard_footer_html(); ?>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
</footer>

<?php
}
?>

<a class="back-to-top" href="#top" ><i class="fa fa-angle-up "></i></a>

<?php
    // If admin settings page, show template for floating save / discard buttons.
    $templatecontext = [
    'topmargin'   => ($PAGE->theme->settings->stickynavbar ? '35px' : '0px'),
    'savetext'    => get_string('savebuttontext', 'theme_adaptable'),
    'discardtext' => get_string('discardbuttontext', 'theme_adaptable')
    ];
    if (strstr($PAGE->pagetype, 'admin-setting')) {
        if ($PAGE->theme->settings->enablesavecanceloverlay) {
            echo $OUTPUT->render_from_template('theme_adaptable/savediscard', $templatecontext);
        }
    }
?>

<?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
<?php echo $PAGE->theme->settings->jssection; ?>

<?php


// Conditional javascript based on a user profile field.
if (!empty($PAGE->theme->settings->jssectionrestrictedprofilefield)) {
    // Get custom profile field setting. (e.g. faculty=fbl).
    $fields = explode('=', $PAGE->theme->settings->jssectionrestrictedprofilefield);
    $ftype = $fields[0];
    $setvalue = $fields[1];

    // Get user profile field (if it exists).
    require_once($CFG->dirroot.'/user/profile/lib.php');
    require_once($CFG->dirroot.'/user/lib.php');
    profile_load_data($USER);
    $ftype = "profile_field_$ftype";
    if (isset($USER->$ftype)) {
        if ($USER->$ftype == $setvalue) {
            // Match between user profile field value and value in setting.

            if (!empty($PAGE->theme->settings->jssectionrestricteddashboardonly)) {

                // If this is set to restrict to dashboard only, check if we are on dashboard page.
                if ($PAGE->has_set_url()) {
                    $url = $PAGE->url;
                } else if ($ME !== null) {
                    $url = new moodle_url(str_ireplace('/my/', '/', $ME));
                }

                // In practice, $url should always be valid.
                if ($url !== null) {
                    // Check if this is the dashboard page.
                    if (strstr ($url->raw_out(), '/my/')) {
                        echo $PAGE->theme->settings->jssectionrestricted;
                    }
                }
            } else {
                echo $PAGE->theme->settings->jssectionrestricted;
            }

        }
    }

}

?>

<?php echo $OUTPUT->get_all_tracking_methods(); ?>
</body>
</html>

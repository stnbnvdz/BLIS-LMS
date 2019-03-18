<?php

defined('MOODLE_INTERNAL') || die;

// Include header.
require_once(dirname(__FILE__) . '/includes/header.php');

$left = $PAGE->theme->settings->blockside;

$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$regions = theme_adaptable_grid($left, $hassidepost);
?>

<div id="page" class="container-outercont">
    <div id="page-content" class="row-fluid">
        <?php echo $OUTPUT->page_navbar(false); ?>

        <section id="region-main" class="<?php echo $regions['content']; ?>">
            <?php
            echo $OUTPUT->get_course_alerts();
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            if ($PAGE->has_set_url()) {
                $currenturl = $PAGE->url;
            } else {
                $currenturl = $_SERVER["REQUEST_URI"];
            } ?>
        </section>
        <?php
            echo $OUTPUT->blocks('side-post', $regions['blocks']);
        ?>
    </div>
</div>

<script type="text/javascript">
    <?php echo $PAGE->theme->settings->jssection;?>
</script>

<?php echo $OUTPUT->standard_end_of_body_html();

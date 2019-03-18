<?php

defined('MOODLE_INTERNAL') || die;

// Include header.
require_once(dirname(__FILE__) . '/includes/header.php');

$left = $PAGE->theme->settings->blockside;

// If page is Grader report, override blockside setting to align left.
if (($PAGE->pagetype == "grade-report-grader-index") ||
    ($PAGE->bodyid == "page-grade-report-grader-index")) {
    $left = true;
}

$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$regions = theme_adaptable_grid($left, $hassidepost);
?>

<div class="container outercont">
    <div id="page-content" class="row-fluid">
        <?php echo $OUTPUT->page_navbar(false); ?>

        <section id="region-main" class="<?php echo $regions['content'];?>">
            <?php
            echo $OUTPUT->get_course_alerts();
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();

            if ($PAGE->has_set_url()) {
                $currenturl = $PAGE->url;
            } else {
                $currenturl = $_SERVER["REQUEST_URI"];
            }

            // Display course page block activity bottom region if this is a mod page of type where you're viewing
            // a section, page or book (chapter).
            if (!empty($PAGE->theme->settings->coursepageblockactivitybottomenabled)) {
                if ( stristr ($currenturl, "mod/page/view") ||
                     stristr ($currenturl, "mod/book/view") ) {
                    echo $OUTPUT->get_block_regions('customrowsetting', 'course-section-', '12-0-0-0');
                }
            }

            echo $OUTPUT->course_content_footer();
            ?>
        </section>

        <?php
            echo $OUTPUT->blocks('side-post', $regions['blocks']);
        ?>
    </div>
</div>

<?php
// Include footer.
require_once(dirname(__FILE__) . '/includes/footer.php');

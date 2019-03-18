<?php


defined('MOODLE_INTERNAL') || die;

// Include header.
require_once(dirname(__FILE__) . '/includes/header.php');

?>

<div class="container outercont">
    <div id="page-content" class="row-fluid">
            <?php echo $OUTPUT->page_navbar(true); ?>
        <section id="region-main" class="span12">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
        </section>
    </div>
</div>

<?php
// Include footer.
require_once(dirname(__FILE__) . '/includes/footer.php');

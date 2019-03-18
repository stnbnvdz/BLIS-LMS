<?php

defined('MOODLE_INTERNAL') || die;

// Include header.
require_once(dirname(__FILE__) . '/includes/header.php');

// Set layout.
$left = $PAGE->theme->settings->blockside;
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$regions = theme_adaptable_grid($left, $hassidepost);

$hasfootnote = (!empty($PAGE->theme->settings->footnote));

?>

<?php

if (!empty($PAGE->theme->settings->dashblocksenabled)) { ?>
    <div id="frontblockregion" class="container">
        <div class="row-fluid">
            <?php echo $OUTPUT->get_block_regions('dashblocklayoutlayoutrow'); ?>
        </div>
    </div>
<?php
}
?>

<div class="container outercont">
    <div id="page-content" class="row-fluid">
    <section id="region-main" class="<?php echo $regions['content'];?>">
        <?php
        echo $OUTPUT->course_content_header();
        echo $OUTPUT->main_content();
        echo $OUTPUT->course_content_footer();
        ?>
    </section>
    <?php
        echo $OUTPUT->blocks('side-post', $regions['blocks']);
    ?>
</div>

<?php
if (is_siteadmin()) {
?>
    <div class="hidden-blocks">
        <div class="row-fluid">
            <h3><?php echo get_string('frnt-footer', 'theme_adaptable') ?></h3>
            <?php
            echo $OUTPUT->blocks('frnt-footer', 'span10');
            ?>
        </div>
    </div>
    <?php
}
?>
</div>

<?php
// Include footer.
require_once(dirname(__FILE__) . '/includes/footer.php');

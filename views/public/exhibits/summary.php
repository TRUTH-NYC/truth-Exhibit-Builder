<?php
if (!$exhibit) {
    $exhibit = get_current_record('exhibit');
}
$file = get_record_by_id('File', $exhibit->cover_image_file_id);

echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); 
?>

<div class="exhibit-header-card" style="--background-color: <?php echo get_theme_option('exhibit_header_card_color'); ?>">
    <div class="exhibit-header-card-content">
    <h1><?php echo metadata('exhibit', 'title'); ?></h1>
    <?php echo exhibit_builder_page_nav(); ?>
    <?php if($file): ?>
        <figure class="exhibit-cover-image mobile-only">
            <img src="<?php echo file_display_url($file); ?>" />
                <?php 
                    $item = get_record_by_id('Item', $exhibit->cover_image_file_id);
                    if($item) {
                    echo '<figcaption>';
                        echo metadata($item, array('Dublin Core', 'Source'));
                    echo '</figcaption>';    
                    }
                ?>
        </figure>
    <?php endif; ?>
    <?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
        <?php 
            $separated = explode("<p></p>\n<p></p>\n<p></p>", $exhibitDescription);
            $exhibitDescription = $separated[0];
            $exhibitDescription2 = $separated[1];
        ?>
        <div class="exhibit-description">
            <?php echo $exhibitDescription; ?>
        </div>
    <?php endif; ?>
    </div>

<?php if($file): ?>
<figure class="exhibit-cover-image">
    <img src="<?php echo file_display_url($file); ?>" />
        <?php 
            $item = get_record_by_id('Item', $exhibit->cover_image_file_id);
            if($item) {
             echo '<figcaption>';
                echo metadata($item, array('Dublin Core', 'Source'));
             echo '</figcaption>';    
            }
        ?>
</figure>
<?php endif; ?>

<?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
<div class="exhibit-credits">
    <h3><?php echo __('Credits'); ?></h3>
    <p><?php echo $exhibitCredits; ?></p>
</div>
<?php endif; ?>
</div>
<?php if ($exhibitDescription2): ?>
<?php
    echo $exhibitDescription2;
 ?>
 <?php endif; ?>
<?php
$pageTree = exhibit_builder_page_thumbnails();
if ($pageTree):
?>
<nav id="exhibit-pages">
    <?php echo $pageTree; ?>
</nav>
<?php endif; ?>

<?php echo foot(); ?>

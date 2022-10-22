<?php
if (!$exhibit) {
    $exhibit = get_current_record('exhibit');
}
$file = get_record_by_id('File', $exhibit->cover_image_file_id);

echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); 
?>
<?php 
    ($color = get_theme_option('exhibit_header_paragraph_color')) || ($color = '#444');
    ($title_color = get_theme_option('exhibit_header_title_color')) || ($title_color = '#444');
    ($subtitle_color = get_theme_option('exhibit_header_subtitle_color')) || ($subtitle_color = '#fff');
    ($text_align =  get_theme_option('exhibit_header_card_text_align')) || ($text_align = 'left');
    ($font_size =  get_theme_option('exhibit_header_paragraph_font_size')) || ($font_size = '16px');
    ($title_font_size =  get_theme_option('exhibit_header_title_font_size')) || ($title_font_size = '28px');
    ($subtitle_font_size =  get_theme_option('exhibit_header_subtitle_font_size')) || ($subtitle_font_size = '40px');
    ($font_family = get_theme_option('exhibit_header_card_text_font_family')) || ($font_family = 'EB Garamond');
    ($title_font_family = get_theme_option('exhibit_header_card_title_font_family')) || ($title_font_family = 'EB Garamond');
    ($subtitle_font_family = get_theme_option('exhibit_header_card_subtitle_font_family')) || ($subtitle_font_family = 'Montserrat');
    ($title_line_height = get_theme_option('exhibit_header_title_line_height')) || ($title_line_height = '54px');
    ($subtitle_line_height = get_theme_option('exhibit_header_subtitle_line_height')) || ($subtitle_line_height = '54px');
?>
<div class="exhibit-header-card" style="--background-color: <?php echo get_theme_option('exhibit_header_card_color'); ?>">
    <div class="exhibit-header-card-content" style="--color: <?php echo $color; ?>; --title-color: <?php echo $title_color; ?>; --subtitle-color: <?php echo $subtitle_color ?>; --text-align: <?php echo $text_align; ?>; --font-size: <?php echo $font_size; ?>; --title-font-size: <?php echo $title_font_size; ?>; --subtitle-font-size: <?php echo $subtitle_font_size; ?>; --font-family: <?php echo $font_family; ?>; --title-font-family: <?php echo $title_font_family; ?>;  --subtitle-font-family: <?php echo $subtitle_font_family; ?>; --title-line-height:  <?php echo $title_line_height; ?>; --subtitle-line-height:  <?php echo $subtitle_line_height; ?>;">
    <h1><?php echo metadata('exhibit', 'title'); ?></h1>
    <?php echo exhibit_builder_page_nav(); ?>
    <?php if($file): ?>
        <figure class="exhibit-cover-image mobile-only">
            <div class="exhibit-cover-image-img" style="background-image: url('<?php echo file_display_url($file); ?>');"></div>
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
    <div class="exhibit-cover-image-img" style="background-image: url('<?php echo file_display_url($file); ?>');"></div>
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

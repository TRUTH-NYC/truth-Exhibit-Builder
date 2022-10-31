<?php
$formStem = $block->getFormStem();
$options = $block->getOptions();
?>
<div class="block-text">
    <h4><?php echo __('Text'); ?></h4>
    <?php echo $this->exhibitFormText($block); ?>
</div>

<div class="item-details">
    <h4> Gallery of items with a tag </h4>
    <div class="query-param">
        <?php echo $this->formLabel($formStem . '', __('Select a Tag for Items:')); ?>
        <?php
        $tags = get_records('Tag', array(), 250);
        $tags_options = array('' => 'Select');

        array_walk($tags, function($tag) use (&$tags_options) {
            $tags_options[$tag->name] = $tag->name;
        });

        echo $this->formSelect($formStem . '[options][tag]',
            @$options['tag'], array(),
            $tags_options
        );
        ?>
    </div>
</div>


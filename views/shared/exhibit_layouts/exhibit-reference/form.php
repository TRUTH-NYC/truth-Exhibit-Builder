<?php
$formStem = $block->getFormStem();
$options = $block->getOptions();
?>
<div class="item-details">
    <h4> Reference Another Exhibit </h4>
    <div class="query-param">
        <?php echo $this->formLabel($formStem . '', __('Select Another Exhibit For Page:')); ?>
        <?php
        $exhibits = get_records('Exhibit', array(), 50);
        // echo $this->formSelect($formStem . '[options][columns]',
        // @$options['columns'], array(),
        //     array(
        //         'oneCol'=>__('One Column'),
        //         'twoCol'=>__('Two Column'),
        //         'threeCol'=>__('Three Column'),
        //     )
        // );
        
        $exhibits_options = array('' => 'Select');

        array_walk($exhibits, function($exhibit) use (&$exhibits_options) {
            $exhibits_options[$exhibit->slug] = $exhibit->title;
        });

        echo $this->formSelect($formStem . '[options][slugs]',
            @$options['slugs'], array(),
            $exhibits_options
        );
        ?>
    </div>
</div>


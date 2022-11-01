<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
?>
<?php
    $page = get_current_record('exhibit_page');
    $blocks = $page->ExhibitPageBlocks;
    $firstBlock;

    if(is_array($blocks)) {
        $firstBlock = array_values($blocks)[0];
    }

    if(isset($firstBlock) && $firstBlock->layout == 'gallery-by-tag') {
        $items = get_records('Item', array('tags' => array(json_decode($firstBlock->options)->tag)), 1);
        
        if(!empty($items)) {
            $firstItem = array_values($items)[0];
        }
    }
    
    $description = '';
    $relation = '';

    if(isset($firstItem)) {
        $description = metadata($firstItem, array('Dublin Core', 'Description'));
        $relation = metadata($firstItem, array('Dublin Core', 'Relation'));
    }
?> 

<div id="exhibit-info">
    <?php if (!empty($description)): ?>
        <p> <?php echo $description; ?> </p>
    <?php endif; ?>
    <?php if (!empty($relation)): ?>
        <p> <?php echo $relation; ?> </p>
    <?php endif; ?>
</div>
<nav id="exhibit-pages">
    <h4><?php echo exhibit_builder_link_to_exhibit($exhibit); ?></h4>
    <?php echo exhibit_builder_page_tree($exhibit, $exhibit_page); ?>
</nav>

<div id="exhibit-blocks">
<?php exhibit_builder_render_exhibit_page(); ?>
</div>

<?php echo foot(); ?>

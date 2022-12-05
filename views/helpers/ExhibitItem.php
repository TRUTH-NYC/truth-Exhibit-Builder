<?php

/**
 * Exhibit attachment view helper.
 * 
 * @package ExhibitBuilder\View\Helper
 */
class ExhibitBuilder_View_Helper_ExhibitItem extends Zend_View_Helper_Abstract
{
    /**
     * Return the markup for displaying an exhibit attachment.
     *
     * @param ExhibitItem $item
     * @param array $fileOptions Array of options for file_markup
     * @param array $linkProps Array of options for exhibit_builder_link_to_exhibit_item
     * @param boolean $forceImage Whether to display the attachment as an image
     *  always Defaults to false.
     * @return string
     * 
     */
    public function exhibitItem($item, $fileOptions = array(), $linkProps = array(), $forceImage = false)
    {
         $itemTitle = metadata($item, 'display_title');
         $html = '<figure class="exhibit-item exhibit-gallery-item">';
        if (metadata($item, 'has thumbnail')) {
            $thumbnail = file_display_url($item->getFile(0));
            $fullsize = file_display_url($item->getFile(0), 'fullsize');
            $image = '<img image-url 
            srcset="' . $thumbnail . ' 139w, '. $fullsize . ' 1000w" 
            sizes="(max-width: 530px) calc(100vw - 4%), (max-width: 918px) calc((100vw - 4% - 3em) / 2), (max-width: 1244px) calc((100vw - 4% - 6em) / 3)"
            src="'
            . $fullsize 
            . '" alt=" ' 
            . $itemTitle 
            . '">';
            $html .= '<div class="item-img">'
            . link_to_item($image, null, null, $item)
            . '<div class="exhibit-item-caption"> <p>'
            . metadata($item, array('Dublin Core', 'Title'))
            . '</p></div>'
            . '</div>';
        }
            $html .= '<figcaption>' . $itemTitle .'</figcaption>'
            . '</figure>';

        return apply_filters('exhibit_attachment_markup', $html,
            compact('attachment', 'fileOptions', 'linkProps', 'forceImage')
        );
    }

    /**
     * Return the markup for an attachment's caption.
     *
     * @param ExhibitBlockAttachment $attachment
     * @return string
     */
    protected function _caption($attachment)
    {
        if (!is_string($attachment['caption']) || $attachment['caption'] == '') {
            return '';
        }

        $html = '<div class="exhibit-item-caption">'
              . $attachment['caption']
              . '</div>';

        return apply_filters('exhibit_attachment_caption', $html, array(
            'attachment' => $attachment
        ));
    }
}

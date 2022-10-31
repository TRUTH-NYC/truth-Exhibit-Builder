<?php

/**
 * View helper for a unordered list "tree" of pages in an exhibit.
 * 
 * @package ExhibitBuilder\View\Helper
 */
class ExhibitBuilder_View_Helper_ExhibitPageThumbnails extends Zend_View_Helper_Abstract
{
    /**
     * @var Exhibit
     */
    protected $_exhibit;
    
    /**
     * Pages, indexed by parent ID, for current exhibit
     * 
     * @var array
     */
    protected $_pages;
    
    /**
     * Return the tree of pages.
     *
     * @param Exhibit $exhibit
     * @param ExhibitPage|null $currentPage
     * @return string
     */
    public function exhibitPageThumbnails($exhibit, $currentPage = null)
    {
        $pages = $exhibit->PagesByParent;
        if (!($pages && isset($pages[0]))) {
            return '';
        }

        $this->_exhibit = $exhibit;
        $this->_pages = $pages;

        $ancestorIds = $this->_getAncestorIds($currentPage);

        $html = $this->_renderListOpening();
        foreach ($pages[0] as $topPage) {
            $html .= $this->_renderPageBranch($topPage, $currentPage, $ancestorIds);
        }
        $html .= '</ul>';
        return $html;
    }

    /**
     * Recursively create the HTML for a "branch" (a page and its descendants)
     * of the tree.
     *
     * @param ExhibitPage $page
     * @param ExhibitPage|null $currentPage
     * @param array $ancestorIds
     * @return string
     */
    protected function _renderPageBranch($page, $currentPage, $ancestorIds)
    {
        if ($currentPage && $page->id === $currentPage->id) {
            $html = '<li class="current">';
        } else if ($ancestorIds && isset($ancestorIds[$page->id])) {
            $html = '<li class="parent">';
        } else {
            $html = '<li>';
        }

        $blocks = $page->ExhibitPageBlocks;
        $firstBlock = array_values($blocks)[0];
        
        $attachments = $page->getAllAttachments();
        if(!empty($attachments)) {
            $firstAttachment = array_values($attachments)[0];
            $file = get_record_by_id('File', $firstAttachment->file_id);
        }

        if($firstBlock->layout == 'gallery-by-tag') {
            $items = get_records('Item', array('tags' => array(json_decode($firstBlock->options)->tag)), 1);
            if(!empty($items)) {
                $firstItem = array_values($items)[0];
                $file = $firstItem->getFile(0);
            }
        }

        if($firstBlock->options) {
            $exhibitions = explode(',', json_decode($firstBlock->options)->slugs);
            $firstExhibitionSlug = array_values($exhibitions)[0];
            $referenceExhibition = get_record('Exhibit', array('slug' => $firstExhibitionSlug));
        }
        
        if($referenceExhibition) {
            $file = get_record_by_id('File', $referenceExhibition->cover_image_file_id);
            $html .= '<div class="sub-category-rich-link"> <a href="' . exhibit_builder_exhibit_uri($referenceExhibition) . '">'
                    . '<h3>'. $referenceExhibition->title .'</h3>'
                    . '<p>'. $referenceExhibition->description .'</p>';
                    if($file) {
                        $html .= '<img src="'. file_display_url($file) .'" />';
                    }
                    $html .= '</a>';
            } else {
                $html .= '<div class="sub-category-rich-link"> <a href="' . exhibit_builder_exhibit_uri($this->_exhibit, $page) . '">'
                . '<p>'. $firstBlock->text .'</p>';
                if($file) {
                    $html .= '<img src="'. file_display_url($file) .'" />';
                }
                $html .= '</a>';
            }
              
        if (isset($this->_pages[$page->id])) {
            $html .= '<ul>';
            foreach ($this->_pages[$page->id] as $childPage) {
                $html .= $this->_renderPageBranch($childPage, $currentPage, $ancestorIds);
            }
            $html .= '</ul>';
        }
        $html .= '</li>';
        return $html;
    }

    /**
     * Get the opening tag for the outermost list element.
     *
     * @return string
     */
    protected function _renderListOpening()
    {
        return '<ul>';
    }

    /**
     * Get the IDs of all pages that are ancestors of the current page.
     *
     * @param ExhibitPage $currentPage
     * @return array
     */
    protected function _getAncestorIds($currentPage)
    {
        $ancestorIds = array();
        if ($currentPage) {
            $pagesById = $this->_exhibit->PagesById;
            $currentId = $currentPage->parent_id;
            while ($currentId) {
                $currentPage = $pagesById[$currentId];
                $ancestorIds[$currentPage->id] = $currentPage->id;
                $currentId = $currentPage->parent_id;
            }
        }

        return $ancestorIds;
    }
}

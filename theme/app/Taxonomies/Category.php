<?php

namespace Theme\Taxonomies;

use Gaumap\Abstracts\AbstractTaxonomy;

class Category extends AbstractTaxonomy
{
    
    public function __construct()
    {
        $this->taxonomy  = 'category';
        $this->singular  = $this->plural = __('Chuyên mục', 'gaumap');
        $this->postTypes = ['post'];
        $this->slug      = 'chuyen-muc';
        parent::__construct();
    }
    
    /**
     * Document: https://docs.carbonfields.net/#/containers/term-meta?id=term-meta
     */
    public function metaFields()
    {
        // Container::make('term_meta', __('Category Properties'))
        //          ->where('term_taxonomy', '=', $this->taxonomy)
        //          ->add_fields([
        //              Field::make('color', 'crb_title_color', __('Title Color')),
        //              Field::make('image', 'crb_thumb', __('Thumbnail')),
        //          ]);
    }
    
}
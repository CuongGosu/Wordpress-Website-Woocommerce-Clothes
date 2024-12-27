<?php

namespace Theme\PostTypes;

use Carbon_Fields\Container\Container;
use Gaumap\Abstracts\AbstractPostType;

class Post extends AbstractPostType
{
    public function __construct()
    {
        $this->showThumbnailOnList = true;
        $this->supports            = [
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
        ];
        $this->menuIcon            = 'dashicons-editor-ul';
        $this->post_type           = 'post';
        $this->singularName        = $this->pluralName = __('Bài viết', 'gaumap');
        $this->titlePlaceHolder    = __('Tiêu đề', 'gaumap');
        $this->slug                = 'bai-viet';
        parent::__construct();
    }
    
    /**
     * Document: https://docs.carbonfields.net/#/containers/post-meta
     */
    // public function metaFields()
    // {
    //     Container::make('post_meta', __('Cài đặt chung', 'gaumap'))
    //              ->set_context('side')// normal, advanced, side or carbon_fields_after_title
    //              ->set_priority('high')// high, core, default or low
    //              ->where('post_type', 'IN', [$this->post_type])
    //              ->add_fields([
    //                  // Field::make('checkbox', 'noi_bat', __('Đánh dấu nổi bật', 'gaumap')),
    //                  // Field::make('text', 'so_luot_xem', __('Số lượt xem', 'gaumap'))->set_attribute('type', 'number'),
    //              ]);
    // }
}
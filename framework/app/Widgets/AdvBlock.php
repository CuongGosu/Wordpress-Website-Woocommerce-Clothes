<?php

namespace Gaumap\Widgets;

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class AdvBlock extends Widget
{
    // Register widget function. Must have the same name as the class
    function __construct()
    {
        $this->setup('adv_block', __('Banner', 'nrglobal'), __('Hiển thị nội dung quảng cáo trang chủ', 'nrglobal'), [
            Field::make('complex', 'main_adv' , __('Nội dung quảng cáo', 'nrglobal'))
             ->set_layout('tabbed-horizontal')// grid, tabbed-vertical
             ->add_fields([
                Field::make('image', 'img_adv', __('Hình ảnh (754 x 899px)', 'nrglobal')),
                Field::make('text', 'link_button', __('Đường dẫn (Link)', 'nrglobal')),
            ]),
        ]);
    }
    
    // Called when rendering the widget in the front-end
    function front_end($args, $instance)
    {
        if($instance['main_adv']):
?>

        <div class="wrapper-home-banner-top">
            <div class="list-slider-banner owl-carousel owl-theme">
                <?php foreach($instance['main_adv'] as $main_adv): ?>
                <div class="home-banner-pd">
                    <div class="block-banner-category ">
                        <a class="link-banner ratiobox" href="<?php echo ($main_adv['link_button'] !='') ? $main_adv['link_button'] : 'javascript:void(0)'; ?>">
                            <img src="<?php echo getImageUrlById($main_adv['img_adv']) ?>" alt="<?php echo get_the_title($main_adv['img_adv']) ?>">
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
<?php
        endif;
    }
}
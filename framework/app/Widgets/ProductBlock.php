<?php

namespace Gaumap\Widgets;

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

class ProductBlock extends Widget
{
    // Register widget function. Must have the same name as the class
    function __construct()
    {
        $this->setup('product_block', __('Khối các sản phẩm', 'nrglobal'), __('Hiển thị Khối sản phẩm', 'nrglobal'), [
            Field::make('text', 'title_product', __('Tiêu đề', 'nrglobal')),
            Field::make('select', 'product_category', __('Lọc theo danh mục'))
                ->set_options(function () {
                    $terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false ]);
                    $items = [];
                    $items[0] = 'Tất cả';
                    foreach ($terms as $term) {
                        if($term->parent == 0){
                            $items[$term->term_id] = $term->name;
                            $items += get_child_terms($term->term_id, $terms, '--');
                        }
                    }
                    return $items;
                }),
            Field::make('text', 'posts_per_page', __('Số lượng sản phẩm', 'nrglobal'))
                 ->set_default_value(10)
                 ->set_attributes(['type' => 'number']),
            Field::make('radio', 'post_style', __('Sắp xếp theo', 'nrglobal'))
             ->set_options([
                 'feature-post'   => __('Sản phẩm nổi bật', 'nrglobal'),
                 'new-post'       => __('Sản phẩm mới nhất', 'nrglobal'),
             ]),
        ]);
    }
    
    // Called when rendering the widget in the front-end
    function front_end($args, $instance)
    {
        $product_category = $instance['product_category']; 
        $post_style = $instance['post_style']; 
        if($instance['title_product'] != ''){
            $title_product = $instance['title_product'];
        }else{
            $title_product =  get_term($product_category)->name;
        }
       
        switch ($post_style) {
            case 'new-post':
                if($product_category == 0){
                    $taxQuery = [];

                }else{
                    $tax_query[] = [
                        [
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    =>  $product_category,
                        ],
                    ];
                }
                
                break;
           
            default:
                if($product_category == 0){
                    $tax_query[] = [
                        [
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                        ],
                    ];
                }else{
                    $tax_query[] = [
                        [
                            'taxonomy'         => 'product_cat',
                            'field'            => 'term_id',
                            'terms'            => $product_category,
                            'include_children' => true,
                        ],
                        [
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                        ]
                    ];  
                }

                
               break;
        }
        $limit = $instance['posts_per_page'];
        if(isMobile()){
            if($instance['posts_per_page'] & 2 != 0){
                $limit = $instance['posts_per_page'] + 1;
            }
        }
        $listProduct = new \WP_Query([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => $limit,
            'tax_query'      => $tax_query,
        ]);
?>
        <section class="section section-collection">
            <div class="wrapper-heading-home animation-tran text-center">
                <div class="container-fluid">
                    <div class="site-animation">
                        <h2>
                            <a href="<?php echo ($product_category == 0) ? get_permalink( woocommerce_get_page_id( 'shop' )) : get_term_link($product_category)  ?>">
                                <?php echo $title_product ?>
                            </a>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="wrapper-collection-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="clearfix content-product-list d-flex flex-wrap">
                            <?php
                                if($listProduct->have_posts()):
                                    while($listProduct->have_posts()): $listProduct->the_post();
                                        template('loop/product');
                                    endwhile;
                                    wp_reset_postdata();
                                    wp_reset_query();
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php

    }
}
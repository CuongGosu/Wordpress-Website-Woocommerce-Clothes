
<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header( 'shop' );?>

<main class="mainContent-theme ">
    <div id="product" class="productDetail-page">
        <?php theBreadcrumb() ?>
        <div class="product-detail-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row product-detail-main pr_style_01">
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="product-gallery">
                                    <div class="product-gallery__thumbs-container hidden-sm hidden-xs">
                                        <div class="product-gallery__thumbs thumb-fix">
                                            <div class="product-gallery__thumb active">
                                                <a class="product-gallery__thumb-placeholder" href="javascript:void(0);" data-image="<?php thePostThumbnailUrl() ?>" data-zoom-image="<?php thePostThumbnailUrl() ?>">
                                                    <img alt="<?php the_title() ?>" src="<?php thePostThumbnailUrl() ?>" data-image="<?php thePostThumbnailUrl() ?>">
                                                </a>
                                            </div>
                                            <?php
                                                $attachment_ids = $product->get_gallery_attachment_ids();
                                                if(count($attachment_ids) > 0) {
                                                    foreach( $attachment_ids as $attachment_id ) {
                                            ?>
                                            <div class="product-gallery__thumb ">
                                                <a class="product-gallery__thumb-placeholder" href="javascript:void(0);" data-image="<?php echo getImageUrlById($attachment_id) ?>" data-zoom-image="<?php echo getImageUrlById($attachment_id) ?>">
                                                    <img alt="<?php the_title() ?>" src="<?php echo getImageUrlById($attachment_id) ?>" data-image="<?php echo getImageUrlById($attachment_id) ?>">
                                                </a>
                                            </div>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="product-image-detail box__product-gallery scroll">
                                        <ul id="sliderproduct" class="site-box-content slide_product">
                                            <li class="product-gallery-item gallery-item">
                                                <a class="fancybox-group" data-fancybox="gallery" href="<?php thePostThumbnailUrl() ?>">
                                                    <img class="product-image-feature" src="<?php thePostThumbnailUrl() ?>" alt="<?php the_title() ?>">
                                                </a>
                                            </li>
                                            <?php
                                                $attachment_ids = $product->get_gallery_attachment_ids();
                                                if(count($attachment_ids) > 0) {
                                                    foreach( $attachment_ids as $attachment_id ) {
                                            ?>
                                            <li class="product-gallery-item gallery-item">
                                                <a class="fancybox-group" data-fancybox="gallery" href="<?php echo getImageUrlById($attachment_id) ?>">
                                                    <img class="product-image-feature" src="<?php echo getImageUrlById($attachment_id) ?>" alt=" <?php the_title() ?>">
                                                </a>
                                            </li>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </ul>
                                        <div class="product-image__button">
                                            <div id="product-zoom-in" class="product-zoom icon-pr-fix " aria-label="Zoom in" title="Zoom in">
                                                <span class="zoom-in" aria-hidden="true">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 36 36" style="enable-background:new 0 0 36 36; width: 30px; height: 30px;" xml:space="preserve">
                                                        <polyline points="6,14 9,11 14,16 16,14 11,9 14,6 6,6 "></polyline>
                                                        <polyline points="22,6 25,9 20,14 22,16 27,11 30,14 30,6 "></polyline>
                                                        <polyline points="30,22 27,25 22,20 20,22 25,27 22,30 30,30 "></polyline>
                                                        <polyline points="14,30 11,27 16,22 14,20 9,25 6,22 6,30 "></polyline>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 product-content-desc" id="detail-product">
                                <div class="product-title">
                                    <h1><?php the_title() ?></h1>
                                    <?php
                                    if($product->get_sku()!= ''){
                                    ?>
                                        <span id="pro_sku"><strong><?php _e('SKU:', 'gaumap') ?></strong> <?php echo $product->get_sku(); ?></span>
                                    <?php } ?>
                                    
                                </div>
                                <div class="product-price" id="price-preview">
                                    <?php
                                        if($product->is_type('variable')){
                                            if($product->get_available_variations()[0]['price_html'] != ''){
                                                echo $product->get_available_variations()[0]['price_html'];
                                            }else{
                                                echo $product->get_price_html();
                                            }
                                        }else{
                                            echo $product->get_price_html();
                                        }
                                    ?>
                                </div>
                                <form  class="variants clearfix">
                                    <?php
                                        if($product->is_type('variable')){
                                            $array_color = array();
                                            $array_size = array();
                                            foreach ( $product->get_available_variations() as $value ) {
                                                $color = get_post_meta($value['variation_id'], 'attribute_pa_mau-sac', true);
                                                $size = get_post_meta($value['variation_id'], 'attribute_pa_size', true);
                                                $array_color[] = $color;
                                                $array_size[] = $size;

                                                $size_name = get_term_by('slug', $size, 'pa_size')->name;

                                                $newData[] = [
                                                    "size_color" =>$size."-". $color,
                                                    "sku" => $value['sku'],
                                                    "price" => ($value['price_html'] != '') ? $value['price_html'] : '<span class="class="woocommerce-Price-amount amount">'.number_format($value['display_price'],0,",",".").' <span class="woocommerce-Price-currencySymbol">₫</span></span>',
                                                    'cart'  => $value['variation_id']
                                                ];
                                            }
                                            $array_color = array_unique($array_color);
                                            $array_size = array_unique($array_size);
                                            $jsonData = json_encode($newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


                                    ?>
                                    <input type="hidden" name="info_pro" data-info="<?php echo htmlspecialchars($jsonData, ENT_QUOTES, 'UTF-8'); ?>" id="info_pro">
                                    <div class="select-swatch clearfix">
                                        <div id="variant-swatch-0" class="swatch size clearfix" data-option="option1" data-option-index="0">
                                            <div class="header hide">Kích thước:</div>
                                            <div class="select-swap">
                                                <?php
                                                    if($array_size){
                                                        foreach($array_size as $key => $arr_size){
                                                            $size_name = get_term_by('slug', $arr_size, 'pa_size')->name;
                                                ?>
                                                <div data-value="<?php echo $arr_size ?>" class="n-sd swatch-element size <?php echo $arr_size ?>  ">
                                                    <input class="variant-<?php echo $key ?>" id="swatch-<?php echo $key.'-'.$arr_size ?>" type="radio" name="option1" value="<?php echo $size_name ?>" data-vhandle="<?php echo $arr_size ?>" <?php echo ($key == 0) ? 'checked=""' : null; ?>>
                                                    <label for="swatch-<?php echo $key.'-'.$arr_size ?> " <?php echo ($key == 0) ? 'class="sd"' : null; ?>>
                                                        <span><?php echo $size_name ?></span>
                                                    </label>
                                                </div>
                                                <?php 
                                                        }
                                                    } 
                                                ?>
                                            </div>
                                        </div>
                                        <div id="variant-swatch-1" class="swatch clearfix" data-option="option2" data-option-index="1">
                                            <div class="group-color d-flex">

                                            <?php
                                                if($array_color){
                                                    foreach($array_color as $key => $arr_color){
                                                        $color = get_term_by('slug', $arr_color, 'pa_mau-sac')->name;

                                                        $term = get_term_by('slug', $arr_color, 'pa_mau-sac');
                                                        $id_color = get_term_meta($term->term_id, 'product_attribute_color', true);
                                            ?>
                                            <div class="group-color__box">
                                                <div class="header"><span><?php echo $color ?></span></div>
                                                <div class="select-swap">
                                                    <div data-value="<?php echo $arr_color ?>" class="n-sd swatch-element color <?php echo $arr_color ?>  ">
                                                        <input class="variant-1" id="swatch-<?php echo $key.'-'.$arr_color ?>" type="radio" name="option2" value="<?php echo $color ?>" data-vhandle="<?php echo $color ?>"  <?php echo ($key == 0) ? 'checked=""' : null; ?>>
                                                        <label class="<?php echo $arr_color ?> <?php echo ($key == 0) ? 'sd' : null; ?>" for="swatch-<?php echo $key.'-'.$arr_color ?>">
                                                            <span style="background-color: <?php echo $id_color ?> !important" ><?php echo $color ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <?php
                                                    }
                                                }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="selector-actions">
                                        <?php
                                            $i = 1; foreach ( $product->get_available_variations() as $key => $value ) {
                                        ?>
                                                 <div class="cart-variable single-cart mb-2 <?php echo ($i == 1) ? "d-block" : "d-none";  ?>" data-cart = "<?php echo $value["variation_id"] ?>">
                                                    <?php
                                                        $text_variable = __('Add to cart', 'nrglobal');
                                                        echo do_shortcode('[a2c_button
                                                           product='.get_the_ID().'
                                                           variation='. $value["variation_id"].'
                                                           class="button alt group-cart-vid d-flex flex-wrap"
                                                           button_text="'.$text_variable.'"
                                                           title="none"
                                                        ]');
                                                    ?>
                                                </div>
                                        <?php
                                            $i++;}
                                        ?>
                                    </div>
                                    <?php 
                                        }else{
                                    ?>
                                            <div class="selector-actions">
                                                <?php
                                                    echo do_shortcode('[add_to_cart id="' . get_the_ID() . '" show_price="false" class="group-cart d-flex border-0 mb-3 p-0"]');
                                                ?>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </form>
                              <!--   <div class="product-size-guide">
                                    <a data-fancybox="" data-src="#size-guide" href="javascript:;" class="btn">SIZE GUIDE</a>
                                </div> -->
                                <?php if(get_the_content() !=''): ?>
                                <div class="product-description">
                                    <div class="title-bl">
                                        <h2><?php _e('Description', 'nrglobal') ?></h2>
                                    </div>
                                    <div class="description-content">
                                        <div class="description-productdetail">
                                            <?php the_content() ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
			                $related = wc_get_related_products(get_the_ID(), 10);
			                if(count($related)):
			            ?>
                        <div class="list-productRelated clearfix">
                            <div class="heading-title text-center">
                                <h2><?php _e('MORE PRODUCTS', 'nrglobal') ?></h2>
                            </div>
                            <div class="content-product-list row">
                            	<?php
			                        $products = new WP_Query(array(
			                           'post_type'            => 'product',
			                           'post__in'             => $related,
			                        ));
			                        if ( $products->have_posts() ) :
			                            while ( $products->have_posts() ) : $products->the_post();
			                                template('loop/product');
			                            endwhile;
			                            wp_reset_postdata();
			                            wp_reset_query();
			                        endif;
			                    ?>
                                
                            </div>
                        </div>
                    	<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</main>

<?php get_footer() ?>
<?php

require_once 'vendor/autoload.php';
require_once get_template_directory() . '/framework/app/Walkers/CustomMenuWalkerPC.php';

register_nav_menu('gm-primary', __('Menu chính', 'nrglobal'));
register_nav_menu('gm-sidebar', __('Menu sidebar', 'nrglobal'));
register_nav_menu('gm-footer', __('Menu footer', 'nrglobal'));
register_nav_menu('gm-product', __('Menu danh mục sản phẩm', 'nrglobal'));

new \Theme\PostTypes\Post();
new \Theme\Taxonomies\Category();

loadStyles([
	asset('css/css.css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=vietnamese'),
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
    'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.4/dist/fancybox.css?ver=0.1.0',
	'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css',
	asset('js/owlcarousel2/assets/owlcarousel/assets/owl.carousel.min.css'),
    asset('js/owlcarousel2/assets/owlcarousel/assets/owl.theme.default.min.css'),
	asset('css/mmenu.css'),
	asset('css/main.css'),
	asset('css/styles.css?v=364'),
]);

loadScripts([
	'https://assets.harafunnel.com/widget/114605586591038/1393166.js',
    'https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.4/dist/fancybox.umd.js?ver=0.1.0',
    "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js",
    "https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js",
	// 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js',
	// asset('js/beacon.min.js'),
	asset('js/mmenu.js'),
	asset('js/owlcarousel2/assets/owlcarousel/owl.carousel.js'),
	asset('js/option_selection.js'),
	// asset('js/api.jquery.js'),
	asset('js/plugins.js?v=364'),
	asset('js/scripts.js'),
]);

add_action('widgets_init', function () {
    register_sidebar([
        'name'          => __('Trang chủ - Nội dung trang chủ', 'nrglobal'),
        'id'            => 'home',
        'description'   => __('Khu vực hiển thị nội dung trang chủ', 'nrglobal'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2 class="home">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'name'          => __('Footer - Nội dung chân website', 'nrglobal'),
        'id'            => 'footer',
        'description'   => __('Khu vực hiển thị nội dung chân website', 'nrglobal'),
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2 class="footer">',
        'after_title'   => '</h2>',
    ]);

    register_widget(\Gaumap\Widgets\AdvBlock::class);
    register_widget(\Gaumap\Widgets\ProductBlock::class);
    register_widget(\Gaumap\Widgets\RegisterBlock::class);
});

/*Woocommerce minicart*/
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
function woocommerce_header_add_to_cart_fragment( $fragments ) {
     global $woocommerce;
     ob_start();
     $items = WC()->cart->get_cart_contents();
?>
        <span class="count"><?php  echo WC()->cart->get_cart_contents_count() ?></span>
<?php
     $fragments['span.count'] = ob_get_clean();
     return $fragments;
}


add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cartplus_fragment');
function woocommerce_header_add_to_cartplus_fragment( $content_cart ) {
    global $woocommerce;
    ob_start();
?>
    <div class="cart-view clearfix">
        <div class="cart-view-scroll">
            <table id="cart-view">
            <?php
                if(WC()->cart->get_cart_contents_count() > 0){
                    $items = WC()->cart->get_cart_contents();
                    foreach ($items as $item) :
                        $_product =  wc_get_product( $item['data']->get_id() );
                        $variation_id = $item['variation_id'];
                        if ($variation_id) {
                            $variation = new WC_Product_Variation($variation_id);
                            $variation_attributes = $variation->get_attributes();

                            $variation_name = '';

                            // Lặp qua các thuộc tính của biến thể
                            foreach ($variation_attributes as $attribute_name => $attribute_value) {
                                $attribute_term = get_term_by('slug', $attribute_value, $attribute_name);
                                
                                if ($attribute_term && !is_wp_error($attribute_term)) {
                                    $variation_name .= $attribute_term->name . '/ ';
                                }
                            }
                            $variation_name = rtrim($variation_name, '/ ');
                        ?>
                            <tr class="item_2">
                                <td class="img">
                                    <a href="<?php echo get_permalink($item['product_id'] ) ?>">
                                        <img src="<?php echo getPostThumbnailUrl($item['product_id'], 67, 100) ?>" alt="<?php echo $_product->get_title() ?>"></a>
                                </td>
                                <td>
                                    <p class="pro-title">
                                        <a class="pro-title-view" href="<?php echo get_permalink($item['product_id'] ) ?>"><?php echo $_product->get_title() ?></a>
                                        <span class="variant"><?php echo $variation_name ?> </span>
                                    </p>
                                    <div class="mini-cart_quantity">
                                        <div class="pro-quantity-view"><span class="qty-value"><?php echo $item['quantity'] ?></span></div>
                                        <div class="pro-price-view"><span class="price-original " ><del></del></span><span class="pro_price"><?php echo wc_price($variation->get_price()) ?></span></div>
                                    </div>
                                    <div class="remove_link remove-cart">
                                        <?php
                                            $_product = apply_filters('woocommerce_cart_item_product', $item['data'], $item, $item['key']);
                                            $remove_url = wc_get_cart_remove_url($item['key']); // Thay đổi này để lấy key của sản phẩm
                                        ?>
                                        <a href="<?php echo esc_url($remove_url); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                                <g>
                                                    <path d="M500,442.7L79.3,22.6C63.4,6.7,37.7,6.7,21.9,22.5C6.1,38.3,6.1,64,22,79.9L442.6,500L22,920.1C6,936,6.1,961.6,21.9,977.5c15.8,15.8,41.6,15.8,57.4-0.1L500,557.3l420.7,420.1c16,15.9,41.6,15.9,57.4,0.1c15.8-15.8,15.8-41.5-0.1-57.4L557.4,500L978,79.9c16-15.9,15.9-41.5,0.1-57.4c-15.8-15.8-41.6-15.8-57.4,0.1L500,442.7L500,442.7z"></path>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
            <?php
                        }else{
            ?>
                            <tr class="item_2">
                                <td class="img">
                                    <a href="<?php echo get_permalink($item['product_id'] ) ?>">
                                        <img src="<?php echo getPostThumbnailUrl($item['product_id'], 67, 100) ?>" alt="<?php echo $_product->get_title() ?>"></a>
                                </td>
                                <td>
                                    <p class="pro-title">
                                        <a class="pro-title-view" href="<?php echo get_permalink($item['product_id'] ) ?>"><?php echo $_product->get_title() ?></a>
                                    </p>
                                    <div class="mini-cart_quantity">
                                        <div class="pro-quantity-view"><span class="qty-value"><?php echo $item['quantity'] ?></span></div>
                                        <div class="pro-price-view"><span class="price-original " ><del></del></span><span class="pro_price"><?php echo wc_price($variation->get_price()) ?></span></div>
                                    </div>
                                    <div class="remove_link remove-cart">
                                        <?php
                                            $cart_item_key = WC()->cart->generate_cart_id( $item['product_id'] );
                                            $in_cart       = WC()->cart->find_product_in_cart( $cart_item_key );
                                            if ( $in_cart ) {
                                                $cart_item_remove_url = wc_get_cart_remove_url( $cart_item_key );
                                        ?>
                                        <a href="<?php echo esc_url( $cart_item_remove_url ); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                                <g>
                                                    <path d="M500,442.7L79.3,22.6C63.4,6.7,37.7,6.7,21.9,22.5C6.1,38.3,6.1,64,22,79.9L442.6,500L22,920.1C6,936,6.1,961.6,21.9,977.5c15.8,15.8,41.6,15.8,57.4-0.1L500,557.3l420.7,420.1c16,15.9,41.6,15.9,57.4,0.1c15.8-15.8,15.8-41.5-0.1-57.4L557.4,500L978,79.9c16-15.9,15.9-41.5,0.1-57.4c-15.8-15.8-41.6-15.8-57.4,0.1L500,442.7L500,442.7z"></path>
                                                </g>
                                            </svg>
                                        </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
            <?php
                        }
                    endforeach;
            ?>
            </table>        
            <?php
                }else{
            ?>
                    <table id="clone-item-cart" class="table-clone-cart">
                        <tr class="item_2 hidden">
                            <td class="img"><a href="" title=""><img src="" alt=""></a></td>
                            <td>
                                <p class="pro-title">
                                    <a class="pro-title-view" href="" title=""></a>
                                    <span class="variant"></span>
                                </p>
                                <div class="mini-cart_quantity">
                                    <div class="pro-quantity-view"><span class="qty-value"></span></div>
                                    <div class="pro-price-view">
                                    </div>
                                </div>
                                <div class="remove_link remove-cart"></div>
                            </td>
                        </tr>
                    </table>
                    <table id="cart-view">
                        <tr class="item-cart_empty">
                            <td>
                                <div class="svgico-mini-cart">
                                    <svg width="81" height="70" viewbox="0 0 81 70">
                                        <g transform="translate(0 2)" stroke-width="4" stroke="#1e2d7d" fill="none" fill-rule="evenodd">
                                            <circle stroke-linecap="square" cx="34" cy="60" r="6"></circle>
                                            <circle stroke-linecap="square" cx="67" cy="60" r="6"></circle>
                                            <path d="M22.9360352 15h54.8070373l-4.3391876 30H30.3387146L19.6676025 0H.99560547"></path>
                                        </g>
                                    </svg>
                                </div>
                                <?php _e('Empty', 'nrglobal') ?>
                            </td>
                        </tr>
                    </table>
            <?php } ?>
        </div>
        <div class="line"></div>
        <div class="cart-view-total">
            <table class="table-total">
                <tr>
                    <td class="text-left">Total:</td>
                    <td class="text-right" id="total-view-cart"><?php echo WC()->cart->get_cart_total() ?></td>
                </tr>
                <tr>
                    <td><a href="<?php echo wc_get_cart_url() ?>" class="linktocart button dark"><?php _e('Cart', 'nrglobal') ?></a></td>
                    <td><a href="<?php echo wc_get_checkout_url() ?>" class="linktocheckout button dark"><?php _e('Checkout', 'nrglobal') ?></a></td>
                </tr>
            </table>
        </div>
    </div>
<?php
    $content_cart['.cart-view'] = ob_get_clean();
    return $content_cart;
}
function isMobile() {
   return preg_match("/(android|iphone|ipad|ipod|mobile|symbian|windows phone)/i", $_SERVER["HTTP_USER_AGENT"]);
}
// checkout page
add_filter('woocommerce_cart_item_name', 'add_product_image_to_checkout', 10, 3);

function add_product_image_to_checkout($product_name, $cart_item, $cart_item_key) {
    $product = $cart_item['data']; // Lấy thông tin sản phẩm
    $thumbnail = $product->get_image(array(50, 50)); // Lấy ảnh sản phẩm với kích thước 50x50

    // Thêm ảnh sản phẩm trước tên sản phẩm
    $product_name_with_image = '<div class="checkout-product-thumbnail" style="display: inline-block; margin-right: 10px;">'
                                . $thumbnail .
                                '</div>' . $product_name;

    return $product_name_with_image;
}
// Tạo endpoint AJAX để cập nhật số lượng giỏ hàng
add_action( 'wp_ajax_nopriv_update_cart_count', 'update_cart_count' );
add_action( 'wp_ajax_update_cart_count', 'update_cart_count' );


function update_cart_count() {
    // Trả về số lượng sản phẩm trong giỏ hàng hiện tại
    $cart_count = WC()->cart->get_cart_contents_count();
    echo $cart_count;
    // Cập nhật số lượng giỏ hàng trên cả hai header
    $header_common_count = '<span class="count" data-cart="' . $cart_count . '">' . $cart_count . '</span>';
    $header_common_mobile_count = '<span class="count" data-cart="' . $cart_count . '">' . $cart_count . '</span>';
    
    // Trả về số lượng giỏ hàng và HTML cho cả hai header
    wp_send_json_success( array( 'cart_count' => $cart_count, 'header_common_count' => $header_common_count, 'header_common_mobile_count' => $header_common_mobile_count ) );
}
function enqueue_block_ui_script() {
    if (!is_admin()) { // Chỉ nạp trên frontend
        wp_enqueue_script('jquery-blockui', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js', array('jquery'), '2.70', true);

    }
}
add_action('wp_enqueue_scripts', 'enqueue_block_ui_script', 10);
// 
function custom_update_cart_count() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            // Lắng nghe sự kiện WooCommerce sau khi cập nhật giỏ hàng
            $(document).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function () {
                // Lấy số lượng từ giỏ hàng WooCommerce
                var cartCount = $('.header-cart .count').first().text();
                
                // Đồng bộ cả header-common và header-common-mobile
                $('.header-common .count, .header-common-mobile .count').text(cartCount);
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'custom_update_cart_count');


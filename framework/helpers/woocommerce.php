<?php

add_filter('woocommerce_empty_price_html', static function () {
    return __('Liên hệ', 'gaumap');
});

/**
 * @return int[]
 */
function getProductGalleryImageIds(): array
{
    /**
     * @var \WC_Product $product
     */
    global $product;
    return $product->get_gallery_image_ids();
}

function theProductPrice()
{
    $price = getProductPrice();
    echo empty($price) ? __('Liên hệ') : wc_price($price);
}

function getProductPrice()
{
    global $product;
    $regularPrice = $product->get_regular_price();
    if (empty($regularPrice)) {
        return 0;
    }
    $salePrice = $product->get_sale_price();
    if (!empty($salePrice)) {
        return $salePrice;
    }
    
    return $regularPrice;
}

function theSalePercentage()
{
    global $product;
    if (!$product->is_on_sale()) {
        return;
    }
    $max_percentage = 0;
    if ($product->is_type('simple')) {
        $max_percentage = (($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100;
    } elseif ($product->is_type('variable')) {
        foreach ($product->get_children() as $child_id) {
            $variation = wc_get_product($child_id);
            $price     = $variation->get_regular_price();
            $sale      = $variation->get_sale_price();
            if ($price != 0 && !empty($sale)) {
                $percentage = ($price - $sale) / $price * 100;
            }
            if ($percentage > $max_percentage) {
                $max_percentage = $percentage;
            }
        }
    }
    if ($max_percentage > 0) {
        echo round($max_percentage) . '%';
    }
}

/**
 * Khóa chức năng chọn loại sản phẩm, chỉ được phép đăng sản phẩm đơn giản.
 */
add_filter('product_type_selector', static function ($types) {
    unset($types['grouped'], $types['external']);
    return $types;
});

// remove some fields from billing form
// ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
add_filter('woocommerce_billing_fields', function ($fields = []) {
    // unset($fields['billing_phone']);
    // unset($fields['billing_address_1']);
    // unset($fields['billing_address_2']);
    // unset($fields['billing_company']);
    // unset($fields['billing_state']);
    // unset($fields['billing_city']);
    // unset($fields['billing_postcode']);
    // unset($fields['billing_country']);
    return $fields;
});

/**
 * Bổ sung class form-group và form-control của bootstrap vào các field checkout
 */
add_filter('woocommerce_checkout_fields', static function ($fields) {
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'form-group';
            
            // add form-control to the actual input
            $field['input_class'][] = 'form-control';
        }
    }
    return $fields;
}, 99);

/**
 * Hàm ajax thêm vào giỏ hàng
 * Tham số truyền vào bao gồm productId, qty
 */
add_action('wp_ajax_nopriv_gm_add_to_cart', 'ajaxAddToCart');
add_action('wp_ajax_gm_add_to_cart', 'ajaxAddToCart');
function ajaxAddToCart()
{
    $cart = WC()->cart;
    
    if (!empty($_POST['productId'])) {
        $qty = !empty($_POST['qty']) ? $_POST['qty'] : 1;
        try {
            $cart->add_to_cart($_POST['productId'], $qty);
        } catch (Exception $e) {
        
        }
    }
    
    wp_send_json_success([
        'items_count' => $cart->get_cart_contents_count(),
        'items_total' => $cart->get_cart_contents_total(),
        'total'       => $cart->get_total(),
        'products'    => $cart->cart_contents,
    ]);
}

function thePrice(){

}
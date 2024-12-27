<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.2.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$aria_describedby = isset( $args['aria-describedby_text'] ) ? sprintf( 'aria-describedby="woocommerce_loop_add_to_cart_link_describedby_%s"', esc_attr( $product->get_id() ) ) : '';

// Tùy chỉnh số lượng (từ file cũ của bạn)
$quantity_field = woocommerce_quantity_input( array(
	'input_name'  => 'quantity',
	'input_value' => 1, // Giá trị mặc định là 1
	'max_value'   => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
	'min_value'   => 1,
), $product, false );

// Xóa các thẻ div không cần thiết và thêm style tùy chỉnh
$quantity_field = str_replace( array( '<div class="quantity">', "</div>" ), '', $quantity_field );
echo str_replace( '<input ', '<input style="max-width: 70px" ', $quantity_field );

// Tạo nút "Add to Cart"
echo apply_filters(
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="%s" %s data-quantity="%s" class="%s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		$aria_describedby,
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		esc_html( $product->add_to_cart_text() )
	),
	$product,
	$args
);

// Thêm mô tả nếu có
if ( isset( $args['aria-describedby_text'] ) ) :
	?>
	<span id="woocommerce_loop_add_to_cart_link_describedby_<?php echo esc_attr( $product->get_id() ); ?>" class="screen-reader-text">
		<?php echo esc_html( $args['aria-describedby_text'] ); ?>
	</span>
	<?php
endif;

// JavaScript để cập nhật số lượng sản phẩm
wc_enqueue_js( "
	jQuery( '.add_to_cart_inline .qty' ).on( 'change', function() {
		var qty = jQuery( this ),
			atc = jQuery( this ).next( '.add_to_cart_button' );

			atc.attr( 'data-quantity', qty.val() );
	});
" );
?>

<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' ); ?>
</div>

<div class="checkout_coupon woocommerce-form-coupon form-coupon" method="post">
	<!-- custom -->
	<input class="input-coupon" type="text" name="coupon_code" placeholder="<?php esc_attr_e( 'Discount code', 'woocommerce' ); ?>"  id="coupon_code" value=""  />
	<button class="button-coupon btn-disabled" type="submit" name="apply_coupon" value="Apply coupon"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>

<!-- 
	<div class="clear"></div> -->
</div>

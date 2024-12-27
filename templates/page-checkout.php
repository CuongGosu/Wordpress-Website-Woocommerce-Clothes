<?php
//Template name: Checkout
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
?>
<!doctype html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head() ?>
    <style>
      .woocommerce-form-coupon-toggle{
        display: none;
      }
    </style>
</head>
<div class="container-fluid">
  <form name="checkout" method="post" class="checkout woocommerce-checkout wrapper-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="main-info">
      <?php
       ?> 
      <div class="info-heading-pc">
          <a href="/">
            <h1>
              <?php theOption('ten_cong_ty') ?>
            </h1>
          </a>
          <ul class="breadcrumb-checkout">
            <!-- Cart  Shipping Information  Payment Method -->
            <li class="breadcrumb-item-checkout">
              <a href="/gio-hang">Cart</a>
            </li>

            <li class="breadcrumb-item-checkout">
              <span>Payment Method</span>
            </li>
          </ul>             
      </div>
      <div id="customer_details">
          <?php 
          do_action( 'woocommerce_checkout_billing' ); ?>
    
        </div>
      <h2 class="section-title">Shipping method</h2>
          <div class="radio-wrapper">
            <label class="radio-label" for="shipping_rate_id_1000668252">
              <div class="radio-input">
                <input id="shipping_rate_id_1000668252" class="input-radio" type="radio" name="shipping_rate_id" value="1000668252" checked="">
              </div>
              <span class="radio-label-primary">Phí vận chuyển</span>
              <span class="radio-accessory content-box-emphasis">
                0₫
              </span>
            </label>
          </div>
      <h2 class="section-title">Payment method</h2>
    
            <div id="payment" class="woocommerce-checkout-payment">
            <?php do_action( 'woocommerce_checkout_payment' );?>
                <?php if ( WC()->cart->needs_payment() ) : ?>
                  <ul class="wc_payment_methods payment_methods methods">
                    <?php
                     $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
                  if ( ! empty( $available_gateways ) ) {
                    foreach ( $available_gateways as $gateway ) {
                      wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
                    }
                  } else {
                    echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
                  }
                  ?>
                </ul>
              <?php endif; ?>
              </div>
            <div class="button-control">
                      <a href="/gio-hang">Cart</a>
                      <div>
                      <noscript>
                        <?php
                        /* translators: $1 and $2 opening and closing emphasis tags respectively */
                        printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
                        ?>
                        <br/><button type="submit" class="btn-checkout button alt" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
                      </noscript>
              <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

            <?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="btn-checkout" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr(  "Finish your order") . '" data-value="' . esc_attr( "Finish your order" ) . '">' . esc_html( "Finish your order" ) . '</button>' ); // @codingStandardsIgnoreLine ?>

            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                      </div>
              </div>
    </div>
    <div class="checkout-sidebar">
       <div class="info-heading-mobile">
    <a href="/">
      <h1>
        <?php theOption('ten_cong_ty') ?>
      </h1>
    </a>
            
    </div>
      <table class="shop_table woocommerce-checkout-review-order-table">
        <thead>
            <tr class="thead-tr">
                <th class="product-thumbnail">Image</th>
                <th class="product-name">Product Details</th>
                <th class="product-total">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : 
                $product = $cart_item['data']; // Lấy thông tin sản phẩm
                $product_permalink = $product->is_visible() ? $product->get_permalink( $cart_item ) : '';
                $thumbnail = $product->get_image( array(50, 50) ); // Lấy ảnh sản phẩm
                $quantity = $cart_item['quantity']; // Số lượng sản phẩm
                $line_total = WC()->cart->get_product_subtotal( $product, $quantity ); // Tổng giá trị sản phẩm
                $attributes = []; // Lưu các thuộc tính sản phẩm (size, màu, v.v.)
                if ( $product->is_type( 'variable' ) && $cart_item['variation'] ) {
                    foreach ( $cart_item['variation'] as $attribute => $value ) {
                        $attributes[] = wc_attribute_label( str_replace( 'attribute_', '', $attribute ) ) . ': ' . $value;
                    }
                }
            ?>
            <tr class="cart_item">
                <td class="product-thumbnail">
                    <div class="image-wrapper">
                        <?php echo $thumbnail; // Hiển thị ảnh sản phẩm ?>
                    </div>
                    <div class="quantity-wrapper">
                        <span class="quantity"><?php echo esc_html( $quantity ); ?></span>
                    </div>
                </td>
                <td class="product-name">
                    <div class="product-title">
                        <?php if ( ! $product_permalink ) : ?>
                            <?php echo wp_kses_post( $product->get_name() ); ?>
                        <?php else : ?>
                            <a href="<?php echo esc_url( $product_permalink ); ?>">
                                <?php echo wp_kses_post( $product->get_name() ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $attributes ) ) : ?>
                        <div class="product-attributes">
                            <?php foreach ( $attributes as $attribute ) : ?>
                                <span class="attribute"><?php echo esc_html( $attribute ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </td>
                <td class="product-total">
                    <?php echo $line_total; // Hiển thị tổng giá trị của sản phẩm ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="cart-coupon-wrapper">
 
    </div>

    <div class="cart-info-money">
      <div class="info-money-top">
            <div class="cart-subtotal">
                <div colspan="2">Subtotal</div>
                <div>
                    <?php echo WC()->cart->get_cart_subtotal(); // Hiển thị tổng phụ ?>
                </div>
                </div>
            <div class="cart-shipping">
                <div colspan="2">Shipping fee</div>
                <div>
                    <?php echo WC()->cart->get_shipping_total() > 0 ? wc_price( WC()->cart->get_shipping_total() ) : 'Free shipping'; ?>
                </div>
              </div>
              </div>
              <div class="info-money-bottom">
            <div class="order-total">
                <div colspan="2">Total</div>
                <div>
                    <?php echo WC()->cart->get_total(); // Hiển thị tổng cộng ?>
                </div>
            </div>
         </div>
        </div>
    </div>
  </form>
  <?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Lấy tất cả các radio button
    const radioButtons = document.querySelectorAll('.radio-input input[type="radio"]');

    radioButtons.forEach(radio => {
        // Lắng nghe sự kiện click trên từng radio button
        radio.addEventListener('click', function () {
            // Lấy giá trị của radio được chọn
            const selectedValue = this.value;

            // Ẩn tất cả các thẻ .content-box-row-secondary
            const allSecondaryDivs = document.querySelectorAll('.content-box-row-secondary');
            allSecondaryDivs.forEach(div => div.classList.add('hidden'));

            // Hiển thị thẻ liên quan đến radio được chọn
            const relatedSecondaryDiv = document.querySelector(`.content-box-row-secondary[for="payment_method_id_${selectedValue}"]`);
            if (relatedSecondaryDiv) {
                relatedSecondaryDiv.classList.remove('hidden');
            }
        });
    });
});

</script>
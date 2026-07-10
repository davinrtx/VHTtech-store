<?php
/**
 * External product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/external.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<div class="product-info">
	<div class="product-info-top">
	
		<form class="cart" action="<?php echo esc_url( $product_url ); ?>" method="get">
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<button type="submit" class="button button-primary add_to_cart_button single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $button_text ); ?></button>

			<?php wc_query_string_form_fields( $product_url ); ?>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>
		
		<?php do_action('klb_single_wishlist_compare'); ?>
	</div>
	
	<?php if(machic_shipping_class_name()){ ?>
		<div class="product-info-bottom">
			<div class="info-message"><i class="klbth-icon-delivery-box-3"></i> <strong><?php echo machic_shipping_class_name(); ?></strong></div>
			<div class="info-message"><?php echo machic_shipping_class_name('desc'); ?></div>
		</div>
	<?php } ?>
</div>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

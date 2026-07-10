<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;
$model = get_post_meta( get_the_ID(), 'klb_product_model', true );
$sku = $product->get_sku();

the_title( '<h1 class="product_title entry-title">', '</h1>' ); ?>

<?php if($model || $sku){ ?>
	<div class="product-meta">
		<?php if($model){ ?>
			<div class="product-model">
				<span><?php esc_html_e('Model:','machic'); ?></span>
				<?php echo esc_html($model); ?>
			</div><!-- product-model -->
		<?php } ?>
		<?php if($product->get_sku()){ ?>
			<div class="sku-wrapper">
				<span><?php esc_html_e('SKU:','machic'); ?></span>
				<span class="sku"><?php echo esc_html($product->get_sku()); ?></span>
			</div><!-- sku-wrapper -->
		<?php } ?>
	</div><!-- product-meta -->
<?php } ?>

<?php

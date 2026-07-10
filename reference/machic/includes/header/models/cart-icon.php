<?php $headercart = get_theme_mod('machic_header_cart','0'); ?>
<?php if($headercart == '1'){ ?>
	<?php global $woocommerce; ?>
	<?php $carturl = wc_get_cart_url(); ?>
	<div class="header-addons cart-button">
		<a href="<?php echo esc_url($carturl); ?>">
			<div class="header-addons-icon">
				<i class="klbth-icon-simple-cart"></i>
				<div class="button-count cart-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'machic'), $woocommerce->cart->cart_contents_count);?></div>
			</div><!-- header-addons-icon -->
			<div class="header-addons-text hide-mobile">
				<div class="sub-text"><?php esc_html_e('Total','machic'); ?></div>
				<div class="primary-text cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
			</div><!-- header-addons-text -->
		</a>
		<div class="cart-dropdown hide">
			<div class="cart-dropdown-wrapper">
				<div class="fl-mini-cart-content">
					<?php woocommerce_mini_cart(); ?>
				</div>
				
				<?php if(get_theme_mod('machic_header_mini_cart_notice')){ ?>
					<div class="cart-noticy">
						<?php echo esc_html(get_theme_mod('machic_header_mini_cart_notice')); ?>
					</div><!-- cart-noticy -->
				<?php } ?>
			</div><!-- cart-dropdown-wrapper -->
		</div><!-- cart-dropdown -->
	</div><!-- header-addons -->

<?php } ?>
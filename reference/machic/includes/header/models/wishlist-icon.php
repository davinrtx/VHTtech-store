<?php $wishlistheader = get_theme_mod('machic_header_wishlist',0); ?>
<?php if($wishlistheader == 1){ ?>

	<?php if ( function_exists( 'tinv_url_wishlist_default' ) ) { ?>
		<div class="header-addons wishlist-button">
				<div class="header-addons-icon">
					<a href="<?php echo tinv_url_wishlist_default(); ?>"><i class="klbth-icon-heart"></i></a>
					<div class="button-count"><?php echo do_shortcode('[ti_wishlist_products_counter]'); ?></div>
				</div><!-- header-addons-icon -->
		</div><!-- header-addons -->
	<?php } elseif( class_exists( 'KlbWishlist' )) { ?>
		<div class="header-addons wishlist-button">
			<a href="<?php echo KlbWishlist::get_url(); ?>">
				<div class="header-addons-icon">
					<i class="klbth-icon-heart"></i>
					<div class="button-count klbwl-wishlist-count"><?php echo KlbWishlist::get_count(); ?></div>
				</div><!-- header-addons-icon -->
			</a>
		</div><!-- header-addons -->
	<?php } ?>

<?php } ?>
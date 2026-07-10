<?php if(get_theme_mod('machic_shop_top_banner_title') || get_theme_mod('machic_shop_top_banner_subtitle')){ ?>
	<div class="row mt-20 d-mt-20 shop-banner-top">
		<div class="col">

			<div class="site-module module-banner-text">
				<div class="banner-wrapper" style="background-color: #f5f5f7;">
					<div class="banner-inner">
						<h4 class="entry-title"><?php echo machic_sanitize_data(get_theme_mod('machic_shop_top_banner_title')); ?></h4>
						<div class="banner-details">
							<div class="banner-price">
								<?php echo machic_sanitize_data(get_theme_mod('machic_shop_top_banner_subtitle')); ?>
							</div><!-- banner-price -->
							<p><?php echo machic_sanitize_data(get_theme_mod('machic_shop_top_banner_desc')); ?></p>
						</div><!-- banner-details -->
						<?php if(get_theme_mod('machic_shop_top_banner_button_text')){ ?>
							<div class="banner-button">
								<a href="<?php echo esc_url(get_theme_mod('machic_shop_top_banner_button_url')); ?>" class="btn small rounded link-color"><?php echo esc_html(get_theme_mod('machic_shop_top_banner_button_text')); ?></a>
							</div>
						<?php } ?>
					</div><!-- banner-inner -->
				</div>
			</div><!-- site-module -->

		</div><!-- col -->
	</div><!-- row -->
<?php } ?>

<?php $shop_banner = get_theme_mod('machic_shop_banner_module'); ?>
<?php if($shop_banner){ ?>
	<div class="row mt-0 d-mt-20 shop-banner-bottom">
	
		<?php foreach($shop_banner as $s){ ?>
			<div class="col col-12 col-lg-4 mt-10 d-mt-0">
				<div class="site-module banner-module">
					<div class="module-wrapper">
						<div class="banner dark align-center price-banner">
							<div class="banner-content">
								<div class="banner-content-wrapper">
									<div class="entry-description">
										<p><?php echo esc_html($s['banner_title']); ?></p>
									</div><!-- entry-description -->
									<h3 class="entry-title"><?php echo esc_html($s['banner_subtitle']); ?></h3>
									<div class="banner-price-content">
										<p><?php echo esc_html($s['banner_desc']); ?></p>
										<span class="price">
											<del aria-hidden="true">
												<span class="woocommerce-Price-amount amount"><bdi><?php echo esc_html($s['banner_regular_price']); ?></bdi></span>
											</del>
											<ins>
												<span class="woocommerce-Price-amount amount"><bdi><?php echo esc_html($s['banner_sale_price']); ?></bdi></span>
											</ins>
										</span><!-- price -->
									</div><!-- banner-price-content -->
								</div><!-- banner-content-wrapper -->
							</div><!-- banner-content -->
							<div class="banner-image"><img src="<?php echo esc_url(machic_get_image($s['banner_image'])); ?>" alt="<?php echo esc_attr($s['banner_title']); ?>"></div>
							<a href="<?php echo esc_url($s['banner_url']); ?>" class="overlay-link"></a>
						</div><!-- banner -->
					</div><!-- module-wrapper -->
				</div><!-- site-module -->
			</div><!-- col -->
		<?php } ?>
	
	</div>
<?php } ?>
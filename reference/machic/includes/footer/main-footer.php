<?php
if ( ! function_exists( 'machic_main_footer_function' ) ) {
	function machic_main_footer_function(){
		
	?>
		<footer class="site-footer">
			<?php $subscribe = get_theme_mod('machic_footer_subscribe_area',0); ?>
			<?php if($subscribe == 1){ ?>
				<div class="footer-row footer-newsletter dark">
					<div class="container">
						<div class="row">
							<div class="col">
								<div class="site-newsletter">
									<div class="site-newsletter-text">
										<h3 class="entry-title"><?php echo machic_sanitize_data(get_theme_mod('machic_footer_subscribe_title')); ?></h3>
										<div class="entry-description">
											<p><?php echo machic_sanitize_data(get_theme_mod('machic_footer_subscribe_subtitle')); ?></p>
										</div><!-- entry-description -->
									</div><!-- site-newsletter-text -->
									<div class="site-newsletter-form">
										<div class="subscribe-form">
											<?php echo do_shortcode('[mc4wp_form id="'.get_theme_mod('machic_footer_subscribe_formid').'"]'); ?>
										</div>
									</div><!-- site-newsletter-form -->
								</div><!-- site-newsletter -->
							</div><!-- col -->
						</div><!-- row -->
					</div><!-- container -->
				</div><!-- footer-row -->
			<?php } ?>
			
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-4' )) { ?>
				<div class="footer-row footer-widgets">
					<div class="container">
						<div class="row">
							<?php if(get_theme_mod('machic_footer_column') == '3columns'){ ?>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div><!-- col -->
							<?php } elseif(get_theme_mod('machic_footer_column') == '4columns'){ ?>
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div><!-- col -->
							<?php } else { ?>
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div><!-- col -->
								<div class="col col-12 col-lg-3 col-five">
									<?php dynamic_sidebar( 'footer-5' ); ?>
								</div><!-- col -->
							<?php } ?>
						</div><!-- row -->
					</div><!-- container -->
				</div><!-- footer-row -->
			<?php } ?>
			
			<div class="footer-row footer-details">
				<div class="container">
					<div class="row">
						<div class="col">
	
							<div class="site-details">
								<div class="site-brand">
									<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
										<?php if (get_theme_mod( 'machic_footer_logo' )) { ?>
											<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'machic_footer_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
										<?php } elseif (get_theme_mod( 'machic_logo' )) { ?>
											<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'machic_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
										<?php } elseif (get_theme_mod( 'machic_logo_text' )) { ?>
											<span class="brand-text"><?php echo esc_html(get_theme_mod( 'machic_logo_text' )); ?></span>
										<?php } else { ?>
											<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-dark.png" width="171" height="34" alt="<?php bloginfo("name"); ?>">
										<?php } ?>
									</a>
								</div>
	
								<?php $footersocial = get_theme_mod('machic_footer_social_list'); ?>
								<?php if(!empty($footersocial)){ ?>
									<div class="site-social">
										<ul>
											<?php foreach($footersocial as $f){ ?>
												<li><a href="<?php echo esc_url($f['social_url']); ?>" target="_blank"><i class="klbth-icon-<?php echo esc_attr($f['social_icon']); ?>"></i></a></li>
											<?php } ?>
										</ul>
									</div>
								<?php } ?>
	
							</div><!-- site-details -->
	
	
							<?php $footertags = get_theme_mod('machic_footer_tags_toggle',0); ?>
							<?php if($footertags == 1){ ?>
								<?php $product_tag = get_terms( 'product_tag' ); ?>
								<?php if ($product_tag){ ?>
									<div class="site-details">
										<ul class="tags">
										<?php  foreach($product_tag as $t){ ?>
											<li><a href="<?php echo esc_url(get_term_link( $t )); ?>"><?php echo esc_html($t->name); ?> </a></li>
										<?php } ?>
										</ul>
									</div><!-- site-details -->
								<?php } ?>
							<?php } ?>
	
						</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->
			</div><!-- footer-row -->
	
			<div class="footer-row footer-copyright bordered">
				<div class="container">
					<div class="row">
						<div class="col">
	
							<div class="footer-bottom">
								<div class="site-copyright">
									<?php if(get_theme_mod( 'machic_copyright' )){ ?>
										<p><?php echo machic_sanitize_data(str_replace( '[year]', date('Y'), get_theme_mod( 'machic_copyright' ) )); ?></p>
									<?php } else { ?>
										<p><?php esc_html_e('Copyright 2025.KlbTheme . All rights reserved','machic'); ?></p>
									<?php } ?>
								</div>
								<?php if(get_theme_mod('machic_footer_payment_image')){ ?>
									<div class="site-payment-logos">
										<a href="<?php echo esc_url(get_theme_mod('machic_footer_payment_image_url')); ?>">
											<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod('machic_footer_payment_image'))); ?>" alt="<?php esc_attr_e('payment','machic'); ?>">
										</a>
									</div>
								<?php } ?>
							</div><!-- footer-bottom -->
	
						</div><!-- col -->
					</div><!-- row -->
				</div><!-- container -->
			</div><!-- footer-row -->
	
		</footer><!-- site-footer -->
	<?php }
}

add_action('machic_main_footer','machic_main_footer_function', 10);
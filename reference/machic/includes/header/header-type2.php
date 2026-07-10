<header id="masthead" class="site-header border-enable header-type2 klb-type2">
	<div class="header-desktop hide-mobile">

		<div class="header-top dark border-disable">
			<div class="container">
				<div class="header-wrapper">

					<div class="column align-center left">
						<nav class="site-menu horizontal">
							<?php 
								wp_nav_menu(array(
								'theme_location' => 'top-left-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => '',
								'depth' => 0 
								));
							?>
						</nav>
					</div><!-- column -->

					<div class="column align-center right">
						<nav class="site-menu horizontal">
							<?php 
								wp_nav_menu(array(
								'theme_location' => 'top-right-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => '',
								'depth' => 0 
								));
							?>
						</nav>

					</div><!-- column -->

				</div><!-- header-wrapper -->
			</div><!-- container -->
		</div><!-- header-top -->

		<div class="header-main height-size">
			<div class="container">
				<div class="header-wrapper">
					
					<div class="column align-center left">
						<div class="site-brand">
							<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
								<?php if (get_theme_mod( 'machic_logo' )) { ?>
									<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'machic_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
								<?php } elseif (get_theme_mod( 'machic_logo_text' )) { ?>
									<span class="brand-text"><?php echo esc_html(get_theme_mod( 'machic_logo_text' )); ?></span>
								<?php } else { ?>
									<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-dark.png" width="171" height="34" alt="<?php bloginfo("name"); ?>">
								<?php } ?>
							</a>
						</div><!-- site-brand -->

						<nav class="site-menu horizontal primary shadow-enable">
							<?php 
								wp_nav_menu(array(
								'theme_location' => 'main-menu',
								'container' => '',
								'fallback_cb' => 'show_top_menu',
								'menu_id' => '',
								'menu_class' => 'menu',
								'echo' => true,
								"walker" => new machic_main_walker(),
								'depth' => 0 
								));
							?>
						</nav><!-- site-menu -->
					</div><!-- column -->

					<div class="column align-center right">

						<?php get_template_part( 'includes/header/models/account-icon' ); ?>
												
						<?php get_template_part( 'includes/header/models/wishlist-icon' ); ?>
						
						<?php get_template_part( 'includes/header/models/cart-icon' ); ?>

					</div><!-- column -->

				</div><!-- header-wrapper -->
			</div><!-- container -->
		</div><!-- header-main -->

		<?php $sidebarmenu = get_theme_mod('machic_header_sidebar','0'); ?>
		<?php $headersearch = get_theme_mod('machic_header_search','0'); ?>
		
		<?php if($sidebarmenu == '1' || $headersearch == '1'){ ?>
			<div class="header-search-column">
				<div class="container">
					<div class="header-wrapper">

						<div class="column align-center left">
							<?php get_template_part( 'includes/header/models/sidebar-menu2' ); ?>

						</div><!-- column -->
						<div class="column align-center right">
							<?php get_template_part( 'includes/header/models/search' ); ?>
						</div><!-- column -->

					</div><!-- header-wrapper -->
				</div><!-- container -->
			</div><!-- header-search-column -->
		<?php } ?>

	</div><!-- header-desktop -->

	<div class="header-mobile-switcher hide-desktop">
		<div class="header-wrapper">
			<div class="column left">
				<div class="site-switcher site-currency">
					<nav class="site-menu horizontal">
						<?php 
							wp_nav_menu(array(
							'theme_location' => 'top-right-menu',
							'container' => '',
							'fallback_cb' => 'show_top_menu',
							'menu_id' => '',
							'menu_class' => 'menu',
							'echo' => true,
							"walker" => '',
							'depth' => 0 
							));
						?>
					</nav>
				</div><!-- site-currency -->
			</div><!-- column -->
		</div><!-- header-wrapper -->
	</div><!-- header-mobile-switcher -->

	<div class="header-mobile hide-desktop">
		<div class="header-wrapper">
			<div class="column left">
				<div class="header-addons menu-toggle">
					<a href="#">
						<div class="header-addons-icon">
							<i class="klbth-icon-menu"></i>
						</div><!-- header-addons-icon -->
					</a>
				</div><!-- menu-toggle -->
			</div><!-- column -->
			<div class="column center">
				<div class="site-brand">
					<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
						<?php if (get_theme_mod( 'machic_logo' )) { ?>
							<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'machic_logo' )) ); ?>" alt="<?php bloginfo("name"); ?>">
						<?php } elseif (get_theme_mod( 'machic_logo_text' )) { ?>
							<span class="brand-text"><?php echo esc_html(get_theme_mod( 'machic_logo_text' )); ?></span>
						<?php } else { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-dark.png" alt="<?php bloginfo("name"); ?>" width="135">
						<?php } ?>
					</a>
				</div><!-- site-brand -->
			</div><!-- column -->
			<div class="column right">
				<?php get_template_part( 'includes/header/models/cart-icon' ); ?>
			</div><!-- column -->
		</div><!-- header-wrapper -->
		
		<?php if(get_theme_mod('machic_mobile_header_search','0') == 1){ ?>
			<div class="mobile-search-column">
				<?php get_template_part( 'includes/header/models/search' ); ?>
			</div>
		<?php } ?>
	</div><!-- header-mobile -->
</header><!-- site-header -->
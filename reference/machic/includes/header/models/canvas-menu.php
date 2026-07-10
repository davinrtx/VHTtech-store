<aside class="site-offcanvas">
	<div class="site-scroll">
		<div class="site-offcanvas-row site-offcanvas-header">
			<div class="column left">
				<div class="site-brand">
					<a href="<?php echo esc_url( home_url( "/" ) ); ?>" title="<?php bloginfo("name"); ?>">
						<?php if (get_theme_mod( 'machic_logo_white' )) { ?>
							<img src="<?php echo esc_url( wp_get_attachment_url(get_theme_mod( 'machic_logo_white' )) ); ?>" alt="<?php bloginfo("name"); ?>">
						<?php } elseif (get_theme_mod( 'machic_logo_text' )) { ?>
							<span class="brand-text"><?php echo esc_html(get_theme_mod( 'machic_logo_text' )); ?></span>
						<?php } else { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-light.png" alt="<?php bloginfo("name"); ?>">
						<?php } ?>					
					</a>
				</div><!-- site-brand -->
			</div><!-- column -->
			<div class="column right">
				<div class="site-offcanvas-close">
					<i class="klbth-icon-cancel"></i>
				</div><!-- site-offcanvas-close -->
			</div><!-- column -->
		</div><!-- site-offcanvas-header -->
		<div class="site-offcanvas-row site-offcanvas-body">
			
			<div class="offcanvas-menu-container">
				<div class="offcanvas-menu-wrapper">

					<?php $sidebarmenu = get_theme_mod('machic_header_sidebar','0'); ?>
					<?php if($sidebarmenu == '1'){ ?>
						<nav class="site-menu vertical categories">
							<a href="#" class="all-categories">
								<div class="departments-icon"><i class="klbth-icon-menu"></i></div>
								<div class="departments-text"><?php esc_html_e('All Departments','machic'); ?></div>
								<div class="departments-arrow"><i class="klbth-icon-nav-arrow-down"></i></div>
							</a>

							<?php 
							wp_nav_menu(array(
							'theme_location' => 'sidebar-menu',
							'container' => '',
							'fallback_cb' => 'show_top_menu',
							'menu_id' => '',
							'menu_class' => 'menu departments-menu collapse show',
							'echo' => true,
							"walker" => '',
							'depth' => 0 
							));
							?>
						</nav>
					<?php } ?>

					<nav class="site-menu vertical primary">
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
					</nav>

					<nav class="site-menu vertical thirdy">
						<?php 
							 wp_nav_menu(array(
							 'theme_location' => 'canvas-bottom',
							 'container' => '',
							 'fallback_cb' => 'show_top_menu',
							 'menu_id' => '',
							 'menu_class' => 'menu',
							 'echo' => true,
							 'depth' => 0 
							)); 
						?>
					</nav>

					<div class="site-copyright">
						<?php if(get_theme_mod( 'machic_copyright' )){ ?>
							<p><?php echo machic_sanitize_data(get_theme_mod( 'machic_copyright' )); ?></p>
						<?php } else { ?>
							<p><?php esc_html_e('Copyright 2021.KlbTheme . All rights reserved','machic'); ?></p>
						<?php } ?>
					</div><!-- site-copyright -->

				</div><!-- offcanvas-menu-wrapper -->

			</div><!-- offcanvas-menu-container -->

		</div><!-- site-offcanvas-body -->
	</div><!-- site-scroll -->
</aside><!-- site-offcanvas -->


<?php $sidebarmenu = get_theme_mod('machic_header_sidebar','0'); ?>

<?php if($sidebarmenu == '1'){ ?>

<div class="site-departments large">
	<div class="site-departments-wrapper">
		<a href="#" class="all-categories">
			<div class="header-addons-icon">
				<i class="klbth-icon-menu"></i>
			</div><!-- header-addons-icon -->
			<div class="button-detail">
				<div class="button-title"><?php esc_html_e('All Departments for you','machic'); ?> </div>
				<?php $total_products = wp_count_posts( 'product' ); ?>
				<?php $total_count = $total_products->publish; ?>
				<?php $total_format = esc_html__('Total %s Products','machic'); ?>
				<span><?php echo sprintf($total_format, $total_count); ?></span>
			</div><!-- button-detail -->
		</a>
		
		<?php $menu_collapse = is_front_page() && !get_theme_mod('machic_header_sidebar_collapse') ? 'collapse show' : 'collapse'; ?>
		
		<?php 
		wp_nav_menu(array(
		'theme_location' => 'sidebar-menu',
		'container' => '',
		'fallback_cb' => 'show_top_menu',
		'menu_id' => '',
		'menu_class' => 'departments-menu '.$menu_collapse,
		'echo' => true,
		"walker" => new machic_sidebar_walker(),
		'depth' => 0 
		));
		?>
	</div><!-- site-departments-wrapper -->
</div>

<?php } ?>
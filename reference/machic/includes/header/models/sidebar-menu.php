<?php $sidebarmenu = get_theme_mod('machic_header_sidebar','0'); ?>

<?php if($sidebarmenu == '1'){ ?>

<div class="site-departments large">
	<div class="site-departments-wrapper">
		<a href="#" class="all-categories">
			<div class="departments-icon"><i class="klbth-icon-menu"></i></div>
			<div class="departments-text"><?php esc_html_e('All Departments','machic'); ?></div>
			<div class="departments-arrow"><i class="klbth-icon-nav-arrow-down"></i></div>
		</a>
		
		<?php if(machic_page_settings('enable_sidebar_collapse') == 'yes'){ ?>
			<?php $menu_collapse = 'collapse show'; ?>
		<?php } else { ?>
			<?php $menu_collapse = is_front_page() && !get_theme_mod('machic_header_sidebar_collapse') ? 'collapse show' : 'collapse'; ?>
		<?php } ?>
		
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
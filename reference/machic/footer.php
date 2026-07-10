<?php
/**
 * footer.php
 * @package WordPress
 * @subpackage Machic
 * @since Machic 1.0
 * 
 */
 ?>
		</div><!-- site-content -->
	</main><!-- site-primary -->

	<?php machic_do_action( 'machic_before_main_footer'); ?>

	<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
		<?php
        /**
        * Hook: machic_main_footer
        *
        * @hooked machic_main_footer_function - 10
        */
        do_action( 'machic_main_footer' );
	
		?>
	<?php } ?>

	<?php machic_do_action( 'machic_after_main_footer'); ?>

	<div class="site-overlay"></div>

	<?php wp_footer(); ?>
	</body>
</html>
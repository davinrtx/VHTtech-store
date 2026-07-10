<?php $discount_products = get_theme_mod('machic_header_products_tab','0'); ?>

<?php if($discount_products == '1'){ ?>

<div class="column align-center right">
	<div class="discount-products">
		<div class="discount-products-wrapper">
			<div class="discount-banner">
				<div class="discount-banner-icon"><i class="klbth-icon-discount-black"></i></div>
				<div class="discount-banner-text">
					<div class="small-text"><?php echo esc_html(get_theme_mod('machic_header_products_button_subtitle')); ?></div>
					<div class="main-text"><?php echo esc_html(get_theme_mod('machic_header_products_button_title')); ?></div>
				</div><!-- discount-banner-text -->
				<div class="discount-banner-arrow"><i class="klbth-icon-nav-arrow-down"></i></div>
			</div><!-- discount-banner -->
			<div class="discount-items">
				<div class="discount-products-header">
					<h4 class="entry-title"><?php echo esc_html(get_theme_mod('machic_header_products_tab_title')); ?></h4>
					<p><?php echo esc_html(get_theme_mod('machic_header_products_tab_subtitle')); ?></p>
				</div><!-- discount-products-header -->
				<?php

					$args = array(
						'post_type' => 'product',
						'posts_per_page' => get_theme_mod('machic_header_products_tab_post_count','6'),
						'order'          => 'DESC',
						'post_status'    => 'publish',
					);

					$args['klb_special_query'] = true;

					if(get_theme_mod('machic_header_products_tab_best_selling') == '1'){
						$args['meta_key'] = 'total_sales';
						$args['orderby'] = 'meta_value_num';
					}

					if(get_theme_mod('machic_header_products_tab_featured') == '1'){
						$args['tax_query'] = array( array(
							'taxonomy' => 'product_visibility',
							'field'    => 'name',
							'terms'    => array( 'featured' ),
								'operator' => 'IN',
						) );
					}
					
					if(get_theme_mod('machic_header_products_tab_on_sale') == '1'){
						$args['meta_key'] = '_sale_price';
						$args['meta_value'] = array('');
						$args['meta_compare'] = 'NOT IN';
					}

					$loop = new \WP_Query( $args );
				?>
				
				
				<div class="products column-6">
					<?php 					
						if ( $loop->have_posts() ) {
							while ( $loop->have_posts() ) : $loop->the_post();
								global $product;
								global $post;
								global $woocommerce;
					?>
						
						<div class="product">
							<?php echo machic_product_type_header(); ?>
						</div>
					
					<?php 
							endwhile;
						}
						wp_reset_postdata();
					?>
				</div>
			</div><!-- discount-items -->
		</div><!-- discount-products-wrapper -->
	</div><!-- discount-products -->
</div><!-- column -->


<?php } ?>
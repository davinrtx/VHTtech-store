<article id="post-<?php the_ID(); ?>" <?php post_class('klb-article post'); ?>>
	<div class="entry-post-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<div class="entry-footer">
			<div class="entry-meta">
				<span class="meta-item entry-published"><a href="<?php the_permalink(); ?>"><i class="klbth-icon-clock-outline"></i> <?php echo get_the_date(); ?></a></span>
			
				<?php if(has_category()){ ?>
				  <span class="meta-item category"><i class="klbth-icon-bookmark-empty"></i> <?php the_category(', '); ?></span>
				<?php } ?>

				<?php the_tags( '<span class="meta-item entry-tags"><i class="klbth-icon-cinema"></i>', ', ', ' </span>'); ?>

				<?php if ( is_sticky()) {
					printf( '<span class="meta-item sticky-post"><i class="klbth-icon-star-empty"></i> %s</span>', esc_html__('Featured', 'machic' ) );
				} ?>

			</div><!-- entry-meta -->
		</div><!-- entry-footer -->
	</div><!-- entry-post-header -->
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { ?>
		<?php  
		$att=get_post_thumbnail_id();
		$image_src = wp_get_attachment_image_src( $att, 'full' );
		$image_src = $image_src[0]; 
		?>
			
		<figure class="entry-media">
			<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_src); ?>" alt="<?php the_title_attribute(); ?>"></a>
		</figure>
	<?php } ?>
	<div class="entry-content">
		<div class="klb-post">
			<?php the_excerpt(); ?>
			<?php wp_link_pages(array('before' => '<div class="klb-pagination">' . esc_html__( 'Pages:', 'machic' ),'after'  => '</div>', 'next_or_number' => 'number')); ?>
		</div>
	</div><!-- entry-content -->
</article><!-- post -->
<?php

/*************************************************
## machic Metabox
*************************************************/

if ( ! function_exists( 'rwmb_meta' ) ) {
  function rwmb_meta( $key, $args = '', $post_id = null ) {
   return false;
  }
 }

add_filter( 'rwmb_meta_boxes', 'machic_register_page_meta_boxes' );

function machic_register_page_meta_boxes( $meta_boxes ) {
	
$prefix = 'klb_';
$meta_boxes = array();


/* ----------------------------------------------------- */
// Product Data
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id' => 'klb_product_settings',
	'title' => esc_html__('Product Data','machic'),
	'pages' => array( 'product' ),
	'context' => 'side',
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		
		array(
			'name'		=> esc_html__('Badge Type','machic'),
			'id'		=> $prefix . 'product_badge_type',
			'type'		=> 'select',
			'options'	=> array(
				'type1'		=> esc_html__('Type 1','machic'),
				'type2'		=> esc_html__('Type 2','machic'),
			),
			'multiple'	=> false,
			'std'		=> array( 'no' ),
			'sanitize_callback' => 'none'
		),
		
		array(
			'name'		=> esc_html__('Badge if on sale','machic'),
			'id'		=> $prefix . 'product_badge',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
		
		array(
			'name'		=> esc_html__('Model','machic'),
			'id'		=> $prefix . 'product_model',
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
				
	)
);

/* ----------------------------------------------------- */
// Product Specification Tab
/* ----------------------------------------------------- */

$meta_boxes[] = [
	'id'      => 'klb_product_extra_tab',
	'title'   => esc_html__( 'Product Specifications', 'machic' ),
	'pages' => array( 'product' ),
	'context' => 'normal',
	'priority' => 'low',
	'fields'  => [
		[
			'type'    => 'wysiwyg',
			'id'      => $prefix . 'product_specification',
		],
	],
];

/* ----------------------------------------------------- */
// Blog Post Slides Metabox
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-gallery',
	'title'		=> esc_html__('Blog Post Image Slides','machic'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'	=> esc_html__('Blog Post Slider Images','machic'),
			'desc'	=> esc_html__('Upload unlimited images for a slideshow - or only one to display a single image.','machic'),
			'id'	=> $prefix . 'blogitemslides',
			'type'	=> 'image_advanced',
		)
		
	)
);

/* ----------------------------------------------------- */
// Blog Audio Post Settings
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id' => 'klb-blogmeta-audio',
	'title' => esc_html('Audio Settings','machic'),
	'pages' => array( 'post'),
	'context' => 'normal',

	// List of meta fields
	'fields' => array(	
		array(
			'name'		=> esc_html('Audio Code','machic'),
			'id'		=> $prefix . 'blogaudiourl',
			'desc'		=> esc_html__('Enter your Audio URL(Oembed) or Embed Code.','machic'),
			'clone'		=> false,
			'type'		=> 'textarea',
			'std'		=> '',
			'sanitize_callback' => 'none'
		),
	)
);



/* ----------------------------------------------------- */
// Blog Video Metabox
/* ----------------------------------------------------- */
$meta_boxes[] = array(
	'id'		=> 'klb-blogmeta-video',
	'title'		=> esc_html__('Blog Video Settings','machic'),
	'pages'		=> array( 'post' ),
	'context' => 'normal',

	'fields'	=> array(
		array(
			'name'		=> esc_html__('Video Type','machic'),
			'id'		=> $prefix . 'blog_video_type',
			'type'		=> 'select',
			'options'	=> array(
				'youtube'		=> esc_html__('Youtube','machic'),
				'vimeo'			=> esc_html__('Vimeo','machic'),
				'own'			=> esc_html__('Own Embed Code','machic'),
			),
			'multiple'	=> false,
			'std'		=> array( 'no' ),
			'sanitize_callback' => 'none'
		),
		array(
			'name'	=> machic_sanitize_data(__('Embed Code<br />(Audio Embed Code is possible, too)','machic')),
			'id'	=> $prefix . 'blog_video_embed',
			'desc'	=> machic_sanitize_data(__('Just paste the ID of the video (E.g. http://www.youtube.com/watch?v=<strong>GUEZCxBcM78</strong>) you want to show, or insert own Embed Code. <br />This will show the Video <strong>INSTEAD</strong> of the Image Slider.<br /><strong>Of course you can also insert your Audio Embedd Code!</strong>','machic')),
			'type' 	=> 'textarea',
			'std' 	=> "",
			'cols' 	=> "40",
			'rows' 	=> "8"
		)
	)
);

return $meta_boxes;
}

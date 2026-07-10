<?php

/*************************************************
## Machic Menu Custom Fields
*************************************************/

function machic_custom_fields( $item_id, $item ) {
	$theme_locations = get_nav_menu_locations();
	$menuid = absint( get_user_option( 'nav_menu_recently_edited' ) );

	if(isset($theme_locations['sidebar-menu'])){
		$menu_obj = get_term( $theme_locations['sidebar-menu'], 'nav_menu' );
	} else {
		return;
	}

	if($menu_obj->term_id != $menuid){
		return;
	}


    $menu_item_megamenu = get_post_meta( $item_id, '_menu_item_megamenu', true );
    $menu_item_megamenu_columns = get_post_meta( $item_id, '_menu_item_megamenu_columns', true );
    $menu_item_menushortcode = get_post_meta( $item_id, '_menu_item_menushortcode', true );
    $menu_item_menuhidetitle = get_post_meta( $item_id, '_menu_item_menuhidetitle', true );
    $menu_item_menulabel = get_post_meta( $item_id, '_menu_item_menulabel', true );
    $menu_item_menulabelcolor = get_post_meta( $item_id, '_menu_item_menulabelcolor', true );
    $menu_item_menuimage = get_post_meta( $item_id, '_menu_item_menuimage', true );

    ?>
    <div class="et_menu_options">
        <div class="machic-field-link-mega-columns description description-thin">
            <label for="menu_item_megamenu-columns-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e( 'Main menu columns', 'machic'  ); ?><br />
                <select class="widefat code edit-menu-item-custom" id="menu_item_megamenu_columns-<?php echo esc_attr($item_id); ?>" name="menu_item_megamenu_columns[<?php echo esc_attr($item_id); ?>]">
                    <?php $value = $menu_item_megamenu_columns;
                    if (!$value) {
                        $value = 5;
                    }
                    for ($i = 1; $i <= 2; $i++) { ?>
                        <option value="<?php echo esc_attr( $i ) ?>" <?php echo htmlspecialchars( $value == $i ) ? "selected='selected'" : ''; ?>><?php echo esc_attr( $i ) ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>


        <div class="machic-field-link-image description description-wide">

            <?php wp_enqueue_media(); ?>

            <label for="menu_item_menuimage-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e( 'Menu Image', 'machic'  ); ?>
            </label>

            <div class='image-preview-wrapper'>
                <?php $image_attributes = wp_get_attachment_image_src( $menu_item_menuimage, 'thumbnail' );
                if ($image_attributes != '' ) { ?>
                    <img id='image-preview-<?php echo esc_attr($item_id); ?>' class="image-preview" src="<?php echo esc_attr( $image_attributes[0]); ?>" />
                <?php } ?>
            </div>
            <input id="remove_image_button-<?php echo esc_attr($item_id); ?>"
            type="button" class="remove_image_button button"
            value="<?php esc_attr_e( 'Remove', 'machic' ); ?>" />
            <input id="upload_image_button-<?php echo esc_attr($item_id); ?>" type="button" class="upload_image_button button" value="<?php esc_attr_e( 'Select image', 'machic' ); ?>" />

            <input type="hidden" class="widefat code edit-menu-item-custom image_attachment_id" id="menu_item_menuimage-<?php echo esc_attr($item_id); ?>" name="menu_item_menuimage[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $menu_item_menuimage ); ?>"/>

        </div>

    </div>

    <?php

}
add_action( 'wp_nav_menu_item_custom_fields', 'machic_custom_fields', 10, 2 );

/*************************************************
## Machic Save menu item meta
*************************************************/
function machic_nav_update( $menu_id, $menu_item_db_id ) {

    if (!empty($_REQUEST['menu_item_megamenu_columns'])) {
        $menumega_columns_enabled_value = $_REQUEST['menu_item_megamenu_columns'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_megamenu_columns', $menumega_columns_enabled_value );
    }

    if (!empty($_REQUEST['menu_item_menuimage'])) {
        $menuimage_enabled_value = $_REQUEST['menu_item_menuimage'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_menuimage', $menuimage_enabled_value );
    }
}

add_action( 'wp_update_nav_menu_item', 'machic_nav_update', 10, 2 );
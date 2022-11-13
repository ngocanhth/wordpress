<?php

function olive_one_click_demo_import_update_global_styles( $new_settings, $new_styles ) {
	// Get the user's global styles CPT id
	$user_custom_post_type_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
	$global_styles_controller = new WP_REST_Global_Styles_Controller();

	$update_request = new WP_REST_Request( 'PUT', '/wp/v2/global-styles/' );
	$update_request->set_param( 'id', $user_custom_post_type_id );
	$update_request->set_param( 'settings', $new_settings );
	$update_request->set_param( 'styles', $new_styles );

	$res = $global_styles_controller->update_item( $update_request );

	// Ideally the call to update_item would delete all of the appropriate transients and caches
	delete_transient( 'global_styles' );
	delete_transient( 'global_styles_' . get_stylesheet() );
	delete_transient( 'gutenberg_global_styles' );
	delete_transient( 'gutenberg_global_styles_' . get_stylesheet() );

	if ( class_exists( 'WP_Theme_JSON_Resolver_Gutenberg' ) ) {
		WP_Theme_JSON_Resolver_Gutenberg::clean_cached_data();
	}
}

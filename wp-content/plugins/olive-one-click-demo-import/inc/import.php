<?php
/**
 * Save import file.
 *
 * @return void
 */
function olive_one_click_demo_import_save_file() {
	if ( empty( $_GET['page'] ) || 'olive-one-click-demo-import' !== $_GET['page'] || empty( $_GET['import'] ) || 'true' !== $_GET['import'] || empty( $_FILES ) ) {
		return false;
	}

	$nonce = $_REQUEST['_wpnonce'];
	if ( ! wp_verify_nonce( $nonce, 'olive-ocdi-nonce' ) ) {
		wp_die( esc_attr( __( 'Invalid action', 'olive-one-click-demo-import' ) ) );
	}

	$continue                = false;
	$import_content_size     = absint( $_FILES['import_content']['size'] );
	$import_content_name     = absint( $_FILES['import_content']['name'] );
	$import_content_tmp_name = sanitize_text_field( $_FILES['import_content']['tmp_name'] );
	$import_content_error    = absint( $_FILES['import_content']['error'] );

	$import_setting_json_size     = absint( $_FILES['import_setting_json']['size'] );
	$import_setting_json_name     = absint( $_FILES['import_setting_json']['name'] );
	$import_setting_json_tmp_name = sanitize_text_field( $_FILES['import_setting_json']['tmp_name'] );
	$import_setting_json_error    = absint( $_FILES['import_setting_json']['error'] );

	$continue = ( 0 === $import_content_error && $import_content_size > 0 ) || ( 0 === $import_setting_json_error && $$import_setting_json_size > 0 );
	if ( ! $continue ) {
		return false;
	}

	$upload_dir = wp_upload_dir();

	if ( empty( $upload_dir['basedir'] ) ) {
		return false;
	}

	$user_dirname = $upload_dir['basedir'] . '/olive-demo-data';
	if ( ! file_exists( $user_dirname ) ) {
		wp_mkdir_p( $user_dirname );
	}

	$redirect_url = admin_url( '/themes.php?page=olive-one-click-demo-import&importing=true' );

	$data = array();
	if ( ! empty( $import_content_tmp_name ) ) {
		$filename = wp_unique_filename( $user_dirname, $import_content_name );
		$path     = $user_dirname . '/' . $filename;
		move_uploaded_file( $import_content_tmp_name, $path );
		$data['content_file'] = $path;
	}

	if ( ! empty( $import_setting_json ) ) {
		$filename = wp_unique_filename( $user_dirname, $import_setting_json_name );
		$path     = $user_dirname . '/' . $filename;
		move_uploaded_file( $import_setting_json, $path );
		$data['setting_style_file'] = $path;
	}

	$name_transient = 'olive-one-click-demo-import-' . current_time( 'timestamp' );
	$redirect_url   = add_query_arg( 'import_id', $name_transient, $redirect_url );

	set_transient( $name_transient, $data, DAY_IN_SECONDS );

	wp_redirect( $redirect_url );

	die();
}
add_action( 'admin_init', 'olive_one_click_demo_import_save_file' );

function olive_one_click_demo_import_download_settings_styles() {
	if ( empty( $_GET['page'] ) || 'olive-one-click-demo-import' !== $_GET['page'] || empty( $_GET['action'] ) || 'download-settings' !== $_GET['action'] ) {
		return false;
	}
	$nonce = $_REQUEST['_wpnonce'];
	if ( ! wp_verify_nonce( $nonce, 'olive-ocdi-nonce' ) ) {
		wp_die( esc_attr( __( 'Invalid action', 'olive-one-click-demo-import' ) ) );
	}
	$data['styles']   = wp_get_global_styles();
	$data['settings'] = wp_get_global_settings();
	$json_data        = wp_json_encode( $data );

	header( 'Content-disposition: attachment; filename=file.json' );
	header( 'Content-type: application/json' );
	echo $json_data;
	die();
}
add_action( 'admin_init', 'olive_one_click_demo_import_download_settings_styles' );

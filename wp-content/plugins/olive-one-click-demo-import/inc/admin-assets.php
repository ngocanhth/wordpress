<?php

function olive_one_click_demo_get_asset_file( $filepath ) {
	 $asset_path = OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_DIR . $filepath . '.asset.php';

	return file_exists( $asset_path )
		? include $asset_path
		: array(
			'dependencies' => array(),
			'version'      => OLIVE_ONE_CLICK_DEMO_IMPORT_VERSION,
		);
}

function olive_one_click_demo_admin_assets() {
	if ( ( ! empty( $_GET['page'] ) && 'olive-one-click-demo-import' === $_GET['page'] ) ) {
		$name   = 'landing-page';
		$assets = olive_one_click_demo_get_asset_file( 'dist/' . $name );

		wp_enqueue_script( 'olive-one-click-demo-import-' . $name, OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_URL . 'dist/' . $name . '.js', $assets['dependencies'], $assets['version'], true );

		wp_enqueue_style( 'olive-one-click-demo-import-' . $name, OLIVE_ONE_CLICK_DEMO_IMPORT_BASE_URL . 'dist/' . $name . '.css', array( 'wp-components' ), $assets['version'] );

		$nonce = wp_create_nonce( 'olive-ocdi-nonce' );
		$data  = array(
			'ajaxUrl'                 => admin_url( 'admin-ajax.php' ),
			'contentExportUrl'        => admin_url( 'export.php' ),
			'formImportURL'           => admin_url( 'themes.php?page=olive-one-click-demo-import&import=true&_wpnonce=' . $nonce ),
			'settingStyleDownloadURL' => admin_url( 'themes.php?page=olive-one-click-demo-import&action=download-settings&_wpnonce=' . $nonce ),
			'_wpnonce'                => $nonce,
			'siteUrl'                 => site_url(),
		);

		if ( ! empty( $_GET['page'] ) && 'olive-one-click-demo-import' === $_GET['page'] && ! empty( $_GET['importing'] ) && 'true' === $_GET['importing'] && ! empty( $_GET['import_id'] ) ) {
			$import_id    = absint( $_GET['import_id'] );
			$import_files = get_transient( $import_id );
			if ( ! empty( $import_files ) ) {
				$import_files['action'] = 'importing';
				$data                   = array_merge( $data, $import_files );
				delete_transient( $import_id );
			}
		}
		wp_localize_script( 'olive-one-click-demo-import-' . $name, 'olive_ocdi', $data );
	}
}
add_action( 'admin_enqueue_scripts', 'olive_one_click_demo_admin_assets' );

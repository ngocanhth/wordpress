<?php

function olive_one_click_demo_admin_menu() {
	add_submenu_page(
		'themes.php',
		__( 'Olive One Click Demo Import', 'olive-one-click-demo-import' ),
		__( 'Olive Importer', 'olive-one-click-demo-import' ),
		'manage_options',
		'olive-one-click-demo-import',
		'olive_one_click_demo_landing_page',
		6
	);
}
add_action( 'admin_menu', 'olive_one_click_demo_admin_menu' );

function olive_one_click_demo_landing_page() {
	echo '<div id="olive-one-click-demo-import-landing-page-app" class="wrap">Loading...</div>';
}

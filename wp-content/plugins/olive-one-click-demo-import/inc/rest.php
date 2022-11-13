<?php
/**
 * Rest API functions.
 *
 * @package Olive One Click Demo Import
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Olive_One_Click_Demo_Import_Rest
 */
class Olive_One_Click_Demo_Import_Rest extends WP_REST_Controller {
	/**
	 * Namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'olive-one-click-demo-import/v';

	/**
	 * Version.
	 *
	 * @var string
	 */
	protected $version = '1';

	/**
	 * Olive_One_Click_Demo_Import_Rest constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register rest routes.
	 */
	public function register_routes() {
		$namespace = $this->namespace . $this->version;

		// Get get_demo_categories.
		register_rest_route(
			$namespace,
			'/get_demo_categories/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_demo_categories' ),
				'permission_callback' => '__return_true',
			)
		);

		// Get Demos.
		register_rest_route(
			$namespace,
			'/get_theme_demo_list/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_theme_demo_list' ),
				'permission_callback' => '__return_true',
			)
		);

		// Import Demo.
		register_rest_route(
			$namespace,
			'/get_theme_manual_import_demo/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_manual_import_demo' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		register_rest_route(
			$namespace,
			'/get_theme_manual_import_demo_styles/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_manual_import_demo_styles' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		register_rest_route(
			$namespace,
			'/get_theme_manual_import_demo_set_pages/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_manual_import_demo_set_pages' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		// Import auto Demo.
		register_rest_route(
			$namespace,
			'/get_theme_import_demo/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_import_demo' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		register_rest_route(
			$namespace,
			'/get_theme_import_demo_styles/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_import_demo_styles' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		register_rest_route(
			$namespace,
			'/get_theme_import_demo_set_pages/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'get_theme_import_demo_set_pages' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);

		// Update Site Optoins.
		register_rest_route(
			$namespace,
			'/update_global_styles/',
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'update_global_styles' ),
				'permission_callback' => array( $this, 'create_permission' ),
			)
		);
	}

	/**
	 * Get edit options permissions.
	 *
	 * @return bool
	 */
	public function create_permission() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $this->error( 'user_dont_have_permission', __( 'User don\'t have permissions to change options.', '@@text_domain' ) );
		}
		return true;
	}

	public function get_demo_categories( WP_REST_Request $request ) {
		$options         = (array) $request->get_params();
		$demo_categories = false;
		if ( empty( $options['force'] ) || 'false' === $options['force'] ) {
			$demo_categories = get_transient( 'olive_demo_categories', false );
		}
		if ( false === $demo_categories ) {
			$error = $this->error( 'error_demo_categories', __( 'Error listing demo', '@@text_domain' ) );

			try {
				$url = 'https://demo.olivethemes.com/wp-json/demo-api/v1/get_demo_categories';
				// 'https://api.github.com/repos/olivethemes/demo-content/contents/themes'
				/** @var array|WP_Error $response */
				$response = wp_remote_get(
					$url,
					array(
						'timeout'     => 120,
						'httpversion' => '1.1',
						'headers'     => array(
							'Accept' => 'application/json',
						),
					)
				);
				if ( ( ! is_wp_error( $response ) ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
					if ( $body = wp_remote_retrieve_body( $response ) ) {
						$responseBody = json_decode( $body );
						$categories   = array();
						if ( ! empty( $responseBody ) && ! empty( $responseBody->response ) ) {
							$categories = $responseBody->response;
						}
						set_transient( 'olive_demo_categories', json_encode( $categories ), DAY_IN_SECONDS );
						return $this->success( $categories );
					}
					return $error;
				}
			} catch ( Exception $ex ) {
				return $error;
			}
		}
		return $this->success( json_decode( $demo_categories ) );
	}

	public function get_theme_demo_list( WP_REST_Request $request ) {
		$options   = (array) $request->get_params();
		$demo_list = false;
		if ( empty( $options['force'] ) || 'false' === $options['force'] ) {
			$demo_list = get_transient( 'olive_demo_import_list', false );
		}
		if ( false === $demo_list ) {
			$error = $this->error( 'error_demo_list', __( 'Error listing demo', '@@text_domain' ) );

			try {
				$url = 'https://demo.olivethemes.com/wp-json/demo-api/v1/get_demos';

				$response = wp_remote_get(
					$url,
					array(
						'timeout'     => 120,
						'httpversion' => '1.1',
						'headers'     => array(
							'Accept' => 'application/json',
						),
					)
				);
				if ( ( ! is_wp_error( $response ) ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
					if ( $body = wp_remote_retrieve_body( $response ) ) {
						$responseBody = json_decode( $body );
						$themes       = array();
						if ( ! empty( $responseBody ) && ! empty( $responseBody->response ) ) {
							$themes = (array) $responseBody->response;
						}
						set_transient( 'olive_demo_import_list', json_encode( $themes ), DAY_IN_SECONDS );
						return $this->success( $themes );
					}
					return $error;
				}
			} catch ( Exception $ex ) {
				return $error;
			}
		}
		return $this->success( json_decode( $demo_list ) );
	}

	public function get_theme_manual_import_demo( WP_REST_Request $request ) {
		$options = (array) $request->get_params();
		if ( ! empty( $options['content_file'] ) ) {
			$content_file = $options['content_file'];
			if ( ! class_exists( '\WP_Importer' ) ) {
				require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
			}
			require_once ABSPATH . 'wp-admin/includes/image.php';
			require_once ABSPATH . 'wp-admin/includes/file.php';

			require_once 'lib/merlin/class-merlin-downloader.php';
			require_once 'lib/WordPress-Importer/vendor/autoload.php';
			if ( ! class_exists( 'Merlin_Logger' ) ) {
				// Get the logger object, so it can be used in the whole class.
				require_once 'lib/merlin/class-merlin-logger.php';

			}
			$logger = Merlin_Logger::get_instance();

			$importer = new ProteusThemes\WPContentImporter2\Importer( array( 'fetch_attachments' => true ), $logger );

			$logs = call_user_func( array( $importer, 'import' ), $content_file );
			error_log( print_r( $logs, true ) );
			return $this->success( $logs );
		}
		$error = $this->error( 'error_demo_item', __( 'Error demo item', '@@text_domain' ) );
	}

	public function get_theme_manual_import_demo_styles( WP_REST_Request $request ) {
		$options = (array) $request->get_params();

		if ( ! empty( $options['setting_style_file'] ) ) {
			$setting_style_file = $options['setting_style_file'];

			require_once 'lib/merlin/class-merlin-downloader.php';

			$core_data = array();
			if ( $setting_style_file ) {
				$string    = file_get_contents( $setting_style_file );
				$core_data = json_decode( $string, true );
				if ( ! empty( $core_data['styles'] ) ) {
					olive_one_click_demo_import_update_global_styles( $core_data['settings'], $core_data['styles'] );
				}
			}
			return $this->success(
				array(
					'core' => $core_data,
				)
			);
		}
		$error = $this->error( 'error_demo_styles', __( 'Error demo styles', '@@text_domain' ) );
	}

	public function get_theme_manual_import_demo_set_pages( WP_REST_Request $request ) {
		$options = (array) $request->get_params();

		// if ( ! empty( $options['name'] ) ) {
			// $name = $options['name'];
			$theme = wp_get_theme();

			// Set Header
			$args    = array(
				'post_type'      => 'wp_template_part',
				'post_name__in'  => array( 'header' ),
				'posts_per_page' => 1,
			);
			$headers = get_posts( $args );
			if ( ! empty( $headers ) ) {
				$post_data = $headers[0];
				wp_set_post_terms( $post_data->ID, 'header', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			// Set Footer
			$args['post_name__in'] = array( 'footer' );
			$footers               = get_posts( $args );
			if ( ! empty( $footers ) ) {
				$post_data = $footers[0];
				wp_set_post_terms( $post_data->ID, 'footer', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			// Set Sidebar
			$args['post_name__in'] = array( 'sidebar' );
			$sidebars              = get_posts( $args );
			if ( ! empty( $sidebars ) ) {
				$post_data = $sidebars[0];
				// wp_set_post_terms( $post_data->ID, 'footer', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			$imported_posts = get_transient( '_transient_pt_importer_data' );
			// $imported_posts = get_option( '_pt_importer_data' );

			$args = array(
				'post_type'      => 'wp_template',
				// 'post_name__in' => array( 'header' ),
				'posts_per_page' => -1,
				'tax_query'      => array(
					array(
						'taxonomy' => 'wp_theme',
						'field'    => 'slug',
						'terms'    => $theme->template,
						'operator' => 'NOT IN',
					),
				),
			);

			if ( false !== $imported_posts && ! empty( $imported_posts['mapping']['post'] ) ) {
				$post_ids         = $imported_posts['mapping']['post'];
				$args['post__in'] = $post_ids;
			}

			$templates = get_posts( $args );

			if ( ! empty( $templates ) ) {
				$do_not_duplicate = array();
				$patterns         = array( '/(\"theme\"\:\".*\")/' );
				$replace          = array( '"theme":"' . $theme->template . '"' );

				foreach ( $templates as $template ) {
					if ( ! in_array( $template->post_name, $do_not_duplicate ) ) {
						$count   = 0;
						$content = preg_replace( $patterns, $replace, $template->post_content, -1, $count );
						error_log( print_r( $count, true ) );

						$data = array(
							'ID'           => $template->ID,
							'post_content' => $content,
						);

						wp_update_post( $data );
						wp_set_post_terms( $template->ID, $theme->template, 'wp_theme' );
						$do_not_duplicate[] = $template->post_name;
					}
				}
			}

			return $this->success(
				array(
					// 'name' => $name,
					'headers'        => $headers,
					'templates'      => $templates,
					'args'           => $args,
					'imported_posts' => $imported_posts,
				)
			);
		// }
		$error = $this->error( 'error_demo_set_pages', __( 'Error demo set pages.', '@@text_domain' ) );
	}

	public function get_theme_import_demo( WP_REST_Request $request ) {
		$options = (array) $request->get_params();


		if ( ! empty( $options['name'] ) ) {
			$name = $options['name'];
			if ( ! class_exists( '\WP_Importer' ) ) {
				require ABSPATH . '/wp-admin/includes/class-wp-importer.php';
			}
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');

			require_once 'lib/merlin/class-merlin-downloader.php';
			require_once ( 'lib/WordPress-Importer/vendor/autoload.php' );
			if ( ! class_exists('Merlin_Logger')){
				// Get the logger object, so it can be used in the whole class.
				require_once 'lib/merlin/class-merlin-logger.php';

			}
			$logger = Merlin_Logger::get_instance();

			$importer = new ProteusThemes\WPContentImporter2\Importer( array( 'fetch_attachments' => true ), $logger  );
			$xml_url = 'https://raw.githubusercontent.com/olive-blocks/demo-content/main/themes/' . $name . '/content.xml';
			$url = 'https://raw.githubusercontent.com/olive-blocks/demo-content/main/themes/' . $name . '/core-settings.json';
			$plugin_settings_file = 'https://raw.githubusercontent.com/olive-blocks/demo-content/main/themes/' . $name . '/plugin-settings.json';

			$downloader = new Merlin_Downloader();
			$xml_file_path = $downloader->download_file( $xml_url, $name . '.xml');
			$global_style_file_path = $downloader->download_file( $url,  $name . '-core-settings.json' );
			$plugin_settings_file_path = $downloader->download_file( $plugin_settings_file,  $name . '-plugin-settings.json' );

			$logs = call_user_func( array( $importer, 'import' ), $xml_file_path );
			error_log( print_r( $logs, true ));
			// if ( $logs ) {
			// 	if ( $global_style_file_path ) {
			// 		$string = file_get_contents( $global_style_file_path );
			// 		$json_a = json_decode($string, true);
			// 		if ( ! empty( $json_a['styles'] ) ) {
			// 			olive_one_click_demo_import_update_global_styles( $json_a['settings'], $json_a['styles'] );
			// 		}
			// 	}

			// 	if ( $plugin_settings_file_path ) {
			// 		$string = file_get_contents( $plugin_settings_file_path );
			// 		$json_a = json_decode($string, true);
			// 		error_log( print_r( $json_a, true ));
			// 		if ( ! empty( $json_a ) ) {
			// 			$current_options = get_option( 'olive_blocks_framework_lite_site_options', array() );
			// 			if ( empty( $current_options ) ) {
			// 				$current_options = array();
			// 			}

			// 			update_option( 'olive_blocks_framework_lite_site_options', array_merge( $current_options, $json_a ) );
			// 		}
			// 	}
			// }
			return $this->success( $logs );
		}
		$error = $this->error( 'error_demo_item', __( 'Error demo item', '@@text_domain' ) );
	}

	public function get_theme_import_demo_styles( WP_REST_Request $request ) {
		$options = (array) $request->get_params();

		if ( ! empty( $options['name'] ) ) {
			$name = $options['name'];

			require_once 'lib/merlin/class-merlin-downloader.php';
			$url = 'https://raw.githubusercontent.com/olive-blocks/demo-content/main/themes/' . $name . '/core-settings.json';
			$plugin_settings_file = 'https://raw.githubusercontent.com/olive-blocks/demo-content/main/themes/' . $name . '/plugin-settings.json';

			$downloader = new Merlin_Downloader();
			$global_style_file_name = $name . '-core-settings.json';
			$global_style_file_path = $downloader->fetch_existing_file( $global_style_file_name );
			if ( false === $global_style_file_path ) {
				$global_style_file_path = $downloader->download_file( $url, $global_style_file_name );
			}

			$plugin_settings_file_name = $name . '-plugin-settings.json';
			$plugin_settings_file_path = $downloader->fetch_existing_file( $plugin_settings_file_name );
			if ( false === $plugin_settings_file_path ) {
				$plugin_settings_file_path = $downloader->download_file( $plugin_settings_file,  $plugin_settings_file_name );
			}


			$core_data = array();
			if ( $global_style_file_path ) {
				$string = file_get_contents( $global_style_file_path );
				$core_data = json_decode($string, true);
				if ( ! empty( $core_data['styles'] ) ) {
					olive_one_click_demo_import_update_global_styles( $core_data['settings'], $core_data['styles'] );
				}
			}

			$plugin_data = array();
			if ( $plugin_settings_file_path ) {
				$string = file_get_contents( $plugin_settings_file_path );
				$plugin_data = json_decode($string, true);
				if ( ! empty( $plugin_data ) ) {
					$current_options = get_option( 'olive_blocks_framework_lite_site_options', array() );
					if ( empty( $current_options ) ) {
						$current_options = array();
					}

					update_option( 'olive_blocks_framework_lite_site_options', array_merge( $current_options, $plugin_data ) );
				}
			}
			return $this->success( array(
				'core' => $core_data,
				'plugin' => $plugin_data,
			) );
		}
		$error = $this->error( 'error_demo_styles', __( 'Error demo styles', '@@text_domain' ) );
	}

	public function get_theme_import_demo_set_pages( WP_REST_Request $request ) {
		$options = (array) $request->get_params();

		if ( ! empty( $options['name'] ) ) {
			$name = $options['name'];
			$theme = wp_get_theme();

			// Set Header
			$args = array(
				'post_type' => 'wp_template_part',
				'post_name__in' => array( 'header' ),
				'posts_per_page' => 1
			);
			$headers = get_posts( $args );
			if ( ! empty( $headers ) ) {
				$post_data = $headers[0];
				wp_set_post_terms( $post_data->ID, 'header', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			// Set Footer
			$args['post_name__in'] = array( 'footer' );
			$footers = get_posts( $args );
			if ( ! empty( $footers ) ) {
				$post_data = $footers[0];
				wp_set_post_terms( $post_data->ID, 'footer', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			// Set Sidebar
			$args['post_name__in'] = array( 'sidebar' );
			$sidebars = get_posts( $args );
			if ( ! empty( $sidebars ) ) {
				$post_data = $sidebars[0];
				// wp_set_post_terms( $post_data->ID, 'footer', 'wp_template_part_area' );
				wp_set_post_terms( $post_data->ID, $theme->template, 'wp_theme' );
			}

			$imported_posts = get_transient( '_transient_pt_importer_data' );
			// $imported_posts = get_option( '_pt_importer_data' );

			$args = array(
				'post_type' => 'wp_template',
				// 'post_name__in' => array( 'header' ),
				'posts_per_page' => -1,
				'tax_query' => array(
					array(
						'taxonomy' => 'wp_theme',
						'field'    => 'slug',
						'terms'    => $theme->template,
						'operator'    => 'NOT IN',
					),
				),
			);

			if ( false !== $imported_posts && ! empty( $imported_posts['mapping']['post'] ) ) {
				$post_ids = $imported_posts['mapping']['post'];
				$args['post__in'] = $post_ids;
			}

			$templates = get_posts( $args );

			if ( ! empty( $templates ) ) {
				$do_not_duplicate = array();
				$patterns = array ('/(\"theme\"\:\".*\")/' );
				$replace = array ('"theme":"'. $theme->template.'"');

				foreach( $templates as $template ) {
					if ( ! in_array( $template->post_name, $do_not_duplicate ) ) {
						$count = 0;
						$content = preg_replace( $patterns, $replace, $template->post_content, -1, $count );
						error_log( print_r( $count, true ) );

						$data = array(
							'ID' => $template->ID,
							'post_content' => $content,
						);

						wp_update_post( $data );
						wp_set_post_terms( $template->ID, $theme->template, 'wp_theme' );
						$do_not_duplicate[] = $template->post_name;
					}
				}
			}

			return $this->success( array(
				'name' => $name,
				'headers' => $headers,
				'templates' => $templates,
				'args' => $args,
				'imported_posts' => $imported_posts,
			) );
		}
		$error = $this->error( 'error_demo_set_pages', __( 'Error demo set pages.', '@@text_domain' ) );
	}

	/**
	 * Update site options.
	 *
	 * @param WP_REST_Request $request  request object.
	 *
	 * @return mixed
	 */
	public function update_global_styles( WP_REST_Request $request ) {
		$options = (array) $request->get_params();

		if ( isset( $options['css'] ) ) {
			update_option( 'olive_blocks_framework_lite_global_style', $options['css'] );
		}

		if ( isset( $options['adminCss'] ) ) {
			update_option( 'olive_blocks_framework_lite_admin_global_style', $options['adminCss'] );
		}

		return $this->success( $options );
	}

	/**
	 * Success rest.
	 *
	 * @param mixed $response response data.
	 * @return mixed
	 */
	public function success( $response ) {
		return new WP_REST_Response(
			array(
				'success'  => true,
				'response' => $response,
			),
			200
		);
	}

	/**
	 * Error rest.
	 *
	 * @param mixed $code     error code.
	 * @param mixed $response response data.
	 * @return mixed
	 */
	public function error( $code, $response ) {
		return new WP_REST_Response(
			array(
				'error'      => true,
				'success'    => false,
				'error_code' => $code,
				'response'   => $response,
			),
			401
		);
	}
}
new Olive_One_Click_Demo_Import_Rest();

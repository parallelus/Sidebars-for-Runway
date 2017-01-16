<?php

class Sidebar_Admin_Object extends Runway_Admin_Object {

	public $dynamic;
	public $option_key;
	public $sidebars_options;

	public function __construct( $settings ) {

		parent::__construct( $settings );

		$this->option_key       = $settings['option_key'];
		$this->sidebars_options = get_option( $this->option_key );

	}

	public function update_sidebar( $options = array() ) {

		if ( ! empty( $options ) ) {
			$this->sidebars_options['sidebars_list'][ $options['alias'] ] = $options;
			update_option( $this->option_key, $this->sidebars_options );

			if ( IS_CHILD && get_template() == 'runway-framework' ) {
				$file_name = $this->option_key . '.json';

				if ( ! function_exists( 'WP_Filesystem' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
				}
				WP_Filesystem();

				global $wp_filesystem;

				if ( $wp_filesystem->put_contents( THEME_DIR . 'data/' . $file_name, json_encode( $this->sidebars_options ), FS_CHMOD_FILE ) ) {
					return true;
				} else {
					return false;
				}
			}
		}

		return false;

	}

	public function delete_sidebar( $alias ) {

		if ( $alias != '' ) {
			unset( $this->sidebars_options['sidebars_list'][ $alias ] );
			update_option( $this->option_key, $this->sidebars_options );

			return true;
		}

		return false;

	}

	public function get_sidebar( $alias ) {

		if ( $alias != '' ) {
			return $this->sidebars_options['sidebars_list'][ $alias ];
		}

		return false;

	}

	// Called by the action get_sidebar. this is what places this into the theme
	//...............................................
	public function get_sidebar_content( $index ) {

		//wp_reset_query();
		global $wp_query;
		$post             = $wp_query->get_queried_object();
		$selected_sidebar = get_post_meta( $post->ID, 'customSidebar', true );

		if ( $selected_sidebar != '' && $selected_sidebar != "0" ) {
			echo "\n\n<!-- begin generated sidebar [$selected_sidebar] -->\n";
			dynamic_sidebar( $selected_sidebar );
			echo "\n<!-- end generated sidebar -->\n\n";
		} else {
			//dynamic_sidebar($index);
			if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $index ) ) :
			endif;
		}

	}

	// Add hooks & crooks
	function add_actions() {

		//include JS (from "load_admin_js" function at end of page)
		add_action( 'admin_print_scripts-' . $this->parent_menu . '_page_' . $this->slug, array(
			$this,
			'load_admin_js'
		) );
		// Init action
		add_action( 'init', array( $this, 'init' ) );

	}

	public function init() {

		if ( isset( $_REQUEST['navigation'] ) && ! empty( $_REQUEST['navigation'] ) ) {
			global $sidebar_admin;
			$sidebar_admin->navigation = $_REQUEST['navigation'];
		}

	}

	function after_settings_init() {
		/* nothing */
  	}

	function validate_sumbission() {

		// Sidebars
		if ( $this->navigation == 'sidebars' ) {
			if ( ! $_POST ) {
				return false;
			}

			$this->fields = array(
				'var'   => array( 'label', 'alias', 'key' ),
				'array' => array()
			);

			// Validate fields
			if ( ! esc_attr( $_POST['label'] ) ) {
				$this->set_navigation( 'sidebar' );

				return $this->error( __( 'You must enter a title.', 'runway' ) );
			}

			if ( ! esc_attr( $_POST['alias'] ) ) {
				$_POST['alias'] = $_POST['label'];
			}

			// No keys or indexes for this type. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed.
			if ( ! $_POST['key'] ) {
				$_POST['key'] = base_convert( microtime(), 10, 36 );
			}

			$_POST['alias'] = sanitize_title( $_POST['alias'] );
			$_POST['index'] = $_POST['key'];

		}

		// Tabs
		if ( $this->navigation == 'tabs' ) {
			if ( ! $_POST ) {
				return false;
			}

			$this->fields = array(
				'var'   => array( 'label', 'class', 'conditions', 'bg_color', 'alias', 'key' ),
				'array' => array()
			);

			// Validate fields
			if ( ! esc_attr( $_POST['label'] ) ) {
				$this->set_navigation( 'tab' );

				return $this->error( __( 'You must enter a title.', 'runway' ) );
			}

			if ( ! esc_attr( $_POST['alias'] ) ) {
				$_POST['alias'] = $_POST['label'];
			}

			// No keys or indexes for this type. Auto-generate and stored in hidden fields.
			// Unique keys are important, otherwise a reference to this item could fail if the title is used as the key and it gets changed.
			if ( ! $_POST['key'] ) {
				$_POST['key']   = base_convert( microtime(), 10, 36 );
				$_POST['alias'] = $_POST['key'];  // sidebars need the alias field
			}
			//$_POST['alias'] = sanitize_title($_POST['alias']);
			$_POST['index'] = $_POST['key'];
		}

		// If all is OK
		return true;
	}

	function load_objects() {

		global $sidebar_settings;
		$this->data = $sidebar_settings->load_objects();

		return $this->data;

	}

	function load_admin_js() {
		/* none */
	}

}

<?php
/*
    Extension Name: Sidebars
    Extension URI: https://github.com/parallelus/Sidebars-for-Runway
    Version: 0.8.4
    Description: Create Sidebars and Widget ready areas in WordPress themes.
    Author: Parallelus
    Author URI: http://runwaywp.com
    Text Domain:
    Domain Path:
    Network:
    Site Wide Only:
*/

// Settings
$fields  = array(
	'var'   => array(),
	'array' => array()
);
$default = array();

$settings = array(
	'name'        => __( 'Sidebars', 'runway' ),
	'option_key'  => $shortname . 'sidebar_settings',
	'fields'      => $fields,
	'default'     => $default,
	'parent_menu' => 'appearance',
	//'menu_permissions' => 5,
	'file'        => __FILE__,
	'js'          => array(
		'jquery',
		'jquery-ui-core',
		'jquery-ui-dialog',
		FRAMEWORK_URL . 'extensions/sidebars/js/sidebars.js',
	),
);

// Including Sidebar Generator and Sidebar Shortcodes

// Required components
include( 'object.php' );
global $sidebar_settings, $sidebar_admin;
$sidebar_settings = new Sidebar_Settings_Object( $settings );

// Load admin components
if ( is_admin() ) {
	include( 'settings-object.php' );
	$sidebar_admin = new Sidebar_Admin_Object( $settings );
}

// Setup a custom button in the title
function title_button_new_sidebar( $title ) {
	if ( $_GET['page'] == 'sidebars' ) {
		$title .= ' <a href="' . admin_url( 'admin.php?page=sidebars&navigation=add-sidebar' ) . '" class="add-new-h2">' . __( 'Add new sidebar', 'runway' ) . '</a>';
	}

	return $title;
}

add_filter( 'framework_admin_title', 'title_button_new_sidebar' );

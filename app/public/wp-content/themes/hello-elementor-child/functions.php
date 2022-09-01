<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}


if (!defined('ABSPATH')) {
  exit;
}
define('HOME_URL', home_url());
define('THEME_PATH', get_theme_file_path());
define('THEME_URI', get_stylesheet_directory_uri());
define('THEME_CSS_URI', get_stylesheet_uri());
define('Components', THEME_PATH . '/components/'); 
define('template_parts', THEME_PATH . '/template-parts/'); 
define('ADMIN_PATH', THEME_PATH . '/admin');
define('ADMIN_URI', THEME_URI . '/admin');
define('DIST', THEME_URI . '/dist');
define('SOURCE_FILES', THEME_URI . '/source_files');
define('IMAGES', THEME_URI . '/dist/img');
define('CSS', THEME_URI . '/dist/css');
define('JS', THEME_URI . '/dist/js');

include(ADMIN_PATH . '/functions.php'); 
include(ADMIN_PATH . '/ajax.php'); 

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

require_once('custom-widgets/my-widgets.php');

?>
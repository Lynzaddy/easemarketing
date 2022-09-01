<?php
/**
 * Enqueue assets
**/
add_action( 'wp_enqueue_scripts', function() {

if(is_page_template( 'page-templates/marketplace.php') || is_page_template( 'page-templates/events.php')) { 
	if(!is_admin()){
	wp_deregister_script('jquery');
	wp_dequeue_script('jquery');
	}
}
		wp_enqueue_style( 'filter_css', THEME_URI . '/vendor/stylesheet//flipster-old/jquery.flipster.css',  false, null );
		wp_enqueue_style( 'filter_css_new', THEME_URI . '/vendor/stylesheet/flipster/jquery.flipster.min.css',  false, null );
		wp_enqueue_style('slick-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',  false, null);
		wp_enqueue_style('slick-theme-css', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', false, null);
		wp_enqueue_style('bootstrap_css2', get_stylesheet_directory_uri() . '/vendor/bootstrap.min.css', false, null);		
    wp_enqueue_style( 'maincss', get_stylesheet_directory_uri() . '/dist/css/main.css', false, '1.6' );

    wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js', NULL, NULL, true);
    wp_enqueue_script('jquery'); 
		wp_enqueue_script('slick-min', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), true);
		wp_enqueue_script( 'flipster', THEME_URI . '/vendor/javascript/flipster.js', ['jquery'], 1.11, true );

		wp_enqueue_script( 'bundle', THEME_URI . '/vendor/bootstrap.bundle.min.js', ['jquery'], 1.11, true );
		wp_enqueue_script( 'matchHeight', THEME_URI . '/vendor/jquery.matchHeight.js', ['jquery'], 1.11, true );
		wp_enqueue_script( 'filter', THEME_URI . '/src/js/components/filter.js', ['jquery'], 1.11, true ); 
		wp_enqueue_script( 'hero1', THEME_URI . '/src/js/components/hero-treatment-1.js', ['jquery'], 1.11, true );
		wp_enqueue_script( 'script_custom', THEME_URI . '/src/js/main.js', ['jquery'], 1.13, true );
		wp_localize_script('script_custom', 'ajaxurl', admin_url('admin-ajax.php') );
		wp_localize_script('script_custom', 'site_url', site_url() );
	

	if(is_page_template( 'page-templates/marketplace.php')) { 
		wp_enqueue_script( 'marketplacepage', THEME_URI . '/src/js/pages/marketplace.js', ['jquery'], 1.15, true );
	}	
	if(is_page_template( 'page-templates/events.php')) { 
		wp_enqueue_script( 'marketplacepage', THEME_URI . '/src/js/pages/events.js', ['jquery'], 1.13, true );
	}	

	 
	// BLOG PAGE
	if (get_option( 'page_for_posts' ) == get_queried_object_id()) {
		wp_enqueue_script('blogpagejs', THEME_URI . '/src/js/pages/blog.js', ['jquery'], 1.23, true);
	}
	// BLOG PAGE END
   
   // wp_enqueue_script( 'filter', THEME_URI . '/dist/js/components/filter.js', ['jquery'], GIT_VERSION, true );

	/*** ACF Options Support **/
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page();
	}
});    

// Max length of text in blog cards 20
function wpdocs_custom_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'wpdocs_custom_excerpt_length', 999);
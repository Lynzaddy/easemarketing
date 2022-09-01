<?php

class My_Elementor_Widgets {

	protected static $instance = null;

	public static function get_instance() {
		if ( ! isset( static::$instance ) ) {
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct() {
		require_once('widget1.php');
		require_once('testimonials-with-image.php');
		require_once('related-content-widget.php');
		require_once('related-content-card-widget.php');
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}

	public function register_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\My_Widget_1() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Testimonials_With_Image() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Related_Content() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\Related_Content_Card() );
	}
	
}

add_action( 'init', 'my_elementor_init' );
function my_elementor_init() {
	My_Elementor_Widgets::get_instance();
}
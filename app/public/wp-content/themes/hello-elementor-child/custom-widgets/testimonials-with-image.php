<?php
namespace Elementor;

class Testimonials_With_Image extends Widget_Base {
	
	public function get_name() {
		return 'testimonials-with-image';
	}
	
	public function get_title() {
		return 'Testimonials With Image';
	}

	public function get_categories() {
		return [ 'basic' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Content', 'elementor' ),
			]
		);

		$this->add_control(
			'post_ids',
			[
				'label' => __( 'Post IDs', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Post IDs', 'elementor' ),
			] 
		);		

		$this->end_controls_section();
	}
	
	protected function render() {

		$setting = $this->get_settings_for_display();

		    $postIDs = $setting['post_ids'];

		include template_parts. "testimonialv1.php";
	}
	
	protected function _content_template() {}
	
}
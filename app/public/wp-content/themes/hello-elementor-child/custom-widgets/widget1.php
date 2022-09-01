<?php
namespace Elementor;

class My_Widget_1 extends Widget_Base {
	
	public function get_name() {
		return 'testimonials-2';
	}
	
	public function get_title() {
		return 'Testimonials [2]';
	}
	
	/* public function get_icon() {
		return 'fa fa-font';
	} */
	
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
		include template_parts. "flipslider.php";
	}
	
	protected function _content_template() { }
	
}
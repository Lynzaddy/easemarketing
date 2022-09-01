<?php
namespace Elementor;

class Related_Content extends Widget_Base {
	
	public function get_name() {
		return 'related-content';
	}
	
	public function get_title() {
		return 'Related Content';
	}

	public function get_categories() {
		return [ 'basic' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Related Content', 'elementor' ),
			]
		);

		$this->add_control(
			'excer_limit',
			[
				'label' => __( 'Excerpt Character Limit', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::NUMBER,
    			'default' => 100,
			] 
		);		

		$this->add_control(
			'post_type',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Post Type', 'elementor' ),
				'options' => [
					'event' => esc_html__( 'Events', 'elementor' ),
					'post' => esc_html__( 'Posts', 'elementor' ),
				],
			]
		);      

		$this->add_control(
			'thumbnail_image_condition',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Thumbnail Image Condition', 'elementor' ),
				'options' => [
					'show' => esc_html__( 'Show', 'elementor' ),
					'hide' => esc_html__( 'Hide', 'elementor' ),
				],
				'default' => 'show',
			]
		);    		

		$this->add_control(
			'tags_condition',
			[
				'type' => \Elementor\Controls_Manager::SELECT,
				'label' => esc_html__( 'Tags Condition', 'elementor' ),
				'options' => [
					'show' => esc_html__( 'Show', 'elementor' ),
					'hide' => esc_html__( 'Hide', 'elementor' ),
				],
				'default' => 'show',
			] 
		);    		
        
		$this->add_control(
			'card_color',
			[
				'type' => \Elementor\Controls_Manager::COLOR,
				'label' => esc_html__( 'Card Color', 'elementor' ),
				'default' => '#f7f2e9',
			]
		);        

		$this->add_control(
			'tax_id',
			[
				'label' => __( 'Taxonomy IDs', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			] 
		);

		$this->add_control(
			'tag_id',
			[
				'label' => __( 'Tag IDs', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			] 
		);
		$this->add_control(
			'post_id',
			[
				'label' => __( 'Post IDs', 'elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			] 
		);

		$this->end_controls_section();
	}
	
	protected function render() {

        $setting = $this->get_settings_for_display();

        $excer_limit = $setting['excer_limit'];

        $thumbnail_image_condition = $setting['thumbnail_image_condition'];

        $tags_condition = $setting['tags_condition'];

        $post_type = $setting['post_type'];

        $card_color = $setting['card_color'];

        $taxID = $setting['tax_id'];

		$tagID = $setting['tag_id'];

        $postID = $setting['post_id'];

		include template_parts. "related-content.php";
	}
	
	protected function _content_template() {}
	
}
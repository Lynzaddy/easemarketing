<?php get_header();
$image = get_the_post_thumbnail_url(); 
$bottom_banner = get_field('bottom_banner');
$promo_banner_link = get_field('promo_banner_link');
$promo_banner_target = get_field('promo_banner_target');
$button = get_field('button');
$is_form = get_field('is_form');
$form_heading = get_field('form_heading');
$form_text = get_field('form_text');
$single_post_form = get_field('single_post_form');
$date = get_field('date');
$related_events = get_field('show_related_events');
$location = get_field('location');
?> 


<?php 
    $event_page = get_field('event_page', 'options');
    $main_page = $event_page['main_page'];
    $main_title = $main_page['main_title'];
    $sub_page =  $event_page['sub_page'];
?>

<div class="custom-breadcrumb">
    <div class="container">
        <div class="custom-row">
            <div class="first-col">
                <div class="main-page">
                    <?php echo $main_title; ?>
                </div>
            </div>
            <div class="second-col">
                <div class="sub-pages">
                    <span class="space_div"></span>
                    <?php foreach($sub_page as $key => $sub_page_items){
                        $title = $sub_page_items['title'];
                        $link = $sub_page_items['link'];
                    ?> 
                        <span class="breadcrumb_item"><a href="<?php echo $link;?>"><?php echo $title?></a></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="custom-breadcrumb responsive">
    <div class="container">
        <div class="breadcrumb-row">
            <span class="breadcrumb_item"><a href="<?php echo HOME_URL; ?>" Class="">Home</a></span>
            <span class="breadcrumb_item active">Events</span>
        </div>
    </div>
</div>

<main class="single-post">
<?php 
   global $post;
    ?>
<section class="hero-section">
    <div class="container">
        <a href="<?php echo HOME_URL; ?>/events" class="back-to">< Back to All Events</a>
        <div class="row hero-row">
            <div class="col-lg-5 col-sm-12 hero-col">
                <h1><?php the_title(); ?></h1>

                <div class="date-location">
                    <span class="date"><?php echo $date; ?></span>
                    <span class="location"><?php echo $location; ?></span>
                </div>

                <?php 
                $tags1 = get_the_terms($post->ID, 'event_cat');
                // echo get_the_term_list( $post->ID, 'event_cat', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' );
                 ?>

            <div class="cat-tags"> 
                <?php if ( $tags1 ) { ?>
                    <div class="tags-container">
                        <?php foreach($tags1 as $tag) { 
                            $name = $tag->name;
                            $term_id = $tag->slug;
                            $taxonomy = $tag->taxonomy;
                            ?>
                            <a class="tag" href="/events?categories=<?php echo $term_id; ?>"><?php echo $name ?></a>
                        <?php } ?>
                    </div>
                <?php } ?> 
            </div>


            </div>
            <div class="col-lg-7 col-sm-12 hero-col">
                <div class="image-wrap">
                    <?php if ( has_post_thumbnail() ) { ?>
                        <img style="margin: 60px 0" src="<?php echo $image; ?>" alt="">
                    <?php }else{ ?>
                        <img style="margin: 60px 0"  src="/wp-content/uploads/2022/04/Event-default-image.jpg" alt="">
                    <?php } ?>                    
                </div>            
            </div>
        </div>
     
    </div> 
</section>


<section class="single-post-content">
    <div class="container">
        <div class="row">
        <?php if($is_form == 1){ ?>
        <div class="col-lg-6 col-sm-12 hero-col">
            <?php the_content(); ?>
            
            <?php if($button['url'] != ''){ ?>
            <a href="<?php echo $button['url']; ?>" class="btn primary-btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
            <?php } ?>
        </div>
        <div class="col-lg-6 col-sm-12 hero-col">
            <div class="form-wrap">
                <h3><?php echo $form_heading; ?></h3>
                <p><?php echo $form_text; ?></p>
                <?php echo $single_post_form; ?>
            </div>
        </div>
            <?php }else{ ?>
        <div class="col-lg-12 col-sm-12 hero-col">
            <?php the_content(); ?>
            
            <?php if($button['url'] != ''){ ?>
            <a href="<?php echo $button['url']; ?>" class="btn primary-btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
            <?php } ?>

        </div>
        <?php } ?>
    
        </div>

            <?php if($bottom_banner != ''){ ?> 
                <?php if(isset($promo_banner_link) && !empty($promo_banner_link)){ ?> 
                    <div class="bottom-banner">
                        <a href="<?php echo $promo_banner_link; ?>" target="<?php echo $promo_banner_target; ?>">
                            <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">
                        </a>    
                    </div>
                <?php }else{ ?>
                    <div class="bottom-banner">
                        <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">  
                    </div>
            <?php } }  ?>


    </div>
</section>


<?php /*
if($related_events == 1){
echo event_related_posts_callback(); 
}else{}*/
?>

<?php 
if($related_events == 1){ ?>



	<?php
		$related_event = get_field('related_event');
		if (!is_array($related_event)) {
			$related_event = [];
		}
		$exclude_event_ids[] = get_the_ID(); 
		if (isset($related_event) && !empty($related_event)) {
			foreach ($related_event as $post) {
				$exclude_event_ids[] = $post->ID;
			}
		}
		$related_event_count = count($related_event);
		if($related_event_count < 3) {
			$latest_posts = get_posts(array(
				'post_type' => [ 'event'],
				'posts_per_page' => 3 - $related_event_count,
				'post_status' => 'publish',
				'post__not_in'			=> $exclude_event_ids,
				'orderby'        	=> 'date',
			));
		} else {
			$latest_posts = array();
		}

		$related_event_post = array_merge($related_event, $latest_posts);
		if (isset($related_event_post) && !empty($related_event_post)) {
	?>
    <section class="related-posts-section">
        <div class="container">
            <div class="row">
					<?php
						foreach ($related_event_post as $post) {
						$post_id = $post->ID; 
						extract(get_fields());
					?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card cardv2">
                            <div class="image-wrap"> 
                                <?php if ( has_post_thumbnail($post_id) ) { ?>
                                    <img src="<?php echo get_the_post_thumbnail_url($post_id); ?>" alt="">
                                <?php }else{ ?>
                                    <img src="/wp-content/uploads/2022/04/Event-default-image.jpg" alt="">
                                <?php } ?>
                            </div>
                            <div class="text-wrap">
                                <h3 data-mh="related-event-title"><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h3>
                                <span class="excerpt" data-mh="related-event-excerpt"><?php the_excerpt($post_id); ?></span>
                                <div class="cat-tags"  data-mh="related-event-tags">
                                    <?php echo get_the_term_list($post_id, 'event_cat', '<span>', '</span><span>', '</span>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
					<?php  } ?>
			</div>
		</div>
	</section>
	<?php }  wp_reset_postdata(); ?>


<?php
}else{}
?>




</main>


<?php get_footer(); ?>
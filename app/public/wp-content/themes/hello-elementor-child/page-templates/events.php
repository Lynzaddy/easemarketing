<?php get_header(); /** Template Name:  Events Page Template  */ 

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
<main class="page-template-events">

	<?php $hero_banner = get_field('hero_banner'); 
    $first_promo_banner = get_field('first_promo_banner');
    $first_promo_banner_link = get_field('first_promo_banner_link');
    $first_promo_banner_target = get_field('first_promo_banner_target');
    $second_promo_banner = get_field('second_promo_banner');
    $second_promo_banner_link = get_field('second_promo_banner_link');
    $second_promo_banner_target = get_field('second_promo_banner_target');
    ?>

	<?php if(isset($hero_banner) && !empty($hero_banner)){ 
		extract($hero_banner); ?>
<section class="hero-section">
    <div class="container">
        <div class="hero-row">
            <div class="hero-col text-col">
                <?php echo ($heading) ? '<h1>'.$heading.'</h1>' : '<h1>'. get_the_title() .'</h1>';  ?>
                <?php echo ($text) ? '<p>'.$text.'</p>' : '';  ?>
            </div>
            <div class="hero-col image-col" style="background-image: url('<?php echo $image; ?>')">
            </div>
        </div>

    </div> 
</section> 
<?php } ?>

 
<section class="listing-section">
    <div class="container">
        <?php
        $taxonomy = get_terms([
            'taxonomy' => 'event_cat',
            'hide_empty' => true, 
        ]);
        ?>
        <div class="filter-container">
            <div class="row filter-row">
                <div class="col-lg-6 col-sm-12 filter-col">
                    <div class="search-bar search-form-wrap search-main d-md-block">
                            <form class="form-search">
                                <input type="text" placeholder="Find Events">
                                <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24.211" height="25.203" viewBox="0 0 24.211 25.203">
                                    <g id="Group_263" data-name="Group 263" transform="translate(1 1)">
                                        <g id="Group_33" data-name="Group 33" transform="translate(0)">
                                        <path id="Path_85" data-name="Path 85" d="M220.778,293.546a8.984,8.984,0,1,1,2.768-2.768A8.889,8.889,0,0,1,220.778,293.546Z" transform="translate(-207 -277)" fill="none" stroke="#08a6a5" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"/>
                                        <line id="Line_82" data-name="Line 82" x2="7.054" y2="7.054" transform="translate(14.742 15.735)" fill="none" stroke="#08a6a5" stroke-linecap="round" stroke-width="2"/>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                        </form>
                    </div> 
                    
                </div>
                <div class="col-lg-6 col-sm-12 filter-col">

                        <div class="dropdown filter-dropdown" id="filterevent">
                                <button class="filter-button dropdown-toggle" type="button" id="filterDropdownType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter Events
                                </button>
                                <div class="dropdown-menu" aria-labelledby="filterDropdownType">
                                    <!-- <a class="dropdown-item reset-button" href="reset">Reset</a> -->
                                            <?php foreach ($taxonomy as $tax) : 
                                                $name = $tax->name;
                                                $slug = $tax->slug;

                                                $args = [
                                                    'post_type'      => 'event',
                                                    'posts_per_page' => -1,
                                                    'meta_key' => 'start_date',
                                                    'orderby' => 'meta_value_num',
                                                    'order' => 'ASC',
                                                    'post_status'    => ['publish'],
                                                    'meta_query' => array(
                                                        'relation' => 'OR',
                                                        array(
                                                            'key' => 'start_date',
                                                            'value' => date("Y-m-d"),
                                                            'compare' => '>=',
                                                            'type' => 'DATE'
                                                        ),
                                                        array(
                                                            'key' => 'end_date',
                                                            'value' => date("Y-m-d"),
                                                            'compare' => '>=',
                                                            'type' => 'DATE'
                                                        )
                                                    ), 
                                            
                                                ];
                                                if (isset($slug) && !empty($slug)) {
                                                    $args['tax_query'][] = [
                                                        'taxonomy' => 'event_cat',
                                                        'field'    => 'slug',
                                                        'terms'    => $slug
                                                    ];
                                                }
                                                $events_check = new WP_Query($args);
                                            ?>
                                            <?php if ($events_check->post_count > 0) { ?>
                                                <div class="checkbox-container">
                                                    <label class="check-box-label" for="<?php echo $slug; ?>">
                                                        <input type='checkbox' value='<?php echo $slug; ?>' class="checkbox" id="<?php echo $slug; ?>" data-name="<?php echo $name; ?>" />
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <div class="dropdown-item-new"><?php echo $name; ?></div>
                                                </div>
                                            <?php } ?>
                                            
                                    <?php endforeach; ?>
                                    <div class="filter-button-new">FILTER</div>
                                </div>
                        </div>

                </div>
            </div>


                <div class="filter-tag-container">
                    <!-- GETS INJECTED VIA blog.js javascript -->
                    <div class="tag tag-hidden">
                        <div class='tag-text'>Filter tag</div>
                        <img src="<?php echo get_stylesheet_directory_uri().'/src/img/close.svg'?>"></img>
                    </div>
                </div>


        </div>
        <div class="loader"></div>

<?php 
    $event = new WP_Query([
        'post_type'      => 'event',
        'posts_per_page' => -1,
        'meta_key' => 'start_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'post_status'    => ['publish'],
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'start_date',
                'value' => date("Y-m-d"),
                'compare' => '>=',
                'type' => 'DATE'
            ),
            array(
                'key' => 'end_date',
                'value' => date("Y-m-d"),
                'compare' => '>=',
                'type' => 'DATE'
            )
        ), 

    ]);
    
     ?>
     <?php if ($event->have_posts()) { ?>
        <div class="list events-list">
        <div class="row">
 				<?php 
				while ($event->have_posts()) { 
					$event->the_post(); 
					$cat_as_text = get_the_term_list($event->ID, 'event_cat', '', ', ', '');
					$category = strip_tags($cat_as_text);
					$category_class = strtolower(str_replace(" ", "-", $category));
                    $end_date = get_field('end_date');
                    $start_date = strtolower(date('F j', strtotime(get_field('start_date', $event->ID))));
                    $location = get_field('location');
                    $tags = get_the_terms($event->ID, 'event_cat');                    
					?>
            <div class="col-lg-6 col-md-6 col-sm-12" style="padding-left: 10px; padding-right: 10px;">
                <div class="card cardv2">
                    <div class="image-wrap">
                        <?php if ( has_post_thumbnail() ) { ?>
                            <img src="<?php echo get_the_post_thumbnail_url($event->ID); ?>" alt="">
                        <?php }else{ ?>
                            <img src="/wp-content/uploads/2022/04/Event-default-image.jpg" alt="">
                        <?php } ?>
                    </div>
                    <div class="tranding-wrap" data-mh="tranding-wrap">
                     
                    </div> 
                    <div class="text-wrap">
                        <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span class="excerpt"><?php the_excerpt(); ?></span>
                        <div class="date-location">
                            <span class="date"><?php echo $start_date; ?> - <?php echo $end_date; ?></span>
                            <span class="location"><?php echo $location; ?></span>
                        </div>
                        <div class="cat-tags">
							<?php if ($tags) { ?>
								<div class="tags-container">
									<?php foreach($tags as $tag) { 
										$name = $tag->name;
										$term_id = $tag->slug;
										?>
										<div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>"><?php echo $name ?></div>
									<?php } ?>
								</div>
							<?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
<?php

    if ($event->current_post === 1) { ?>
    <div class="col-lg-12 col-md-2 col-sm-12 image-banner"> 
        <?php if(isset($first_promo_banner_link) && !empty($first_promo_banner_link)){ ?> 
            <a href="<?php echo $first_promo_banner_link; ?>" target="<?php echo $first_promo_banner_target; ?>">
                <img style="margin-bottom: 40px" src="<?php echo $first_promo_banner; ?>" alt="">
            </a>    
        <?php }else{ ?>
            <img style="margin-bottom: 40px" src="<?php echo $first_promo_banner; ?>" alt="">
        <?php }  ?>
    </div>  
<?php 
    } ?>
<?php
    if ($event->current_post === 3) { ?>
    <div class="col-lg-12 col-md-2 col-sm-12 image-banner">
        <?php if(isset($second_promo_banner_link) && !empty($second_promo_banner_link)){ ?> 
            <a href="<?php echo $second_promo_banner_link; ?>" target="<?php echo $second_promo_banner_target; ?>">
                <img style="margin-bottom: 40px" src="<?php echo $second_promo_banner; ?>" alt="">
            </a>    
        <?php }else{ ?>
            <img style="margin-bottom: 40px" src="<?php echo $second_promo_banner; ?>" alt="">
        <?php }  ?>
    </div>  
      <?php 
    } ?>
            <?php }	?>

        </div>
        <?php }
				wp_reset_postdata(); ?>	
        </div>


 

 
    </div>
</section>

</main>

<?php get_footer(); ?>
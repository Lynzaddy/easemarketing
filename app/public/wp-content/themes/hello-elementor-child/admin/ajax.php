<?php

/**************************************/
/************* Marketplace **************/
/**************************************/
add_action('wp_ajax_load_marketplace', 'load_marketplace');
add_action('wp_ajax_nopriv_load_marketplace', 'load_marketplace'); 

function load_marketplace()
{
    $args = [
        'post_type'      => 'partner',
        'posts_per_page' => -1,
        'orderby' => 'title', 
        'order' => 'ASC',
    ];

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $args['s'] = $_POST['keyword'];
    }

    // if (isset($_POST['marketplaceCat']) && !empty($_POST['marketplaceCat'])) {
    //     $args['tax_query'][] = [
    //         'relation' => 'OR',
    //         array(
    //             'taxonomy' => 'partner_types',
    //             'field'    => 'slug',
    //             'terms'    => $_POST['marketplaceCat'],
    //         ),
    //         // array(
    //         //     'taxonomy' => 'benefit_types',
    //         //     'field'    => 'slug',
    //         //     'terms'    => $_POST['marketplaceCat'],
    //         // ),

    //     ];
    // }     

    if (isset($_POST['tags']) && !empty($_POST['tags'])) {
        $array = $_POST['tags'];
        
        $all_ids = array();

        // $partner_ids = array();
        // $benefits_ids = array();

        // print_r($array);

        foreach ($array as $key => $value) {

            $tax = $value['taxonomy'];
            $tag = $value['tag'];

            // print_r($value);
            // print_r('key'. $key);

            if ($tax == 'partner_types') {
                $all_ids[] = $tag;
            }

            if ($tax == 'benefit_types') {
                $all_ids[] = $tag;
            }
        }

        // print_r($partner_ids);
        // print_r($benefits_ids);

        // $args['tag__in'] = $tag_ids;
        // $args['tax_query'] = [
        //     [
        //         'taxonomy'  => 'partner_types',
        //         'field'     => 'slug',
        //         'terms'     =>  $tag_ids,
        //     ]
        // ];

        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'partner_types',
                'field'    => 'slug',
                'terms'    => $all_ids,
            ),
            array(
                'taxonomy' => 'benefit_types',
                'field'    => 'slug',
                'terms'    => $all_ids,
            ),
        );
        
    }


    $result = new WP_Query($args);

    if ($result->have_posts()) :

    ?>
        <div class="marketplace-list">
            <div class="row">
                <?php 
                while ($result->have_posts()) : $result->the_post();
                    $id = get_the_ID();
                    // $cat_as_text = get_the_term_list($id, 'marketplace_cat', '', ', ', '');
                    // $category = strip_tags($cat_as_text);
                    // $category_class = strtolower(str_replace(" ", "-", $category));
                    // $tags = get_the_terms($marketplace->ID, 'partner_types');
                   // $tags = get_the_terms($marketplace->ID, array('partner_types', 'benefit_types'));

                    $tags1 = get_the_terms($result->ID, 'partner_types');
                    $tags2 = get_the_terms($result->ID, 'benefit_types');
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="image-wrap">
                                <img src="<?php echo get_the_post_thumbnail_url($id); ?>" alt="">
                            </div>
                            <div class="text-wrap">
                                <h3><a href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
                                <span class="excerpt"><?php the_excerpt($id); ?></span>
                                <div class="cat-tags">

                                    <?php if ($tags1 || $tags2) { ?>
                                        <div class="tags-container">
                                            <?php foreach($tags1 as $tag) { 
                                                $name = $tag->name;
                                                $term_id = $tag->slug;
                                                $taxonomy = $tag->taxonomy;
                                                ?>
                                                <div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>" data-taxonomy="<?php echo $taxonomy ?>"><?php echo $name ?></div>
                                            <?php } ?>
                                            <?php foreach($tags2 as $tag) { 
                                                $name = $tag->name;
                                                $term_id = $tag->slug;
                                                $taxonomy = $tag->taxonomy;
                                                ?>
                                                <div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>" data-taxonomy="<?php echo $taxonomy ?>"><?php echo $name ?></div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?> 


                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endwhile; ?>
            </div>
        </div>
    <?php
        wp_reset_postdata();
    endif;
    wp_die();
}

/**************************************/
/************* Events **************/
/**************************************/
add_action('wp_ajax_load_event', 'load_event');
add_action('wp_ajax_nopriv_load_event', 'load_event');

function load_event()
{
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

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $args['s'] = $_POST['keyword'];
    }

    if (isset($_POST['eventCat']) && !empty($_POST['eventCat'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'event_cat',
            'field'    => 'slug',
            'terms'    => $_POST['eventCat']
        ];
    }


    if (isset($_POST['tags']) && !empty($_POST['tags'])) {
        $array = $_POST['tags'];
        $tag_ids = array();
        foreach ($array as $key => $value) {
            $tag_ids[] = $value;
        }
        // $args['tag__in'] = $tag_ids;
        $args['tax_query'] = [
            [
                'taxonomy'  => 'event_cat',
                'field'     => 'slug',
                'terms'     =>  $tag_ids,
            ]
        ];
        
    }

    $result = new WP_Query($args);

    if ($result->have_posts()) :

    ?>
        <div class="events-list">
            <div class="row">
                <?php
                while ($result->have_posts()) : $result->the_post();
                    $id = get_the_ID();
                    $cat_as_text = get_the_term_list($id, 'event_cat', '', ', ', '');
                    $category = strip_tags($cat_as_text);
                    $category_class = strtolower(str_replace(" ", "-", $category));
                    $end_date = get_field('end_date');
                    $start_date = strtoupper(date('F j', strtotime(get_field('start_date', $id))));
                    $location = get_field('location');
                    $tags = get_the_terms($result->ID, 'event_cat');
                ?>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card cardv2">
                            <div class="image-wrap">
                                <?php if (has_post_thumbnail( $result->ID ) ){ ?>
                                <img src="<?php echo get_the_post_thumbnail_url($result->ID); ?>" alt="">
                                <?php }else{ ?>
                                <img src="<?php echo DIST; ?>/img/Event-default-image.jpg" alt="">
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
                endwhile; ?>
            </div>
        </div>
    <?php
        wp_reset_postdata();
    endif;
    wp_die();
}


add_action('wp_ajax_load_blogs', 'load_blogs');
add_action('wp_ajax_nopriv_load_blogs', 'load_blogs');

function load_blogs()
{

    $paged = $_POST['pg'];
    $args = [
        'post_type'      => 'post',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    ];

    $args['posts_per_page'] = (isset($_POST['posts_per_page']) && !empty($_POST['posts_per_page'])) ? $_POST['posts_per_page'] : -1;

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $args['s'] = $_POST['keyword'];
    }

    if (isset($_POST['categories']) && !empty($_POST['categories'])) {
        $List = implode(', ', $_POST['categories']);
        $args['category_name'] = $List;
    }

    if (isset($_POST['tags']) && !empty($_POST['tags'])) {
        $array = $_POST['tags'];
        $tag_ids = array();
        foreach ($array as $key => $value) {
            $tag_ids[] = $value;
        }
        // $args['tag__in'] = $tag_ids;
        $args['tax_query'] = [
            [
                'taxonomy'  => 'post_tag',
                'field'     => 'slug',
                'terms'     =>  $tag_ids,
            ]
        ];
        
    }

    $blog_page_id = get_option('page_for_posts');
    $promo_banners = get_field('promo_banners', $blog_page_id);
    $promo_banners_array = $promo_banners['promo_banner'];

    $promo_banner_two = $promo_banners_array[1];
    $promo_banner_two_image = $promo_banner_two['banner_image'];

    $result = new WP_Query($args);

    if ($result->have_posts()) :

    ?>

        <div>
            <?php
            $x = 0;

            while ($result->have_posts()) {

                $x++;

                if ($x == 3) {
                    $x = 4;
                }

                $result->the_post();
                $ID = get_the_ID();
                $post_link = get_permalink();
                $thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id($ID), 'large');
                $title = get_the_title();
                $author = get_the_author();
                $date = get_the_date();
                $tags = get_the_tags();

                $trending_post_content = get_field('post_section');
                $trending_post = $trending_post_content['trending_post'];
            ?>
                <article class="post" style="order: <?php echo $x; ?>">

                    <div <div style='background-image: url(<?php if (!empty($thumbnail)) {
                                                                echo $thumbnail;
                                                            } else {
                                                                echo get_stylesheet_directory_uri() . '/src/img/placeholder.png';
                                                            } ?>)' class="background-image"></div>

                    <?php if ($trending_post == 'yes') { ?>

                        <div class="trending">TRENDING BLOG POST</div>

                    <?php } else { ?>

                        <div class="trending-empty"></div>

                    <?php } ?>

                    <div class="content-container">

                        <div>
                            <h2 class="heading"><a href="<?php echo $post_link; ?>"><?php echo $title; ?></a></h2>
                            <?php echo '<p class="the-excerpt">' . get_the_excerpt() . '</p>' ?>
                        </div>

                        <div>
                            <div class="icon-container">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/src/img/usericon.svg' ?>"></img>
                                <div><?php echo $author; ?></div>
                            </div>

                            <div class="icon-container">
                                <img src="<?php echo get_stylesheet_directory_uri() . '/src/img/dateicon.svg' ?>"></img>
                                <div><?php echo $date; ?></div>
                            </div>

                            <?php if ($tags) { ?>
                                <div class="tags-container">
                                    <?php foreach ($tags as $tag) {
                                        $name = $tag->name;
                                        $term_id = $tag->slug;
                                    ?>
                                        <div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>"><?php echo $name ?></div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </article>
            <?php } ?>
            <!-- $_POST['categories'] == 'reset' -->
            <?php if (!empty($promo_banner_two_image)  && empty($_POST['keyword']) && empty($_POST['categories']) && empty($_POST['tags'])) { ?>
                <img src="<?php echo $promo_banner_two_image ?>" class="banner-image-two" style="order: 3;"></img>
            <?php } ?>

            <div class='pagination-container' style="order: <?php echo $x + 1; ?>">
                <?php
                $GLOBALS['wp_query']->max_num_pages = $result->max_num_pages;
                $icon = get_stylesheet_directory_uri() . '/src/img/rightarrow.svg';
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => __("<img src='$icon'></img>", 'textdomain'),
                    'next_text' => __("<img src='$icon'></img>", 'textdomain'),
                ));
                ?>
            </div>
        </div>
    <?php
        wp_reset_postdata();
    endif;
    wp_die();
}

/******************* Relevant  Marketplace Posts *********************/

function marketplace_related_posts_callback($title = 'Related Posts')
{
    ob_start();
    ?>
    <section class="related-posts-section related-market-place">
        <div class="container">
            <div class="row">
                <?php
                $terms = get_the_terms($post->ID, 'marketplace_cat', 'string');
                $term_ids = wp_list_pluck($terms, 'term_id');

                $my_query = new WP_Query(array(
                    'post_type' => 'marketplace',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'marketplace_cat',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator' => 'IN' //Or 'AND' or 'NOT IN'
                        )
                    ),
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'rand',
                    'post__not_in' => array($post->ID)
                ));


                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    $id = get_the_ID();
                ?>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card cardv2">
                            <div class="image-wrap">
                                <img src="<?php echo get_the_post_thumbnail_url($id); ?>" alt="">
                            </div>
                            <div class="text-wrap">
                                <h3><a href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
                                <span class="excerpt"><?php the_excerpt($id); ?></span>
                            </div>
                        </div>
                    </div>



                <?php } ?>

            </div>
        </div>
    </section>

    <?php wp_reset_query();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}


/******************* Relevant  Events Posts *********************/

function event_related_posts_callback($title = 'Related Posts')
{
    ob_start();
    ?>
    <section class="related-posts-section">
        <div class="container">
            <div class="row">
                <?php
                $terms = get_the_terms($post->ID, 'event_cat', 'string');
                $term_ids = wp_list_pluck($terms, 'term_id');

                $my_query = new WP_Query(array(
                    'post_type' => 'event',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'event_cat',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator' => 'IN' //Or 'AND' or 'NOT IN'
                        )
                    ),
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'rand',
                    'post__not_in' => array($post->ID)
                ));


                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    $id = get_the_ID();
                ?>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card cardv2">
                            <div class="image-wrap">
                                <?php if ( has_post_thumbnail($id) ) { ?>
                                    <img src="<?php echo get_the_post_thumbnail_url($id); ?>" alt="">
                                <?php }else{ ?>
                                    <img src="/wp-content/uploads/2022/04/Event-default-image.jpg" alt="">
                                <?php } ?>
                            </div>
                            <div class="text-wrap">
                                <h3 data-mh="related-event-title"><a href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
                                <span class="excerpt" data-mh="related-event-excerpt"><?php the_excerpt($id); ?></span>
                                <?php echo get_the_term_list($event->ID, 'event_cat', '<div class="cat-tags"  data-mh="related-event-tags"><span>', '</span><span>', '</span></div>'); ?>
                            </div>
                        </div>
                    </div>



                <?php } ?>

            </div>
        </div>
    </section>

    <?php wp_reset_query();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

?>
<?php /******************* Relevant Posts *********************/ ?>
<?php

function blog_related_posts_callback($title = 'Related Posts')
{
    global $post;
    $post_tags = wp_get_post_tags($post->ID);
    ob_start();
    ?>

    <section class="related-posts-section">
        <div class="container">
            <div class="row">
                <?php
                $tag_ids = array();
                foreach ($post_tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                $args1 = array(
                    'tag__in' => $tag_ids,
                    //  'post__not_in' => array($postid),
                    'posts_per_page' => 3, // Number of related posts to display.
                    'ignore_sticky_posts' => 1
                );

                $args2 = array(
                    'posts_per_page' => 3, // Number of related posts to display.
                    'orderby' => 'rand',
                    'order'    => 'ASC',
                    'ignore_sticky_posts' => 1
                );
                $my_query = new wp_query($args1);

                // $my_query = get_posts( $args_1 );
                if (empty($my_query)) {
                    $my_query = new wp_query($args2);
                }
                while ($my_query->have_posts()) {
                    $my_query->the_post();
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card cardv2">
                            <div class="image-wrap">
                                <img src="<?php echo get_the_post_thumbnail_url($id); ?>" alt="">
                            </div>
                            <div class="text-wrap">
                                <h3><a href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_title($id); ?></a></h3>
                                <span class="excerpt"><?php the_excerpt($id); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </section>

    <?php wp_reset_query();
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/******************* Relevant Posts *********************/

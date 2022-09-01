
<?php 
global $post;

    if($post_type == 'event'){
        $tax = 'event_cat';
    }else{
        $tax = 'category';    
    }

    if($taxID != ''){
        $tax_id = explode(",", $taxID);
    }else{
        $tax_id = get_terms( $tax, array(
            'hide_empty' => 0,
            'fields' => 'ids'
        ) );
    }
   
    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => 3,
        'post_status'    => ['publish'],
       
        'tax_query' => array(
            array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => $tax_id,
            ),
        ), 
    ];

    
    if($tagID != ''){
        $tag_id = explode(",", $tagID);
        $args['tag__in'] = $tag_id;
    }

    if($postID != ''){
        $post_id = explode(",", $postID);
        $args['post__in'] = $post_id;
    }else{}


    if($post_type == 'event'){
        $args['meta_key'] = 'start_date';
        $args['meta_query'][] = [
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
            ];
    }

    $content = new WP_Query($args);

     if ($content->have_posts()) { 
              
         ?>
<section class="related-content-component">
    <div class="container">
        <div class="row">

        <?php  
        while ($content->have_posts()) {  
            $content->the_post(); 
            // $cat_as_text = get_the_term_list($content->ID, 'event_cat', '', ', ', '');
            // $category = strip_tags($cat_as_text);
            // $category_class = strtolower(str_replace(" ", "-", $category));

            $excerpt = get_the_excerpt(); 
            $excerpt = substr( $excerpt, 0, $excer_limit );
            $result = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
            
           
            ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card cardv2">
                    <?php    if($thumbnail_image_condition == 'show'){
                        $thumb = get_the_post_thumbnail_url($content->ID);
                        $thumb = empty($thumb) ? "/wp-content/uploads/2022/06/Screen-Shot-2022-04-21-at-11.39.58-AM.png" : $thumb;
                        
                    ?>
                    <div class="image-wrap">
                        <img src="<?php echo $thumb ?>" alt="">
                    </div>
                    <?php }else{} ?>
                    <div class="text-wrap" style="background-color: <?php echo $card_color; ?>">
                        <h3 data-mh="title"><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span class="excerpt" data-mh="excerpt"><?php echo $result; ?>[…]</span>
                        <?php if($tags_condition == 'show'){ ?>
                        <?php if($post_type == 'event'){ ?>
                        <?php echo get_the_term_list( $content->ID, 'event_cat', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' ); ?>
                        <?php }else{ ?>
                            <?php echo get_the_term_list( $content->ID, 'category', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' ); ?>
                        <?php } ?>
                        <?php }else{} ?>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div> 
    </div> 
</section> 
        <?php } wp_reset_postdata(); ?>	


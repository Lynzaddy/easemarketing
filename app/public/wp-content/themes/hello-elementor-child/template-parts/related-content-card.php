
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

    $content = new WP_Query([
        'post_type'      => $post_type,
        'posts_per_page' => 1,
        'post_status'    => ['publish'],
        'tax_query' => array(
            array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => $tax_id,
            ),
        ),        
    ]);

     if ($content->have_posts()) { 
              
         ?>
<div class="related-content-card-component">
        <?php  
        while ($content->have_posts()) {  
            $content->the_post(); 
            $excerpt = get_the_excerpt(); 
            $excerpt = substr( $excerpt, 0, $excer_limit );
            $result = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );

            $end_date = get_field('end_date');
            $start_date = strtoupper(date('F j', strtotime(get_field('start_date', $content->ID))));
            $location = get_field('location');            
       ?>
                <div class="card cardv2">
                    <?php 
                    
                    if($thumbnail_image_condition == 'show'){
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
                        <?php if($post_type == 'event'){ ?>
                            <div class="date-location">
                                <span class="date"><?php echo $start_date; ?> - <?php echo $end_date; ?></span>
                                <span class="location"><?php echo $location; ?></span>
                            </div>
                        <?php } ?>
                        <?php if($tags_condition == 'show'){ ?>
                        <?php if($post_type == 'event'){ ?>
                        <?php echo get_the_term_list( $content->ID, 'event_cat', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' ); ?>
                        <?php }else{ ?>
                            <?php echo get_the_term_list( $content->ID, 'category', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' ); ?>
                        <?php } ?>
                        <?php }else{} ?>
                    </div>
                </div>
            <?php } ?>

</div> 
        <?php } wp_reset_postdata(); ?>	


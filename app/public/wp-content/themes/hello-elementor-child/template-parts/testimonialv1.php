
<?php 

    $ids = explode(",", $postIDs);

    $testimonial = new WP_Query([
        'post_type'      => 'testimonials',
        'posts_per_page' => -1,
        'post__in' => $ids,
    ]);

     if ($testimonial->have_posts()) { 
              
         ?>
        <div class="testimonial-with-thumbnail testimonial-row">
            <div class="testimonial-col headshot-col">
                <div class="tabs-nav quote-author-slider">

 			
                    <div class="headshot-slide">
                        <a>
                            <img src="<?php echo get_stylesheet_directory_uri().'/src/img/testimonials/1.png'?>">
                        </a>
                    </div>

                    <div class="headshot-slide">
                        <a>
                            <img src="<?php echo get_stylesheet_directory_uri().'/src/img/testimonials/2.png'?>">
                        </a>
                    </div> 
                    <div class="headshot-slide">
                        <a>
                            <img src="<?php echo get_stylesheet_directory_uri().'/src/img/testimonials/3.png'?>">
                        </a>
                    </div>  
                    <div class="headshot-slide">
                        <a>
                            <img src="<?php echo get_stylesheet_directory_uri().'/src/img/testimonials/4.png'?>">
                        </a>
                    </div>  <div class="headshot-slide">
                        <a>
                            <img src="<?php echo get_stylesheet_directory_uri().'/src/img/testimonials/5.png'?>">
                        </a>
                    </div>
            
                </div>
 
            </div>  
            <div class="testimonial-col dot-col">
               
                <div class="tabs-nav dots-wrap"> 

 				<?php 
                 $s=0;
				while ($testimonial->have_posts()) { 
					$testimonial->the_post(); 
                    $s++;
					?>
                    <div class="dot-slide">
                        <a href="#tab<?php echo $s; ?>">
                            <?php echo $s; ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>            

            </div>

            <div class="testimonial-col quote-col"> 
                <div class="quote-slider" id="tabs-content">
 				<?php 
                 $x=0;
				while ($testimonial->have_posts()) { 
					$testimonial->the_post(); 
                    $quote = get_field('quote');
                    $author = get_field('author');
                    $x++;
					?>                    
                    <div class="quote-slide tab-content" id="tab<?php echo $x; ?>">
                        <div class="quote-wrap">
                            <span class="quote">
                                <?php echo $quote; ?>”
                                
                            </span>
                            <span class="quote-author">- <?php echo $author; ?></span>
                        </div>
                    </div>
                    <?php } ?> 
                </div>
            </div>
        </div>
        <?php } wp_reset_postdata(); ?>	


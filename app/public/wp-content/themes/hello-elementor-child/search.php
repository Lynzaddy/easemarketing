<?php	 get_header(); ?>

<main class='blog-inside container'>
  <?php
    $s=get_search_query();
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        's' =>$s,
        'posts_per_page' => 6,
        'order'          => 'DESC',
        'paged'          => $paged,
        'orderby'=> 'date', 
    );
        // The Query
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
          _e("<h2>Search Results for: ".get_query_var('s')."</h2>");
          while ( $the_query->have_posts() ) {
            $the_query->the_post();
                  ?>
              <div class='search-result-container'>           
                <h3>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <!-- <div><?php the_date();?></div> -->
                <h4><?php the_excerpt();?></h4>
              </div>
            <?php
          }
      ?> 
      	<div class="pagination">
          <div class='newer'><?php previous_posts_link( '← newer' ); ?></div>
          <div class='older'><?php next_posts_link( 'older →' ); ?></div>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php
      }else{
  ?>
    <?php _e("<h2>Search Results for: ".get_query_var('s')."</h2>");?>
    <p>It seems we can't find what you're looking for.</p>
  <?php } ?>

</main>

<?php get_footer(); ?>
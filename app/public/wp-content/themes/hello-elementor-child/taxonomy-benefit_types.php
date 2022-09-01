<?php get_header();

//   $paged = get_query_var('paged');
//   $paged = $paged ? $paged : 1;
?> 
<main class="page-template-marketplace aaaaaa">

<section class="listing-section">
    <div class="container">
        <?php if (have_posts()) { ?>
        <div class="row">

				<?php 
				while (have_posts()) { 
					the_post(); 
                    global $post;
					// $cat_as_text = get_the_term_list($p->ID, 'marketplace_cat', '', ', ', '');
					// $category = strip_tags($cat_as_text);
					// $category_class = strtolower(str_replace(" ", "-", $category));
					?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card">
                    <div class="image-wrap">
                        <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>" alt="">
                    </div>
                    <div class="text-wrap">
                        <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <span class="excerpt"><?php the_excerpt(); ?></span>
                        
                            <?php echo get_the_term_list( $post->ID, 'benefit_types', '<div class="cat-tags"><span>', '</span><span>', '</span></div>' ); ?>
                        
                    </div>
                </div>
            </div>
            <?php }	?>

        </div>
        <?php } ?>	
    </div>
</section>

</main>
<?php get_footer(); ?>
<?php 
	global $post;

	$ids = explode(",", $postIDs);
	$testimonials_args  = array( 
		'post_type' => 'testimonials',
		'posts_per_page' => -1,
        'post__in' => $ids,
	);
	$testimonials_posts = get_posts($testimonials_args); 
?>
<?php if ($testimonials_posts) { ?>
<section class="flip-slider-section">
	<div class="flipster">
		<ul class="flip-items">
			<?php
				foreach ($testimonials_posts as $post) {
				setup_postdata($post);
				$quote = get_field('quote', $post->ID);
				$author = get_field('author', $post->ID);
			?>	
			<li>
				<div class="flip-wrap">
					<div class="text-wrap">
						<?php if( $quote != '') { ?><p>“<?php echo $quote; ?>” </p><?php } ?>
						<?php if( $author != '') { ?><p class="author">- <?php echo $author; ?></p><?php } ?>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</section>

<!-- <script>
	setTimeout(() => {
		jQuery('.flip-items').flipster({
			touch: true
		});
	}, 1000);
</script> -->

<?php	} else {}	wp_reset_postdata(); ?> 
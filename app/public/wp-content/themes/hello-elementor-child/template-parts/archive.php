
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
            <span class="breadcrumb_item active">Blog</span>
        </div>
    </div>
</div>
<main id="content" class="blog-template" role="main">

	<div class="container" id='main-blog-container'>

		<?php
			// Grabbing fields from blog page since elementor overwrites default blog page with this archive page.
			$blog_page_id = get_option( 'page_for_posts' );
			$featured_blog = get_field('featured_blog', $blog_page_id);
			$featured_post = $featured_blog['featured_post'][0];
			$ID = $featured_post->ID;
			$title = $featured_post->post_title;
			$author_id = $featured_post->post_author;
			$author_name = get_the_author_meta( 'display_name', $author_id );
			$date = get_the_date( 'M j, Y', $ID );
			$thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id($ID), 'large');
			$tags = get_the_tags($ID);
			// $link = get_page_link($ID);
			$post_name = $featured_post->post_name;
			$exerpt = $featured_post->post_excerpt;

			$promo_banners = get_field('promo_banners', $blog_page_id);
			$promo_banners_array = $promo_banners['promo_banner'];
			$promo_banner_one = $promo_banners_array[0];
			$promo_banner_one_image = $promo_banner_one['banner_image'];
			$promo_banner_one_link = $promo_banner_one['promo_banner_link'];
			$promo_banner_one_target = $promo_banner_one['promo_banner_target'];

			$promo_banner_two = $promo_banners_array[1];
			$promo_banner_two_image = $promo_banner_two['banner_image'];
			$promo_banner_two_link = $promo_banner_two['promo_banner_link'];
			$promo_banner_two_target = $promo_banner_two['promo_banner_target'];
		?>

		<div class='featured-post-container'>

			<div style='background-image: url(<?php echo $thumbnail; ?>)' class="background-image"></div>

			<div class='content-container'>
				
				<div>
					<h2 class="heading"><a href="<?php echo $post_name;?>"><?php echo $title;?></a></h2>
					<div class='the-excerpt'><?php echo $exerpt; ?></div>
				</div>

				<div>
					<div class="icon-main-container">
						<div class="icon-container">
							<img src="<?php echo get_stylesheet_directory_uri().'/src/img/usericon.svg'?>"></img>
							<div><?php echo $author_name; ?></div>
						</div>
		
						<div class="icon-container">
							<img src="<?php echo get_stylesheet_directory_uri().'/src/img/dateicon.svg'?>"></img>
							<div><?php echo $date; ?></div>
						</div>
					</div>
	
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

		<div class="reset-filter-container reset-filter-hide">		
			<a class="back-link reset-button">&lt; Back to All Blogs</a>
		</div>

		<div class='filter-container'>	
			
			<!-- Search bar -->
			<div class="search-bar search-form-wrap search-main d-md-block">
				<form class="form-search">
						<input type="text" placeholder="Find posts">
						<button type="submit">
							<img src="<?php echo get_stylesheet_directory_uri().'/src/img/searchicon.svg'?>"></img>
						</button>
				</form>
			</div>
			<!-- Search bar end -->
			
			<!-- Filter bar -->
			<?php
				$category = get_categories([
					'type'       => 'post',
					'hide_empty' => true,
					'taxonomy'   => 'category',
				]);
			?>
			<div class="filter-bar">
				<div class="dropdown filter-dropdown" id="filtermarketplace">
						<button class="filter-button dropdown-toggle" type="button" id="filterDropdownType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Filter posts
						</button>
						<div class="dropdown-menu" aria-labelledby="filterDropdownType">
							<!-- <a class="dropdown-item reset-button" href="reset">Reset</a> -->
							<?php foreach ($category as $tax) : 
									$name = $tax->name;
									$slug = $tax->slug;
									?>
									<div class="checkbox-container">
										<label class="check-box-label" for="<?php echo $slug; ?>">
											<input type='checkbox' value='<?php echo $slug; ?>' class="checkbox" id="<?php echo $slug; ?>" data-name="<?php echo $name; ?>" />
											<span class="checkmark"></span>
										</label>
										<div class="dropdown-item-new"><?php echo $name; ?></div>
									</div>
							<?php endforeach; ?>
							<div class="filter-button-new">FILTER</div>
						</div>
				</div>
			</div>
			<!-- Filter bar end -->

		</div>

		<div class="filter-tag-container">
			<!-- GETS INJECTED VIA blog.js javascript -->
			<div class="tag tag-hidden">
				<div class='tag-text'>Filter tag</div>
				<img src="<?php echo get_stylesheet_directory_uri().'/src/img/close.svg'?>"></img>
			</div>
		</div>

		<?php  if (!empty($promo_banner_one_image)) { ?>
			<?php if(isset($promo_banner_one_link) && !empty($promo_banner_one_link)){ ?> 
				<a href="<?php echo $promo_banner_one_link; ?>" target="<?php echo $promo_banner_one_target; ?>">
					<img src="<?php echo $promo_banner_one_image ?>" class="banner-image-one"></img>
				</a>    
			<?php }else{ ?>
				<img src="<?php echo $promo_banner_one_image ?>" class="banner-image-one"></img>
			<?php }  ?>
		<?php } ?>

		<div class="loader"></div>

		<div class="card-container">
			<?php
				$x=0;
				while ( have_posts() ) {
					
					$x++;

					if ($x == 3) {
						$x = 4;
					}
					
					the_post();
					$post_link = get_permalink();
					$thumbnail = get_the_post_thumbnail_url( $post, 'large' );
					$title = get_the_title();
					$author = get_the_author();
					$date = get_the_date();
					$tags = get_the_tags();

					$post_field = get_field('post_section');
					$trending_post = $post_field['trending_post'];
			?>
				<article class="post" style="order: <?php echo $x; ?>">
					
					<div style='background-image: url(<?php if (!empty($thumbnail)) { echo $thumbnail; } else { echo get_stylesheet_directory_uri().'/src/img/placeholder.png'; } ?>)' class="background-image"></div>

					<?php if ($trending_post == 'yes') {?>

						<div class="trending">TRENDING BLOG POST</div>
					
					<?php } else { ?>
						
						<div class="trending-empty"></div>

					<?php } ?>

					<div class="content-container">

						<div>
							<h2 class="heading"><a href="<?php echo $post_link;?>"><?php echo $title;?></a></h2>
	
							<?php echo '<p class="the-excerpt">' . get_the_excerpt() . '</p>' ?>
						</div>

						<div>
							<div class="icon-container">
								<img src="<?php echo get_stylesheet_directory_uri().'/src/img/usericon.svg'?>"></img>
								<div><?php echo $author; ?></div>
							</div>
	
							<div class="icon-container">
								<img src="<?php echo get_stylesheet_directory_uri().'/src/img/dateicon.svg'?>"></img>
								<div><?php echo $date; ?></div>
							</div>
	
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

				</article>
			<?php } ?>
			
			<?php  if (!empty($promo_banner_two_image) && $x >= 4 ) { ?>
				<?php if(isset($promo_banner_two_link) && !empty($promo_banner_two_link)){ ?> 
					<a href="<?php echo $promo_banner_two_link; ?>" target="<?php echo $promo_banner_two_target; ?>" style="order: 3;">
						<img src="<?php echo $promo_banner_two_image ?>" class="banner-image-two" ></img>
					</a>    
				<?php }else{ ?>
					<img src="<?php echo $promo_banner_two_image ?>" class="banner-image-two" style="order: 3;"></img>
				<?php }  ?>				
			<?php } ?>
		
			<div class='pagination-container' style="order: <?php echo $x + 1;?>">
				<?php
					$icon = get_stylesheet_directory_uri().'/src/img/rightarrow.svg';
					the_posts_pagination( array(
						'mid_size' => 2,
						'prev_text' => __( "<img src='$icon'></img>", 'textdomain' ),
						'next_text' => __( "<img src='$icon'></img>", 'textdomain' ),
					));
				?>
			</div>
		</div>
	</div>
</main>

<style>
	.reset-filter-hide{
		display: none;
	}

</style>
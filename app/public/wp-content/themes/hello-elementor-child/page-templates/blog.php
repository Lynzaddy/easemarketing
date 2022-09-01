<?php

/** Template Name:  Blog template  */ 

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
            <span class="breadcrumb_item active">Blog</span>
        </div>
    </div>
</div>
<main id="content" class="blog-template" role="main">

<div class="container">

  <?php

    global $post;
    echo $post->ID;
    
    $featured_blog = get_field('featured_blog');
    $featured_post = $featured_blog['featured_post'];

    print_r($post);
    print_r($featured_post);
  ?>

  <div class="card-container">
    <?php
      while ( have_posts() ) {
        the_post();
        $post_link = get_permalink();
        $thumbnail = get_the_post_thumbnail_url( $post, 'large' ) || '/src/img/placeholder.png';
        $title = get_the_title();
        $author = get_the_author();
        $date = get_the_date();
        $tags = get_the_tags();

        $trending_post_content = get_field('trending_post_tab');
        $trending_post = $trending_post_content['trending_post'];
    ?>
      <article class="post">
        
        <div style='background-image: url(<?php echo $thumbnail;  ?>)' class="background-image"></div>

        <?php if ($trending_post == 'yes') {?>

          <div class="trending">TRENDING BLOG POST</div>
        
        <?php } else { ?>
          
          <div class="trending-empty"></div>

        <?php } ?>

        <div class="content-container">

          <h2 class="heading"><a href="<?php echo $post_link;?>"><?php echo $title;?></a></h2>

          <p><?php echo the_excerpt(); ?></p>

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
              <?php foreach($tags as $tag) { ?>
                <div class="tag"><?php echo $tag->name ?></div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>

      </article>
    <?php } ?>
  </div>
  <?php
    $icon = get_stylesheet_directory_uri().'/src/img/rightarrow.svg';
    the_posts_pagination( array(
      'mid_size' => 2,
      'prev_text' => __( "<img src='$icon'></img>", 'textdomain' ),
      'next_text' => __( "<img src='$icon'></img>", 'textdomain' ),
    ));
  ?>
</div>
</main>

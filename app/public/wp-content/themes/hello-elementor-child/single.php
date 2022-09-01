<?php	 get_header(); 

    global $post;
    $post_id = get_the_id();
    $post_type_name = get_post_type();
		$author_id = get_post_field('post_author');
		$background_image = get_the_post_thumbnail_url();
		$author_name = get_the_author_meta('display_name', $author_id);
    $newDate = get_the_date("F d, Y", $post_id );
    $tags = get_the_tags();

    $post_field = get_field('post_section');
    $related_post = get_field('show_related_post');
    $cta_text = $post_field['cta_text'];
    $cta_url = $post_field['cta_url'];
    $banner_image = $post_field['banner_image'];
    $promo_banner_link = $post_field['promo_banner_link'];
    $promo_banner_target = $post_field['promo_banner_target'];
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

<main class="blog-inside">

  <div class="container-top">
    <div class="container">
      <a class="back-link" href="/blog">< Back to All Blogs</a>
      <div class='featured-post-container'>
                
        <div class='content-container'>
          
          <div>
            <h1 class="heading"><?php the_title() ?></a></h1>
          </div>

          <div>
            <div class="icon-main-container">
              <div class="icon-container">
                <img src="<?php echo get_stylesheet_directory_uri().'/src/img/usericon.svg'?>"></img>
                <div><?php echo $author_name; ?></div>
              </div>
      
              <div class="icon-container">
                <img src="<?php echo get_stylesheet_directory_uri().'/src/img/dateicon.svg'?>"></img>
                <div><?php echo $newDate; ?></div>
              </div>
            </div>
    
            <?php if ($tags) { ?>
              <div class="tags-container">
                <?php foreach($tags as $tag) { 
                  $name = $tag->name;
                  $slug = $tag->slug;
                  ?>
                  <!-- <a class="tag" href="/blog/?name=<?php echo $slug; ?>&name=<?php echo $name?>" data-id="<?php echo $slug ?>" data-name="<?php echo $name ?>"><?php echo $name ?></a> -->
                  <a class="tag" href="/blog?tags=<?php echo $slug; ?>"><?php echo $name ?></a> 
                <?php } ?>
              </div>
            <?php } ?>
          </div>

        </div>

        <div style='background-image: url(<?php echo $background_image; ?>)' class="background-image"></div>

      </div>
    </div>
  </div>

  <div class="container container-bottom">
    <?php the_content(); ?>
  </div>

  <?php  if (!empty($cta_url) && !empty($cta_text) || !empty($banner_image)) { ?>
  <div class="container cta-and-banner-container">

    <?php  if (!empty($cta_url) && !empty($cta_text)) { ?>
      <div class="cta-button-container">
        <a class='cta-button' href="<?php echo $cta_url; ?>">
          <?php echo $cta_text; ?>
        </a>
      </div>
    <?php } ?>

    <?php  if (!empty($banner_image)) { ?>
      <?php if(isset($promo_banner_link) && !empty($promo_banner_link)){ ?> 
        <a href="<?php echo $promo_banner_link; ?>" target="<?php echo $promo_banner_target; ?>">
          <img src="<?php echo $banner_image ?>" class="banner-image"></img>
        </a>
        <?php }else{ ?>
          <img src="<?php echo $banner_image ?>" class="banner-image"></img> 
    <?php } } ?>

  </div>
  <?php } ?>

<?php 
if($related_post == 1){
echo blog_related_posts_callback();
}else{}
?>

</main>

<?php get_footer(); ?>
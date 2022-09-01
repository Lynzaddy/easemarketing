<?php get_header();
$image = get_the_post_thumbnail_url(); 
$bottom_banner = get_field('bottom_banner');
$promo_banner_link = get_field('promo_banner_link');
$promo_banner_target = get_field('promo_banner_target');
$button = get_field('button');
$is_form = get_field('is_form');
$form_heading = get_field('form_heading');
$form_text = get_field('form_text');
$single_post_form = get_field('single_post_form', 'option');
$single_post_form_from_posttype = get_field('single_post_form');


$related_post = get_field('show_related_post_section');
?> 


<?php 
    $main_page = get_field('main_page', 'options');
    $main_title = $main_page['main_title'];
    $sub_page = get_field('sub_page', 'options');
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
            <span class="breadcrumb_item active">Marketplace</span>
        </div>
    </div>
</div>

<main class="single-post">
<?php 
   global $post;

//  $tags = get_the_terms($post->ID, array('partner_types', 'benefit_types'));
    $tags1 = get_the_terms($post->ID, 'partner_types');
    $tags2 = get_the_terms($post->ID, 'benefit_types');
    ?>
<section class="hero-section">
    <div class="container">
        <a href="<?php echo HOME_URL; ?>/marketplace" class="back-to">< Back to Marketplace</a>
        <div class="row hero-row">
            <div class="col-lg-5 col-sm-12 hero-col">
                <h1><?php the_title(); ?></h1>
                <div class="cat-tags">            
                    <?php if ( $tags1 || $tags2 ) { ?>
                        <div class="tags-container">
                            <?php foreach($tags1 as $tag) { 
                                $name = $tag->name;
                                $term_id = $tag->slug;
                                $taxonomy = $tag->taxonomy;
                                ?>
                                <a class="tag" href="/marketplace?categories=<?php echo $term_id; ?>"><?php echo $name ?></a>
                            <?php } ?>

                            <?php foreach($tags2 as $tag) { 
                                $name = $tag->name;
                                $term_id = $tag->slug;
                                $taxonomy = $tag->taxonomy;
                                ?>
                                <a class="tag" href="/marketplace?categories=<?php echo $term_id; ?>"><?php echo $name ?></a>
                            <?php } ?>
                        </div>
                    <?php } ?> 
                </div>
            </div>
            <div class="col-lg-7 col-sm-12 hero-col">
                <div class="image-wrap">
                    <img style="margin: 48px 0" src="<?php echo $image; ?>" alt="">
                </div>            
            </div>
        </div>
     
    </div> 
</section>


<section class="single-post-content">
    <div class="container">
        <div class="row">
        <?php if($is_form == 1){ ?>
            <div class="col-lg-6 col-sm-12 hero-col">
                <?php the_content(); ?>
            </div>
            <div class="col-lg-6 col-sm-12 hero-col">
                <div class="form-wrap">
                    <?php if($form_heading != ''){ ?><h3><?php echo $form_heading; ?></h3><?php } ?>
                    <?php if($form_text != ''){ ?><p><?php echo $form_text; ?></p><?php } ?>
                    <?php if($single_post_form_from_posttype != ''){ ?>
                        <?php echo $single_post_form_from_posttype; ?>
                    <?php }else{ ?>
                        <?php echo $single_post_form; ?>
                    <?php } ?>
                </div>
            </div>
            <?php if($button['url'] != ''){ ?>
                <a href="<?php echo $button['url']; ?>" class="btn primary-btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
            <?php } ?>
                <?php if($bottom_banner != ''){ ?> 
                    <?php if(isset($promo_banner_link) && !empty($promo_banner_link)){ ?> 
                        <div class="bottom-banner">
                            <a href="<?php echo $promo_banner_link; ?>" target="<?php echo $promo_banner_target; ?>">
                                <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">
                            </a>    
                        </div>
                    <?php }else{ ?>
                        <div class="bottom-banner">
                            <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">  
                        </div>
                <?php } }  ?>

        <?php }else{ ?>
            <div class="col-lg-12 col-sm-12 hero-col">
                <?php the_content(); ?>
                
                <?php if($button['url'] != ''){ ?>
                <a href="<?php echo $button['url']; ?>" class="btn primary-btn" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
                <?php } ?>
                <?php if($bottom_banner != ''){ ?> 
                    <?php if(isset($promo_banner_link) && !empty($promo_banner_link)){ ?> 
                        <div class="bottom-banner">
                            <a href="<?php echo $promo_banner_link; ?>" target="<?php echo $promo_banner_target; ?>">
                                <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">
                            </a>    
                        </div>
                    <?php }else{ ?>
                        <div class="bottom-banner">
                            <img style="margin: 65px 0" src="<?php echo $bottom_banner; ?>" alt="">  
                        </div>
                <?php } }  ?>
            </div>
        <?php } ?>
    
        </div>

    </div>
</section>


<?php 
if($related_post == 1){
echo marketplace_related_posts_callback(); 
}else{}
?>
</main>

<?php get_footer(); ?>
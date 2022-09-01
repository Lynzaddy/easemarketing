<?php get_header();
/** Template Name:  Marketplaces Page Template  */

//   $paged = get_query_var('paged');
//   $paged = $paged ? $paged : 1;
?>
<?php
$main_page = get_field('main_page', 'options');
$main_title = $main_page['main_title'];
$sub_page = get_field('sub_page', 'options');
?>

<main class="page-template-marketplace">
    <?php
    $heading = get_field('heading');
    $sub_heading = get_field('sub_heading');
    $banner_image = get_field('banner_image');
    $promo_banner_link = get_field('promo_banner_link');
    $promo_banner_target = get_field('promo_banner_target');
    ?>
    <section class="hero-section">
        <div class="container">
            <?php echo ($heading) ? '<h1>' . $heading . '</h1>' : '<h1>' . get_the_title() . '</h1>';  ?>
            <div class="row hero-row">
                <div class="col-lg-5 col-sm-12 hero-col">
                    <div class="filter-container">
                        <div class="search-bar search-form-wrap search-main d-md-block">
                            <form class="form-search">
                                <input type="text" placeholder="Find a Partner">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24.211" height="25.203" viewBox="0 0 24.211 25.203">
                                        <g id="Group_263" data-name="Group 263" transform="translate(1 1)">
                                            <g id="Group_33" data-name="Group 33" transform="translate(0)">
                                                <path id="Path_85" data-name="Path 85" d="M220.778,293.546a8.984,8.984,0,1,1,2.768-2.768A8.889,8.889,0,0,1,220.778,293.546Z" transform="translate(-207 -277)" fill="none" stroke="#08a6a5" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" />
                                                <line id="Line_82" data-name="Line 82" x2="7.054" y2="7.054" transform="translate(14.742 15.735)" fill="none" stroke="#08a6a5" stroke-linecap="round" stroke-width="2" />
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <?php
                        $taxonomy = get_terms([
                            'taxonomy' => array('partner_types', 'benefit_types'),
                            'hide_empty' => true,
                        ]);

                        //Removes duplicates from array

                        $c_taxonomy = array();

                        foreach ($taxonomy as $term) {
                            $c_taxonomy[] = array('name' => $term->name, 'slug' => $term->slug);
                        }

                        $unique_taxonomy = array_unique($c_taxonomy, SORT_REGULAR);
                        ?>

                        <div class="filter-bar">
                            <div class="dropdown filter-dropdown" id="filtermarketplace">
                                <button class="filter-button dropdown-toggle" type="button" id="filterDropdownType" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter by Category
                                </button>
                                <div class="dropdown-menu" aria-labelledby="filterDropdownType">
                                    <div class='scroll-container'>
                                        <!-- <a class="dropdown-item reset-button" href="reset">Reset</a> -->
                                        <?php foreach ($unique_taxonomy as $tax) :
                                            $name = $tax['name'];
                                            $slug = $tax['slug'];
                                        ?>
                                            <div class="checkbox-container">
                                                <label class="check-box-label" for="<?php echo $slug; ?>">
                                                    <input type='checkbox' value='<?php echo $slug; ?>' class="checkbox" id="<?php echo $slug; ?>" data-name="<?php echo $name; ?>" />
                                                    <span class="checkmark"></span>
                                                </label>
                                                <div class="dropdown-item-new"><?php echo $name; ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="filter-button-new">FILTER</div>
                                </div>
                            </div>
                        </div>
                        <!-- Filter bar end -->
                    </div>

                </div>
                <div class="col-lg-7 col-sm-12 hero-col">
                    <?php echo ($sub_heading) ? '<p>' . $sub_heading . '</p>' : '';  ?>
                </div>
            </div>

            <div class="filter-tag-container">
                <!-- GETS INJECTED VIA blog.js javascript -->
                <div class="tag tag-hidden">
                    <div class='tag-text'>Filter tag</div>
                    <img src="<?php echo get_stylesheet_directory_uri() . '/src/img/close.svg' ?>"></img>
                </div>
            </div>

            <?php if ($banner_image != '') { ?>
                <?php if (isset($promo_banner_link) && !empty($promo_banner_link)) { ?>
                    <a href="<?php echo $promo_banner_link; ?>" target="<?php echo $promo_banner_target; ?>">
                        <img style="margin: 65px 0" src="<?php echo $banner_image; ?>" alt="">
                    </a>
                <?php } else { ?>
                    <img style="margin: 65px 0" src="<?php echo $banner_image; ?>" alt="">
            <?php }
            }  ?>
        </div>
    </section>

    <?php
    $marketplace = new WP_Query([
        'post_type'      => 'partner',
        'posts_per_page' => 999999,
        'orderby' => 'title',
        'order' => 'ASC',
    ]);
    ?>
    <section class="listing-section">
        <div class="loader"></div>
        <div class="container">
            <?php if ($marketplace->have_posts()) { ?>
                <div class="list marketplace-list">
                    <div class="row">

                        <?php
                        while ($marketplace->have_posts()) {
                            $marketplace->the_post();
                            $cat_as_text = get_the_term_list($marketplace->ID, 'partner_types', '', ', ', '');
                            $category = strip_tags($cat_as_text);
                            $category_class = strtolower(str_replace(" ", "-", $category));

                            $tags1 = get_the_terms($marketplace->ID, 'partner_types');
                            $tags2 = get_the_terms($marketplace->ID, 'benefit_types');
                            //                    $tags = get_the_terms($marketplace->ID, array('partner_types', 'benefit_types'));
                        ?>




                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="image-wrap">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                                    </div>
                                    <div class="text-wrap">
                                        <h3><a href="<?php echo get_the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <span class="excerpt"><?php the_excerpt(); ?></span>
                                        <div class="cat-tags">
                                            <?php if ($tags1 || $tags2) { ?>
                                                <div class="tags-container">
                                                    <?php foreach ($tags1 as $tag) {
                                                        $name = $tag->name;
                                                        $term_id = $tag->slug;
                                                        $taxonomy = $tag->taxonomy;
                                                    ?>
                                                        <div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>" data-taxonomy="<?php echo $taxonomy ?>"><?php echo $name ?></div>
                                                    <?php } ?>
                                                    <?php foreach ($tags2 as $tag) {
                                                        $name = $tag->name;
                                                        $term_id = $tag->slug;
                                                        $taxonomy = $tag->taxonomy;
                                                    ?>
                                                        <div class="tag" data-id="<?php echo $term_id ?>" data-name="<?php echo $name ?>" data-taxonomy="<?php echo $taxonomy ?>"><?php echo $name ?></div>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }    ?>

                    </div>
                <?php }
            wp_reset_postdata(); ?>
                </div>
        </div>
    </section>

</main>



<?php get_footer(); ?>
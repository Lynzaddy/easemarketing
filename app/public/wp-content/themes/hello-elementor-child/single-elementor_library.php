<?php	 get_header(); 
?>

<main class="">
  <div class="container">
    <h2 class="heading"><?php the_title() ?></a></h2>
    <?php the_content(); ?>
  </div>
</main>
<style>
  h2.heading{
    padding: 40px 0;
  }
</style>
<?php get_footer(); ?>
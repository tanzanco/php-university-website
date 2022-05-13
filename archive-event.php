<?php get_header();
pageBanner([
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world'
]);
?>

<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php // echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">All Events</h1> -->
        <!-- TRIED TO DO IT THE DIFFERENT WAY BY SELF -->

      <?php //if(is_category()){
            //single_cat_title();
        //}elseif(is_author()){
           //echo 'Posts by ' ; the_author();
        //} ?> 


      <!-- <div class="page-banner__intro">
        <p>See what is going on in our world</p> -->
        <!-- TRIED TO DO IT THE DIFFERENT WAY BY SELF -->
        <!-- <?php// if(is_category()){
        //     echo 'All posts of '; single_cat_title(); echo ' category';
        // }elseif(is_author()){
        //     echo 'All posts by '; the_author();
        // } ?>
      </div>
    </div>  
  </div> -->
  <div class="container container--narrow page-section">
    <?php
    while(have_posts()){
      the_post();
      get_template_part('template-parts/content', 'event');
        }    ?>
      <?php
      echo paginate_links();
      ?>
      <hr class="section-break">
      <p>Looking for the recap of all our past events? <a href="<?php echo site_url('/past_events') ?>">Check out our past event archive page</a></p>
  </div>

<?php get_footer();?>


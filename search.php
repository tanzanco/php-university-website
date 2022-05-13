<?php get_header();
pageBanner([
  'title' => 'Search Results',
  'subtitle' => 'You Searched For &ldquo;' . get_search_query() . '&rdquo;'
]);?>


  <div class="container container--narrow page-section">
    <?php
    if(have_posts()){
        while(have_posts()){
            the_post();
            get_template_part('template-parts/content', get_post_type());
        }   
        echo paginate_links();
            
    }else{
        echo '<h2 class="headline headline--small-plus">No Results Match That Search</h2>';
    }
    get_search_form();
    ?>
  </div>

<?php get_footer();?>


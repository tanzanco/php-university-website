<?php get_header();

  pageBanner([
    'title' => 'All Programs',
    'subtitle' => 'There something for everyone. have a look around'
  ]);?>

    <div class="container container--narrow page-section">
      <ul class="link-list min-list">
      <?php
      while(have_posts()){
        the_post();?>
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php  }    ?>
      </ul>
        <?php
        echo paginate_links();
        ?>
        <!-- <hr class="section-break">
        <p>Looking for the recap of all our past events? <a href="<?php echo site_url('/past_events') ?>">Check out our past event archive page</a></p> -->
    </div>

<?php get_footer();?>


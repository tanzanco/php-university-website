<?php get_header(); ?>
<?php

?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?>);"></div>
    <div class="page-banner__content container t-center c-white">
      <h1 class="headline headline--large">Welcome!</h1>
      <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
      <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
      <a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--large btn--blue">Find Your Major</a>
    </div>
  </div>

  <div class="full-width-split group">
    <div class="full-width-split__one">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
        <?php
        // $today = date('Ymd');
        $homePageEvents = new WP_Query([
          'posts_per_page' => 2,
          'post_type' => 'event',
          // 'meta_key' => 'event_date',
          // 'value' => 'value,
          'orderby' => 'title',
          'order' => 'ASC'
          //'meta_query' => [
            // 'key' => 'event_date',
            // 'compare' => '>=',
            // 'value' => $today, 
            // 'type' => numeric
         // ]
        ]);
        while($homePageEvents->have_posts()){
          $homePageEvents->the_post(); 
          get_template_part('template-parts/content', 'event');
          } ?>
        
        
        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View all events</a></p>

      </div>
    </div>
    <div class="full-width-split__two">
      <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
        <?php
        $homePagePost = new WP_Query([
            'posts_per_page' => 2,
        ]); 
        while($homePagePost->have_posts()){
            $homePagePost->the_post();?>
            <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php the_time('M'); ?></span>
            <span class="event-summary__day"><?php the_time('d'); ?></span>  
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php if(has_excerpt()){
              echo get_the_excerpt();
            }else{
              echo wp_trim_words(get_the_content(),18);
            } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
          </div>
        </div>
            <?php }  wp_reset_postdata(); ?>

        
        <p class="t-center no-margin"><a href="<?php echo site_url("/blog"); ?>" class="btn btn--yellow">View all blog posts</a></p>
      </div>
    </div>
  </div>

  <div class="hero-slider">
    <?php
    $slideshow = new WP_Query([
      'post_type' => 'slide',
      'posts_per_page' => '3'
    ]);
    while($slideshow->have_posts()){
      $slideshow->the_post(); ?>
      <div class="hero-slider__slide" style="background-image: url(<?php echo get_field('slide_image')['sizes']['pageBanner']; ?>);">
      <div class="hero-slider__interior container">
        <div class="hero-slider__overlay">
          <h2 class="headline headline--medium t-center"><?php echo get_field('slide_title');?></h2>
          <p class="t-center"><?php echo get_field('slide_subtitle');?></p>
          <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
        </div>
      </div>
    </div>

      <?php  } wp_reset_postdata(); ?>
  
  <!-- <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg'); ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">An Apple a Day</h2>
        <p class="t-center">Our dentistry program recommends eating apples.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
  <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg'); ?>);">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center">Free Food</h2>
        <p class="t-center">Fictional University offers lunch plans for those in need.</p>
        <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>-->
</div> 

  <!-- <div class="search-overlay">

    <div class="search-overlay__top">
      <div class="container">
        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="one-half">
          <div id="general-results"></div>
          <div id="program-results"></div>
        </div>
        <div class="one-half">
          <div id="professor-results"></div>
          <div id="campus-results"></div>
          <div id="event-results"></div>
        </div>
      </div>
    </div>
  </div> -->
<?php get_footer(); ?>

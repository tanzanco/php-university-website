<?php get_header();

  pageBanner([
    'title' => 'Our Campuses',
    'subtitle' => 'We have several convenient located campuses'
  ]);?>

    <div class="container container--narrow page-section">
      <ul class="link-list min-list">
      <?php
      while(have_posts()){
        the_post();
        // $mapLocation = get_field('map_location');
        ?>
        <!-- <div class="marker" data-lat="<?php //echo $mapLocation['lat']?>" data-lng="<?php //echo $mapLocation['lng']?>"><h3><a href="<?php // the_permalink(); ?>"><?php // the_title(); ?></a></h3> <?php // echo $mapLocation['address']; ?></div> -->
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d58759.69954607611!2d72.60371427724608!3d23.00609678438499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1642926836051!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        <?php  }    ?>
      </ul>
        
        <!-- <hr class="section-break">
        <p>Looking for the recap of all our past events? <a href="<?php echo site_url('/past_events') ?>">Check out our past event archive page</a></p> -->
    </div>

<?php get_footer();?>


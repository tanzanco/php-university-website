<?php get_header();?>
<?php
while(have_posts()){
    the_post();
    pageBanner();
    ?>
    

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses </a> <span class="metabox__main"><?php the_title(); ?></span></p></div> 
      <div class="generic-content">
      <?php the_content(); ?>
      </div>
      <div class="container container--narrow page-section">
      <ul class="link-list min-list">
      <?php
        the_post();
        // $mapLocation = get_field('map_location');
        ?>
        <!-- <div class="marker" data-lat="<?php //echo $mapLocation['lat']?>" data-lng="<?php //echo $mapLocation['lng']?>"><h3><?php // the_title(); ?></h3> <?php // echo $mapLocation['address']; ?></div> -->
          <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d58759.69954607611!2d72.60371427724608!3d23.00609678438499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1642926836051!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </ul>
      <?php
      $relatedPrograms = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'program',
        'orderby' => 'title',
        'order' => 'ASC',
        'meta_query' => [ 
          [
              'key' => 'related_campus',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"'
          ]
        ]
      ]);
      if($relatedPrograms->have_posts()){
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">Programs available at this campus <h2>';
          echo '<ul class="min-link list-link">';
          while($relatedPrograms->have_posts()){
            $relatedPrograms->the_post(); ?>
          <li >
            <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> 
            </a>
          </li>
          <?php } 
          echo '</ul>';
      }
      wp_reset_postdata();
        
        ?>
  </div>
<?php } ?>
<?php get_footer(); ?>


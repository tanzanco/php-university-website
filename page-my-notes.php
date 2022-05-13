<?php
if(!is_user_logged_in()){
    wp_redirect(esc_url(site_url('/')));
    exit;
}

?>
<?php get_header(); ?>
<?php
while(have_posts()){
    the_post();
    pageBanner();
    ?>
  <div class="container container--narrow page-section">
      <div class="create-note">
          <h2 class="headline headline--medium">Create New Note</h2>
          <input class="new-note-title" type="text" placeholder="Title">
          <textarea class="new-note-body" placeholder="Your note here"></textarea>
          <span class="submit-note">Create Note</span>
          <span class="note-limit-message ">Note Limit Reached : Delete An Existing Post To Make Room For The New Ones</span>

      </div>
      <ul class="link-list min-list" id="my-notes">
          <?php
          $userNotes = new WP_Query([
              'post_type' => 'note',
              'posts_per_page' => -1,
              'author' => get_current_user_id()
          ]);
          while($userNotes->have_posts()){
              $userNotes->the_post();?>
              <li data-id="<?php the_ID(); ?>">
                  <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>">
                  <span class="edit-note"><i class="fas fa-pencil" aria-hidden="true"></i>Edit</span>
                  <span class="delete-note"><i class="fas fa-trash-o" aria-hidden="true"></i>Delete</span>
                  <textarea readonly class="note-body-field" name="" id="" cols="30" rows="10"><?php echo esc_textarea(get_the_content()); //str_replace('<p></p>', '', esc_attr(get_the_content())); ?></textarea>
                  <span class="update-note btn btn--blue btn--small"><i class="fas fa-arrow-right" aria-hidden="true">Save</i></span>

              </li>


              <?php  } ?>
      </ul>
  </div>
<?php } ?>
<?php get_footer(); ?>


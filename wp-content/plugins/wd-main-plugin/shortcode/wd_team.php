<?php

if(!function_exists('wd_team_scode')){
  function wd_team_scode($atts) {
	  $show_description = $columns = $itemperpage = $team_collapse = "";
  	extract( shortcode_atts( array(
    'columns_mobile' => '1',
    'columns_tablet' => '2',
    'columns_desktop' => '3',
    'itemperpage' => '10',
    'team_style' => 'style_1',
    'css_animation' => 'no',
    'show_description' => 'yes',
    'team_collapse' => 'yes'
  ), $atts ) );

    $animation_classes =  "";
    $data_animated = "";
    if(($css_animation != 'no')){
      $animation_classes =  " animated ";
      $data_animated = "data-animated=$css_animation";
    }

    ob_start(); ?>

<?php
    if( $team_style == "style_2" ) { ?>
      <div class="team-list-style2 small-up-<?php echo esc_attr($columns_mobile); ?> large-up-<?php echo esc_attr($columns_desktop); ?> medium-up-<?php echo esc_attr($columns_tablet); ?> <?php if($team_collapse == "") echo "collapse"; ?>">
       <?php $loop = new WP_Query(array('post_type' => 'team-member', 'posts_per_page' => $itemperpage,));
    while ($loop->have_posts()) : $loop->the_post(); ?>
      <div
        class="<?php echo esc_attr($animation_classes); ?> column column-block" <?php echo esc_attr($data_animated); ?>>
        <div class="team-member">
          <div class="team-member__picture">
	          <?php
	          $image_url = get_post_meta(get_the_ID(), 'picture', true);
	          $image_url=image_from_url_relative($image_url);
	          $image_id = attachment_url_to_postid($image_url);

	          if ( $image_id != '' ) { ?>

		          <?php  print wp_get_attachment_image( $image_id, 'wd_team' );   ?>

	          <?php }
	          else { ?>
		          <?php 	the_post_thumbnail('wd_team') ; } ?>

          </div>
          <div class="team-member__info">
            <h5 class="team-member__name"><span><?php the_title(); ?></span></h5>
            <?php if (get_post_meta(get_the_ID(), 'job_title', true) != '') { ?>
              <p class="team-member__job"><span><?php echo get_post_meta(get_the_ID(), 'job_title', true); ?></span>
              </p>
            <?php } ?>
            <?php if ($team_style != 'style1') { ?>
              <p class="team-member__desc"><?php echo get_the_excerpt() ?></p>
            <?php } ?>
          </div>
          <?php
          if ($team_style != 'style1') {
            $facebook = get_post_meta(get_the_ID(), 'team-facebook', true);
            $instagram = get_post_meta(get_the_ID(), 'team-instagram', true);
            $twitter = get_post_meta(get_the_ID(), 'team-twitter', true);
            if ($facebook || $instagram || $twitter) {
              ?>
              <div class="team-member__socialmedia">
                <ul>
                  <?php if ($facebook) { ?>
                    <li><a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a></li>
                  <?php }
                  if ($instagram) { ?>
                    <li><a href="<?php echo $instagram; ?>"><i class="fa fa-instagram"></i></a></li>
                  <?php }
                  if ($twitter) { ?>
                    <li><a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a></li>
                  <?php } ?>
                </ul>
              </div>
            <?php }
          } ?>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
    <?php }
    else{  ?>
      <div class="wd-section-team team-list small-up-<?php echo esc_attr($columns_mobile); ?> large-up-<?php echo esc_attr($columns_desktop); ?> medium-up-<?php echo esc_attr($columns_tablet); ?> <?php if($team_collapse == "") echo "collapse"; ?>">
        <?php $loop = new WP_Query( array( 'post_type' => 'team-member', 'posts_per_page' => $itemperpage, ) );
        while ( $loop->have_posts() ) : $loop->the_post();  ?>
          <div class="wd-team-member-item column column-block">
            <div class="wd-team-member">
	            <?php
	            $image_url = get_post_meta(get_the_ID(), 'picture', true);
	            $image_url=image_from_url_relative($image_url);
	            $image_id = wd_get_image_id($image_url);

	            if ( $image_id != '' ) { ?>

		            <?php  print wp_get_attachment_image( $image_id, 'wd_team' );   ?>

	            <?php }
	            else { ?>
		            <?php 	the_post_thumbnail('wd_team') ; } ?>

              <h4 class="wd-title-element"><?php the_title(); ?></h4>
              <?php if ( $show_description == "yes" && get_post_meta(get_the_ID(), 'description', true) != ""){ ?>
                <p>
                  <?php echo get_post_meta(get_the_ID(), 'description', true); ?>
                </p>
              <?php } ?>
            </div>

          </div>
        <?php endwhile; ?>
      </div>
      <?php
    }
    ?>
   <?php
      return ob_get_clean();
      }
  add_shortcode( 'wd_team', 'wd_team_scode' );
}
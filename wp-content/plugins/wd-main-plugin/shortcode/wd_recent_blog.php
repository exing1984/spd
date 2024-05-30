<?php 
if(!function_exists('wd_recent_blog')){
function wd_recent_blog($atts) {

	$show_thumbnail = "";
  extract( shortcode_atts( array(
    'blog_layout' => '1',
    'itemperpage' => '3',
    'columns_mobile' => '1',
    'columns_tablet' => '2',
    'columns_desktop' => '3',
    'show_thumbnail' => 'yes',
    'show_pagination' => '',
    'css_animation' => 'no'
  ), $atts ) );

  ob_start();
  $animation_classes =  "";
      $data_animated = "";
  if(($css_animation != 'no')){
      $animation_classes =  " animated ";
      $data_animated = "data-animated=$css_animation";
    }
?>

	<div class='simple-blog small-up-<?php echo $columns_mobile; ?> medium-up-<?php echo $columns_tablet; ?> large-up-<?php echo $columns_desktop; ?>' >
  	<?php
    if (!empty($show_pagination)) {
      $show_pagination = false;
    } else {
      $show_pagination = true;
    };
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $loop = new WP_Query(array('posts_per_page' => $itemperpage, 'paged' => $paged, 'no_found_rows' => $show_pagination));
    while ( $loop->have_posts() ) : $loop->the_post(); ?>

    	<div class="column column-block blog-layout<?php echo $blog_layout ?>">
            <?php if($blog_layout == '1') {
                ?>
                <div class="wd-latest-news hvr-underline-from-center <?php echo esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
                    <div class="wd-image-date">
                        <?php if($show_thumbnail != "") the_post_thumbnail( 'flooring_blog' ) ?>
                        <span><strong><?php the_time('d'); ?></strong><?php the_time('M'); ?></span>
                    </div>
                    <?php $style = ($show_thumbnail == "" || ($show_thumbnail != "" && !has_post_thumbnail()))? ' style="margin-left:55px;"' : '';  ?>
                    <h4 class="wd-title-element"<?php echo $style; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <p>
                        <?php echo wp_trim_words(get_the_content(),25); ?>
                        <a class="hvr-pop read-more" href="<?php the_permalink() ?>"><?php esc_html__('Read More →','flooring') ?></a>
                    </p>
                </div>
            <?php }else{ ?>
                <div class="wd-latest-news hvr-underline-from-center <?php echo esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
                    <div class="wd-image-date">
                        <?php if($show_thumbnail != "") the_post_thumbnail( 'flooring_blog' ) ?>
                       <div class="post-category"><?php the_category() ?></div>
                    </div>
                    <?php $style = ($show_thumbnail == "" || ($show_thumbnail != "" && !has_post_thumbnail()))? ' style="margin-left:55px;"' : '';  ?>

                    <h4 class="post-title"<?php echo $style; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                    <div class="post-date"><?php echo get_the_date(); ?></div>
                    <p>
                        <?php echo wp_trim_words(get_the_content(),25); ?>
                        <a class="hvr-pop read-more" href="<?php the_permalink() ?>"><?php esc_html__('Read More →','flooring') ?></a>
                    </p>
                </div>
            <?php } ?>

    	</div>
  	<?php endwhile;?>
  </div>
  <!-- pagination here -->
  <?php
  if (function_exists('flooring_pagination')) {
    flooring_pagination($loop->max_num_pages, "", $paged);
  }
  ?>
  <?php return ob_get_clean();
  }
add_shortcode( 'wd_blog', 'wd_recent_blog' );
}  ?>
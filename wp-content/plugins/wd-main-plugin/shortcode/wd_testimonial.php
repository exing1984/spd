<?php
function wd_testimonial($atts) {

	extract(shortcode_atts(array(

		'itemperpage' => '5',
		'font_color' => "#fff",
		'css_animation' => 'no',
        'layout' => ''

	), $atts));

	$animation_classes = "";
	$data_animated = "";
	if (($css_animation != 'no')) {
		$animation_classes = " animated ";
		$data_animated = "data-animated=$css_animation";
	}

	ob_start(); ?>

  <?php if ($layout == 'style_2'){
    ?>
    <div class="owl-testimonial wd-testimonial wd-testimonial_<?php echo $layout; ?>" >
			<?php
			query_posts(array('post_type' => 'testimonials', 'posts_per_page' => $itemperpage));
			while (have_posts()) : the_post(); ?>
        <blockquote class="wd-testimonial__item">
          <div class="wd-testimonial__thumbnail">
						<?php the_post_thumbnail("flooring__testimonial_layout_2");?>
          </div>
          <div class="wd-testimonial__info">
            <div class="excerpt" >
                <p style="<?php echo flooring_check_if_empty('color', $font_color); ?>">
                    <?php echo get_the_excerpt(); ?>
                </p>

            </div>
            <h5 class="title">
							<?php the_title(); ?>
            </h5>
            <p class="job p-small">
							<?php echo get_post_meta(get_the_ID(), 'job_title', true) ?>
            </p>
          </div>
        </blockquote>
			<?php endwhile;
			wp_reset_query();
			?>
    </div>
    <?php
  } else {
    ?>
    <div class="<?php echo esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
      <div class="owl-testimonial wd-testimonial" style="<?php echo flooring_check_if_empty('color', $font_color); ?>">
				<?php $loop = new WP_Query(array('post_type' => 'testimonials', 'posts_per_page' => $itemperpage));
				while ($loop->have_posts()) : $loop->the_post(); ?>
          <div class="testimonial-item">
            <blockquote>
							<?php
							the_excerpt();

							if (has_post_thumbnail()) {
								the_post_thumbnail( array(70, 70) );
							} ?>
              <cite><?php the_title(); ?></cite>
              <div class="job-title"><?php get_post_meta(get_the_ID(), 'job_title', true) ?></div>
            </blockquote>
          </div>
				<?php endwhile; ?>
      </div>
    </div>
    <?php
	}?>
	<?php return ob_get_clean();
}

add_shortcode('wd_testimonial', 'wd_testimonial');
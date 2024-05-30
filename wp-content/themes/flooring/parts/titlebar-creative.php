<?php $flooring_menu_style = flooring_get_option('flooring_menu_style','creative'); ?>
<div class="wd-title-bar <?php echo esc_attr($flooring_menu_style) ?>">
		<div class="row">
			<div class="large-12 columns wd-title-section_l ">
				<h2><?php
				if (flooring_is_blog()) {
					$flooring_blog_id = get_option('page_for_posts');
					if ($flooring_blog_id == false) {
						if (!is_archive()) {
							echo esc_html__('Blog', 'flooring');
						} elseif (is_category()) {
							echo esc_html__('Category Archives', 'flooring');
							echo "  " . strip_tags(category_description());
						} elseif (is_tag()) {
							echo esc_html__('Tag Archives', 'flooring');
						} elseif (is_year()) {
							echo esc_html__('Yearly Archives', 'flooring');
						} elseif (is_month()) {
							echo esc_html__('Monthly Archives', 'flooring');
						} elseif (is_date()) {
							echo esc_html__('Daily Archives', 'flooring');
						} elseif (is_author()) {
							echo esc_html__('Author Archives', 'flooring');
						}
					} else {
						echo get_the_title($flooring_blog_id);
					}
				} elseif ( is_search() ) { ?>
					<?php echo esc_html__( 'Search Result of', 'flooring' ) . ': ' . esc_html( get_search_query( false ) ) ?>
					<?php
				}else {
					the_title();
				}
				?>
				</h2>
				<?php // Subtitle
				$flooring_page_sub_title = get_post_meta( get_the_ID(), 'flooring_page_sub_title', true );
				if ( ! empty( $flooring_page_sub_title ) ) { ?>
					<h5><?php echo esc_attr( $flooring_page_sub_title ) ?></h5>
				<?php } ?>
			</div>
			
		</div>
	</div>
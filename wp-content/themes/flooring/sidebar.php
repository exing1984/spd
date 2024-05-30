<?php 

if ( is_active_sidebar( 'sidebar' ) ) : ?>
		<aside class="large-4 small-12 sidebar-second columns sidebar">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</aside><!-- #secondary -->
	<?php endif;
<?php
/*if (flooring_get_option('flooring_search_icon','off') != "off") {*/ ?>
	<div class="min-search">
		<span class="show-search right"><a href="#">
       <svg xmlns="http://www.w3.org/2000/svg" width="18.907" height="18.507" viewBox="0 0 18.907 18.507"><circle cx="8" cy="8" r="8" transform="translate(0.5 0.5)" fill="none" stroke="#4c5264" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1"/><line x2="3.5" y2="3.5" transform="translate(14.7 14.3)" stroke-width="1" stroke="#4c5264" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" fill="none"/><path d="M9,2.8a5.335,5.335,0,0,1,5.3,5.3" fill="none" stroke="#4c5264" stroke-linecap="round" stroke-miterlimit="10" stroke-width="1"/></svg>
      </a></span>
		<div class="overlay-search hide">
			<form method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
				<label>
					<span class="screen-reader-text"><?php echo load_theme_textdomain( 'Search for:', 'label' ) ?></span>
					<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search','flooring' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr__( 'Search for:','flooring' ) ?>" />
				</label>
				<input type="submit" class="search-submit" value="<?php echo esc_attr__( 'Search','flooring' ) ?>" />
			</form>
		</div>
	</div>

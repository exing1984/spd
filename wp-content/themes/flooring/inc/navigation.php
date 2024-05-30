<?php

// This theme uses wp_nav_menu() in two locations.
//____________navigation____________

register_nav_menus( array(
	'primary' => esc_html__( 'Primary Navigation', 'flooring' ),
) );

/**
 * Desktop navigation - right top bar
 *
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
if ( ! function_exists( 'flooring_top_bar_primary' ) ) {
	function flooring_top_bar_primary() {
		$primarymenu = "primary";
		wp_nav_menu(
			array(
				'container'      => false,
				'menu_class'     => 'desktop-menu menu',
				'theme_location' => $primarymenu,
				'depth'          => 4,
				'fallback_cb'    => 'flooring_main_menu_fallback',
				'walker'         => new flooring_top_bar_walker(),
			)
		);
	}
}

/**
 * Mobile navigation - topbar (default) or offcanvas
 */
if ( ! function_exists( 'flooring_mobile_nav' ) ) {
	function flooring_mobile_nav() {
		wp_nav_menu(
			array(
				'container'      => false,                         // Remove nav container
				'menu'           => esc_html__( 'mobile-nav', 'flooring' ),
				'menu_class'     => 'vertical menu',
				'theme_location' => 'primary',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true">%3$s</ul>',
				'fallback_cb'    => false,
				'walker'         => new flooring_mobile_walker(),
			)
		);
	}
}

/**
 * Mobile navigation - topbar (default) or offcanvas
 */


if (!class_exists('flooring_corporate_mobile_walker')) :
	class flooring_corporate_mobile_walker extends Walker_Nav_Menu
	{
		function start_lvl(&$output, $depth = 0, $args = array())
		{
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu dropdown \">\n";
		}
	}
endif;

if ( ! function_exists( 'flooring_corporate_mobile_nav' ) ) {
	function flooring_corporate_mobile_nav() {
		wp_nav_menu(
			array(
				'container'      => false,                         // Remove nav container
				'menu'           => esc_html__( 'mobile-nav', 'flooring' ),
				'menu_class'     => 'vertical menu',
				'theme_location' => 'primary',
				'items_wrap'     => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true">%3$s</ul>',
				'fallback_cb'    => false,
				'walker'         => new flooring_corporate_mobile_walker(),
			)
		);
	}
}


/**
 * Get title bar responsive toggle attribute
 */

if ( ! function_exists( 'flooring_title_bar_responsive_toggle' ) ) {
	function flooring_title_bar_responsive_toggle() {

		echo 'data-responsive-toggle="mobile-menu"';

	}
}


/**
 * Menu Fallback
 */
function flooring_main_menu_fallback() {
	echo '<div class="empty-menu">';
	echo __( 'Please assign a menu to the primary menu location under ', 'flooring' ); ?>
  <a
    href="<?php echo get_admin_url( get_current_blog_id(), 'nav-menus.php' ) ?>"><?php echo esc_html__( 'Menus Settings', 'flooring' ); ?></a>
  </div> <?php
}
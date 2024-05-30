<?php

$flooring_counter = 1;

if (!class_exists('flooring_top_bar_walker')) :
	class flooring_top_bar_walker extends Walker_Nav_Menu
	{

		static protected $menu_bg_test;
		public $flooring_megamenu;
		public $flooring_count;

		public function __construct()
		{
			$this->flooring_megamenu = 0;
			$this->flooring_count = 0;
		}

		function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0)
		{

			$flooring_class = "";
			if (is_object($args)) {
				global $flooring_counter;
				if ($item->mega_menu == 1) {
					$flooring_class = 'mega-menu';
					$this->flooring_megamenu = $item->ID;
				}
				self::$menu_bg_test = $item->mega_menu_bg_image;
				$indent = ($depth) ? str_repeat("\t", $depth) : '';
				$class_names = $value = '';

				$classes = empty($item->classes) ? array() : (array)$item->classes;
				$classes[] = ($item->current) ? 'active' : '';
				$classes[] = ($args->has_children) ? ' is-dropdown-submenu-parent opens-right not-click' : '';
				$args->link_before = (in_array('section', $classes)) ? '<label>' : '';
				$args->link_after = (in_array('section', $classes)) ? '</label>' : '';
				$output .= (in_array('section', $classes));
				$class_names = !empty($classes) ? implode(' ', $classes) . ' ' : '';
				$class_names .= ($args->has_children) ? 'has-dropdown not-click ' . $flooring_class : '';
				$parent = $item->menu_item_parent;
				if ($parent == 0) {
					$flooring_counter++;

				}

				$current_page = empty($item->classes[4]) ? '' : $item->classes[4];
				$class_names .= ' color-' . $flooring_counter . ' ' . $current_page;
				$class_names = strlen(trim($class_names)) > 0 ? ' class="' . esc_attr($class_names) . '"' : '';

				$output .= $indent . '<li' . $value . $class_names . '>';


				$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
				$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
				$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
				$attributes .= !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';


				$item_output = $args->before;

				$item_output .= (!in_array('section', $classes)) ? '<a' . $attributes . '>' : '';
				$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
				$item_output .= $args->link_after;

				//post image
				$has_featured_image = array_search('menu-item-object-post', $classes);
				if ($has_featured_image !== false && $this->flooring_megamenu != 0) {
					$postID = url_to_postid($item->url);
					$image_src = get_the_post_thumbnail_url($postID);
					$item_output .= "<img src='" . $image_src . "'/>";
				}


				$item_output .= (!in_array('section', $classes)) ? '</a>' : '';
				$item_output .= $args->after;

				if ($this->flooring_megamenu === intval($item->menu_item_parent) && $this->flooring_megamenu != 0) {
					$this->flooring_count++;
					if ($this->flooring_count > 4) {

						$output .= "</ul></li><li class=\" mega-menu-column\"><ul><li>";
						$this->flooring_count = 1;
					}

				}

				$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
			}


		}

		function end_el(&$output, $item, $depth = 0, $args = Array())
		{
			if ($this->flooring_megamenu == 0) {
				$output .= '</li>' . "\n";
			}
		}

		function start_lvl(&$output, $depth = 0, $args = Array())
		{
			$indent = str_repeat("\t", $depth);
			if (isset($menu_bg_test) && $menu_bg_test != "") {
				$output .= "\n" . $indent . '
        <ul class="sub-menu dropdown " style = "background-image : url(' . self::$menu_bg_test . ')">' . "\n";
			} else {

				$output .= "\n" . $indent . '<ul class="submenu is-dropdown-submenu ">' . "\n";
				if ($this->flooring_megamenu != 0) {
					$output .= "<li class=\" mega-menu-column\"><ul> ";
				}
			}

		}

		function end_lvl(&$output, $depth = 0, $args = Array())
		{
			$indent = str_repeat("\t", $depth);
			if ($this->flooring_megamenu != 0) {
				$output .= "</ul></li> ";
			}
			$output .= $indent . ' </ul>' . "\n";
		}

		function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
		{
			$id_field = $this->db_fields['id'];
			if (is_object($args[0])) {
				$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			}
			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}

	}
endif;
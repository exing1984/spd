<?php

$flooring_custom_css = "";
$flooring_custom_css .= "";


//______________ background header pages ______________________________
global $wp_query;
define( 'flooring_PAGE_ID', 0 );
if ( function_exists( 'WC' ) ) {
	if ( is_shop() ) {
		$GLOBALS['flooring_PageID'] = get_option( 'woocommerce_shop_page_id' );
	} else {
		$GLOBALS['flooring_PageID'] = get_the_ID();
	}
} elseif ( is_object( $wp_query ) && is_object( $wp_query->post ) && isset( $wp_query->post->ID ) ) {
	$GLOBALS['flooring_PageID'] = get_the_ID();
} else {
	$GLOBALS['flooring_PageID'] = get_the_ID();
}

$flooring_page_bg_img = get_post_meta( $GLOBALS['flooring_PageID'], 'flooring_page_title_area_bg_img', true );
if ( $flooring_page_bg_img != '' ) {
	$flooring_custom_css .= "
			body .wd-title-bar {
				background:url(" . $flooring_page_bg_img . ") no-repeat #525354;
				background-size:cover;
			}
		";
}
$flooring_page_title_color = get_post_meta( $GLOBALS['flooring_PageID'], 'flooring_page_title_color', true );
if ( $flooring_page_title_color != '' ) {
	$flooring_custom_css .= "
			.wd-title-bar div h2,
			.wd-title-bar div h5 {
				color: " . $flooring_page_title_color . ";
			}
		";
}
$blog_page_id = get_option( 'page_for_posts' );
if ( isset( $blog_page_id ) && $blog_page_id != '' ) {
	$blog_flooring_page_bg_img = get_post_meta( $blog_page_id, 'flooring_page_title_area_bg_img', true );
	if ( $blog_flooring_page_bg_img != '' ) {
		$flooring_custom_css .= "
			.blog .wd-title-bar {
				background:url(" . $blog_flooring_page_bg_img . ") no-repeat #4B4C4D !important;
				background-size:cover;
			}
		";
	}
	$blog_flooring_page_title_color = get_post_meta( $blog_page_id, 'flooring_page_title_color', true );
	if ( $blog_flooring_page_title_color != '' ) {
		$flooring_custom_css .= "
			.wd-title-bar div h2,
			.wd-title-bar div h5 {
				color: " . $blog_flooring_page_title_color . " !important;
			}
		";
	}
}
if(flooring_get_option( 'logo_height', '' ) != '' ) {
		$flooring_custom_css .= "
	.top-bar-left img {
		max-height: ".flooring_get_option( 'logo_height', '' )."px;
	}";
}

//______________ background header single pages ______________________________

$flooring_single_post_bg_img = flooring_get_option( 'flooring_bg_single_post_path', '' );
if ( $flooring_single_post_bg_img != '' ) {
	$flooring_custom_css .= "
			.single-post .wd-title-bar {
				background:url(" . $flooring_single_post_bg_img . ") no-repeat #4B4C4D;
				background-size:cover;
			}
		";
}
$flooring_bg_single_page = flooring_get_option( 'flooring_bg_single_page', '' );
if ( $flooring_bg_single_page != '' ) {
	$flooring_custom_css .= "
			.wd-title-bar {
				background:url(" . $flooring_bg_single_page . ") no-repeat #4B4C4D;
				background-size:cover;
			}
		";
}

//______________ Typography  ______________________________
if ( ( flooring_get_option( 'flooring_body_font_familly', 'Open Sans' ) != 'default' ) && ( flooring_get_option( 'flooring_body_font_familly', 'Open Sans' ) != false ) ) {
	$flooring_custom_css .= "body ,body p {
    	font-family :'" . flooring_get_option( 'flooring_body_font_familly', 'Open Sans' ) . "';
    	font-weight :" . flooring_get_option( 'flooring_body_font_weight', '400' ) . ";
    	font-style :" . flooring_get_option( 'flooring_body_font_style', 'normal' ) . ";
    }";
} else {
	$flooring_custom_css .= "body ,body p {
    	font-family: 'Open Sans', sans-serif;
    	font-weight :" . flooring_get_option( 'flooring_body_font_weight', '400' ) . ";
    	font-style :" . flooring_get_option( 'flooring_body_font_style', 'normal' ) . ";
    }";
}
if ( ( flooring_get_option( 'flooring_body_font_size', '14' ) != 'default' ) && ( flooring_get_option( 'flooring_body_font_size', '14' ) != false ) ) {
	$flooring_custom_css .= "body p {
    	font-size :" . flooring_get_option( 'flooring_body_font_size', '14' ) . ";
    }";
}
if ( ( flooring_get_option( 'flooring_head_font_familly', 'Open Sans' ) != 'default' ) && ( flooring_get_option( 'flooring_head_font_familly', 'Open Sans' ) != false ) ) {
	$flooring_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
    	font-family :'" . flooring_get_option( 'flooring_head_font_familly', 'Open Sans' ) . "';
		font-weight :" . flooring_get_option( 'flooring_heading-font-weight-style', '700' ) . ";
		font-style :" . flooring_get_option( 'flooring_head_font_style', 'normal' ) . ";
    }";
} else {
	$flooring_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
    	font-family: 'Open Sans', sans-serif;
		font-weight :" . flooring_get_option( 'flooring_heading-font-weight-style', '400' ) . ";
		font-style :" . flooring_get_option( 'flooring_head_font_style', 'normal' ) . ";
    }";
}

if ( flooring_get_option( 'flooring_navigation_font_familly', 'Open Sans' ) != "default" ) {
	$flooring_custom_css .= ".l-header .top-bar ul.desktop-menu li.menu-item >  a {
				font-family : '" . flooring_get_option( 'flooring_navigation_font_familly', 'Open Sans' ) . "';
			}";
} else {
	$flooring_custom_css .= ".l-header .top-bar ul.desktop-menu li.menu-item >  a {
				font-family: 'Open Sans', sans-serif;
			}";
}
if ( flooring_get_option( 'flooring_navigation-font-weight-style', '400' ) != "" ) {
	$flooring_custom_css .= ".l-header .top-bar ul.desktop-menu li.menu-item >  a {
				font-weight : " . flooring_get_option( 'flooring_navigation-font-weight-style', '400' ) . ";
			}";
}

if ( flooring_get_option( 'flooring_navigation-transform', 'normal' ) != "" ) {
	$flooring_custom_css .= ".l-header .top-bar ul.desktop-menu li.menu-item >  a {
				text-transform : " . flooring_get_option( 'flooring_navigation-transform', 'normal' ) . ";
			}";
}

if ( ( flooring_get_option( 'flooring_navigation_font_size', '14' ) != 'default' ) && ( flooring_get_option( 'flooring_navigation_font_size', '14' ) != false ) ) {
	$flooring_custom_css .= ".l-header .top-bar ul.desktop-menu li.menu-item >  a {
    	font-size :" . flooring_get_option( 'flooring_navigation_font_size', '14px' ) . " !important;
    }";
}
if ( flooring_get_option( 'flooring_heading-transform', 'normal' ) != "" ) {
	$flooring_custom_css .= "h1, h2, h3, h4, h5, h6, .menu-list a {
				text-transform : " . flooring_get_option( 'flooring_heading-transform', 'normal' ) . ";
			}";
}
if ( flooring_get_option( 'flooring_text-transform', 'normal' ) != "" ) {
	$flooring_custom_css .= "body ,body p {
				text-transform : " . flooring_get_option( 'flooring_text-transform', 'normal' ) . ";
			}";

}
$flooring_custom_css .= flooring_get_option( 'flooring_theme_custom_css' ) ;

$flooring_custom_css .= "
    :root {
      --primary-color:            " . esc_attr(flooring_get_option('flooring_primary_color','#B6702A')) . ";
      --secondary-color:          " . esc_attr(flooring_get_option('flooring_secondary_color', '#ffb61e')) . ";
      --headings-color:          " . esc_attr(flooring_get_option('flooring_headings_color', '#0a0a0a')) . ";
           
      --topbar-background:        " . esc_attr(flooring_get_option('flooring_nav_bg_color','rgba(0, 0, 0, 0.45)')) . ";
      --topbar-text:              " . esc_attr(flooring_get_option('flooring_nav_color','#fff')) . ";
      --topbar-sticky-bg:         " . esc_attr(flooring_get_option('navigation_bg_color_sticky')) . ";
      --topbar-sticky-text:       " . esc_attr(flooring_get_option('navigation_color_sticky')) . ";
      --topbar-hover-sticky-text: " . esc_attr(flooring_get_option('navigation_color_hover_sticky')) . ";
      --topbar-hover-text:        " . esc_attr(flooring_get_option('flooring_nav_hover_color','#B6702A')) . ";
   
      --footer-background:        " . esc_attr(flooring_get_option('footer_bg_color','#383838')) . ";
      --footer-background-image: url(" . esc_attr(flooring_get_option('footer_bg_img')) . ");
      --footer-text-color:        " . esc_attr(flooring_get_option('footer_text_color','#fff')) . ";
      --copyright-background:     " . esc_attr(flooring_get_option('copyright_bg_color')) . ";
      --copyright-text:           " . esc_attr(flooring_get_option('copyright_text_color')) . ";
      
      --copyright-bg-color:           " . esc_attr(flooring_get_option('footer_copyright_bg_color')) . ";
       --copyright-text-color:           " . esc_attr(flooring_get_option('footer_copyright_text_color')) . ";
    }";



$flooring_custom_css .= "
		.wd-heading{ "
                        . flooring_check_if_empty( 'margin-top', flooring_get_option( 'heading_space_top' ) )
                        . flooring_check_if_empty( 'margin-bottom', flooring_get_option( 'heading_space_bottom' ) ) . "
		}";

$flooring_custom_css .= "
		.wd-heading .title_a { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_a_title_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_a_title_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_a_title_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_a_title_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_a_title_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_a_title_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_a_title_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_a_title_letter_spacing' ) ) . "
		}
		.wd-heading .sub_title_a { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_a_subtitle_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_a_subtitle_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_a_subtitle_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_a_subtitle_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_a_subtitle_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_a_subtitle_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_a_subtitle_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_a_subtitle_letter_spacing' ) ) . "		
		}
		";

$flooring_custom_css .= "
		.wd-heading .title_b { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_b_title_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_b_title_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_b_title_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_b_title_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_b_title_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_b_title_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_b_title_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_b_title_letter_spacing' ) ) . "
		}
		.wd-heading .sub_title_b { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_b_subtitle_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_b_subtitle_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_b_subtitle_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_b_subtitle_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_b_subtitle_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_b_subtitle_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_b_subtitle_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_b_subtitle_letter_spacing' ) ) . "
		}
		";
$flooring_custom_css .= "
		.wd-heading .title_c { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_c_title_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_c_title_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_c_title_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_c_title_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_c_title_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_c_title_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_c_title_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_c_title_letter_spacing' ) ) . "
		}
		.wd-heading .sub_title_c { "
                        . flooring_check_if_empty( 'font-family', flooring_get_option( 'heading_c_subtitle_font_family' ) )
                        . flooring_check_if_empty( 'font-style', flooring_get_option( 'heading_c_subtitle_font_style' ) )
                        . flooring_check_if_empty( 'font-weight', flooring_get_option( 'heading_c_subtitle_font_weight' ) )
                        . flooring_check_if_empty( 'font-size', flooring_get_option( 'heading_c_subtitle_font_size' ) )
                        . flooring_check_if_empty( 'color', flooring_get_option( 'heading_c_subtitle_font_color' ) )
                        . flooring_check_if_empty( 'text-transform', flooring_get_option( 'heading_c_subtitle_text_transform' ) )
                        . flooring_check_if_empty( 'line-height', flooring_get_option( 'heading_c_subtitle_line_height' ) )
                        . flooring_check_if_empty( 'letter-spacing', flooring_get_option( 'heading_c_subtitle_letter_spacing' ) ) . "
		}";

$flooring_custom_css .= "
		.wd-heading .hr_a { "
                        . flooring_check_if_empty( 'border-bottom-style', flooring_get_option( 'headings_a_separator_style' ) )
                        . flooring_check_if_empty( 'border-bottom-width', flooring_get_option( 'heading_a_separator_width' ) )
                        . flooring_check_if_empty( 'border-bottom-color', flooring_get_option( 'heading_a_separator_color' ) ) . "
        width: 73px;
		}";

$flooring_custom_css .= "
		.wd-heading .hr_b { "
                        . flooring_check_if_empty( 'border-bottom-style', flooring_get_option( 'headings_b_separator_style' ) )
                        . flooring_check_if_empty( 'border-bottom-width', flooring_get_option( 'heading_b_separator_width' ) )
                        . flooring_check_if_empty( 'border-bottom-color', flooring_get_option( 'heading_b_separator_color' ) ) . "
		}";

$flooring_custom_css .= "
		.wd-heading .hr_c { "
                        . flooring_check_if_empty( 'border-bottom-style', flooring_get_option( 'headings_c_separator_style' ) )
                        . flooring_check_if_empty( 'border-bottom-width', flooring_get_option( 'heading_c_separator_width' ) )
                        . flooring_check_if_empty( 'border-bottom-color', flooring_get_option( 'heading_c_separator_color' ) ) . "
		}";
if(flooring_get_option( 'flooring_footer_bg_path' ) != '') {
    $flooring_custom_css .= "
        .wd-footer {
                background-image:url(".flooring_get_option( 'flooring_footer_bg_path' ).");
        }
    ";
    if(flooring_get_option("flooring_footer_bg_size") == "cover") {
        $flooring_custom_css .= "
        .wd-footer {
                background-size:".flooring_get_option( 'flooring_footer_bg_size' ).";
        }
        ";
    }
}


<?php
global $cat_array, $vc_add_css_animation;
/* portfolio
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Portfolio", 'flooring' ),
    "base"            => "wd_vc_portfolio",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Columns To Display in mobile", 'flooring' ),
            "param_name"  => "columns_mobile",
            'description' => esc_html__( 'Used in Grid Layout', 'flooring' ),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Columns To Display in tablet", 'flooring' ),
            "param_name"  => "columns_tablet",
            'description' => esc_html__( 'Used in Grid Layout', 'flooring' ),
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Columns To Display in desktop", 'flooring' ),
            "param_name"  => "columns_desktop",
            'description' => esc_html__( 'Used in Grid Layout', 'flooring' ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Categories", 'flooring' ),
            "param_name" => "category",
            'value'      => $cat_array,
        ),
        array(
            "type"        => "textfield",
            "heading"     => esc_html__( "Items to display", 'flooring' ),
            "param_name"  => "itemperpage",
            'description' => esc_html__( 'Used in Carousel Layout', 'flooring' ),
        ),
        array(
            "type"       => "dropdown", // it will bind a textfield in WP
            "heading"    => esc_html__( "Layout", 'flooring' ),
            "param_name" => "layout",
            "value"      => array( 'Style I' => '1', 'Style II' => '2', 'Style III' => '3' ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display Pagination", 'flooring' ),
            "param_name" => "show_pagination",
        ),
        $vc_add_css_animation

    )
) );
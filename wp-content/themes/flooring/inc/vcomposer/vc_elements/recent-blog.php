<?php
global $vc_add_css_animation;
/* recent blog
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Recent Blog", 'flooring' ),
    "base"            => "wd_blog",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__( "Blog Style", 'flooring' ),
            "param_name" => "blog_layout",
            "value"      => array( 'Style I' => '1', 'Style II' => '2' ),
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Items to display", 'flooring' ),
            "param_name" => "itemperpage",
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Columns To Display in mobile", 'flooring' ),
            "param_name" => "columns_mobile"
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Columns To Display in tablet", 'flooring' ),
            "param_name" => "columns_tablet"
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Columns To Display in desktop", 'flooring' ),
            "param_name" => "columns_desktop"
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display thumbnail", 'flooring' ),
            "param_name" => "show_thumbnail",
            "std"        => "yes",
            'value'      => array( esc_html__( 'Yes, please', 'flooring' ) => 'yes' ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display Pagination", 'flooring' ),
            "param_name" => "show_pagination",
        ),
        $vc_add_css_animation


    )
) );
<?php
global $icons, $vc_add_css_animation;
/* Count To
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Count Up", 'flooring' ),
    "base"            => "wd_count_up",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Title", 'flooring' ),
            "param_name" => "title",
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Countto (number)", 'flooring' ),
            "param_name" => "countto",
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "time (in seconds, only number)", 'flooring' ),
            "param_name" => "time",
        ),
        array(
            "type"       => "colorpicker",
            "heading"    => esc_html__( "Color", 'flooring' ),
            "param_name" => "text_color",
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display image instead of icon", 'flooring' ),
            "param_name" => "image_checkbox",
            'value'      => array( esc_html__( 'Yes, please', 'flooring' ) => 'yes' ),
        ),
        array(
            "type"       => "attach_image", // it will bind a img choice in WP
            "heading"    => esc_html__( "Image", 'flooring' ),
            "param_name" => "image",
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Icon', 'flooring' ),
            'param_name'  => 'icon',
            'value'       => $icons,
            'description' => esc_html__( 'Select the icon to use.', 'flooring' ),
            'admin_label' => true
        ),
        $vc_add_css_animation
    )
) );
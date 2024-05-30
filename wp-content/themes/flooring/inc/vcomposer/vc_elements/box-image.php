<?php
global $vc_add_css_animation;
/* Image with text
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Image Box", 'flooring' ),
    "base"            => "wd_image_with_text",
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
            "type"       => "textarea",
            "heading"    => esc_html__( "Text", 'flooring' ),
            "param_name" => "text",
        ),
        array(
            "type"       => "attach_image", // it will bind a img choice in WP
            "heading"    => esc_html__( "Image", 'flooring' ),
            "param_name" => "image",
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Layout', 'flooring' ),
            'param_name'  => 'layout',
            'value'       => array( 
                    'Layout 1 (title above image)' => 1, 
                    'Layout 2 (title below image)' => 2,
                    'Layout 3' => 3,
                    'Layout 4' => 4 
                ),
            'description' => esc_html__( 'Select the box style.', 'flooring' ),
            'admin_label' => true
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Alignment', 'flooring' ),
            'param_name'  => 'alignment',
            'value'       => array( 
                    'Center' => 'center', 
                    'left'   => 'left',
                    'Right'  => 'right'
                ),
            'description' => esc_html__( 'Select the box style.', 'flooring' ),
            'admin_label' => true
        ),
        array(
            "type"       => "vc_link",
            "heading"    => esc_html__( "URL to :", 'flooring' ),
            "param_name" => "url",
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Extra Classes", 'flooring' ),
            "param_name" => "extra_classes",
        ),
        $vc_add_css_animation
    )
) );


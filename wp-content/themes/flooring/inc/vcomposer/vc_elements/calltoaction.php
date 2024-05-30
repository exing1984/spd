<?php
global $vc_add_css_animation;
/* Call To Action
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Call To Action", 'flooring' ),
    "base"            => "wd_call_to_action",
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
            "type"       => "textfield",
            "heading"    => esc_html__( "Button Text", 'flooring' ),
            "param_name" => "button_text",
        ),
        array(
            "type"       => "vc_link",
            "heading"    => esc_html__( "Button URL", 'flooring' ),
            "param_name" => "button_url",
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__( 'Layout', 'flooring' ),
            'param_name' => 'layout',
            'value'      => array(
                'Layout 1' => '',
                'Layout 2' => '-invers',
            ),
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Extra Classes", 'flooring' ),
            "param_name" => "extra_classes",
        ),
        $vc_add_css_animation
    )
) );
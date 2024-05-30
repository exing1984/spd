<?php
global $vc_add_css_animation;
/* Testimonial
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Testimonial", 'flooring' ), // add a name
    "base"            => "wd_testimonial", // bind with our shortcode
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true, // set this parameter when element will has a content
    "is_container"    => false, // set this param when you need to add a content element in this element
    // Here starts the definition of array with parameters of our compnent
    "params"          => array(

        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Maximum Number Of Items To Show", 'flooring' ),
            "param_name" => "itemperpage",
        ),
        array(
            "type"       => "colorpicker",
            "heading"    => esc_html__( "Text Color", 'flooring' ),
            "param_name" => "font_color",
        ),
        array(
            'type' => 'dropdown',
            'param_name' => 'layout',
            'heading' => esc_html__('Testimonial Layout', 'flooring'),
            'value' => array(
                esc_html__('Default', 'flooring') => 'style_1',
                esc_html__('Style II', 'flooring') => 'style_2'
            ),
        ),
        $vc_add_css_animation
    )
) );
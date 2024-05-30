<?php
global $vc_add_css_animation;
/* Our Clients
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Carousel Client", 'flooring' ),
    "base"            => "wd_client",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            'type'       => 'attach_images',
            'heading'    => esc_html__( 'Images', 'flooring' ),
            'param_name' => 'images',

        ),
        array(
            "type"       => "dropdown",
            "heading"    => esc_html__( "Columns", 'flooring' ),
            "param_name" => "columns",
            "value"      => array( '1', '2', '3', '4', '5', '6', '7' ),
        ),
        $vc_add_css_animation
    )
) );
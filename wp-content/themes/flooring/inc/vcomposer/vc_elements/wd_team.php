<?php

global $vc_add_css_animation;
/* Team
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Team", 'flooring' ), // add a name
    "base"            => "wd_team", // bind with our shortcode
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true, // set this parameter when element will has a content
    "is_container"    => false, // set this param when you need to add a content element in this element
    // Here starts the definition of array with parameters of our compnent
    "params"          => array(
        array(
            'type'       => 'dropdown',
            'param_name' => 'team_style',
            'heading'    => esc_html__( 'Team Style', 'flooring' ),
            'value'      => array(
                esc_html__( 'Style 1', 'flooring' ) => 'style_1',
                esc_html__( 'Style 2', 'flooring' ) => 'style_2'
            ),
        ),
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
            "type"       => "textfield",
            "heading"    => esc_html__( "Items Per Page", 'flooring' ),
            "param_name" => "itemperpage",
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display column gutters", 'flooring' ),
            "param_name" => "team_collapse",
            "std"        => "yes",
            'value'      => array( esc_html__( 'Yes, please', 'flooring' ) => 'yes' ),
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display team members description", 'flooring' ),
            "param_name" => "show_description",
            "std"        => "yes",
            'value'      => array( esc_html__( 'Yes, please', 'flooring' ) => 'yes' ),
        ),
        $vc_add_css_animation
    )
) );

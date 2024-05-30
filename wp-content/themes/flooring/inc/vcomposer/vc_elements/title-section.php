<?php
global $vc_add_css_animation;
/* Separator Title
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Separator Title", 'flooring' ),
    "base"            => "wd_separator_title",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Title", 'flooring' ),
            "param_name" => "wd_title",
            'edit_field_class' => 'vc_col-xs-8',
        ),
        array(
            "type"       => "colorpicker",
            "heading"    => esc_html__( "Title Color", 'flooring' ),
            "param_name" => "wd_title_color",
            'edit_field_class' => 'vc_col-xs-4',
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Subtitle", 'flooring' ),
            "param_name" => "wd_subtitle",
            'edit_field_class' => 'vc_col-xs-8',
        ),
        array(
            "type"       => "colorpicker",
            "heading"    => esc_html__( "SubTitle Color", 'flooring' ),
            "param_name" => "wd_subtitle_color",
            'edit_field_class' => 'vc_col-xs-4',
        ),
        array(
            'type'       => 'dropdown',
            'param_name' => 'wd_separator_style',
            'value'      => array(
                esc_html__( 'Center', 'flooring' ) => 'wd-title-section_c',
                esc_html__( 'Left', 'flooring' )   => 'wd-title-section_l'
            ),
            'heading'    => esc_html__( 'Wd Separator title Align', 'flooring' )
        ),
        $vc_add_css_animation
    )
) );
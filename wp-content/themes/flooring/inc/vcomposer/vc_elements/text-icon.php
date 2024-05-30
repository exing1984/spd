<?php
global $icons, $vc_add_css_animation;
/* Text Block with icon/image
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Text With Icon", 'flooring' ),
    "base"            => "wd_icon_text",
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
            "param_name" => "content",
        ),
        array(
            "type"       => "checkbox",
            "heading"    => esc_html__( "Display image instead of icon", 'flooring' ),
            "param_name" => "image_checkbox",
            'value'      => array( esc_html__( 'Yes, please', 'flooring' ) => 'yes' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Image type:', 'flooring'),
            'param_name' => 'choice',
            'value' => array(
                'Image File (png, jpg, svg, gif)' => 'image_choice',
                'SVG Code' => 'svg_choice',
                'Icon' => 'icon_choice',
            ),
        ),
        array(
            "type"       => "attach_image", // it will bind a img choice in WP
            "heading"    => esc_html__( "Image", 'flooring' ),
            "param_name" => "image",
            "dependency" => Array("element" => "choice", "value" => array('image_choice'))
        ),
        array(
            "type" => "textarea_raw_html", // it will bind a textfield in WP
            "heading" => esc_html__("SVG Code", 'flooring'),
            "param_name" => "secondary_svg",

            "dependency" => Array("element" => "choice", "value" => array('svg_choice'))
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Icon', 'flooring' ),
            'param_name'  => 'icon',
            'value'       => $icons,
            'description' => esc_html__( 'Select the icon to use.', 'flooring' ),
            'admin_label' => true,
            "dependency" => Array("element" => "choice", "value" => array('icon_choice'))
        ),
        array(
            'type'        => 'dropdown',
            'heading'     => esc_html__( 'Layout', 'flooring' ),
            'param_name'  => 'layout',
            'value'       => array(
                'Layout 1' => '-style1',
                'Layout 2' => '-style4',
                'Layout 3' => '-style2',
                'Layout 4' => '-style3',
                'Layout 5' => '-style5',
                'Layout 6' => '-rtl',
            ),
            'description' => esc_html__( 'Select the icon to use.', 'flooring' ),
            'admin_label' => true
        ),
        array(
            "type"       => "vc_link",
            "heading"    => esc_html__( "Link URL", 'flooring' ),
            "param_name" => "icon_txt_url",
        ),
        array(
            "type"       => "textfield",
            "heading"    => esc_html__( "Extra Classes", 'flooring' ),
            "param_name" => "extra_classes",
        ),
        $vc_add_css_animation
    )
) );

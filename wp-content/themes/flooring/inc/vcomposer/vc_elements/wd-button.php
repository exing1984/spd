<?php
global $vc_add_css_animation;
global $wd_fonts_array;

vc_map(array(
    "name" => esc_html__("Button", 'flooring'),
    "base" => "flooring_button",
    "icon" => get_template_directory_uri() . "/images/icon/greenenergy_icon.png",
    "content_element" => true,
    'is_container'    => false,
    "category" => 'Webdevia',
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Button Text", 'flooring'),
            "param_name" => "flooring_btn_text",
            "value" => "Read More",
            "admin_label" => true,
        ),
        array(
            "type" => "vc_link",
            "heading" => esc_html__("Button Link", 'flooring'),
            "param_name" => "flooring_btn_link",
            "value" => "#",
        ),
        array(
            "heading" => esc_html__("Button Style", "flooring"),
            "param_name" => "flooring_btn_style",
            "type" => "dropdown",
            'value' => array(
                'Simple' => "btn-solid",
                'Border' => "btn-border",
                'Underline' => "btn-underline",
            ),
            'edit_field_class' => 'vc_col-xs-8',
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button border Color", 'flooring'),
            "param_name" => "flooring_btn_custom_border_color",
            "dependency" => array(
                "element" => "flooring_btn_style",
                "value" => "btn-border"
            ),
            'edit_field_class' => 'vc_col-xs-4',


        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Text Color", 'flooring'),
            "param_name" => "flooring_btn_custom_text_color",
            'edit_field_class' => 'vc_col-xs-6',

        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Background Color", 'flooring'),
            "param_name" => "flooring_btn_custom_bg_color",
            'edit_field_class' => 'vc_col-xs-6',
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Hover Text Color", 'flooring'),
            "param_name" => "flooring_btncustom_hover_color",
            'edit_field_class' => 'vc_col-xs-6',
        ),
        array(
            "type" => "colorpicker",
            "heading" => esc_html__("Button Hover Background Color", 'flooring'),
            "param_name" => "flooring_btn_custom_hover_bg_color",
            'edit_field_class' => 'vc_col-xs-6',
        ),
        array(
            "heading" => esc_html__("Button Size", "flooring"),
            "param_name" => "flooringbtn_btn_size",
            "type" => "dropdown",
            'value' => array(
                'Medium (Default)' => "btn-medium",
                'Big' => "btn-big",
                'Small' => "btn-small",
            ),
        ),

        array(
            "heading" => esc_html__("Alignment", "flooring"),
            "param_name" => "flooringbtn_btn_align",
            "type" => "dropdown",
            'value' => array(
                'Left' => "text-left",
                'Center' => "text-center",
                'Right' => "text-right",
            ),
        ),







        $vc_add_css_animation

    )
));
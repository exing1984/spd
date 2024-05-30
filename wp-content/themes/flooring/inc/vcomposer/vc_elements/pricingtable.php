<?php
global $vc_add_css_animation;
/* Pricing Table
---------------------------------------------------------- */
vc_map( array(
    "name"            => esc_html__( "Pracing Table", 'flooring' ),
    "base"            => "wd_pricing_table",
    "icon"            => get_template_directory_uri() . "/inc/images/icon/flooring_icon.png",
    "category"        => 'Webdevia',
    "content_element" => true,
    "is_container"    => false,
    "params"          => array(
        array(
            'type' => 'textfield',
            "heading" => esc_html__("Head Title", 'flooring'),
            'param_name' => 'head_title',
        ),
        array(
            'type' => 'param_group',
            "heading" => esc_html__("Plan Options", 'flooring'),
            'param_name' => 'plan_options',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => esc_html__('Option','flooring'),
                    'param_name' => 'plan_option_head',
                    'edit_field_class' => 'vc_col-xs-8',
                ),
                array(
                    'type' => 'textfield',
                    'value' => '',
                    'heading' => esc_html__('Price','flooring'),
                    'param_name' => 'plan_option_price',
                    'edit_field_class' => 'vc_col-xs-4',
                ),
                array(
                    'type' => 'textarea',
                    'value' => '',
                    'heading' => esc_html__('Description','flooring'),
                    'param_name' => 'plan_option_descriptinsss',
                )
            )
        ),

        $vc_add_css_animation
    )
) );
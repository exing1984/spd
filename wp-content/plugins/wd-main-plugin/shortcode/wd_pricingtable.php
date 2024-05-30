<?php
function wd_pricing_table($atts) {

    extract( shortcode_atts( array(
        "head_title"=>"",
        "plan_options"=>"",
        'css_animation'   => 'no'
    ), $atts ) );

    $animation_classes =  "";
    $data_animated = "";
    if(($css_animation != 'no')){
        $animation_classes =  " animated ";
        $data_animated = "data-animated=$css_animation";
    }



    $sub_options = vc_param_group_parse_atts( $plan_options );

    ob_start(); ?>


    <div class="flooring-pricing-table <?php echo esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
       <div class="table-title">
           <h2><?php echo $head_title ?></h2>
           <i class="fa fa-angle-down"></i>
       </div>

      <?php  foreach ($sub_options as $sub_option) { ?>
            <div class="clearfix">
          <div class="details">
              <h5><?php echo $sub_option['plan_option_head']; ?></h5>
              <p><?php echo $sub_option['plan_option_descriptinsss']; ?></p>
          </div>
        <div class="price">
            <span><?php echo $sub_option['plan_option_price']; ?></span>
        </div>
            </div>
        <?php }  ?>

    </div>


    <?php return ob_get_clean();
}
add_shortcode( 'wd_pricing_table', 'wd_pricing_table' );
<?php
function flooring_button($atts)
{
  extract(shortcode_atts(array(
    'flooring_btn_text' => 'Read More',
    'flooring_btn_link' => '',
    'flooring_btn_style' => 'btn-solid',
    'flooring_btn_custom_border_color' => '',
    'custom_color' => '',
    'flooring_btn_custom_text_color' => '',
    'flooring_btn_custom_bg_color' => '',
    'flooring_btncustom_hover_color' => '',
    'flooring_btn_custom_hover_bg_color' => '',
    'flooringbtn_btn_size' => 'btn-medium',
    'flooringbtn_btn_align' => 'text-left',
    'css_animation' => 'no'),
    $atts));
  ob_start();


  // get the url from visual composer link string
	$flooring_btn_link = vc_build_link( $flooring_btn_link );

  $btn_classes = $flooring_btn_style . " " . $flooringbtn_btn_size   ;

  $animation_classes = "";
  $data_animated = "";

  if (($css_animation != 'no')) {
    $animation_classes = " animated ";
    $data_animated = "data-animated=$css_animation";
  }?>

  <div
    class="wd-btn-wrap <?php echo esc_attr($flooringbtn_btn_align) . ' ' . esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
    <a href="<?php echo $flooring_btn_link["url"] ?>" class="wd-btn <?php echo esc_attr($btn_classes) ?>"

        style="<?php echo flooring_check_if_empty('color', $flooring_btn_custom_text_color); ?>  <?php echo flooring_check_if_empty('background-color', $flooring_btn_custom_bg_color) ?> <?php echo flooring_check_if_empty('border-color', $flooring_btn_custom_border_color); ?>"
        onMouseOver="this.style.color='<?php echo $flooring_btncustom_hover_color ?>', this.style.backgroundColor='<?php echo $flooring_btn_custom_hover_bg_color ?>'"
        onMouseOut="this.style.color='<?php echo $flooring_btn_custom_text_color ?>', this.style.backgroundColor='<?php echo $flooring_btn_custom_bg_color ?>'"
    >
      <?php echo $flooring_btn_text ?>
    </a>
  </div>

  <?php return ob_get_clean();
}

add_shortcode('flooring_button', 'flooring_button');
<?php 
function wd_separator_title($atts) {
           
  extract( shortcode_atts( array(
  
    'wd_title' => '',
    'wd_title_color' => '',
    'wd_subtitle'=>'',
    'wd_subtitle_color'=>'',
    'wd_separator_style' => 'wd-title-section_c',
    'css_animation' => 'no'
    
  ), $atts ) );

  $animation_classes =  "";
    $data_animated = "";
  if(($css_animation != 'no')){
      $animation_classes =  " animated ";
      $data_animated = "data-animated=$css_animation";
}

    $wd_title = str_replace("/n","<br/>", $wd_title);
    $wd_subtitle = str_replace("/n","<br/>", $wd_subtitle);

    $title_style = $subtitle_style='';
    if($wd_title_color != '') {
        $title_style = "style = 'color:".$wd_title_color .";'" ;
    }
    if($wd_subtitle_color != '') {
        $subtitle_style = "style = 'color:".$wd_subtitle_color .";'" ;
    }


  ob_start(); ?>


<div class="<?php echo esc_attr($animation_classes); ?>" <?php echo esc_attr($data_animated); ?>>
  <div class="large-12 columns <?php echo esc_attr($animation_classes) . ' ' . esc_attr($wd_separator_style) ; ?>" <?php echo esc_attr($data_animated); ?>>

  <?php if ($wd_title != "") { ?>
    <h2 <?php echo $title_style ?>><?php echo $wd_title ?></h2>
  <?php } ?>
  <?php if ($wd_title != "") { ?>
    <h5 <?php echo $subtitle_style ?>><?php echo $wd_subtitle ?></h5>
  <?php } ?>
  
  </div>
</div>

  
<?php return ob_get_clean();
}
add_shortcode( 'wd_separator_title', 'wd_separator_title' );
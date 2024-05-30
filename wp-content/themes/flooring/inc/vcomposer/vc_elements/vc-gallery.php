<?php
/*============================= vc-gallery =====================================*/


$attributes = array(
  'type' => 'dropdown',
  'heading' => esc_html__( 'Gallery type', 'flooring' ),
  'param_name' => 'type',
  'value' => array(
      esc_html__( 'Flex slider fade', 'flooring' ) => 'flexslider_fade',
      esc_html__( 'Flex slider slide', 'flooring' ) => 'flexslider_slide',
      esc_html__( 'Nivo slider', 'flooring' ) => 'nivo',
      esc_html__( 'Image grid', 'flooring' ) => 'image_grid',
      esc_html__('Carousel', 'flooring') => 'Carousel',
  ),
  'description' => esc_html__( 'Select gallery type.', 'flooring' ),
);
vc_add_param( 'vc_gallery', $attributes ); // Note: 'vc-gallery' was used as a base for "Message box" element

<?php
if ( ! function_exists( 'wd_headings' ) ) {
	function wd_headings( $atts ) {

		$custom_header_inline_style = $custom_subheader_inline_style = $custom_separatore_style = $wd_heading_spacing = $heading_extraclass = $headings_separator = $custom_separatore_style = $custom_separatore_img_style = "";

		$default_atts_value = array(
			'title'                 => 'this is a title',
			'headings_title'        => '',
			'headings_title_tag'    => 'h2',
			'headings_subtitle'     => '',
			'headings_subtitle_tag' => 'p',
			'headings_layout'       => 's-under-t',
			'headings_alignment'    => '',
			'headings_max_width'    => '',

			'headings_separator'               => '',
			'headings_separator_position'      => '',
			'headings_separator_border_style'  => '',
			'headings_separator_border_width'  => '',
			'headings_separator_border_height' => '',
			'headings_separator_border_color'  => '',

			'heading_extraclass' => '',

			'wd_heading_font_family'    => '',
			'wd_heading_font_weight'    => '',
			'wd_heading_font_size'      => '',
			'wd_heading_color'          => '',
			'wd_heading_text_transform' => '',
			'wd_heading_line_height'    => '',
			'wd_heading_letter_spacing' => '',

			'wd_heading_spacing' => '10px',

			'wd_sub_heading_font_family'    => '',
			'wd_sub_heading_font_weight'    => '',
			'wd_sub_heading_font_size'      => '',
			'wd_sub_heading_color'          => '',
			'wd_sub_heading_text_transform' => '',
			'wd_sub_heading_line_height'    => '',
			'wd_sub_heading_letter_spacing' => '',

			'heading_top_d_space'    => '',
			'heading_top_t_space'    => '',
			'heading_top_m_space'    => '',
			'heading_bottom_d_space' => '',
			'heading_bottom_t_space' => '',
			'heading_bottom_m_space' => '',

			'css_animation'            => 'no',
			'enable_content_animation' => '',
			'table_css'                => '',

		);


		extract( shortcode_atts( $default_atts_value, $atts ) );


		$headings_title = str_replace( "{", "<span>", $headings_title );
		$headings_title = str_replace( "}", "</span>", $headings_title );

		$headings_subtitle = str_replace( "{", "<span>", $headings_subtitle );
		$headings_subtitle = str_replace( "}", "</span>", $headings_subtitle );

		$headings_title    = str_replace( "/n", "<br/>", $headings_title );
		$headings_subtitle = str_replace( "/n", "<br/>", $headings_subtitle );

		$headings_subtitle != "" ? $stroke_text = $headings_subtitle : $stroke_text = $headings_title;

		if ( $headings_alignment == 'center' ) {
			$custom_separatore_style .= ' margin: ' . esc_attr( $wd_heading_spacing ) . ' auto;';
		} elseif ( $headings_alignment == 'left' ) {
			$custom_separatore_style .= ' margin: ' . esc_attr( $wd_heading_spacing ) . ' 0;';
		} elseif ( $headings_alignment == 'right' ) {
			$custom_separatore_style .= ' margin: ' . esc_attr( $wd_heading_spacing ) . ';';
			$custom_separatore_style .= ' float: right;';
		}

		$custom_header_inline_style        = "";
		$wd_font_family_heading_to_enqueue = "";
		if ( $wd_heading_font_family != '' ) {
			$custom_header_inline_style        .= 'font-family:' . esc_attr( $wd_heading_font_family ) . ';';
			$wd_font_family_heading_to_enqueue .= esc_attr( $wd_heading_font_family ) . ":";
		}
		if ( $wd_heading_font_weight != '' ) {
			$custom_header_inline_style        .= 'font-weight:' . esc_attr( $wd_heading_font_weight ) . ';';
			$wd_font_family_heading_to_enqueue .= esc_attr( $wd_heading_font_weight );
		}
		if ( $wd_heading_font_size != '' ) {
			$custom_header_inline_style .= 'font-size:' . esc_attr( $wd_heading_font_size ) . 'px;';
		}
		if ( $wd_heading_color != '' ) {
			$custom_header_inline_style .= 'color:' . esc_attr( $wd_heading_color ) . ';';
		}
		if ( $wd_heading_text_transform != '' ) {
			$custom_header_inline_style .= 'text-transform:' . esc_attr( $wd_heading_text_transform ) . ';';
		}
		if ( $wd_heading_line_height != '' ) {
			$custom_header_inline_style .= 'line-height:' . esc_attr( $wd_heading_line_height ) . 'px;';
		}
		if ( $wd_heading_letter_spacing != '' ) {
			$custom_header_inline_style .= 'letter-spacing:' . esc_attr( $wd_heading_letter_spacing ) . 'px;';
		}


		// Separator : border
		if ( $headings_separator == 'border' && $headings_separator_border_style !== '' ) {
			$custom_separatore_style .= 'border-bottom-style: ' . esc_attr( $headings_separator_border_style ) . ';';
		}
		if ( $headings_separator == 'border' && $headings_separator_border_width !== '' ) {
			$custom_separatore_style .= 'width: ' . esc_attr( $headings_separator_border_width ) . ';';
		}
		if ( $headings_separator == 'border' && $headings_separator_border_color !== '' ) {
			$custom_separatore_style .= 'border-bottom-color: ' . esc_attr( $headings_separator_border_color ) . ';';
		}
		if ( $headings_separator == 'border' && $headings_separator_border_height !== '' ) {
			$custom_separatore_style .= 'border-bottom-width: ' . esc_attr( $headings_separator_border_height ) . ';';
		}

		if ( $wd_sub_heading_font_family != '' ) {
			$custom_subheader_inline_style     .= 'font-family:' . esc_attr( $wd_sub_heading_font_family ) . ';';
			$wd_font_family_heading_to_enqueue .= "|" . esc_attr( $wd_sub_heading_font_family ) . ":";
		}
		if ( $wd_sub_heading_font_weight != '' ) {
			$custom_subheader_inline_style     .= 'font-weight:' . esc_attr( $wd_sub_heading_font_weight ) . ';';
			$wd_font_family_heading_to_enqueue .= esc_attr( $wd_sub_heading_font_weight );
		}
		if ( $wd_sub_heading_font_size != '' ) {
			$custom_subheader_inline_style .= 'font-size:' . esc_attr( $wd_sub_heading_font_size ) . 'px;';
		}
		if ( $wd_sub_heading_color != '' ) {
			$custom_subheader_inline_style .= 'color:' . esc_attr( $wd_sub_heading_color ) . ';';
		}
		if ( $wd_sub_heading_text_transform != '' ) {
			$custom_subheader_inline_style .= 'text-transform:' . esc_attr( $wd_sub_heading_text_transform ) . ';';
		}
		if ( $wd_sub_heading_line_height != '' ) {
			$custom_subheader_inline_style .= 'line-height:' . esc_attr( $wd_sub_heading_line_height ) . 'px;';
		}
		if ( $wd_sub_heading_letter_spacing != '' ) {
			$custom_subheader_inline_style .= 'letter-spacing:' . esc_attr( $wd_sub_heading_letter_spacing ) . 'px;';
		}


		ob_start();


		echo "<div class='wd_empty_space' data-heightmobile='$heading_top_m_space' data-heighttablet='$heading_top_t_space' data-heightdesktop='$heading_top_d_space'></div>";
		?>
  <div class="wd-heading <?php echo $headings_layout ?> text-<?php esc_attr_e( $headings_alignment ); ?> <?php echo $heading_extraclass; ?>"
       style="<?php echo flooring_check_if_empty( 'max-width', $headings_max_width ) ?>; <?php if ( $headings_alignment == "center" && $headings_max_width != "" ) {
		     echo "margin: 0 auto;";
	     } ?>">
		<?php if ( $headings_layout == "t-under-s" ) { ?>
			<?php if ( $headings_separator_position == "top" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>
			<?php if ( $headings_subtitle != '' ) { ?>
        <<?php echo $headings_subtitle_tag ?> style="<?php echo esc_attr( $custom_subheader_inline_style ); ?>" class="subtitle">
				<?php echo $headings_subtitle ?>
        </<?php echo $headings_subtitle_tag ?>>
			<?php } ?>
			<?php if ( $headings_separator_position == "center" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>

      <<?php echo $headings_title_tag ?> style="<?php echo esc_attr( $custom_header_inline_style ); ?>" "
      data-text="<?php echo $stroke_text ?>">
			<?php echo $headings_title ?>
      </<?php echo $headings_title_tag ?>>

			<?php if ( $headings_separator_position == "bottom" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>

		<?php } elseif ( $headings_layout == "t-only" ) {

			if ( $headings_separator_position == "top" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>

      <<?php echo $headings_title_tag ?> style="<?php echo esc_attr( $custom_header_inline_style ); ?>""
      data-text="<?php echo $stroke_text ?>">
			<?php echo $headings_title ?>
      </<?php echo $headings_title_tag ?>>

			<?php if ( $headings_separator_position == "center" || $headings_separator_position == "bottom" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			}

		} else { ?>

			<?php if ( $headings_separator_position == "top" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>

      <<?php echo $headings_title_tag ?> style="<?php echo esc_attr( $custom_header_inline_style ); ?>" data-text="<?php echo $stroke_text ?>">
			<?php echo $headings_title ?>
      </<?php echo $headings_title_tag ?>>

			<?php if ( $headings_separator_position == "center" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>
			<?php if ( $headings_subtitle != '' ) { ?>
        <<?php echo $headings_subtitle_tag ?> style="<?php echo esc_attr( $custom_subheader_inline_style ); ?>" class="subtitle">
				<?php echo $headings_subtitle ?>
        </<?php echo $headings_subtitle_tag ?>>
			<?php } ?>
			<?php if ( $headings_separator_position == "bottom" ) {
				wd_get_heading_separator( $headings_separator, $custom_separatore_style);
			} ?>

		<?php } ?>
    </div>
		<?php
		echo "<div class='wd_empty_space' data-heightmobile='$heading_bottom_m_space' data-heighttablet='$heading_bottom_t_space' data-heightdesktop='$heading_bottom_d_space'></div>";

		return ob_get_clean();
	}

	add_shortcode( 'wd_headings', 'wd_headings' );
}
?>
<?php 
$flooring_menu_style = flooring_get_option('flooring_menu_style','creative');
$flooring_menu_sticky = flooring_get_option('flooring_menu_sticky', '');
?>
<div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium" >
	<button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
	<div class="title-bar-title">
		<?php
		$flooring_logo_path = flooring_get_option( 'flooring_logo_path', '' ) ?>
		<h1>
			<a title="<?php echo bloginfo( "name" ); ?>" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php if ( $flooring_logo_path != '' ) { ?>
					<img alt="<?php esc_attr__( 'logo', 'flooring' ) ?>"
					     src="<?php echo esc_url( $flooring_logo_path ) ?>">
				<?php } else {
					echo get_bloginfo( "name" );
				} ?>
			</a>
		</h1>
	</div>
</div>

<div data-sticky-container class="l-header <?php echo esc_attr($flooring_menu_style) . '-layout' ?>">
	<div class="contain-to-grid   <?php if($flooring_menu_sticky == 'on')  echo "sticky-nav"; ?> " data-options="marginTop:0;"   data-top-anchor="1" data-btm-anchor="content:bottom" >
		<div class="top-bar <?php 
			if( flooring_get_option( 'flooring_header_contain_to_grid' ) != "off"){ 
				echo "row";
			}else{ 
				echo "full-width-header";
			} ?>" id="responsive-menu" >
			<div class="top-bar-left">				
				<?php $flooring_logo_path = flooring_get_option( 'flooring_logo_path', '' ) ?>
				<h1>
					<a title="<?php echo bloginfo( "name" ); ?>" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if ( $flooring_logo_path != '' ) { ?>
							<img alt="<?php esc_attr__( 'logo', 'flooring' ) ?>"
										src="<?php echo esc_url( $flooring_logo_path ) ?>">
						<?php } else {
							echo get_bloginfo( "name" );
						} ?>
					</a>
				</h1>
			</div>
			<div class="top-bar-right">
				<?php if ( flooring_get_option( 'flooring_show_adress_bar' ) == '1' ) { ?>
					<div class="show-for-meduim-up creative-social">
						<ul class="social-icons inline-list">
							<?php if ( flooring_get_option( 'flooring_phone', '' ) != '' ) { ?>
								<li class="call"><?php echo esc_html__( 'Call us:', 'flooring' ) ?>
									<span><?php echo flooring_get_option( 'flooring_phone', '' ) ?></span>
								</li>
							<?php } ?>
						<?php
						$socialmediaicon_arry = explode(' ', flooring_get_option('social_icon'));
						$socialmedia_arry = explode(' ', flooring_get_option('socialmedia_name'));					
						if(!empty($socialmedia_arry[0])) {
							$i = 0;
							foreach($socialmedia_arry as $social_data) { ?>
								<li class="">
									<a href="<?php echo esc_url($social_data) ?>"><i class="fa fa-<?php echo esc_attr($socialmediaicon_arry[$i]) ?>"></i></a>
								</li>
								<?php
								$i++;
							}
						}
						?>
						</ul>
					</div>
				<?php }				
				flooring_top_bar_primary(); ?>
				<nav class="mobile-menu vertical menu" id="<?php esc_attr(flooring_mobile_menu_id()); ?>">
					<?php flooring_mobile_nav(); ?>
				</nav>
			</div>
		</div>
	</div>
</div>
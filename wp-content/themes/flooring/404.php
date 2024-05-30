<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta content="ie=edge, chrome=1" http-equiv="x-ua-compatible" />
		<meta http-equiv="ImageToolbar" content="false" />
		<meta name="viewport" content="width=device-width" />
		<?php if(flooring_get_option('webdevia_favicon_icon_path','')!= '') { ?>
		 <link rel="shortcut icon" href="<?php echo flooring_get_option('webdevia_favicon_icon_path',''); ?>" />
		<?php } ?>
	<?php wp_head(); ?>
	</head>
	<body>
		


  	<div class="corp">
		<div class="row">
			<section class="oops">
				<h2><?php esc_html_e('Oops!!','flooring'); ?></h2>
			</section>
			<section>
				<p class="message">
					<?php echo esc_html__('It looks like that page no longer exists. Would you like to go to','flooring'); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><strong><?php echo esc_html__('Home page','flooring'); ?></strong></a>  <?php echo esc_html__('instead?','flooring'); ?>
				</p>
			</section>
			<section class="large-6 columns">
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="serch" method="get">
					   <input type="text" class="text-input" id="s" name="s" value="<?php echo esc_html__('Search ...','flooring') ?>" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
					   <input  type="submit" class="submit-input" value="<?php echo esc_html__('Search','flooring') ?>">
				    </form>
			</section>
		</div>	
	</div>
	<div class="oops-footer">
		<ul class="row social-icons accent inline-list">
			<?php
			$socialmediaicon_arry = explode(' ', flooring_get_option('social_icon'));
			$socialmedia_arry = explode(' ', flooring_get_option('socialmedia_name'));
			if(!empty($socialmedia_arry[0])) {
				?>

				<?php
				$i = 0;
				foreach($socialmedia_arry as $social_data) {
					?>
					<li class="">
						<a href="<?php echo esc_url($social_data) ?>"><i
								class="fa <?php echo esc_attr($socialmediaicon_arry[$i]) ?>"></i></a>
					</li>
					<?php
					$i++;
				}
				?>

				<?php
			}
			?>
					
				</ul>
	</div>

	<?php wp_footer(); ?> 
</body>
</html>
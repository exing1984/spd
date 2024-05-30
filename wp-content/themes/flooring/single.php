<?php get_header();
$flooring_menu_style = flooring_get_option('flooring_menu_style','creative');

get_template_part( 'parts/titlebar-'.$flooring_menu_style );
?>



			<main id="l-main" class="row single-post">
            <div class="large-8 main column">
            	<?php if (have_posts()) : 
            		  while (have_posts()) : the_post();
            		?>
	            <div class="blog-page">
		           <?php  the_post_thumbnail('flooring_blog-thumb');  ?>

		            <div class="blog-body clearfix p-t-20">
			           <?php the_content() ?>
		            </div>
                    <ul class="post-infos clearfix">
                        <li>
                            <?php echo esc_html__('By:','flooring') ?> <a href="<?php the_author_link() ?>" ><?php the_author() ?></a>
                        </li>

                        <?php if(has_tag()){ ?>
                            <li class="tag"> <?php the_tags(); ?></li>
                        <?php } ?>
                        <li class="category">
                            <?php echo esc_html__('Category:','flooring') ?> <?php  the_category(', '); ?>
                        </li>
                        <li class="comment-count">
                            <a href="<?php comments_link(); ?>"><?php comments_number( '0', '1', '% responses' ); echo esc_html__(' comment', 'flooring') ?></a>
                        </li>
                    </ul>
	            </div>
	            
	            <?php if (comments_open()){
		              comments_template( '', true );
		            } 
				endwhile;
				endif; ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'flooring' ), 'after' => '</div>' ) ); ?>
            </div>
           <?php get_sidebar(); ?>
        </main>

<?php get_footer(); ?>
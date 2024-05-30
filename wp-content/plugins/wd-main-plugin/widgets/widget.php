<?php

class wd_recent_post extends WP_Widget
{
    function __construct()
    {
        parent::__construct(false, $name = 'Last Posts');
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;


       $instance['title']= $new_instance['title'];
        $instance['dis_posts']= $new_instance['dis_posts'];
        $instance['show_thumb']= isset($new_instance['show_thumb']) ? $new_instance['show_thumb'] : "";

        return $instance;
    }
    function form($instance)
    {
        $title = esc_attr($instance['title']);
        $dis_posts = esc_attr($instance['dis_posts']);
        $show_thumb = isset($instance['show_thumb']) ? $instance['show_thumb'] : "";
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat"
                                                                                                  id="<?php echo $this->get_field_id('title'); ?>"
                                                                                                  name="<?php echo $this->get_field_name('title'); ?>"
                                                                                                  type="text"
                                                                                                  value="<?php echo $title; ?>"/></label>
        </p>
        <p><label for="<?php echo $this->get_field_id('dis_posts'); ?>"><?php _e('Number of Posts Displayed:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('dis_posts'); ?>"
                       name="<?php echo $this->get_field_name('dis_posts'); ?>" type="text"
                       value="<?php echo $dis_posts; ?>"/></label></p>
        <p><label for="<?php echo $this->get_field_id('show_thumb'); ?>"><?php _e('show thumbnail'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('show_thumb'); ?>"
                       name="<?php echo $this->get_field_name('show_thumb'); ?>" type="checkbox"
                    <?php checked( 'on', $show_thumb ); ?> ></label></p>
        <?php
    }


    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $dis_posts = $instance['dis_posts'];
        $show_thumb = esc_attr($instance['show_thumb']);
        ?>
        <?php echo $before_widget; ?>
        <?php if ($title)
        echo $before_title . $title . $after_title;
        global $wp_registered_sidebars;
        foreach ($wp_registered_sidebars as $value) {

            if ($value['name'] == 'footer') {
                $class = "black-separateur";
            } else {
                $class = "";
            }
        }

        ?>
        <div class="latest-posts <?php echo $class ?>">
            <ul>
                <?php
                global $post;
                global $wp_query;
                $args = array('posts_per_page' => $dis_posts);
                $loop = new WP_Query($args);
                while ($loop->have_posts()) : $loop->the_post();
                    ?>
                    <li class="clearfix">
                        <?php if (has_post_thumbnail() && $show_thumb == "on") { ?>
                        <div class="blog-image <?php if (is_rtl()) {
                            echo 'right';
                        } else {
                            echo 'left';
                        } ?>">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </div>
                        <?php } ?>
                        <div class="recent-post-details <?php if($show_thumb == "on") { echo "has-image"; } ?>">
                            <h3 class="blog-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
                            <p class="subheader">
                                <?php the_time('d') ?> <?php the_time('F') ?>,<?php the_time('Y') ?>
                            </p>
                        </div>

                    </li>

                <?php endwhile; ?>
            </ul>
        </div>
        <?php echo $after_widget; ?>
        <?php
    }
}

add_action('widgets_init', function () {
    register_widget("wd_recent_post");
});
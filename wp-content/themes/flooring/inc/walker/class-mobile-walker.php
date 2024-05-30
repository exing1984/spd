<?php

if (!class_exists('flooring_mobile_walker')) :
    class flooring_mobile_walker extends Walker_Nav_Menu
    {
        function start_lvl(&$output, $depth = 0, $args = array())
        {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"vertical nested menu\">\n";
        }
    }
endif;

<?php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Start Level
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    // Start Element
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // Add default class for all items
        $classes[] = 'nav-item';

        // Check if the menu item has children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'menu-item-has-children';
        }

        // Combine and filter classes
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        // Add ID attribute
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        // Build the opening <li> tag
        $output .= $indent . '<li' . $id . $class_names .'>';

        // Link attributes
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )       ? $item->xfn         : '';
        $atts['href']   = ! empty( $item->url )       ? $item->url         : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Build the link output
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        // Add ion-icon for dropdown
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<span class="dropdown-icon"><ion-icon name="chevron-down-outline"></ion-icon></span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        // Apply filters to the final item output
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

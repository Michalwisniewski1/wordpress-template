<?php
/**
* load css/scripts
*/
function load_styles_and_scripts() {

  // loading CSS
  wp_enqueue_style(
      'bootstrap-styles',
      'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
  );

  wp_enqueue_style(
      'font-awesome',
      'http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'
    );

  wp_enqueue_style(
      'main-styles',
      get_template_directory_uri().'/style.css'
  );

  // loading bootstrap js
  wp_enqueue_script(
    'bootstrap-js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
    false,
    '3.3.7',
    true
  );

  // loading js
  wp_enqueue_script(
    'jquery',
    'https://code.jquery.com/jquery-3.2.1.min.js',
    false,
    '3.2.1',
    true
  );
}

add_action('wp_enqueue_scripts', 'load_styles_and_scripts');


/**
* Header's and footer's menu
**/
register_nav_menus(array(

    'main-nav' => 'Gorne menu strony'

));

register_nav_menus(array(

    'footer-nav' => 'Menu w stopce'

));

/**
 * Footer's widgets
 */

function footer_widgets_init() {
    //1st column
    register_sidebar ( array(
      'name'          => 'footer-sidebar-1',
      'description'   => 'First widget',
      'before_widget' => '<div class="jumbotron">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>'
    ));
    //2nd column
    register_sidebar ( array(
      'name'          => 'footer-sidebar-2',
      'description'   => 'Second widget',
      'before_widget' => '<div class="well well-lg">',
      'after_widget'  => '</div>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>'
    ));
    //3rd column
    register_sidebar ( array(
      'name'          => 'footer-sidebar-3',
      'description'   => 'Third widget',
      'before_widget' => '<div class="custom-footer-widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<div class="page-header"><h3 class="widget-title">',
      'after_title'   => '</h3></div>'
    ));
}
//Widgets
add_action( 'widgets_init', 'footer_widgets_init' );

/**
 * thumbnails
 */
add_theme_support( 'post-thumbnails');


/**
 * Implement the Bootstrap 3.0+ navigation style in a custom theme using the WordPress built in menu manager.
 */
class BootstrapNavMenuWalker extends Walker_Nav_Menu {


  function start_lvl( &$output, $depth ) {

    $indent = str_repeat( "\t", $depth );
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output    .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";

  }

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    // managing divider: add divider class to an element to get a divider before it.
    $divider_class_position = array_search('divider', $classes);
    if($divider_class_position !== false){
      $output .= "<li class=\"divider\"></li>\n";
      unset($classes[$divider_class_position]);
    }

    $classes[] = ($args->has_children) ? 'dropdown' : '';
    $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
    $classes[] = 'menu-item-' . $item->ID;
    if($depth && $args->has_children){
      $classes[] = 'dropdown-submenu';
    }


    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr( $class_names ) . '"';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
    $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ($args->has_children)      ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
    $item_output .= ($depth == 0 && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
    $item_output .= $args->after;


    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }


  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
    //v($element);
    if ( !$element )
      return;

    $id_field = $this->db_fields['id'];

    //display this element
    if ( is_array( $args[0] ) )
      $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
    else if ( is_object( $args[0] ) )
      $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'start_el'), $cb_args);

    $id = $element->$id_field;

    // descend only when the depth is right and there are childrens for this element
    if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

      foreach( $children_elements[ $id ] as $child ){

        if ( !isset($newlevel) ) {
          $newlevel = true;
          //start the child delimiter
          $cb_args = array_merge( array(&$output, $depth), $args);
          call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
        }
        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
      }
      unset( $children_elements[ $id ] );
    }

    if ( isset($newlevel) && $newlevel ){
      //end the child delimiter
      $cb_args = array_merge( array(&$output, $depth), $args);
      call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
    }

    //end this element
    $cb_args = array_merge( array(&$output, $element, $depth), $args);
    call_user_func_array(array(&$this, 'end_el'), $cb_args);

  }

}

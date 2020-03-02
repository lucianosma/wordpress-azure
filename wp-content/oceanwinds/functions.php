<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "./app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
// array_map(
//     'add_filter',
//     ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
//     array_fill(0, 4, 'dirname')
// );
Container::getInstance()
  ->bindIf('config', function () {
    return new Config([
      'assets' => require __DIR__.'/config/assets.php',
      'theme' => require __DIR__.'/config/theme.php',
      'view' => require __DIR__.'/config/view.php',
    ]);
  }, true);


/**********************************************************
** Add featured image to posts
/**********************************************************/
add_theme_support( 'post-thumbnails' );

/**********************************************************
** Menu custom walker
/**********************************************************/
class My_Walker extends Walker_Nav_Menu {
  function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 ) {
    $active_parent_class = $item->current ? 'active ' : '';

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $class_names = $value = '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;

    $output .= $indent . '<li id="menu-item-'. $item->ID . '" class="relative mr-l-l mb-l-nl pt-xs pr-s-xl of-hidden">';

    $attributes = ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .' class="' . $value . $class_names . $active_parent_class . ' relative nav-menu__link" data-title="' . $item->title . '">';
    $item_output .= $args->link_before .  $item->title . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}

/**********************************************************
** ACF PRO - Activate Options Page
/**********************************************************/
if (function_exists('acf_add_options_page')) {
	acf_add_options_sub_page('Social');
	acf_add_options_sub_page('Contacts');
	acf_add_options_sub_page('General');
}


/**********************************************************
** Filter except length to 35 words
/**********************************************************/
function tn_custom_excerpt_length( $length ) {
  return 33;
}
add_filter( 'excerpt_length', 'tn_custom_excerpt_length', 999 );

function new_excerpt_more() {
  return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


/**********************************************************
** Polylang string translations
/**********************************************************/
if (function_exists('pll_register_string')) {
  pll_register_string( 'see more', 'See more' );
  pll_register_string( 'careers', 'Careers' );
  pll_register_string( 'latest news', 'Latest news' );
  pll_register_string( 'mail us', 'Mail us' );
  pll_register_string( 'call us', 'Call us' );
  pll_register_string( 'learn more', 'Learn more' );
  pll_register_string( 'follow us', 'Follow us' );
  pll_register_string( 'play video', 'Play video' );
  pll_register_string( 'accept', 'Accept' );
  pll_register_string( "wind direction", "Today's wind direction" );
  pll_register_string( "All rights reserved", "All rights reserved" );
}


/**********************************************************
** Add Open Graph tags in head
/**********************************************************/
function add_opengraph_doctype( $output ) {
  return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'add_opengraph_doctype');

function opengraph() {

  if (!is_admin()) {
    $post_id = get_queried_object_id();
    $site_name = get_bloginfo('name');
    $url = get_permalink($post_id);
    $title = get_the_title($post_id);
    $description = get_post_field('post_content', $post_id) === "" ? get_bloginfo('description') : wp_trim_words( get_post_field('post_content', $post_id), 25 );
    $image = get_field('og_image', 'options') ? get_field('og_image', 'options') : get_the_post_thumbnail_url($post_id);
    
    echo '<meta property="og:title" content="' . esc_attr($title) . ' | ' . esc_attr($site_name) . '" />';
    echo '<meta property="og:description" content="' . esc_attr($description) . '" />';
    echo '<meta property="og:url" content="' . esc_url($url) . '" />';
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />';
    echo '<meta property="og:image" content="' . esc_url($image) . '" />';
  }
}
add_action('wp_head', 'opengraph');

/**********************************************************
// Remove default text editor
/**********************************************************/
function init_remove_support(){
  remove_post_type_support( 'page', 'editor');
}
add_action('init', 'init_remove_support',100);
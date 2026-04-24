<?php
if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'theme_setup' ) ) :
  function theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
  }
endif;
add_action( 'after_setup_theme', 'theme_setup' );

/* Register menu */
    function register_my_menu() {
      register_nav_menu('header-menu',__( 'Header Menu' ));
      register_nav_menu('footer-menu-1',__( 'Footer menu 1' ));
      register_nav_menu('footer-menu-2',__( 'Footer menu 2' ));
    }
    add_action( 'init', 'register_my_menu' );
/* Register menu end */

//Disable Gutenburg Editor
    add_filter('use_block_editor_for_post', '__return_false', 10);
//Disable Gutenburg Editor end

// support SVG
    function cc_mime_types($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }
    add_filter('upload_mimes', 'cc_mime_types');
// support SVG end

/* Convert to WEBP URL*/
    function webpUrl($url) {
      if($url && strpos($url, 'uploads') !== false){
        $url = str_replace("uploads","uploads-webpc/uploads", $url);
        $url = $url . '.webp';
      }
      return $url;
    }
/* Convert to WEBP URL end*/

/* Enqueue scripts and styles.*/
function theme_scripts() {
  // css
    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), _S_VERSION );
    wp_enqueue_style( 'bootstrap-css',get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap-icons-css',get_template_directory_uri() . '/assets/bootstrap/css/bootstrap-icons.min.css');
    wp_enqueue_style( 'animate-css',get_template_directory_uri() . '/assets/plugins/css/animate.min.css');
    wp_enqueue_style( 'theme-styles', get_template_directory_uri() . '/assets/theme/css/style.css', array(), '1.0' );
    wp_enqueue_style( 'additional-styles', get_template_directory_uri() . '/assets/css/style.min.css', array(), '1.0' );
    wp_style_add_data( 'theme-style', 'rtl', 'replace' );
  // js
    wp_enqueue_script('bootstrap-js',get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.bundle.min.js',array('jquery'), _S_VERSION, true );
    wp_enqueue_script('additional-js', get_template_directory_uri() . '/assets/js/main.min.js', array(), _S_VERSION, true );
    wp_enqueue_script('theme-js',get_template_directory_uri() . '/assets/theme/js/main.js',array('jquery'), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

// Disable automatic <p> and <br> tags in Contact Form 7 forms
add_filter('wpcf7_autop_or_not', '__return_false');

// custom functions
    require get_template_directory() . '/includes/custom.php';
    require get_template_directory() . '/template/wishlist.php'; 
// custom functions end

// CPT
    //require get_template_directory() . '/includes/cpt/career.php';
// CPT end

// Remove editor for 'Page' and 'Expertises' custom post type
  // function remove_editor_for_event_cpt() {
  //   remove_post_type_support( 'expertises', 'editor' );
  //   remove_post_type_support( 'page', 'editor' );
  // }
  // add_action( 'init', 'remove_editor_for_event_cpt' );
// end

// style for editor
function my_mce_css( $mce_css ) {
  $mce_css .= ',' . get_template_directory_uri() . '/editor/editor-style.css';
  return $mce_css;
}
add_filter( 'mce_css', 'my_mce_css' );
// end


?>
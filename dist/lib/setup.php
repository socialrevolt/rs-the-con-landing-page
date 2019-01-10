<?php
/* == make sure rss info is added to head ============================================ */
add_theme_support('automatic-feed-links');
/* == add WP 3.0 menu support ======================================================== */
add_theme_support('menus');
/* == add thumbnail and featured image support ======================================= */
add_theme_support('post-thumbnails');
/* == remove admin bar =============================================================== */
add_filter('show_admin_bar', '__return_false');
/* == Removes the default link on attachments  ======================================= */
update_option('image_default_link_type', 'none');
/* == Remove the version number of WP  =============================================== */
remove_action('wp_head', 'wp_generator');

/* == Add site name to title ========================================================= */
function rs_alter_title($title, $sep) {
   global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo( 'name', 'display' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
    }
    return $title;
}
add_filter('wp_title', 'rs_alter_title', 10, 2);

/* == Queue up all css & js files ==================================================== */
function rs_scripts_styles() {
	wp_enqueue_script('rs_scripts', get_template_directory_uri() . '/dist/js/script.min.js',array('jquery'), null, true);
	wp_enqueue_style('rs_styleS', get_template_directory_uri() . '/dist/css/style.min.css', false, null);
}
add_action('wp_enqueue_scripts', 'rs_scripts_styles');

function rs_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'rs_deregister_scripts' );

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* == adds iOS icons and favicon ===================================================== */
function rs_header_icons() {
  $output = '';
  $output .= '<link rel="apple-touch-icon" sizes="144x144" href="' . get_template_directory_uri() . '/dist/img/favicon/fav_144.png' . '" />' . "\n";
  $output .= '<link rel="apple-touch-icon" sizes="114x114" href="' . get_template_directory_uri() . '/dist/img/favicon/fav_114.png' . '" />' . "\n";
  $output .= '<link rel="apple-touch-icon" sizes="72x72" href="' . get_template_directory_uri() . '/dist/img/favicon/fav_72.png' . ' " />' . "\n";
  $output .= '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/dist/img/favicon/fav_apple.png' . '" />' . "\n";
  $output .= '<link id="favicon" rel="shortcut icon" href="' . get_template_directory_uri() . '/favicon.jpg' . '" type="image/jpeg">' . "\n";
  echo $output;
}
add_action('wp_head', 'rs_header_icons');

//Add Open Graph Meta Info
function facebook_open_graph() {
  global $post;
  if ( !is_singular()) //if it is not a post or a page
   return;
	if($excerpt = $post->post_excerpt) {
			$excerpt = strip_tags($post->post_excerpt);
		$excerpt = str_replace("", "'", $excerpt);
  } else {
    $excerpt = get_bloginfo('description');
	}
  // 100004048168000 - account ID
  //You'll need to find you Facebook profile Id and add it as the admin
  //echo '<meta property="fb:admins" content="100004048168000"/>';
  echo '<meta property="og:title" content="' . get_the_title() . '"/>';
	echo '<meta property="og:description" content="' . $excerpt . '"/>';
  echo '<meta property="og:type" content="article"/>';
  echo '<meta property="og:url" content="' . get_permalink() . '"/>';

  // Customize the below with the name of your site
  echo '<meta property="og:site_name" content="rewardStye"/>';
  if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
    //Create a default image on your server or an image in your media library, and insert it's URL here
    $default_image=''.get_stylesheet_directory_uri().'/dist/img/default.jpg';
    echo '<meta property="og:image" content="' . $default_image . '"/>';
  }
  else{
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
    echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
  }
  echo "";
}
add_action( 'wp_head', 'facebook_open_graph', 5 );

/* == adds wp menus =============================================================== */
function register_my_menus() {
  register_nav_menus(
    array(
			'primary-menu' => __( 'Primary Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
    )
  );
}
add_action( 'init', 'register_my_menus' );

function bemit_nav_menu_css_class( $classes, $item, $args, $depth ) {

  // Reset all default classes and start adding custom classes to array.
  $_classes = [ 'menu__item' ];

  // Get theme location, fallback for `default`.
  $theme_location = $args->theme_location ? $args->theme_location : 'default';

   // Add theme location class.
  $_classes[] = 'menu__item--' . $theme_location;

  // Return custom classes.
  return $_classes;

}
add_filter( 'nav_menu_css_class', 'bemit_nav_menu_css_class', 10, 4 );

function bemit_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

  // Start adding custom classes.
  $atts['class'] = 'menu__anchor';

  // Add `menu__anchor--button` when there is `button` class in `<li>` element.
  if ( in_array( 'button', $item->classes, true ) ) {
     $atts['class'] .= ' menu__anchor--button';
  }

  return $atts;

}
add_filter( 'nav_menu_link_attributes', 'bemit_nav_menu_link_attributes', 10, 4 );

/* == adds svg support =============================================================== */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/* == adds google fonts ============================================================= */
add_action( 'wp_enqueue_scripts', 'load_google_fonts' );
function load_google_fonts() {
  // Setup font arguments
	$query_args = array(
		'family' => 'Montserrat:400,500,700' // Change this font to whatever font you'd like
	);
 	// A safe way to register a CSS style file for later use
	wp_register_style( 'google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
	// A safe way to add/enqueue a CSS style file to a WordPress generated page
	wp_enqueue_style( 'google-fonts' );
}

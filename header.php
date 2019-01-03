<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta content="IE=edge" http-equiv="X-UA-Compatible" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title( '-', true, 'left' );?></title>

<meta name="description" content="<?php if ( is_single() ) {single_post_title('', true);} else {bloginfo('name'); echo " - "; bloginfo('description');} ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php wp_head(); ?>

<noscript>
  <style>
    .lazyload.loading { display: none; }
  </style>
</noscript>

</head>

<body <?php body_class(); ?>>

<div class="site-wrapper" itemscope itemtype="http://schema.org/Event">
<?php
	// Main WP Header file
	include( locate_template( 'views/row-header.php', false, false ) );
	?>
	<main class="base">

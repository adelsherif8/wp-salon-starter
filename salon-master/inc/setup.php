<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 240, 'flex-width' => true ) );
	register_nav_menus( array( 'primary' => __( 'Primary', 'salon-master' ) ) );
	add_image_size( 'salon-portrait', 600, 750, true );
} );

/** One compiled Tailwind file for parent + child (the build scans both themes). Versioned by file time. */
add_action( 'wp_enqueue_scripts', function () {
	$css = '/assets/app.css';
	$js  = '/assets/app.js';
	wp_enqueue_style( 'salon-app', SALON_URI . $css, array(), filemtime( SALON_DIR . $css ) );
	wp_enqueue_script( 'salon-app', SALON_URI . $js, array(), filemtime( SALON_DIR . $js ), array( 'strategy' => 'defer', 'in_footer' => true ) );
	if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/style.css' ) ) {
		wp_enqueue_style( 'salon-child', get_stylesheet_uri(), array( 'salon-app' ), filemtime( get_stylesheet_directory() . '/style.css' ) );
	}
} );

/** Main archive queries: full service menu and team on one page, in menu order. */
add_action( 'pre_get_posts', function ( WP_Query $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( $q->is_post_type_archive( array( 'salon_service', 'salon_stylist', 'salon_location' ) ) ) {
		$q->set( 'posts_per_page', 100 );
		$q->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
	}
} );

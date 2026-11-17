<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	$types = array(
		'salon_service'  => array( 'Services', 'Service', 'services', 'dashicons-art' ),
		'salon_stylist'  => array( 'Stylists', 'Stylist', 'stylists', 'dashicons-groups' ),
		'salon_location' => array( 'Locations', 'Location', 'locations', 'dashicons-location' ),
	);
	foreach ( $types as $type => list( $plural, $single, $slug, $icon ) ) {
		register_post_type( $type, array(
			'labels'       => array( 'name' => $plural, 'singular_name' => $single, 'add_new_item' => "Add {$single}" ),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => $slug ),
			'menu_icon'    => $icon,
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		) );
	}
	register_taxonomy( 'service_category', 'salon_service', array(
		'label' => 'Service categories', 'hierarchical' => true, 'show_in_rest' => true, 'rewrite' => array( 'slug' => 'menu' ),
	) );
	register_taxonomy( 'stylist_level', 'salon_stylist', array(
		'label' => 'Stylist levels', 'hierarchical' => true, 'show_in_rest' => true, 'rewrite' => array( 'slug' => 'level' ),
	) );
} );

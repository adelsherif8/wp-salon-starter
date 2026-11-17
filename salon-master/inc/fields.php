<?php
/**
 * Custom fields, registered in code so they live in Git with the theme.
 * Uses ACF (free) when it is active; salon_field() falls back to post meta so templates never fatal.
 * On ACF PRO the stylist "specialties" and location "hours" would be repeaters; here they are
 * one-per-line textareas parsed in PHP, which keeps the theme free of paid dependencies.
 */
defined( 'ABSPATH' ) || exit;

function salon_field( $name, $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	if ( function_exists( 'get_field' ) ) {
		return get_field( $name, $post_id );
	}
	return get_post_meta( $post_id, $name, true );
}

/** "Mon-Fri: 9-7" lines -> array of [label, value]. */
function salon_lines( $text ) {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( ':', $line, 2 ) );
		$out[] = array( $parts[0], $parts[1] ?? '' );
	}
	return $out;
}

add_action( 'acf/init', function () {
	$field = function ( $key, $label, $type = 'text', $extra = array() ) {
		return array_merge( array( 'key' => "field_salon_{$key}", 'label' => $label, 'name' => $key, 'type' => $type ), $extra );
	};
	acf_add_local_field_group( array(
		'key'      => 'group_salon_service',
		'title'    => 'Service details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'salon_service' ) ) ),
		'fields'   => array(
			$field( 'price_from', 'Price from ($)', 'number', array( 'min' => 0 ) ),
			$field( 'duration', 'Duration (minutes)', 'number', array( 'min' => 0 ) ),
			$field( 'price_note', 'Price note', 'text', array( 'instructions' => 'e.g. "varies by stylist level"' ) ),
		),
	) );
	acf_add_local_field_group( array(
		'key'      => 'group_salon_stylist',
		'title'    => 'Stylist details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'salon_stylist' ) ) ),
		'fields'   => array(
			$field( 'job_title', 'Job title' ),
			$field( 'years', 'Years of experience', 'number', array( 'min' => 0 ) ),
			$field( 'specialties', 'Specialties (one per line)', 'textarea', array( 'rows' => 4 ) ),
			$field( 'location', 'Works at', 'post_object', array( 'post_type' => array( 'salon_location' ), 'return_format' => 'id' ) ),
			$field( 'booking_url', 'Book with this stylist (URL)', 'url' ),
			$field( 'instagram', 'Instagram handle' ),
		),
	) );
	acf_add_local_field_group( array(
		'key'      => 'group_salon_location',
		'title'    => 'Location details',
		'location' => array( array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'salon_location' ) ) ),
		'fields'   => array(
			$field( 'street', 'Street address' ),
			$field( 'city', 'City' ),
			$field( 'region', 'State / province' ),
			$field( 'postcode', 'ZIP / postal code' ),
			$field( 'phone', 'Phone' ),
			$field( 'hours', 'Hours (one per line, "Mo-Fr: 09:00-19:00")', 'textarea', array( 'rows' => 5 ) ),
			$field( 'lat', 'Latitude', 'text' ),
			$field( 'lng', 'Longitude', 'text' ),
			$field( 'booking_url', 'Online booking URL (Zenoti, Phorest, SalonBiz...)', 'url' ),
		),
	) );
} );

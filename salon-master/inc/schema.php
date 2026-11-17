<?php
/**
 * JSON-LD for local search: one salon entity per location (HairSalon / BeautySalon / DaySpa / NailSalon),
 * with address, geo, phone and opening hours. Printed on the home page (all locations) and on each location.
 */
defined( 'ABSPATH' ) || exit;

function salon_location_schema( $id ) {
	$type  = get_theme_mod( 'salon_schema_type', 'HairSalon' );
	$type  = in_array( $type, array( 'HairSalon', 'BeautySalon', 'DaySpa', 'NailSalon' ), true ) ? $type : 'HairSalon';
	$hours = array();
	foreach ( salon_lines( salon_field( 'hours', $id ) ) as list( $days, $time ) ) {
		if ( preg_match( '/^(\d{2}:\d{2})-(\d{2}:\d{2})$/', str_replace( ' ', '', $time ), $m ) ) {
			$hours[] = "{$days} {$m[1]}-{$m[2]}"; // schema.org openingHours text format, e.g. "Mo-Fr 09:00-19:00"
		}
	}
	$data = array(
		'@type'     => $type,
		'@id'       => get_permalink( $id ) . '#salon',
		'name'      => get_bloginfo( 'name' ) . ' ' . get_the_title( $id ),
		'url'       => get_permalink( $id ),
		'telephone' => salon_field( 'phone', $id ),
		'address'   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => salon_field( 'street', $id ),
			'addressLocality' => salon_field( 'city', $id ),
			'addressRegion'   => salon_field( 'region', $id ),
			'postalCode'      => salon_field( 'postcode', $id ),
		),
		'openingHours' => $hours,
		'parentOrganization' => array( '@id' => home_url( '/#org' ) ),
	);
	if ( salon_field( 'lat', $id ) && salon_field( 'lng', $id ) ) {
		$data['geo'] = array( '@type' => 'GeoCoordinates', 'latitude' => (float) salon_field( 'lat', $id ), 'longitude' => (float) salon_field( 'lng', $id ) );
	}
	if ( $book = salon_booking_url( $id ) ) {
		$data['potentialAction'] = array( '@type' => 'ReserveAction', 'target' => $book );
	}
	if ( has_post_thumbnail( $id ) ) {
		$data['image'] = get_the_post_thumbnail_url( $id, 'large' );
	}
	return array_filter( $data );
}

add_action( 'wp_head', function () {
	$graph = array();
	if ( is_front_page() ) {
		$graph[] = array( '@type' => 'Organization', '@id' => home_url( '/#org' ), 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) );
		foreach ( get_posts( array( 'post_type' => 'salon_location', 'numberposts' => 20, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) as $loc ) {
			$graph[] = salon_location_schema( $loc->ID );
		}
	} elseif ( is_singular( 'salon_location' ) ) {
		$graph[] = salon_location_schema( get_the_ID() );
	}
	if ( $graph ) {
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES ) . "</script>\n";
	}
} );

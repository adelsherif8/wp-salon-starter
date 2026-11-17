<?php
/**
 * Demo content for a fictional two-location salon ("Maison Rouge"). Run: npm run wp:seed
 * Everything here is made up: names, addresses, phone numbers and prices.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

$set = function ( $id, $name, $value ) {
	function_exists( 'update_field' ) ? update_field( $name, $value, $id ) : update_post_meta( $id, $name, $value );
};
$post = function ( $type, $title, $content = '', $order = 0 ) {
	$found = get_posts( array( 'post_type' => $type, 'title' => $title, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) );
	return $found ? $found[0] : wp_insert_post( array( 'post_type' => $type, 'post_title' => $title, 'post_content' => $content, 'post_status' => 'publish', 'menu_order' => $order ) );
};
/** Placeholder portrait: soft colour + initials, generated with GD. */
$portrait = function ( $post_id, $initials, $rgb ) {
	if ( has_post_thumbnail( $post_id ) || ! function_exists( 'imagecreatetruecolor' ) ) { return; }
	$im = imagecreatetruecolor( 600, 750 );
	imagefill( $im, 0, 0, imagecolorallocate( $im, ...$rgb ) );
	$ink = imagecolorallocate( $im, 255, 255, 255 );
	imagestring( $im, 5, 280, 365, $initials, $ink );
	$up = wp_upload_dir(); $file = $up['path'] . "/demo-{$post_id}.png"; imagepng( $im, $file ); imagedestroy( $im );
	$att = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => $initials, 'post_status' => 'inherit' ), $file, $post_id );
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $file ) );
	set_post_thumbnail( $post_id, $att );
};

/** Import a demo photo shipped in assets/demo (Unsplash, see CREDITS.md) once, return its attachment ID. */
$photo = function ( $name, $parent = 0 ) {
	$found = get_posts( array( 'post_type' => 'attachment', 'meta_key' => '_salon_demo', 'meta_value' => $name, 'numberposts' => 1, 'fields' => 'ids' ) );
	if ( $found ) { return $found[0]; }
	$src = get_template_directory() . "/assets/demo/{$name}.jpg";
	if ( ! file_exists( $src ) ) { return 0; }
	$up = wp_upload_dir(); $dest = trailingslashit( $up['path'] ) . "salon-{$name}.jpg"; copy( $src, $dest );
	$att = wp_insert_attachment( array( 'post_mime_type' => 'image/jpeg', 'post_title' => ucfirst( $name ), 'post_status' => 'inherit' ), $dest, $parent );
	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $att, wp_generate_attachment_metadata( $att, $dest ) );
	update_post_meta( $att, '_salon_demo', $name );
	return $att;
};

// Locations
$locs = array(
	array( 'Uptown', '4120 Magazine St', 'New Orleans', 'LA', '70115', '(504) 555-0142', 29.9227, -90.1022 ),
	array( 'Metairie', '3301 Veterans Blvd', 'Metairie', 'LA', '70002', '(504) 555-0187', 30.0060, -90.1600 ),
);
$loc_ids = array();
foreach ( $locs as $i => list( $name, $street, $city, $region, $zip, $phone, $lat, $lng ) ) {
	$id = $post( 'salon_location', $name, 'Free parking behind the salon. Complimentary consultation with every colour service.', $i );
	foreach ( compact( 'street', 'city', 'region', 'phone', 'lat', 'lng' ) as $k => $v ) { $set( $id, $k, $v ); }
	$set( $id, 'postcode', $zip );
	$set( $id, 'hours', "Tu-Fr: 09:00-19:00\nSa: 08:00-17:00\nSu-Mo: Closed" );
	$set( $id, 'booking_url', 'https://example.com/book/' . sanitize_title( $name ) );
	if ( ! has_post_thumbnail( $id ) && ( $img = $photo( strtolower( $name ), $id ) ) ) { set_post_thumbnail( $id, $img ); }
	$loc_ids[ $name ] = $id;
}

// Service menu
$menu = array(
	'Cut & Style' => array( array( "Women's cut & style", 'Consultation, wash, cut and blow-dry.', 75, 60 ), array( "Men's cut", 'Clipper or scissor cut, hot towel finish.', 45, 45 ), array( 'Blow-dry', 'Wash and blow-dry, straight or waves.', 50, 45 ) ),
	'Colour'      => array( array( 'Single-process colour', 'Root touch-up or all-over colour.', 95, 90 ), array( 'Balayage', 'Hand-painted, soft grown-out blend.', 210, 180 ), array( 'Gloss', 'Tone and shine between colour visits.', 55, 30 ) ),
	'Treatments'  => array( array( 'Bond repair treatment', 'Rebuilds strength after colour.', 40, 20 ), array( 'Scalp ritual', 'Exfoliation, massage and steam.', 65, 45 ) ),
);
$o = 0;
foreach ( $menu as $cat => $items ) {
	$term = term_exists( $cat, 'service_category' ) ?: wp_insert_term( $cat, 'service_category' );
	foreach ( $items as list( $title, $desc, $price, $mins ) ) {
		$id = $post( 'salon_service', $title, $desc, $o++ );
		wp_set_object_terms( $id, (int) $term['term_id'], 'service_category' );
		$set( $id, 'price_from', $price ); $set( $id, 'duration', $mins );
	}
}

// Team
$team = array(
	array( 'Camille Broussard', 'Master Stylist', 'Master', 14, "Balayage\nPrecision cuts\nBridal", 'Uptown', array( 163, 51, 74 ) ),
	array( 'Andre Thibodeaux', 'Senior Stylist', 'Senior', 9, "Men's cuts\nTextured hair\nFades", 'Uptown', array( 47, 74, 58 ) ),
	array( 'Lena Park', 'Colour Specialist', 'Senior', 7, "Colour correction\nBlonding\nGloss", 'Metairie', array( 156, 107, 78 ) ),
	array( 'Maya Fontenot', 'Stylist', 'New Talent', 2, "Blow-dries\nWaves\nTrims", 'Metairie', array( 118, 102, 106 ) ),
);
foreach ( $team as $i => list( $name, $title, $level, $years, $spec, $loc, $rgb ) ) {
	$id = $post( 'salon_stylist', $name, "{$name} has been doing hair for {$years} years and loves a good consultation.", $i );
	$term = term_exists( $level, 'stylist_level' ) ?: wp_insert_term( $level, 'stylist_level' );
	wp_set_object_terms( $id, (int) $term['term_id'], 'stylist_level' );
	$set( $id, 'job_title', $title ); $set( $id, 'years', $years ); $set( $id, 'specialties', $spec ); $set( $id, 'location', $loc_ids[ $loc ] );
	$img = $photo( strtolower( strtok( $name, ' ' ) ), $id );
	if ( $img && ! has_post_thumbnail( $id ) ) { set_post_thumbnail( $id, $img ); }
	if ( ! $img ) { $portrait( $id, implode( '', array_map( function ( $w ) { return $w[0]; }, explode( ' ', $name ) ) ), $rgb ); }
}

// Pages, menu, settings
$home = $post( 'page', 'Home' );
if ( ! has_post_thumbnail( $home ) && ( $img = $photo( 'hero', $home ) ) ) { set_post_thumbnail( $home, $img ); }
update_option( 'salon_gallery', array_filter( array_map( $photo, array( 'g1', 'g2', 'g3', 'g4', 'g5' ) ) ) );
update_option( 'salon_before_after', $photo( 'gloss' ) );
// Fictional reviews for the demo
update_option( 'salon_reviews', array(
	array( 'Camille took me from brassy to the exact soft blonde I showed her. First salon that actually listened.', 'Jess R.' ),
	array( 'Booked online at 11 pm, got a reminder text, in and out in an hour. Best fade in Uptown.', 'Marcus T.' ),
	array( 'Lena fixed a box-dye disaster in one visit. I cried a little. Happy tears.', 'Priya S.' ),
	array( 'The scalp ritual is the most relaxing 45 minutes of my month.', 'Dana L.' ),
	array( 'Warm, honest about price before they start, and the coffee is good.', 'Nora B.' ),
) );
update_option( 'show_on_front', 'page' ); update_option( 'page_on_front', $home );
update_option( 'blogname', 'Maison Rouge' ); update_option( 'blogdescription', 'Hair, colour and care in New Orleans.' );
set_theme_mod( 'salon_tagline', 'Hair that feels like you.' );
set_theme_mod( 'salon_booking_url', 'https://example.com/book' );
set_theme_mod( 'salon_schema_type', 'HairSalon' );
$menu_id = wp_get_nav_menu_object( 'Primary' ) ? wp_get_nav_menu_object( 'Primary' )->term_id : wp_create_nav_menu( 'Primary' );
if ( ! wp_get_nav_menu_items( $menu_id ) ) {
	foreach ( array( 'Menu' => 'salon_service', 'Stylists' => 'salon_stylist', 'Locations' => 'salon_location' ) as $label => $type ) {
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => $label, 'menu-item-url' => get_post_type_archive_link( $type ), 'menu-item-status' => 'publish', 'menu-item-type' => 'custom' ) );
	}
}
set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu_id ) );
switch_theme( 'salon-child-maison' );
// set the menu again on the child theme (theme mods are per theme), then rebuild permalinks
set_theme_mod( 'nav_menu_locations', array( 'primary' => $menu_id ) );
foreach ( array( 'salon_tagline' => 'Hair that feels like you.', 'salon_booking_url' => 'https://example.com/book', 'salon_schema_type' => 'HairSalon' ) as $k => $v ) { set_theme_mod( $k, $v ); }
update_option( 'permalink_structure', '/%postname%/' ); flush_rewrite_rules();
echo "Seeded: " . count( $loc_ids ) . " locations, {$o} services, " . count( $team ) . " stylists.\n";

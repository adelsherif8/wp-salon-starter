<?php
/**
 * Booking. Salons book in their own software (Zenoti, Phorest, SalonBiz...), so the site's job is to
 * send people to the right booking page for the right location or stylist, and to track the click.
 */
defined( 'ABSPATH' ) || exit;

function salon_booking_url( $location_id = 0, $stylist_id = 0 ) {
	foreach ( array( $stylist_id, $location_id ) as $id ) {
		if ( $id && ( $url = salon_field( 'booking_url', $id ) ) ) {
			return $url;
		}
	}
	return get_theme_mod( 'salon_booking_url', '' );
}

/** The one Book Now button every template uses. data-* attributes feed the GA4 event in app.js. */
function salon_book_button( $args = array() ) {
	$a   = wp_parse_args( $args, array( 'location' => 0, 'stylist' => 0, 'label' => __( 'Book now', 'salon-master' ), 'class' => '', 'context' => 'page' ) );
	$url = salon_booking_url( $a['location'], $a['stylist'] );
	if ( ! $url ) {
		return;
	}
	printf(
		'<a href="%1$s" class="btn-book %2$s" target="_blank" rel="noopener" data-salon-book data-context="%3$s" data-location="%4$s" data-stylist="%5$s">%6$s</a>',
		esc_url( $url ),
		esc_attr( $a['class'] ),
		esc_attr( $a['context'] ),
		esc_attr( $a['location'] ? get_the_title( $a['location'] ) : '' ),
		esc_attr( $a['stylist'] ? get_the_title( $a['stylist'] ) : '' ),
		esc_html( $a['label'] )
	);
}

/**
 * [salon_booking_widget url="..."]: embeds a booking page in an iframe, but only from booking platforms
 * we trust; anything else becomes a plain button so editors can't paste arbitrary embeds.
 */
add_shortcode( 'salon_booking_widget', function ( $atts ) {
	$atts  = shortcode_atts( array( 'url' => get_theme_mod( 'salon_booking_url', '' ), 'height' => 760 ), $atts );
	$host  = wp_parse_url( $atts['url'], PHP_URL_HOST );
	$hosts = apply_filters( 'salon_booking_hosts', array( 'zenoti.com', 'phorest.com', 'phorest.me', 'salonbiz.com' ) );
	$ok    = $host && array_filter( $hosts, function ( $h ) use ( $host ) { return $host === $h || substr( $host, -strlen( ".$h" ) ) === ".$h"; } );
	if ( ! $ok ) {
		return '<p><a class="btn-book" data-salon-book data-context="widget-fallback" href="' . esc_url( $atts['url'] ) . '" target="_blank" rel="noopener">' . esc_html__( 'Book online', 'salon-master' ) . '</a></p>';
	}
	return sprintf( '<iframe class="w-full rounded-xl border border-black/10" src="%s" height="%d" loading="lazy" title="%s"></iframe>',
		esc_url( $atts['url'] ), absint( $atts['height'] ), esc_attr__( 'Online booking', 'salon-master' ) );
} );

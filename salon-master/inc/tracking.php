<?php
/**
 * GA4 through Google Tag Manager. The container ID is a Customizer setting; app.js pushes
 * book_now_click / phone_click / directions_click to the dataLayer, and GTM turns those into GA4 events.
 */
defined( 'ABSPATH' ) || exit;

function salon_gtm_id() {
	$id = strtoupper( trim( (string) get_theme_mod( 'salon_gtm_id', '' ) ) );
	return preg_match( '/^GTM-[A-Z0-9]{4,10}$/', $id ) ? $id : '';
}

add_action( 'wp_head', function () {
	echo "<script>window.dataLayer=window.dataLayer||[];</script>\n";
	if ( $id = salon_gtm_id() ) {
		printf( "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','%s');</script>\n", esc_js( $id ) );
	}
}, 1 );

add_action( 'wp_body_open', function () {
	if ( $id = salon_gtm_id() ) {
		printf( '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>', esc_attr( $id ) );
	}
} );

<?php
/**
 * Brand tokens. Tailwind's colours and fonts point at CSS variables (see tailwind.config.js),
 * so a child theme rebrands a site by filtering these values: no new CSS build per client.
 */
defined( 'ABSPATH' ) || exit;

function salon_brand_tokens() {
	return apply_filters( 'salon_brand_tokens', array(
		'--salon-ink'     => '29 26 23',   // RGB channels so Tailwind opacity works: text-ink/60
		'--salon-paper'   => '250 247 242',
		'--salon-accent'  => '#9c6b4e',
		'--salon-accent2' => '#2f4a3a',
		'--salon-muted'   => '#6f655b',
		'--salon-display' => "'Playfair Display', Georgia, serif",
		'--salon-body'    => "'Inter', system-ui, sans-serif",
	) );
}

add_action( 'wp_head', function () {
	$css = '';
	foreach ( salon_brand_tokens() as $var => $value ) {
		if ( preg_match( '/^--salon-[a-z0-9-]+$/', $var ) ) {
			$css .= $var . ':' . preg_replace( '/[^#a-zA-Z0-9 ,.\'()%-]/', '', $value ) . ';';
		}
	}
	echo '<style id="salon-tokens">:root{' . $css . '}</style>' . "\n"; // values sanitised above
	$fonts = apply_filters( 'salon_google_fonts', 'family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=Inter:wght@400;500;600' );
	if ( $fonts ) {
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		echo '<link rel="stylesheet" href="' . esc_url( 'https://fonts.googleapis.com/css2?' . $fonts . '&display=swap' ) . '">' . "\n";
	}
}, 5 );

/** Customizer: settings an account manager can change without a developer. */
add_action( 'customize_register', function ( WP_Customize_Manager $c ) {
	$c->add_section( 'salon_settings', array( 'title' => 'Salon settings', 'priority' => 30 ) );
	$settings = array(
		'salon_gtm_id'      => array( 'Google Tag Manager ID (GTM-XXXX)', 'sanitize_text_field' ),
		'salon_booking_url' => array( 'Default online booking URL', 'esc_url_raw' ),
		'salon_schema_type' => array( 'Schema type: HairSalon, BeautySalon, DaySpa or NailSalon', 'sanitize_text_field' ),
		'salon_tagline'     => array( 'Hero tagline', 'sanitize_text_field' ),
	);
	foreach ( $settings as $id => list( $label, $clean ) ) {
		$c->add_setting( $id, array( 'sanitize_callback' => $clean ) );
		$c->add_control( $id, array( 'label' => $label, 'section' => 'salon_settings', 'type' => 'text' ) );
	}
} );

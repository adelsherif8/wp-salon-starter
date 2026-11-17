<?php
/** Maison Rouge: the whole rebrand is these tokens + fonts. Layout, menu, schema and tracking come from the parent. */
defined( 'ABSPATH' ) || exit;

add_filter( 'salon_brand_tokens', function ( $t ) {
	return array_merge( $t, array(
		'--salon-ink'     => '35 26 28',
		'--salon-paper'   => '251 246 243',
		'--salon-accent'  => '#a3334a',
		'--salon-accent2' => '#e9d6cf',
		'--salon-muted'   => '#76666a',
		'--salon-display' => "'Cormorant Garamond', Georgia, serif",
		'--salon-body'    => "'DM Sans', system-ui, sans-serif",
	) );
} );

add_filter( 'salon_google_fonts', function () {
	return 'family=Cormorant+Garamond:ital,wght@0,500;0,700;1,500&family=DM+Sans:wght@400;500;700';
} );

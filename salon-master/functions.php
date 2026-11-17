<?php
/**
 * Salon Master: parent theme. Everything client-specific lives in a child theme
 * (brand tokens, logo, template overrides), so one fix here reaches every site.
 */
defined( 'ABSPATH' ) || exit;

define( 'SALON_DIR', get_template_directory() );
define( 'SALON_URI', get_template_directory_uri() );

foreach ( array( 'setup', 'post-types', 'fields', 'brand', 'booking', 'schema', 'tracking', 'gravity-forms' ) as $salon_file ) {
	require SALON_DIR . "/inc/{$salon_file}.php";
}

<?php
/**
 * Gravity Forms helpers (only load when Gravity Forms is active).
 * NOTE: written against the documented hooks; not run in this repo's demo because Gravity Forms needs a licence.
 *  - Any field with the CSS class "salon-locations" is filled with the salon's locations.
 *  - After a submission, a generate_lead event is queued for the dataLayer on the confirmation page.
 */
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'GFForms' ) ) {
	return;
}

function salon_gf_locations( $form ) {
	foreach ( $form['fields'] as $field ) {
		if ( false === strpos( (string) $field->cssClass, 'salon-locations' ) ) {
			continue;
		}
		$field->choices = array_map( function ( $p ) {
			return array( 'text' => $p->post_title, 'value' => $p->post_title );
		}, get_posts( array( 'post_type' => 'salon_location', 'numberposts' => 50, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) );
	}
	return $form;
}
foreach ( array( 'gform_pre_render', 'gform_pre_validation', 'gform_pre_submission_filter', 'gform_admin_pre_render' ) as $hook ) {
	add_filter( $hook, 'salon_gf_locations' );
}

add_filter( 'gform_confirmation', function ( $confirmation, $form ) {
	if ( is_string( $confirmation ) ) {
		$confirmation .= sprintf( '<script>window.dataLayer=window.dataLayer||[];dataLayer.push({event:"generate_lead",form_name:%s});</script>', wp_json_encode( $form['title'] ) );
	}
	return $confirmation;
}, 10, 2 );

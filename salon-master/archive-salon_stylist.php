<?php
/** "Find your stylist": filter by level and location (client-side; the full team is on the page). */
get_header();
$levels = get_terms( array( 'taxonomy' => 'stylist_level', 'hide_empty' => true ) );
$locs   = get_posts( array( 'post_type' => 'salon_location', 'numberposts' => 20, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>
<section class="mx-auto max-w-6xl px-5 py-20">
	<h1 class="font-display text-5xl"><?php esc_html_e( 'Find your stylist', 'salon-master' ); ?></h1>
	<form class="mt-8 flex flex-wrap gap-4" data-stylist-filter aria-label="<?php esc_attr_e( 'Filter stylists', 'salon-master' ); ?>">
		<label class="text-sm"><span class="mb-1 block text-muted"><?php esc_html_e( 'Level', 'salon-master' ); ?></span>
			<select name="level" class="rounded-lg border border-ink/20 bg-white px-3 py-2">
				<option value=""><?php esc_html_e( 'Any level', 'salon-master' ); ?></option>
				<?php foreach ( is_wp_error( $levels ) ? array() : $levels as $l ) : ?><option value="<?php echo esc_attr( $l->slug ); ?>"><?php echo esc_html( $l->name ); ?></option><?php endforeach; ?>
			</select></label>
		<label class="text-sm"><span class="mb-1 block text-muted"><?php esc_html_e( 'Location', 'salon-master' ); ?></span>
			<select name="location" class="rounded-lg border border-ink/20 bg-white px-3 py-2">
				<option value=""><?php esc_html_e( 'Any location', 'salon-master' ); ?></option>
				<?php foreach ( $locs as $loc ) : ?><option value="<?php echo esc_attr( $loc->ID ); ?>"><?php echo esc_html( $loc->post_title ); ?></option><?php endforeach; ?>
			</select></label>
		<p class="self-end pb-2 text-sm text-muted" aria-live="polite" data-stylist-count></p>
	</form>
	<div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
		<?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/stylist-card' ); } ?>
	</div>
</section>
<?php get_footer(); ?>

<?php get_header(); ?>
<?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/hero' ); } ?>

<section class="mx-auto max-w-6xl px-5 py-16">
	<div class="mb-10 flex items-end justify-between gap-6">
		<h2 class="font-display text-4xl"><?php esc_html_e( 'The menu', 'salon-master' ); ?></h2>
		<a class="text-sm font-medium uppercase tracking-wider text-accent" href="<?php echo esc_url( get_post_type_archive_link( 'salon_service' ) ); ?>"><?php esc_html_e( 'Full menu', 'salon-master' ); ?> &rarr;</a>
	</div>
	<?php get_template_part( 'template-parts/service-menu', null, array( 'limit' => 3 ) ); ?>
</section>

<?php $team = new WP_Query( array( 'post_type' => 'salon_stylist', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
<?php if ( $team->have_posts() ) : ?>
<section class="bg-white py-16">
	<div class="mx-auto max-w-6xl px-5">
		<div class="mb-10 flex items-end justify-between gap-6">
			<h2 class="font-display text-4xl"><?php esc_html_e( 'Meet the team', 'salon-master' ); ?></h2>
			<a class="text-sm font-medium uppercase tracking-wider text-accent" href="<?php echo esc_url( get_post_type_archive_link( 'salon_stylist' ) ); ?>"><?php esc_html_e( 'Find your stylist', 'salon-master' ); ?> &rarr;</a>
		</div>
		<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
			<?php while ( $team->have_posts() ) { $team->the_post(); get_template_part( 'template-parts/stylist-card' ); } wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php $locs = new WP_Query( array( 'post_type' => 'salon_location', 'posts_per_page' => 6, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
<?php if ( $locs->have_posts() ) : ?>
<section class="mx-auto max-w-6xl px-5 py-16">
	<h2 class="mb-10 font-display text-4xl"><?php esc_html_e( 'Visit us', 'salon-master' ); ?></h2>
	<div class="grid gap-8 md:grid-cols-2"><?php while ( $locs->have_posts() ) { $locs->the_post(); get_template_part( 'template-parts/location-card' ); } wp_reset_postdata(); ?></div>
</section>
<?php endif; ?>
<?php get_footer(); ?>

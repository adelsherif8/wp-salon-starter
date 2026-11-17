<?php get_header(); while ( have_posts() ) : the_post(); $id = get_the_ID(); ?>
<section class="mx-auto max-w-6xl px-5 py-20">
	<h1 class="font-display text-5xl"><?php the_title(); ?></h1>
	<div class="mt-10 grid gap-10 md:grid-cols-2">
		<div><?php get_template_part( 'template-parts/location-card' ); ?></div>
		<div class="prose max-w-none"><?php the_content(); ?></div>
	</div>
	<?php $team = new WP_Query( array( 'post_type' => 'salon_stylist', 'posts_per_page' => 50, 'meta_key' => 'location', 'meta_value' => $id, 'orderby' => 'menu_order', 'order' => 'ASC' ) ); ?>
	<?php if ( $team->have_posts() ) : ?>
		<h2 class="mt-16 mb-8 font-display text-3xl"><?php esc_html_e( 'Stylists here', 'salon-master' ); ?></h2>
		<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4"><?php while ( $team->have_posts() ) { $team->the_post(); get_template_part( 'template-parts/stylist-card' ); } wp_reset_postdata(); ?></div>
	<?php endif; ?>
</section>
<?php endwhile; get_footer(); ?>

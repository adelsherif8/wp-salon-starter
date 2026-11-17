<?php get_header(); ?>
<section class="mx-auto max-w-6xl px-5 py-20">
	<h1 class="mb-12 font-display text-5xl"><?php esc_html_e( 'Our salons', 'salon-master' ); ?></h1>
	<div class="grid gap-8 md:grid-cols-2"><?php while ( have_posts() ) { the_post(); get_template_part( 'template-parts/location-card' ); } ?></div>
</section>
<?php get_footer(); ?>

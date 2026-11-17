<?php get_header(); ?>
<section class="mx-auto max-w-3xl px-5 py-20">
	<p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent"><?php esc_html_e( 'Prices from', 'salon-master' ); ?></p>
	<h1 class="mt-3 mb-12 font-display text-5xl"><?php esc_html_e( 'Service menu', 'salon-master' ); ?></h1>
	<?php get_template_part( 'template-parts/service-menu' ); ?>
	<p class="mt-6 text-sm text-muted"><?php esc_html_e( 'Final price depends on hair length and stylist level. Your stylist confirms it at your consultation.', 'salon-master' ); ?></p>
	<div class="mt-10"><?php salon_book_button( array( 'context' => 'menu' ) ); ?></div>
</section>
<?php get_footer(); ?>

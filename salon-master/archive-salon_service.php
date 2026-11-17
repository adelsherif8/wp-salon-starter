<?php get_header(); ?>
<section class="mx-auto max-w-3xl px-5 py-20">
	<p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent"><?php esc_html_e( 'Prices from', 'salon-master' ); ?></p>
	<h1 class="mt-3 mb-12 font-display text-5xl"><?php esc_html_e( 'Service menu', 'salon-master' ); ?></h1>
	<?php $cats = get_terms( array( 'taxonomy' => 'service_category', 'hide_empty' => true ) ); if ( ! is_wp_error( $cats ) && count( $cats ) > 1 ) : ?>
		<nav class="sticky top-[73px] z-30 -mx-5 mb-10 flex gap-2 overflow-x-auto bg-paper/95 px-5 py-3 backdrop-blur" aria-label="<?php esc_attr_e( 'Menu sections', 'salon-master' ); ?>" data-menu-pills>
			<?php foreach ( $cats as $c ) : ?><a href="#cat-<?php echo esc_attr( $c->slug ); ?>" class="pill whitespace-nowrap rounded-full border border-ink/15 px-4 py-2 text-sm transition"><?php echo esc_html( $c->name ); ?></a><?php endforeach; ?>
		</nav>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/service-menu' ); ?>
	<p class="mt-6 text-sm text-muted"><?php esc_html_e( 'Final price depends on hair length and stylist level. Your stylist confirms it at your consultation.', 'salon-master' ); ?></p>
	<div class="mt-10"><?php salon_book_button( array( 'context' => 'menu' ) ); ?></div>
</section>
<?php get_footer(); ?>

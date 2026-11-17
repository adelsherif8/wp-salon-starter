<?php
/** Child override of the parent hero: same data, different layout (centred, italic accent line). */
$tagline = get_theme_mod( 'salon_tagline', get_bloginfo( 'description' ) );
?>
<section class="bg-accent2">
	<div class="mx-auto max-w-4xl px-5 py-24 text-center md:py-32">
		<p class="mb-6 text-xs font-semibold uppercase tracking-[0.3em] text-accent"><?php esc_html_e( 'New Orleans · Metairie', 'salon-master' ); ?></p>
		<h1 class="font-display text-5xl leading-[1.02] md:text-7xl"><?php echo esc_html( $tagline ); ?> <em class="text-accent">Since 2009.</em></h1>
		<div class="mt-10 flex flex-wrap justify-center gap-4">
			<?php salon_book_button( array( 'context' => 'hero' ) ); ?>
			<a class="btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'salon_stylist' ) ); ?>"><?php esc_html_e( 'Find your stylist', 'salon-master' ); ?></a>
		</div>
	</div>
</section>

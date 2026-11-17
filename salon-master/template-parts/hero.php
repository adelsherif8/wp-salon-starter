<?php
/** Home hero. Child themes override this file (see salon-child-maison/template-parts/hero.php). */
$tagline = get_theme_mod( 'salon_tagline', get_bloginfo( 'description' ) );
?>
<section class="relative overflow-hidden">
	<div class="mx-auto grid max-w-6xl items-center gap-10 px-5 py-20 md:grid-cols-2 md:py-28">
		<div>
			<p class="mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-accent"><?php esc_html_e( 'Hair · Colour · Care', 'salon-master' ); ?></p>
			<h1 class="font-display text-5xl leading-[1.05] md:text-6xl"><?php echo esc_html( $tagline ); ?></h1>
			<div class="mt-8 flex flex-wrap gap-4">
				<?php salon_book_button( array( 'context' => 'hero' ) ); ?>
				<a class="btn-ghost" href="<?php echo esc_url( get_post_type_archive_link( 'salon_service' ) ); ?>"><?php esc_html_e( 'See the menu', 'salon-master' ); ?></a>
			</div>
		</div>
		<div class="aspect-[4/5] rounded-[2rem] bg-accent2"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'salon-portrait', array( 'class' => 'h-full w-full rounded-[2rem] object-cover' ) ); } ?></div>
	</div>
</section>

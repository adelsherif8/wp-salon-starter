<?php
/** Child override of the parent hero: full-bleed photo with a slow zoom, headline words rise in one by one. */
$tagline = get_theme_mod( 'salon_tagline', get_bloginfo( 'description' ) );
$words   = preg_split( '/\s+/', trim( $tagline ) );
?>
<section class="relative isolate flex min-h-[88vh] items-end overflow-hidden">
	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'full', array( 'class' => 'hero-img absolute inset-0 -z-10 h-full w-full object-cover', 'fetchpriority' => 'high' ) ); } ?>
	<div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink/85 via-ink/30 to-transparent"></div>
	<div class="mx-auto w-full max-w-6xl px-5 pb-20 text-paper md:pb-28">
		<p class="hero-kicker mb-6 text-xs font-semibold uppercase tracking-[0.3em]"><?php esc_html_e( 'New Orleans · Metairie', 'salon-master' ); ?></p>
		<h1 class="font-display text-5xl leading-[1.02] md:text-8xl">
			<?php foreach ( $words as $i => $w ) : ?><span class="word" style="--i:<?php echo (int) $i; ?>"><?php echo esc_html( $w ); ?></span> <?php endforeach; ?>
			<em class="word block text-accent2" style="--i:<?php echo count( $words ); ?>"><?php esc_html_e( 'Since 2009.', 'salon-master' ); ?></em>
		</h1>
		<div class="hero-cta mt-10 flex flex-wrap gap-4">
			<?php salon_book_button( array( 'context' => 'hero', 'class' => 'bg-paper !text-ink hover:!bg-accent hover:!text-paper' ) ); ?>
			<a class="btn-ghost border-paper/50 text-paper hover:border-paper" href="<?php echo esc_url( get_post_type_archive_link( 'salon_stylist' ) ); ?>"><?php esc_html_e( 'Find your stylist', 'salon-master' ); ?></a>
		</div>
	</div>
	<a href="#menu" class="scroll-cue absolute bottom-6 left-1/2 -translate-x-1/2 text-paper/80" aria-label="<?php esc_attr_e( 'Scroll to the menu', 'salon-master' ); ?>"><svg width="22" height="34" viewBox="0 0 22 34" aria-hidden="true"><rect x="1" y="1" width="20" height="32" rx="10" fill="none" stroke="currentColor" stroke-width="2"/><circle class="scroll-dot" cx="11" cy="10" r="3" fill="currentColor"/></svg></a>
</section>

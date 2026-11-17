<?php
/** Drag-to-compare slider. A range input drives a CSS variable that clips the "after" image. Keyboard-accessible. */
$img = (int) get_option( 'salon_before_after' );
if ( ! $img ) { return; }
$src = wp_get_attachment_image_url( $img, 'large' );
?>
<section class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-20 md:grid-cols-2" data-reveal>
	<div>
		<p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent"><?php esc_html_e( 'The gloss difference', 'salon-master' ); ?></p>
		<h2 class="mt-3 font-display text-4xl md:text-5xl"><?php esc_html_e( 'Thirty minutes. Twice the shine.', 'salon-master' ); ?></h2>
		<p class="mt-5 max-w-md text-muted"><?php esc_html_e( 'A gloss tones out brassiness and seals the cuticle, so colour looks fresh again between appointments. Drag to compare.', 'salon-master' ); ?></p>
	</div>
	<figure class="ba relative aspect-square select-none overflow-hidden rounded-[2rem]" data-before-after style="--pos:50%">
		<img src="<?php echo esc_url( $src ); ?>" alt="<?php esc_attr_e( 'Before the gloss', 'salon-master' ); ?>" class="absolute inset-0 h-full w-full object-cover ba-before" loading="lazy">
		<img src="<?php echo esc_url( $src ); ?>" alt="<?php esc_attr_e( 'After the gloss', 'salon-master' ); ?>" class="absolute inset-0 h-full w-full object-cover ba-after" loading="lazy">
		<span class="ba-line" aria-hidden="true"><span class="ba-knob">&#x2194;</span></span>
		<span class="absolute left-4 top-4 rounded-full bg-ink/70 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-paper"><?php esc_html_e( 'Before', 'salon-master' ); ?></span>
		<span class="absolute right-4 top-4 rounded-full bg-paper/90 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-ink"><?php esc_html_e( 'After', 'salon-master' ); ?></span>
		<input type="range" min="0" max="100" value="50" class="ba-range" aria-label="<?php esc_attr_e( 'Compare before and after', 'salon-master' ); ?>">
	</figure>
</section>

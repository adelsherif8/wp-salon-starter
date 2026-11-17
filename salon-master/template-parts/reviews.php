<?php
/** Reviews marquee: an endless CSS scroll (list is duplicated, the copy is aria-hidden). Pauses on hover; static if reduced motion. */
$reviews = (array) get_option( 'salon_reviews', array() );
if ( ! $reviews ) { return; }
$card = function ( $r, $hidden = false ) { ?>
	<li class="w-80 shrink-0 rounded-2xl border border-ink/10 bg-white p-6" <?php echo $hidden ? 'aria-hidden="true"' : ''; ?>>
		<p class="text-accent" aria-label="<?php esc_attr_e( '5 out of 5 stars', 'salon-master' ); ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</p>
		<p class="mt-3 font-display text-xl leading-snug">&ldquo;<?php echo esc_html( $r[0] ); ?>&rdquo;</p>
		<p class="mt-4 text-sm text-muted">&mdash; <?php echo esc_html( $r[1] ); ?></p>
	</li>
<?php };
?>
<section class="overflow-hidden bg-accent2 py-20" data-reveal>
	<h2 class="mx-auto mb-10 max-w-6xl px-5 font-display text-4xl"><?php esc_html_e( 'What guests say', 'salon-master' ); ?></h2>
	<div class="marquee">
		<ul class="marquee-track flex gap-5">
			<?php foreach ( $reviews as $r ) { $card( $r ); } foreach ( $reviews as $r ) { $card( $r, true ); } ?>
		</ul>
	</div>
</section>

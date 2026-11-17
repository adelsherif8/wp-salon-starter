<?php $id = get_the_ID(); ?>
<article class="rounded-2xl border border-ink/10 bg-white p-7">
	<h3 class="font-display text-2xl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<address class="mt-3 not-italic text-muted"><?php echo esc_html( salon_field( 'street', $id ) ); ?><br><?php echo esc_html( trim( salon_field( 'city', $id ) . ', ' . salon_field( 'region', $id ) . ' ' . salon_field( 'postcode', $id ) ) ); ?></address>
	<?php if ( $phone = salon_field( 'phone', $id ) ) : ?>
		<a class="mt-3 inline-block font-medium text-accent" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" data-salon-phone data-location="<?php the_title_attribute(); ?>"><?php echo esc_html( $phone ); ?></a>
	<?php endif; ?>
	<dl class="mt-5 space-y-1 text-sm">
		<?php foreach ( salon_lines( salon_field( 'hours', $id ) ) as list( $d, $t ) ) : ?>
			<div class="flex justify-between gap-4"><dt class="text-muted"><?php echo esc_html( $d ); ?></dt><dd><?php echo esc_html( $t ); ?></dd></div>
		<?php endforeach; ?>
	</dl>
	<div class="mt-6 flex flex-wrap gap-3">
		<?php salon_book_button( array( 'location' => $id, 'context' => 'location-card', 'class' => 'btn-sm' ) ); ?>
		<?php if ( salon_field( 'street', $id ) ) : ?>
			<a class="btn-ghost btn-sm" target="_blank" rel="noopener" data-salon-directions data-location="<?php the_title_attribute(); ?>" href="<?php echo esc_url( 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( salon_field( 'street', $id ) . ', ' . salon_field( 'city', $id ) ) ); ?>"><?php esc_html_e( 'Directions', 'salon-master' ); ?></a>
		<?php endif; ?>
	</div>
</article>

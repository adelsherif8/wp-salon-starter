<?php
$id    = get_the_ID();
$hours = salon_lines( salon_field( 'hours', $id ) );
?>
<article class="group overflow-hidden rounded-2xl border border-ink/10 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="aspect-[16/9] overflow-hidden"><?php the_post_thumbnail( 'large', array( 'class' => 'h-full w-full object-cover transition duration-700 group-hover:scale-105', 'loading' => 'lazy' ) ); ?></div>
	<?php endif; ?>
	<div class="p-7">
	<div class="flex items-center justify-between gap-4">
	<h3 class="font-display text-2xl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<span class="open-badge hidden rounded-full px-3 py-1 text-xs font-semibold" data-open-badge data-hours="<?php echo esc_attr( wp_json_encode( $hours ) ); ?>"></span>
	</div>
	<address class="mt-3 not-italic text-muted"><?php echo esc_html( salon_field( 'street', $id ) ); ?><br><?php echo esc_html( trim( salon_field( 'city', $id ) . ', ' . salon_field( 'region', $id ) . ' ' . salon_field( 'postcode', $id ) ) ); ?></address>
	<?php if ( $phone = salon_field( 'phone', $id ) ) : ?>
		<a class="mt-3 inline-block font-medium text-accent" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" data-salon-phone data-location="<?php the_title_attribute(); ?>"><?php echo esc_html( $phone ); ?></a>
	<?php endif; ?>
	<dl class="mt-5 space-y-1 text-sm">
		<?php foreach ( $hours as list( $d, $t ) ) : ?>
			<div class="flex justify-between gap-4"><dt class="text-muted"><?php echo esc_html( $d ); ?></dt><dd><?php echo esc_html( $t ); ?></dd></div>
		<?php endforeach; ?>
	</dl>
	<div class="mt-6 flex flex-wrap gap-3">
		<?php salon_book_button( array( 'location' => $id, 'context' => 'location-card', 'class' => 'btn-sm' ) ); ?>
		<?php if ( salon_field( 'street', $id ) ) : ?>
			<a class="btn-ghost btn-sm" target="_blank" rel="noopener" data-salon-directions data-location="<?php the_title_attribute(); ?>" href="<?php echo esc_url( 'https://www.google.com/maps/dir/?api=1&destination=' . rawurlencode( salon_field( 'street', $id ) . ', ' . salon_field( 'city', $id ) ) ); ?>"><?php esc_html_e( 'Directions', 'salon-master' ); ?></a>
		<?php endif; ?>
	</div>
	</div>
</article>

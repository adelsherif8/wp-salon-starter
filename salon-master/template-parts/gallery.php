<?php
/** Scroll-snap photo strip; clicking opens a native <dialog> lightbox (Esc closes, arrow keys browse). */
$ids = array_filter( array_map( 'absint', (array) get_option( 'salon_gallery', array() ) ) );
if ( ! $ids ) { return; }
?>
<section class="py-20" data-reveal>
	<div class="mx-auto mb-8 flex max-w-6xl items-end justify-between gap-6 px-5">
		<h2 class="font-display text-4xl"><?php esc_html_e( 'Fresh from the chair', 'salon-master' ); ?></h2>
		<p class="hidden text-sm text-muted md:block"><?php esc_html_e( 'Swipe or scroll', 'salon-master' ); ?> &rarr;</p>
	</div>
	<ul class="gallery flex snap-x snap-mandatory gap-5 overflow-x-auto px-5 pb-4 md:px-[max(1.25rem,calc((100vw-72rem)/2+1.25rem))]" data-gallery>
		<?php foreach ( $ids as $i => $id ) : ?>
			<li class="w-64 shrink-0 snap-start md:w-72">
				<button type="button" class="group block w-full overflow-hidden rounded-2xl" data-lightbox="<?php echo esc_url( wp_get_attachment_image_url( $id, 'large' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Open photo %d', 'salon-master' ), $i + 1 ) ); ?>">
					<?php echo wp_get_attachment_image( $id, 'salon-portrait', false, array( 'class' => 'aspect-[4/5] w-full object-cover transition duration-700 ease-out group-hover:scale-110', 'loading' => 'lazy' ) ); ?>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
	<dialog class="lightbox" data-lightbox-dialog>
		<img alt="" data-lightbox-img>
		<button type="button" class="lb-close" data-lightbox-close aria-label="<?php esc_attr_e( 'Close', 'salon-master' ); ?>">&times;</button>
	</dialog>
</section>

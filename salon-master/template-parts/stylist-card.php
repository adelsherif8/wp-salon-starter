<?php
/** One stylist. data-* attributes drive the "find your stylist" filter in app.js. */
$id    = get_the_ID();
$loc   = (int) salon_field( 'location', $id );
$level = wp_get_post_terms( $id, 'stylist_level', array( 'fields' => 'slugs' ) );
$years = (int) salon_field( 'years', $id );
?>
<article class="group" data-stylist data-level="<?php echo esc_attr( implode( ' ', is_wp_error( $level ) ? array() : $level ) ); ?>" data-location="<?php echo esc_attr( $loc ); ?>" data-years="<?php echo esc_attr( $years ); ?>">
	<a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-2xl bg-accent2">
		<div class="aspect-[4/5]"><?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'salon-portrait', array( 'class' => 'h-full w-full object-cover transition duration-500 group-hover:scale-105' ) ); } ?></div>
	</a>
	<h3 class="mt-4 font-display text-xl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<p class="text-sm text-muted">
		<?php echo esc_html( salon_field( 'job_title', $id ) ); ?>
		<?php if ( $years ) { echo ' · ' . esc_html( sprintf( _n( '%d year', '%d years', $years, 'salon-master' ), $years ) ); } ?>
		<?php if ( $loc ) { echo ' · ' . esc_html( get_the_title( $loc ) ); } ?>
	</p>
	<div class="mt-3"><?php salon_book_button( array( 'stylist' => $id, 'location' => $loc, 'context' => 'stylist-card', 'label' => __( 'Book with me', 'salon-master' ), 'class' => 'btn-sm' ) ); ?></div>
</article>

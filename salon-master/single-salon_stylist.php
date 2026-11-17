<?php get_header(); while ( have_posts() ) : the_post(); $id = get_the_ID(); $loc = (int) salon_field( 'location', $id ); ?>
<article class="mx-auto grid max-w-6xl gap-12 px-5 py-20 md:grid-cols-2">
	<div class="aspect-[4/5] overflow-hidden rounded-[2rem] bg-accent2"><?php the_post_thumbnail( 'salon-portrait', array( 'class' => 'h-full w-full object-cover' ) ); ?></div>
	<div>
		<p class="text-xs font-semibold uppercase tracking-[0.25em] text-accent"><?php echo esc_html( salon_field( 'job_title', $id ) ); ?></p>
		<h1 class="mt-3 font-display text-5xl"><?php the_title(); ?></h1>
		<div class="prose mt-6 max-w-none text-muted"><?php the_content(); ?></div>
		<?php $spec = salon_lines( salon_field( 'specialties', $id ) ); if ( $spec ) : ?>
			<h2 class="mt-8 text-sm font-semibold uppercase tracking-wider"><?php esc_html_e( 'Specialties', 'salon-master' ); ?></h2>
			<ul class="mt-3 flex flex-wrap gap-2"><?php foreach ( $spec as list( $s ) ) : ?><li class="rounded-full border border-ink/15 px-3 py-1 text-sm"><?php echo esc_html( $s ); ?></li><?php endforeach; ?></ul>
		<?php endif; ?>
		<div class="mt-10"><?php salon_book_button( array( 'stylist' => $id, 'location' => $loc, 'context' => 'stylist-page', 'label' => sprintf( __( 'Book with %s', 'salon-master' ), get_the_title() ) ) ); ?></div>
	</div>
</article>
<?php endwhile; get_footer(); ?>

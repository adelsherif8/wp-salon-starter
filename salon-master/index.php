<?php get_header(); ?>
<section class="mx-auto max-w-3xl px-5 py-20">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article class="mb-12 border-b border-ink/10 pb-10">
			<h2 class="font-display text-3xl"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="prose mt-4 max-w-none"><?php the_excerpt(); ?></div>
		</article>
	<?php endwhile; the_posts_pagination(); else : ?>
		<p><?php esc_html_e( 'Nothing here yet.', 'salon-master' ); ?></p>
	<?php endif; ?>
</section>
<?php get_footer(); ?>

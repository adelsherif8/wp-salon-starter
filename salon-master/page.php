<?php get_header(); while ( have_posts() ) : the_post(); ?>
<article class="mx-auto max-w-3xl px-5 py-20">
	<h1 class="mb-8 font-display text-5xl"><?php the_title(); ?></h1>
	<div class="prose max-w-none"><?php the_content(); ?></div>
</article>
<?php endwhile; get_footer(); ?>

<?php get_header(); ?>
<section class="mx-auto max-w-3xl px-5 py-32 text-center">
	<h1 class="font-display text-5xl"><?php esc_html_e( 'This page had a bad hair day.', 'salon-master' ); ?></h1>
	<p class="mt-4 text-muted"><?php esc_html_e( "It's not here. Try the menu, or book a visit instead.", 'salon-master' ); ?></p>
	<div class="mt-8 flex justify-center gap-4"><?php salon_book_button( array( 'context' => '404' ) ); ?><a class="btn-ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'salon-master' ); ?></a></div>
</section>
<?php get_footer(); ?>

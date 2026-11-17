</main>
<footer class="mt-24 bg-ink text-paper">
	<div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-3">
		<div>
			<p class="font-display text-2xl"><?php bloginfo( 'name' ); ?></p>
			<p class="mt-3 text-sm opacity-70"><?php bloginfo( 'description' ); ?></p>
		</div>
		<?php foreach ( get_posts( array( 'post_type' => 'salon_location', 'numberposts' => 2, 'orderby' => 'menu_order', 'order' => 'ASC' ) ) as $loc ) : ?>
			<div class="text-sm">
				<p class="mb-2 font-semibold uppercase tracking-wider"><?php echo esc_html( get_the_title( $loc ) ); ?></p>
				<p class="opacity-80"><?php echo esc_html( salon_field( 'street', $loc->ID ) ); ?>, <?php echo esc_html( salon_field( 'city', $loc->ID ) ); ?></p>
				<?php if ( $phone = salon_field( 'phone', $loc->ID ) ) : ?>
					<a class="mt-1 inline-block underline-offset-4 hover:underline" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" data-salon-phone data-location="<?php echo esc_attr( get_the_title( $loc ) ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<p class="border-t border-paper/10 py-5 text-center text-xs opacity-60">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>

<?php
/**
 * Service menu grouped by category, with prices. $args['limit'] trims it for the home page.
 * Salons live and die by an accurate, current menu, so prices come from fields, never from page copy.
 */
$limit = isset( $args['limit'] ) ? (int) $args['limit'] : 0;
$cats  = get_terms( array( 'taxonomy' => 'service_category', 'hide_empty' => true ) );
foreach ( is_wp_error( $cats ) ? array() : $cats as $cat ) :
	$services = get_posts( array(
		'post_type'   => 'salon_service',
		'numberposts' => $limit ?: 100,
		'orderby'     => 'menu_order',
		'order'       => 'ASC',
		'tax_query'   => array( array( 'taxonomy' => 'service_category', 'terms' => $cat->term_id ) ),
	) );
	?>
	<div class="mb-12 scroll-mt-40" id="cat-<?php echo esc_attr( $cat->slug ); ?>" data-menu-section>
		<h3 class="mb-5 border-b border-ink/15 pb-3 font-display text-2xl"><?php echo esc_html( $cat->name ); ?></h3>
		<ul class="divide-y divide-ink/10">
			<?php foreach ( $services as $s ) :
				$price = salon_field( 'price_from', $s->ID );
				$mins  = salon_field( 'duration', $s->ID ); ?>
				<li class="menu-row flex items-baseline justify-between gap-6 py-4">
					<div>
						<p class="font-medium"><?php echo esc_html( $s->post_title ); ?></p>
						<p class="text-sm text-muted"><?php echo esc_html( wp_strip_all_tags( $s->post_content ) ); ?><?php if ( $mins ) { echo ' · ' . esc_html( $mins ) . ' min'; } ?></p>
					</div>
					<p class="whitespace-nowrap font-display text-xl">
						<?php if ( '' !== (string) $price ) { echo esc_html( sprintf( __( 'from $%s', 'salon-master' ), number_format_i18n( (float) $price ) ) ); } ?>
					</p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endforeach; ?>

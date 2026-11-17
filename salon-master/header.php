<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-paper text-ink font-body antialiased' ); ?>>
<?php wp_body_open(); ?>
<a class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-ink focus:text-paper focus:px-4 focus:py-2" href="#main"><?php esc_html_e( 'Skip to content', 'salon-master' ); ?></a>
<header class="sticky top-0 z-40 border-b border-ink/10 bg-paper/95 backdrop-blur" data-header>
	<div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-display text-2xl tracking-tight">
			<?php if ( has_custom_logo() ) { the_custom_logo(); } else { bloginfo( 'name' ); } ?>
		</a>
		<button class="md:hidden" aria-controls="site-nav" aria-expanded="false" data-nav-toggle>
			<span class="sr-only"><?php esc_html_e( 'Menu', 'salon-master' ); ?></span>
			<svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 6h18M3 12h18M3 18h18" stroke="currentColor" stroke-width="2"/></svg>
		</button>
		<nav id="site-nav" class="hidden w-full md:flex md:w-auto md:items-center md:gap-8" aria-label="<?php esc_attr_e( 'Primary', 'salon-master' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => false, 'menu_class' => 'flex flex-col gap-3 py-4 text-sm font-medium uppercase tracking-wider md:flex-row md:gap-8 md:py-0' ) ); ?>
			<?php salon_book_button( array( 'context' => 'header', 'class' => 'mt-2 md:mt-0' ) ); ?>
		</nav>
	</div>
</header>
<main id="main">

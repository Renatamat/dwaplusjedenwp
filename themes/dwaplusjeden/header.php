<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dwaplusjeden
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'dwaplusjeden' ); ?></a>

	<?php
	$header_logo = dwaplusjeden_get_header_logo();
	$login_url   = function_exists( 'get_field' ) ? get_field( 'general_login_url', 'option' ) : '';
	$login_url   = dwaplusjeden_translate_url( $login_url );
	?>

	<header>
		<div class="fixed-header">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="site-header">
							<div class="d-flex align-items-center gap-48">
								<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Strona główna', 'dwaplusjeden' ); ?>">
									<img src="<?php echo esc_url( $header_logo['url'] ); ?>" alt="<?php echo esc_attr( $header_logo['alt'] ); ?>">
								</a>

								<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Główne menu', 'dwaplusjeden' ); ?>">
									<div class="mobile-header-menu d-xl-none">
										<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Strona główna', 'dwaplusjeden' ); ?>">
											<img src="<?php echo esc_url( $header_logo['url'] ); ?>" alt="<?php echo esc_attr( $header_logo['alt'] ); ?>">
										</a>
										<div class="mobile-header-close">
											<svg class="i-sprite icon-24">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#close"></use>
											</svg>
										</div>
									</div>

									<?php dwaplusjeden_main_navigation(); ?>

									<div class="mobile-footer-menu">
										<?php if ( $login_url ) : ?>
											<a href="<?php echo esc_url( $login_url ); ?>" class="c-btn c-btn-s c-btn-fill menu-login d-xl-none w-100">
												<span><?php esc_html_e( 'Logowanie', 'dwaplusjeden' ); ?></span>
											</a>
										<?php endif; ?>
										<a href="#" class="c-btn c-btn-s c-btn-link d-xl-none w-100">
											<span class="c-black"><?php echo esc_html( strtoupper( substr( get_locale(), 0, 2 ) ) ); ?></span>
										</a>
									</div>
								</nav>
							</div>

							<div class="d-flex gap-24 align-items-center">
								<?php if ( $login_url ) : ?>
									<a href="<?php echo esc_url( $login_url ); ?>" class="c-btn c-btn-s c-btn-fill menu-login d-none d-sm-flex">
										<span><?php esc_html_e( 'Logowanie', 'dwaplusjeden' ); ?></span>
									</a>
								<?php endif; ?>
								<div class="menu-hamburger d-xl-none">
									<svg class="i-sprite icon-24">
										<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-24.svg' ) ); ?>#hamburger"></use>
									</svg>
								</div>
								<a href="#" class="c-btn c-btn-s c-btn-link d-none d-xl-block btn-lang">
									<span><?php echo esc_html( strtoupper( substr( get_locale(), 0, 2 ) ) ); ?></span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php dwaplusjeden_breadcrumb(); ?>
			</div>
		</div>
	</div>								

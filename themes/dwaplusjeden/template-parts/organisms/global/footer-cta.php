<?php
/**
 * Footer CTA.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$enabled        = get_field( 'footer_cta_enabled', 'option' );
$avatar_id      = get_field( 'footer_cta_avatar', 'option' );
$name           = get_field( 'footer_cta_name', 'option' );
$role           = get_field( 'footer_cta_role', 'option' );
$heading        = get_field( 'footer_cta_heading', 'option' );
$text           = get_field( 'footer_cta_text', 'option' );
$primary_link   = dwaplusjeden_get_acf_link( 'footer_cta_primary_link' );
$secondary_link = dwaplusjeden_get_acf_link( 'footer_cta_secondary_link' );
$avatar_src     = $avatar_id ? wp_get_attachment_image_url( $avatar_id, 'thumbnail' ) : '';
$avatar_alt     = $avatar_id ? get_post_meta( $avatar_id, '_wp_attachment_image_alt', true ) : '';

if ( false === $enabled || '0' === $enabled ) {
	return;
}

if ( ! $avatar_src && ! $name && ! $role && ! $heading && ! $text && empty( $primary_link ) && empty( $secondary_link ) ) {
	return;
}
?>

<div class="footer-cta mb-32 mb-lg-48">
	<div class="footer-cta-wrapper">
		<?php if ( $avatar_src || $name || $role ) : ?>
			<div class="footer-cta-avatar">
				<?php if ( $avatar_src ) : ?>
					<div class="avatar">
						<div class="avatar-wrapper">
							<img src="<?php echo esc_url( $avatar_src ); ?>" alt="<?php echo esc_attr( $avatar_alt ); ?>">
						</div>
					</div>
				<?php endif; ?>

				<?php if ( $name || $role ) : ?>
					<div class="d-flex flex-column align-items-center">
						<?php if ( $name ) : ?>
							<span class="p-s fw-bolder c-white"><?php echo esc_html( $name ); ?></span>
						<?php endif; ?>

						<?php if ( $role ) : ?>
							<span class="p-overline c-white"><?php echo esc_html( $role ); ?></span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $heading || $text ) : ?>
			<div class="d-flex flex-column gap-24 align-items-center mt-32">
				<?php if ( $heading ) : ?>
					<span class="h5 fw-bolder c-white text-center"><?php echo esc_html( $heading ); ?></span>
				<?php endif; ?>

				<?php if ( $text ) : ?>
					<p class="p-l fw-bolder c-white text-center"><?php echo esc_html( $text ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
			<div class="d-flex flex-column flex-lg-row gap-16 gap-lg-24 justify-content-center mt-32 align-items-center footer-cta-buttons">
				<?php if ( ! empty( $primary_link['url'] ) ) : ?>
					<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill">
						<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $secondary_link['url'] ) ) : ?>
					<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline">
						<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Blog single CTA box ACF block.
 *
 * @package dwaplusjeden
 *
 * @var array $block Block settings and attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$block_id       = ! empty( $block['id'] ) ? $block['id'] : '';
$is_dark        = function_exists( 'get_field' ) && get_field( 'blog_single_boxcta_dark_mode', $block_id );
$eyebrow        = function_exists( 'get_field' ) ? get_field( 'blog_single_boxcta_eyebrow', $block_id ) : '';
$heading        = function_exists( 'get_field' ) ? get_field( 'blog_single_boxcta_heading', $block_id ) : '';
$primary_link   = function_exists( 'get_field' ) ? dwaplusjeden_get_acf_link( 'blog_single_boxcta_primary_link', $block_id ) : array();
$secondary_link = function_exists( 'get_field' ) ? dwaplusjeden_get_acf_link( 'blog_single_boxcta_secondary_link', $block_id ) : array();
$id             = ! empty( $block['anchor'] ) ? $block['anchor'] : 'blog-single-boxcta-' . ( $block_id ? $block_id : wp_unique_id() );
$classes        = array( 'boxcta', 'blog-single-boxcta-block' );

if ( empty( $primary_link['url'] ) ) {
	$primary_link = array(
		'url'    => dwaplusjeden_translate_url( home_url( '/kontakt/' ) ),
		'title'  => __( 'Skontaktuj się z nami', 'dwaplusjeden' ),
		'target' => '',
	);
}

if ( empty( $secondary_link['url'] ) ) {
	$secondary_link = array(
		'url'    => dwaplusjeden_translate_url( home_url( '/cennik/' ) ),
		'title'  => __( 'Cennik', 'dwaplusjeden' ),
		'target' => '',
	);
}

if ( $is_dark ) {
	$classes[] = '--dark';
}

if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', $block['className'] ) ) ) );
}

if ( ! $eyebrow && ! $heading && empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) && ! is_admin() ) {
	return;
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( $eyebrow || $heading || ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
		<div class="d-flex flex-column gap-32 align-items-center">
			<?php if ( $eyebrow || $heading ) : ?>
				<div class="d-flex flex-column gap-24 align-items-center">
					<?php if ( $eyebrow ) : ?>
						<span class="h6 fw-bolder c-body text-center"><?php echo esc_html( $eyebrow ); ?></span>
					<?php endif; ?>
					<?php if ( $heading ) : ?>
						<p class="p-l fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
				<div class="d-flex flex-column flex-sm-row gap-8 gap-sm-24 boxcta-buttons">
					<?php if ( ! empty( $primary_link['url'] ) ) : ?>
						<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
							<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( ! empty( $secondary_link['url'] ) ) : ?>
						<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline w-100">
							<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	<?php elseif ( is_admin() ) : ?>
		<div class="blog-single-boxcta-block__placeholder">
			<span class="p-m fw-bolder"><?php esc_html_e( 'Box CTA', 'dwaplusjeden' ); ?></span>
			<p><?php esc_html_e( 'Uzupełnij treści i przyciski w ustawieniach bloku.', 'dwaplusjeden' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
/**
 * Info section ACF block.
 *
 * @package dwaplusjeden
 *
 * @var array $block Block settings and attributes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$block_id = ! empty( $block['id'] ) ? $block['id'] : '';
$title    = function_exists( 'get_field' ) ? get_field( 'text_wysiwyg_title', $block_id ) : '';
$content  = function_exists( 'get_field' ) ? get_field( 'text_wysiwyg_content', $block_id ) : '';
$id       = ! empty( $block['anchor'] ) ? $block['anchor'] : 'info-section-' . ( $block_id ? $block_id : wp_unique_id() );
$classes  = array( 'important-box', 'info-section-block' );

if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', $block['className'] ) ) ) );
}

if ( ! $title && ! $content && ! is_admin() ) {
	return;
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( $title || $content ) : ?>
		<?php if ( $title ) : ?>
			<span class="p-m fw-bolder"><?php echo esc_html( $title ); ?></span>
		<?php endif; ?>

		<?php if ( $content ) : ?>
			<div class="d-flex flex-column gap-24">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		<?php endif; ?>
	<?php elseif ( is_admin() ) : ?>
		<div class="info-section-block__placeholder">
			<span class="p-m fw-bolder"><?php esc_html_e( 'Info sekcja', 'dwaplusjeden' ); ?></span>
			<p><?php esc_html_e( 'Uzupełnij nagłówek i treść w ustawieniach bloku.', 'dwaplusjeden' ); ?></p>
		</div>
	<?php endif; ?>
</div>

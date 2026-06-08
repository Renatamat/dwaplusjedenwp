<?php
/**
 * Blog card.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$post_id      = ! empty( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
$extra_classes = ! empty( $args['class'] ) ? array_map( 'sanitize_html_class', preg_split( '/\s+/', $args['class'] ) ) : array();
$class         = $extra_classes ? ' ' . implode( ' ', array_filter( $extra_classes ) ) : '';
$category     = null;
$categories   = get_the_category( $post_id );

if ( class_exists( 'WPSEO_Primary_Term' ) ) {
	$primary_term = new WPSEO_Primary_Term( 'category', $post_id );
	$primary_id   = (int) $primary_term->get_primary_term();
	$primary      = $primary_id ? get_term( $primary_id, 'category' ) : null;

	if ( $primary && ! is_wp_error( $primary ) ) {
		$category = $primary;
	}
}

if ( ! $category && $categories ) {
	$category = $categories[0];
}
$content      = get_post_field( 'post_content', $post_id );
$reading_time = 0;

if ( class_exists( 'WPSEO_Meta' ) && method_exists( 'WPSEO_Meta', 'get_value' ) ) {
	$reading_time = (int) WPSEO_Meta::get_value( 'estimated-reading-time-minutes', $post_id );
}

if ( ! $reading_time ) {
	$word_count   = preg_match_all( '/[\p{L}\p{N}]+/u', wp_strip_all_tags( $content ) );
	$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
}

$excerpt      = get_the_excerpt( $post_id );
?>

<article class="blog-card<?php echo esc_attr( $class ); ?>">
	<div class="blog-card-wrapper">
		<?php if ( $category ) : ?>
			<div class="blog-card-category">
				<span class="p-xs c-white"><?php echo esc_html( $category->name ); ?></span>
			</div>
		<?php endif; ?>
		<div class="d-flex flex-column gap-16 h-100 justify-content-between">
			<div class="d-flex flex-column gap-8">
				<div class="d-flex gap-16 align-items-center">
					<div class="d-flex gap-8 align-items-center">
						<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
							<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#calendar"></use>
						</svg>
						<span class="p-xs"><?php echo esc_html( get_the_date( 'd F Y', $post_id ) ); ?></span>
					</div>
					<div class="d-flex gap-8 align-items-center">
						<svg class="icon-16" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false">
							<path d="M14.6768 8.00098C14.6767 6.2303 13.9727 4.53238 12.7207 3.28027C11.4685 2.02808 9.7699 1.32422 7.99902 1.32422C6.22827 1.3243 4.53044 2.02815 3.27832 3.28027C2.0262 4.53239 1.32235 6.23022 1.32227 8.00098C1.32227 9.77185 2.02612 11.4705 3.27832 12.7227C4.53042 13.9747 6.22834 14.6786 7.99902 14.6787C9.7699 14.6787 11.4685 13.9749 12.7207 12.7227C13.9729 11.4705 14.6768 9.77185 14.6768 8.00098ZM7.25 4.44922C7.25 4.03501 7.58579 3.69922 8 3.69922C8.41421 3.69922 8.75 4.03501 8.75 4.44922V7.6709L12.3818 11.001C12.6869 11.2809 12.7076 11.7553 12.4277 12.0605C12.1478 12.3656 11.6734 12.3862 11.3682 12.1064L7.49316 8.55371C7.33835 8.41167 7.25 8.21109 7.25 8.00098V4.44922ZM16.1768 8.00098C16.1768 10.1697 15.3148 12.2497 13.7812 13.7832C12.2477 15.3167 10.1677 16.1787 7.99902 16.1787C5.83044 16.1786 3.75022 15.3166 2.2168 13.7832C0.6835 12.2497 -0.177734 10.1695 -0.177734 8.00098C-0.177648 5.8324 0.683373 3.75217 2.2168 2.21875C3.75022 0.685326 5.83044 -0.175695 7.99902 -0.175781C10.1676 -0.175781 12.2478 0.685453 13.7812 2.21875C15.3147 3.75217 16.1767 5.8324 16.1768 8.00098Z" fill="currentColor"/>
						</svg>
						<span class="p-xs"><?php echo esc_html( sprintf( _n( '%s min', '%s min', $reading_time, 'dwaplusjeden' ), number_format_i18n( $reading_time ) ) ); ?></span>
					</div>
				</div>
				<h3 class="p-m fw-bolder c-body blog-card-header">
					<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="c-body"><?php echo esc_html( get_the_title( $post_id ) ); ?></a>
				</h3>
				<?php if ( $excerpt ) : ?>
					<p class="p-s blog-card-desc"><?php echo esc_html( $excerpt ); ?></p>
				<?php endif; ?>
			</div>
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="c-btn c-btn-s c-btn-text w-100 justify-content-between">
				<span class="p-0"><?php esc_html_e( 'Dowiedz się więcej', 'dwaplusjeden' ); ?></span>
				<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
					<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right_2"></use>
				</svg>
			</a>
		</div>
	</div>
</article>

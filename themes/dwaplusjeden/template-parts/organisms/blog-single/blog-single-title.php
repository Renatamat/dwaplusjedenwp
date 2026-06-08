<?php
/**
 * Blog single title section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$post_id      = get_the_ID();
$content      = get_post_field( 'post_content', $post_id );
$reading_time = 0;

if ( class_exists( 'WPSEO_Meta' ) && method_exists( 'WPSEO_Meta', 'get_value' ) ) {
	$reading_time = (int) WPSEO_Meta::get_value( 'estimated-reading-time-minutes', $post_id );
}

if ( ! $reading_time ) {
	$word_count   = preg_match_all( '/[\p{L}\p{N}]+/u', wp_strip_all_tags( $content ) );
	$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
}

$wp_author_id      = (int) get_post_field( 'post_author', $post_id );
$wp_author_name    = get_the_author_meta( 'display_name', $wp_author_id );
$author_type       = function_exists( 'get_field' ) ? get_field( 'typ_autora', $post_id ) : '';
$related_author_id = function_exists( 'get_field' ) ? (int) get_field( 'powiazany_autor', $post_id ) : 0;
$manual_author     = function_exists( 'get_field' ) ? get_field( 'autor', $post_id ) : '';
$manual_image_id   = function_exists( 'get_field' ) ? (int) get_field( 'autor_zdjecie', $post_id ) : 0;
$author_name       = $wp_author_name;
$author_image_id   = 0;
$author_url        = '';
$use_wp_avatar     = true;

if ( 'reczny' !== $author_type && $related_author_id ) {
	$author_name     = get_the_title( $related_author_id );
	$author_image_id = get_post_thumbnail_id( $related_author_id );
	$author_url      = get_permalink( $related_author_id );
	$use_wp_avatar   = false;
} elseif ( 'reczny' === $author_type && $manual_author ) {
	$author_name     = $manual_author;
	$author_image_id = $manual_image_id;
	$use_wp_avatar   = false;
}
?>

<section class="blog-single-title pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div class="d-flex flex-column gap-48">
					<h1 class="h6 c-body"><?php the_title(); ?></h1>
					<div class="blog-single-title-meta">
						<div class="d-flex gap-8 align-items-center c-body">
							<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
								<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#calendar"></use>
							</svg>
							<span class="p-xs"><?php echo esc_html( get_the_date( 'd F Y', $post_id ) ); ?></span>
						</div>
						<div class="d-flex gap-8 align-items-center c-body">
							<svg class="icon-16" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" focusable="false">
								<path d="M14.6768 8.00098C14.6767 6.2303 13.9727 4.53238 12.7207 3.28027C11.4685 2.02808 9.7699 1.32422 7.99902 1.32422C6.22827 1.3243 4.53044 2.02815 3.27832 3.28027C2.0262 4.53239 1.32235 6.23022 1.32227 8.00098C1.32227 9.77185 2.02612 11.4705 3.27832 12.7227C4.53042 13.9747 6.22834 14.6786 7.99902 14.6787C9.7699 14.6787 11.4685 13.9749 12.7207 12.7227C13.9729 11.4705 14.6768 9.77185 14.6768 8.00098ZM7.25 4.44922C7.25 4.03501 7.58579 3.69922 8 3.69922C8.41421 3.69922 8.75 4.03501 8.75 4.44922V7.6709L12.3818 11.001C12.6869 11.2809 12.7076 11.7553 12.4277 12.0605C12.1478 12.3656 11.6734 12.3862 11.3682 12.1064L7.49316 8.55371C7.33835 8.41167 7.25 8.21109 7.25 8.00098V4.44922ZM16.1768 8.00098C16.1768 10.1697 15.3148 12.2497 13.7812 13.7832C12.2477 15.3167 10.1677 16.1787 7.99902 16.1787C5.83044 16.1786 3.75022 15.3166 2.2168 13.7832C0.6835 12.2497 -0.177734 10.1695 -0.177734 8.00098C-0.177648 5.8324 0.683373 3.75217 2.2168 2.21875C3.75022 0.685326 5.83044 -0.175695 7.99902 -0.175781C10.1676 -0.175781 12.2478 0.685453 13.7812 2.21875C15.3147 3.75217 16.1767 5.8324 16.1768 8.00098Z" fill="currentColor"/>
							</svg>
							<span class="p-xs"><?php echo esc_html( sprintf( _n( '%s min czytania', '%s min czytania', $reading_time, 'dwaplusjeden' ), number_format_i18n( $reading_time ) ) ); ?></span>
						</div>
						<div class="blog-single-title-meta-author">
							<div class="avatar">
								<div class="avatar-wrapper">
									<?php if ( $author_url ) : ?>
										<a href="<?php echo esc_url( $author_url ); ?>" aria-label="<?php echo esc_attr( $author_name ); ?>">
									<?php endif; ?>

									<?php
									if ( $author_image_id ) {
										echo wp_get_attachment_image(
											$author_image_id,
											'thumbnail',
											false,
											array(
												'alt' => get_post_meta( $author_image_id, '_wp_attachment_image_alt', true ) ?: $author_name,
											)
										);
									} elseif ( $use_wp_avatar ) {
										echo get_avatar( $wp_author_id, 96, '', $author_name );
									}
									?>

									<?php if ( $author_url ) : ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
							<?php if ( $author_url ) : ?>
								<a href="<?php echo esc_url( $author_url ); ?>" class="p-xs c-body"><?php echo esc_html( $author_name ); ?></a>
							<?php else : ?>
								<span class="p-xs c-body"><?php echo esc_html( $author_name ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

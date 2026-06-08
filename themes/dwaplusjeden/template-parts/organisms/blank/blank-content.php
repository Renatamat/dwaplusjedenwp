<?php
/**
 * Blank page content and downloads.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf           = function_exists( 'get_field' );
$downloads_enabled = $has_acf ? get_field( 'blank_downloads_enabled' ) : false;
$downloads_heading = $has_acf ? get_field( 'blank_downloads_heading' ) : '';
$downloads         = $has_acf ? get_field( 'blank_downloads' ) : array();
?>

<section class="blank-content pt-32 pb-56 pt-sm-40 pb-sm-64 pt-lg-48 pb-lg-96 pt-xxxl-56 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="offset-lg-2 col-lg-8">
				<div class="blog-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Strony:', 'dwaplusjeden' ),
							'after'  => '</div>',
						)
					);
					?>

					<?php if ( $downloads_enabled && $downloads ) : ?>
						<div class="content-download">
							<?php if ( $downloads_heading ) : ?>
								<span class="p-m fw-bolder"><?php echo esc_html( $downloads_heading ); ?></span>
							<?php endif; ?>
							<div class="d-flex flex-column gap-8 pt-16">
								<?php foreach ( $downloads as $download ) : ?>
									<?php
									$file_id = ! empty( $download['file'] ) ? (int) $download['file'] : 0;
									$label   = ! empty( $download['label'] ) ? $download['label'] : '';
									$url     = $file_id ? wp_get_attachment_url( $file_id ) : '';

									if ( ! $url ) {
										continue;
									}

									$file_path = get_attached_file( $file_id );
									$size      = $file_path && file_exists( $file_path ) ? size_format( filesize( $file_path ), 2 ) : '';
									$title     = $label ?: get_the_title( $file_id );
									$title     = $title ?: basename( wp_parse_url( $url, PHP_URL_PATH ) );
									$meta      = $size ? ' (' . $size . ')' : '';
									?>
									<a href="<?php echo esc_url( $url ); ?>" class="c-btn c-btn-s c-btn-text" download>
										<span class="ps-0"><?php echo esc_html( $title . $meta ); ?></span>
										<svg class="i-sprite icon-16 c-black" aria-hidden="true" focusable="false">
											<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#download"></use>
										</svg>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

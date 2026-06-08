<?php
/**
 * Author profile section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$post_id  = get_the_ID();
$position = function_exists( 'get_field' ) ? get_field( 'author_position', $post_id ) : '';
$content  = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
?>

<section class="author pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="offset-xxxl-1 col-12 col-xxxl-10">
				<div class="author-wrapper">
					<?php if ( has_post_thumbnail( $post_id ) ) : ?>
						<div class="author-image a-slide-left" data-animate-delay="0.16">
							<?php
							echo wp_get_attachment_image(
								get_post_thumbnail_id( $post_id ),
								'full',
								false,
								array(
									'alt' => get_post_meta( get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true ) ?: get_the_title( $post_id ),
								)
							);
							?>
						</div>
					<?php endif; ?>

					<div class="author-description a-fade-in-up">
						<div class="d-flex flex-column gap-16 gap-lg-24">
							<div class="author-name">
								<h1 class="p-l fw-bolder c-body"><?php the_title(); ?></h1>
								<?php if ( $position ) : ?>
									<span class="p-overline fw-bolder c-body"><?php echo esc_html( $position ); ?></span>
								<?php endif; ?>
							</div>

							<?php if ( $content ) : ?>
								<div class="blog-content c-black">
									<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

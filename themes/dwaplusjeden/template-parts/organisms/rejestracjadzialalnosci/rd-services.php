<?php
/**
 * Registration page services section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'rd_services_enabled' ) ) {
	return;
}

$heading       = get_field( 'rd_services_heading' );
$text          = get_field( 'rd_services_text' );
$bubble_text   = get_field( 'rd_services_bubble_text' );
$bubble_name   = get_field( 'rd_services_bubble_name' );
$bubble_role   = get_field( 'rd_services_bubble_role' );
$bubble_avatar = get_field( 'rd_services_bubble_avatar' );
$items         = get_field( 'rd_services_items' );

if ( ! $heading && ! $text && ! $bubble_text && ! $items ) {
	return;
}
?>

<section class="rd-services pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="rd-services-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="offset-xxxl-1 col-lg-5 col-xxxl-4">
				<div class="d-flex flex-column-reverse flex-lg-column gap-48">
					<?php if ( $heading || $text ) : ?>
						<div class="d-flex flex-column gap-24">
							<?php if ( $heading ) : ?>
								<h2 id="rd-services-heading" class="h6 fw-bolder c-white a-slide-left" data-animate-delay="0.06"><?php echo wp_kses_post( $heading ); ?></h2>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<p class="p-m c-white a-slide-left" data-animate-delay="0.10"><?php echo wp_kses_post( $text ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $bubble_text || $bubble_name || $bubble_role || $bubble_avatar ) : ?>
						<div class="hp-hero-slider-message a-bubble-pop" data-animate-delay="0.22" data-animate-start="top 80%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $bubble_text ) : ?>
										<p class="p-s"><?php echo wp_kses_post( $bubble_text ); ?></p>
									<?php endif; ?>
									<?php if ( $bubble_name || $bubble_role ) : ?>
										<div class="d-flex flex-column">
											<?php if ( $bubble_name ) : ?>
												<span class="p-s fw-bolder c-body"><?php echo esc_html( $bubble_name ); ?></span>
											<?php endif; ?>
											<?php if ( $bubble_role ) : ?>
												<span class="p-overline c-black"><?php echo esc_html( $bubble_role ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ( $bubble_avatar ) : ?>
								<div class="hero-slider-avatar">
									<div class="avatar">
										<div class="avatar-wrapper">
											<?php dwaplusjeden_image( $bubble_avatar, 'thumbnail' ); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $items ) : ?>
				<div class="offset-lg-1 col-lg-6 mt-32 mt-sm-40 mt-lg-0">
					<div class="d-flex flex-column gap-16 gap-lg-24">
						<?php foreach ( $items as $item ) : ?>
							<?php
							$item_text = ! empty( $item['text'] ) ? $item['text'] : '';

							if ( ! $item_text ) {
								continue;
							}
							?>
							<div class="rd-services-item a-fade-in-up">
								<span class="p-m fw-bolder c-white"><?php echo wp_kses_post( $item_text ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/**
 * Field offer call section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'od_call_enabled' ) ) {
	return;
}

$background_image = $has_acf ? get_field( 'od_call_background_image' ) : 0;
$heading          = $has_acf ? get_field( 'od_call_heading' ) : '';
$text             = $has_acf ? get_field( 'od_call_text' ) : '';
$link             = $has_acf ? dwaplusjeden_get_acf_link( 'od_call_link', get_the_ID() ) : array();
$front_image      = $has_acf ? get_field( 'od_call_front_image' ) : 0;
$bubble_text      = $has_acf ? get_field( 'od_call_bubble_text' ) : '';
$bubble_name      = $has_acf ? get_field( 'od_call_bubble_name' ) : '';
$bubble_role      = $has_acf ? get_field( 'od_call_bubble_role' ) : '';
$bubble_avatar    = $has_acf ? get_field( 'od_call_bubble_avatar' ) : 0;
?>

<section class="od-call pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="od-call-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="position-relative">
					<div class="od-call-container">
						<?php if ( $background_image ) : ?>
							<div class="od-call-bg">
								<?php echo wp_get_attachment_image( $background_image, 'full' ); ?>
							</div>
						<?php endif; ?>
						<div class="od-call-content">
							<?php if ( $heading ) : ?>
								<span id="od-call-heading" class="p-xl fw-bolder c-white"><?php echo wp_kses_post( $heading ); ?></span>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<p class="p-m c-white"><?php echo wp_kses_post( $text ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $link['url'] ) ) : ?>
								<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill">
									<span><?php echo esc_html( $link['title'] ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( $front_image ) : ?>
						<div class="od-call-front-image">
							<?php echo wp_get_attachment_image( $front_image, 'full' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $bubble_text || $bubble_name || $bubble_role || $bubble_avatar ) : ?>
						<div class="hp-hero-slider-message a-bubble-pop" data-animate-delay="0.22" data-animate-start="top 80%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $bubble_text ) : ?>
										<p class="p-s"><?php echo wp_kses_post( $bubble_text ); ?></p>
									<?php endif; ?>
									<div class="d-flex flex-column">
										<?php if ( $bubble_name ) : ?>
											<span class="p-s fw-bolder c-body"><?php echo esc_html( $bubble_name ); ?></span>
										<?php endif; ?>
										<?php if ( $bubble_role ) : ?>
											<span class="p-overline c-black"><?php echo esc_html( $bubble_role ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php if ( $bubble_avatar ) : ?>
								<div class="hero-slider-avatar">
									<div class="avatar">
										<div class="avatar-wrapper">
											<?php echo wp_get_attachment_image( $bubble_avatar, 'thumbnail' ); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

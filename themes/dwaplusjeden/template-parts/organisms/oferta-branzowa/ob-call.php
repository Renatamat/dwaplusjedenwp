<?php
/**
 * Offer industry call section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$prefix = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'ob_call';

if ( ! get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading      = get_field( $prefix . '_heading' );
$text         = get_field( $prefix . '_text' );
$link         = dwaplusjeden_get_acf_link( $prefix . '_link', get_the_ID() );
$bg_image     = 542;
$front_image  = 543;
$bubble_text  = get_field( $prefix . '_bubble_text' );
$bubble_name  = get_field( $prefix . '_bubble_name' );
$bubble_role  = get_field( $prefix . '_bubble_role' );
$bubble_image = get_field( $prefix . '_bubble_image' );
?>

<section class="od-call --ver2 pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="position-relative od-call-overflow">
					<div class="od-call-container">
						<div class="od-call-bg">
							<?php dwaplusjeden_image( $bg_image, 'full', 'callbg2.jpg' ); ?>
						</div>
						<div class="od-call-content">
							<?php if ( $heading ) : ?>
								<span class="p-xl fw-bolder c-white"><?php echo esc_html( $heading ); ?></span>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<p class="p-m c-white"><?php echo esc_html( $text ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $link['url'] ) ) : ?>
								<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill">
									<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>
					<div class="od-call-front-image">
						<?php dwaplusjeden_image( $front_image, 'full', 'callfront2.png' ); ?>
					</div>
					<?php if ( $bubble_text || $bubble_name || $bubble_role ) : ?>
						<div class="hp-hero-slider-message a-bubble-pop" data-animate-delay="0.22" data-animate-start="top 80%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $bubble_text ) : ?>
										<p class="p-s"><?php echo esc_html( $bubble_text ); ?></p>
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
							<div class="hero-slider-avatar">
								<div class="avatar">
									<div class="avatar-wrapper">
										<?php dwaplusjeden_image( $bubble_image, 'thumbnail', 'person.jpg' ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

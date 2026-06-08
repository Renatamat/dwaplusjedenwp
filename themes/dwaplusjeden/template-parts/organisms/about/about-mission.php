<?php
/**
 * About page mission.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'about_mission_enabled' ) ) {
	return;
}

$heading    = $has_acf ? get_field( 'about_mission_heading' ) : '';
$left_text  = $has_acf ? get_field( 'about_mission_left_text' ) : '';
$right_text = $has_acf ? get_field( 'about_mission_right_text' ) : '';

if ( ! $heading && ! $left_text && ! $right_text ) {
	return;
}
?>

<section class="about-mission overflow-hidden pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="about-mission-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="about-mission-heading" class="h6 fw-bolder c-body text-center w-100"><?php echo wp_kses_post( $heading ); ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $left_text || $right_text ) : ?>
			<div class="row mt-16 r-gap-24">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-16">
						<?php if ( $left_text ) : ?>
							<div class="col-md-6 a-slide-left" data-animate-start="top 80%" data-animate-duration="1.3">
								<p class="p-m text-start text-md-end"><?php echo wp_kses_post( $left_text ); ?></p>
							</div>
						<?php endif; ?>
						<?php if ( $right_text ) : ?>
							<div class="col-md-6 a-slide-right" data-animate-start="top 80%" data-animate-duration="1.3">
								<p class="p-m text-start"><?php echo wp_kses_post( $right_text ); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

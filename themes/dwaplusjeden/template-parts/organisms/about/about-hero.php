<?php
/**
 * About page hero.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'about_hero_enabled' ) ) {
	return;
}

$background_image = $has_acf ? get_field( 'about_hero_background_image' ) : 0;
$heading          = $has_acf ? get_field( 'about_hero_heading' ) : '';
$text             = $has_acf ? get_field( 'about_hero_text' ) : '';
$stats            = $has_acf ? get_field( 'about_hero_stats' ) : array();

if ( ! $heading && ! $text && ! $stats && ! $background_image ) {
	return;
}
?>

<section class="about-header"<?php echo $heading ? ' aria-labelledby="about-hero-heading"' : ''; ?>>
	<div class="about-header-bg">
		<?php dwaplusjeden_image( $background_image, 'full', 'aboutheader.jpg', wp_strip_all_tags( $heading ) ); ?>
	</div>
	<div class="about-header-wrapper">
		<div class="container position-relative">
			<div class="row">
				<div class="col-12">
					<?php dwaplusjeden_breadcrumb(); ?>
				</div>
			</div>
		</div>

		<div class="container position-relative mt-auto">
			<?php if ( $heading || $text ) : ?>
				<div class="row">
					<div class="col-12 col-lg-8 col-xxxl-6 mx-auto">
						<div class="d-flex flex-column gap-8 align-items-center">
							<?php if ( $heading ) : ?>
								<h1 id="about-hero-heading" class="h5 fw-bolder c-white text-center a-about-header-title"><?php echo wp_kses_post( $heading ); ?></h1>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<div class="p-m c-white text-center a-about-header-copy"><?php echo wp_kses_post( $text ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $stats ) : ?>
				<div class="row r-gap-24 mt-32 a-about-header-cards">
					<?php foreach ( $stats as $stat ) : ?>
						<?php
						$value  = isset( $stat['value'] ) ? $stat['value'] : '';
						$suffix = isset( $stat['suffix'] ) ? $stat['suffix'] : '';
						$label  = isset( $stat['label'] ) ? $stat['label'] : '';
						$target = is_numeric( $value ) ? $value : preg_replace( '/[^0-9.]/', '', (string) $value );
						?>
						<?php if ( '' !== $value || $suffix || $label ) : ?>
							<div class="col-md-6 col-xl-3 a-about-header-card">
								<div class="about-header-card">
									<div class="d-flex flex-column align-items-center gap-8">
										<div class="h5 fw-lighter c-body d-flex">
											<span class="a-about-counter"<?php echo '' !== $target ? ' data-target="' . esc_attr( $target ) . '"' : ''; ?>><?php echo esc_html( $value ); ?></span>
											<?php if ( $suffix ) : ?>
												<span class="a-about-counter-suffix"><?php echo esc_html( $suffix ); ?></span>
											<?php endif; ?>
										</div>
										<?php if ( $label ) : ?>
											<span class="p-s fw-bolder c-body"><?php echo esc_html( $label ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

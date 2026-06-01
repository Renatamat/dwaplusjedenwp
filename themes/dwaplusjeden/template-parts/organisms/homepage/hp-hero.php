<?php
/**
 * Homepage hero.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'homepage_hero_enabled' ) ) {
	return;
}

$line_1       = get_field( 'homepage_hero_line_1' );
$line_2       = get_field( 'homepage_hero_line_2' );
$avatars      = get_field( 'homepage_hero_avatars' );
$primary_link = dwaplusjeden_get_acf_link( 'homepage_hero_primary_link', get_the_ID() );
$second_link  = dwaplusjeden_get_acf_link( 'homepage_hero_secondary_link', get_the_ID() );
?>

<section class="hp-hero" data-hero-shrink>
	<div class="container">
		<div class="row">
			<div class="col-xl-10 col-xxxl-8 mx-auto">
				<h1 class="h4 fw-bolder c-body text-center d-flex align-items-center flex-column">
					<div class="d-flex flex-column flex-xl-row gap-16 align-items-center">
						<?php if ( $line_1 ) : ?>
							<span data-hero-split><?php echo esc_html( $line_1 ); ?></span>
						<?php endif; ?>

						<?php if ( $avatars ) : ?>
							<div class="avatar-header">
								<?php foreach ( $avatars as $avatar ) : ?>
									<div class="avatar">
										<div class="avatar-wrapper">
											<?php dwaplusjeden_image( $avatar['image'], 'thumbnail', 'person.jpg' ); ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( $line_2 ) : ?>
						<span class="text-center" data-hero-split><?php echo esc_html( $line_2 ); ?></span>
					<?php endif; ?>
				</h1>

				<?php if ( ! empty( $primary_link['url'] ) || ! empty( $second_link['url'] ) ) : ?>
					<div class="hp-hero-buttons d-flex flex-column flex-lg-row gap-16 justify-content-center align-items-center mt-48">
						<?php if ( ! empty( $primary_link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-outline">
								<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $second_link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $second_link ); ?> class="c-btn c-btn-s c-btn-fill">
								<span><?php echo esc_html( $second_link['title'] ?: $second_link['url'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

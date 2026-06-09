<?php
/**
 * About page team section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'about_team_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( 'about_team_heading' ) : '';
$text    = $has_acf ? get_field( 'about_team_text' ) : '';
$members = $has_acf ? get_field( 'about_team_members' ) : array();
$link    = $has_acf ? dwaplusjeden_get_acf_link( 'about_team_link', get_the_ID() ) : array();

if ( ! $heading && ! $text && ! $members && empty( $link['url'] ) ) {
	return;
}
?>

<section class="about-team pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="about-team-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-16">
						<?php if ( $heading ) : ?>
							<h2 id="about-team-heading" class="h6 fw-bolder c-white w-100 text-center"><?php echo wp_kses_post( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m c-white w-100 text-center"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $members ) : ?>
			<div class="row mt-48">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 justify-content-center a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $members as $member ) : ?>
							<?php
							$name       = isset( $member['name'] ) ? $member['name'] : '';
							$role       = isset( $member['role'] ) ? $member['role'] : '';
							$experience = isset( $member['experience'] ) ? $member['experience'] : '';
							$image      = isset( $member['image'] ) ? $member['image'] : 0;
							$author     = isset( $member['author'] ) ? $member['author'] : 0;
							$author_id  = 0;
							$author_url = '';

							if ( is_array( $author ) && isset( $author[0] ) ) {
								$author_id = (int) $author[0];
							} elseif ( is_numeric( $author ) ) {
								$author_id = (int) $author;
							}

							if ( $author_id ) {
								if ( has_filter( 'wpml_object_id' ) ) {
									$author_id = apply_filters( 'wpml_object_id', $author_id, 'autorzy', true );
								}

								if ( 'autorzy' === get_post_type( $author_id ) ) {
									$author_url = dwaplusjeden_translate_url( get_permalink( $author_id ) );

									if ( ! $name ) {
										$name = get_the_title( $author_id );
									}

									if ( ! $role && function_exists( 'get_field' ) ) {
										$role = get_field( 'author_position', $author_id );
									}

									if ( ! $image ) {
										$image = get_post_thumbnail_id( $author_id );
									}
								}
							}
							?>
							<?php if ( $name || $role || $experience || $image ) : ?>
								<div class="col-sm-6 col-lg-4 col-xl-3 a-card-item">
									<div class="about-team-card">
										<div class="about-team-card-img">
											<?php if ( $author_url ) : ?>
												<a href="<?php echo esc_url( $author_url ); ?>" aria-label="<?php echo esc_attr( $name ); ?>">
													<?php dwaplusjeden_image( $image, 'medium_large', 'team1.jpg', wp_strip_all_tags( $name ) ); ?>
												</a>
											<?php else : ?>
												<?php dwaplusjeden_image( $image, 'medium_large', 'team1.jpg', wp_strip_all_tags( $name ) ); ?>
											<?php endif; ?>
										</div>
										<div class="about-team-card-desc">
											<div class="d-flex flex-column">
												<?php if ( $name ) : ?>
													<h3 class="p-m fw-bolder">
														<?php if ( $author_url ) : ?>
															<a href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $name ); ?></a>
														<?php else : ?>
															<?php echo esc_html( $name ); ?>
														<?php endif; ?>
													</h3>
												<?php endif; ?>
												<?php if ( $role ) : ?>
													<span class="p-overline fw-bolder"><?php echo esc_html( $role ); ?></span>
												<?php endif; ?>
											</div>
											<?php if ( $experience ) : ?>
												<span class="p-s"><?php echo esc_html( $experience ); ?></span>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row mt-48">
				<div class="col-lg-4 col-xxxl-3 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

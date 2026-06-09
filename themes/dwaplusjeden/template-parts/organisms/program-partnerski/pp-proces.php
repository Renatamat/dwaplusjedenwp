<?php
/**
 * Partner program recruitment process section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'pp_proces_enabled' ) ) {
	return;
}

$heading = get_field( 'pp_proces_heading' );
$steps   = get_field( 'pp_proces_steps' );

if ( ! $heading ) {
	$heading = 'Proces rekrutacji';
}

if ( ! $steps ) {
	$steps = array(
		array(
			'title' => 'Aplikacja',
			'text'  => 'Wyślij CV i list motywacyjny przez formularz lub na adres rekrutacja@biurorachunkowe.pl',
		),
		array(
			'title' => 'Weryfikacja aplikacji',
			'text'  => 'Sprawdzamy aplikacje i kontaktujemy się z wybranymi kandydatami w ciągu 7 dni',
		),
		array(
			'title' => 'Rozmowa telefoniczna',
			'text'  => 'Krótka rozmowa wstępna na temat Twoich kompetencji i oczekiwań',
		),
		array(
			'title' => 'Spotkanie rekrutacyjne',
			'text'  => 'Rozmowa z przyszłym przełożonym i omówienie szczegółów współpracy',
		),
		array(
			'title' => 'Decyzja',
			'text'  => 'Informujemy o wyniku rekrutacji i omawiamy warunki zatrudnienia',
		),
	);
}

if ( ! $heading && ! $steps ) {
	return;
}
?>

<section class="pp-proces pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="pp-proces-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="pp-proces-heading" class="h6 fw-bolder c-body text-center w-100"><?php echo wp_kses_post( $heading ); ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $steps ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="d-flex flex-column gap-24">
						<?php foreach ( $steps as $index => $step ) : ?>
							<?php
							$title = ! empty( $step['title'] ) ? $step['title'] : '';
							$text  = ! empty( $step['text'] ) ? $step['text'] : '';

							if ( ! $title && ! $text ) {
								continue;
							}
							?>
							<div class="pp-proces-item a-fade-in-up">
								<div class="d-flex gap-20 gap-lg-32 align-items-center">
									<span class="pp-proces-item-number h6 fw-bolder c-body"><?php echo esc_html( $index + 1 ); ?></span>
									<div class="d-flex flex-column gap-8">
										<?php if ( $title ) : ?>
											<h3 class="p-m fw-bolder c-body"><?php echo wp_kses_post( $title ); ?></h3>
										<?php endif; ?>
										<?php if ( $text ) : ?>
											<p class="p-s"><?php echo wp_kses_post( $text ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

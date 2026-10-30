<?php
/**
 * Template Name: Formularz zgłoszeniowy
 *
 * @package dwaplusjeden
 */

get_header();

$application_redirect_url = get_permalink( 50 );

if ( ! $application_redirect_url ) {
	$parent_id = wp_get_post_parent_id( get_queried_object_id() );
	$application_redirect_url = $parent_id ? get_permalink( $parent_id ) : home_url( '/' );
}
?>

	<main id="primary" class="site-main">
		<section class="formularz-zgloszeniowy  zlecenie-ksiegowosci  pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 mx-auto">
						<div class="d-flex flex-column gap-48">
							<h1 class="h5 fw-bolder c-body text-center"><?php esc_html_e( 'Formularz zgłoszeniowy', 'dwaplusjeden' ); ?></h1>
							<?php echo do_shortcode( '[contact-form-7 id="73a4eea" title="Formularz zgłoszeniowy"]' ); ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		get_template_part(
			'template-parts/organisms/contact/contact-popup',
			null,
			array(
				'id'            => 'application-popup',
				'form_selector' => '.formularz-zgloszeniowy',
				'title'         => __( 'Dziękujemy za zgłoszenie!', 'dwaplusjeden' ),
				'subtitle'      => __( "Miło nam, że chcesz współpracować z 2+1.\nZapoznamy się z Twoim zgłoszeniem.", 'dwaplusjeden' ),
				'text'          => __( "Jeśli zaprosimy Cię do kolejnego etapu,\nskontaktujemy się z Tobą, aby porozmawiać o współpracy. Zastrzegamy sobie prawo do kontaktowania się z wybranymi kandydatami.", 'dwaplusjeden' ),
				'button_label'  => __( 'Ok', 'dwaplusjeden' ),
				'button_url'    => $application_redirect_url,
			)
		);
		?>
	</main>

<?php
get_footer();

<?php
/**
 * Template Name: Formularz PIT
 *
 * @package dwaplusjeden
 */

get_header();

$pit_redirect_url = get_permalink( 50 );

if ( ! $pit_redirect_url ) {
	$parent_id = wp_get_post_parent_id( get_queried_object_id() );
	$pit_redirect_url = $parent_id ? get_permalink( $parent_id ) : home_url( '/' );
}
?>

<main id="primary" class="site-main">
	<section class="formularz-pit formularz-zgloszeniowy zlecenie-ksiegowosci pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<div class="d-flex flex-column gap-48">
						<h1 class="h5 fw-bolder c-body text-center">
							<?php esc_html_e( 'Formularz rozliczenia PIT', 'dwaplusjeden' ); ?>
						</h1>
						<?php
						// Replace this shortcode with the ID of the new Contact Form 7 form.
						echo do_shortcode( '[contact-form-7 id="5c995be" title="Formularz PIT"]' );
						?>
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
			'id'            => 'pit-popup',
			'form_selector' => '.formularz-pit',
			'title'         => __( 'Dziękujemy za zgłoszenie!', 'dwaplusjeden' ),
			'subtitle'      => __( "Skontaktujemy się z Tobą tak szybko,\njak będzie to możliwe.", 'dwaplusjeden' ),
			'text'          => __( "Potwierdzenie wysłania formularza otrzymasz\nna podany przez Ciebie adres e-mail.", 'dwaplusjeden' ),
			'button_label'  => __( 'Ok', 'dwaplusjeden' ),
			'button_url'    => $pit_redirect_url,
		)
	);
	?>
</main>

<?php
get_footer();

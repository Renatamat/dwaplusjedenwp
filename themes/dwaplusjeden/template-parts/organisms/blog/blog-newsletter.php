<?php
/**
 * Blog newsletter using the existing footer newsletter options.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$newsletter_shortcode = get_field( 'footer_newsletter_shortcode', 'option' );

if ( ! $newsletter_shortcode ) {
	return;
}

$newsletter_form = do_shortcode( $newsletter_shortcode );

if ( '' === trim( $newsletter_form ) ) {
	return;
}

$newsletter_heading = get_field( 'footer_newsletter_heading', 'option' );
$newsletter_text    = get_field( 'footer_newsletter_text', 'option' );
?>

<div class="blog-newsletter-slot a-card-item">
	<aside class="blog-card blog-newsletter" aria-labelledby="blog-newsletter-heading">
		<div class="newsletter-card-wrapper">
			<h3 id="blog-newsletter-heading" class="p-l fw-bolder blog-newsletter-title"><?php esc_html_e( 'Newsletter', 'dwaplusjeden' ); ?></h3>
			<?php if ( $newsletter_heading || $newsletter_text ) : ?>
				<div class="d-flex flex-column gap-8">
					<?php if ( $newsletter_heading ) : ?>
						<p class="p-m fw-bolder c-body"><?php echo esc_html( $newsletter_heading ); ?></p>
					<?php endif; ?>
					<?php if ( $newsletter_text ) : ?>
						<p class="p-s c-body"><?php echo esc_html( $newsletter_text ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="blog-newsletter-form">
				<?php echo $newsletter_form; ?>
			</div>
		</div>
	</aside>
</div>

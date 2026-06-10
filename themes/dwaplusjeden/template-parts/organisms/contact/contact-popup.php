<?php
/**
 * Contact form success popup.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$popup_id      = ! empty( $args['id'] ) ? sanitize_html_class( $args['id'] ) : 'contact-popup';
$form_selector = ! empty( $args['form_selector'] ) ? (string) $args['form_selector'] : '.contact';
$title         = ! empty( $args['title'] ) ? (string) $args['title'] : __( 'Otrzymaliśmy Twoją wiadomość!', 'dwaplusjeden' );
$subtitle      = ! empty( $args['subtitle'] ) ? (string) $args['subtitle'] : __( 'Skontaktujemy się z Tobą w ciągu 24h.', 'dwaplusjeden' );
$text          = ! empty( $args['text'] ) ? (string) $args['text'] : __( "Potwierdzenie wysłania wiadomości otrzymasz\nna podany przez Ciebie adres e-mail.", 'dwaplusjeden' );
$button_label  = ! empty( $args['button_label'] ) ? (string) $args['button_label'] : __( 'Ok', 'dwaplusjeden' );
$button_url    = ! empty( $args['button_url'] ) ? (string) $args['button_url'] : '';
?>

<div class="contact-popup js-contact-popup" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $popup_id ); ?>-title" data-contact-popup-form-selector="<?php echo esc_attr( $form_selector ); ?>" hidden>
	<div class="contact-popup-backdrop js-contact-popup-close" aria-hidden="true"></div>
	<div class="contact-popup-dialog contact-form bg-white a-fade-in-up">
		<div class="contact-popup-content d-flex flex-column gap-24">
			<div class="contact-popup-heading d-flex flex-column gap-32 align-items-center">
				<div class="contact-item-icon pp-proces-item-number a-bubble-pop js-contact-popup-icon" data-animate-delay="0.10">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M46.1192 9.89888L19.6557 39.0088C19.1133 39.6054 18.1962 39.6665 17.5795 39.1471L1.88672 25.9308L3.81924 23.6362L18.4073 35.9221L43.8994 7.88086L46.1192 9.89888Z" fill="#E62E2E" stroke="#E62E2E" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
					</svg>
				</div>
				<p id="<?php echo esc_attr( $popup_id ); ?>-title" class="p-xl fw-bolder c-headline text-center mb-0 c-body "><?php echo esc_html( $title ); ?></p>
			</div>
			<?php if ( $subtitle ) : ?>
				<p class="p-l fw-bolder c-secondary text-center mb-0 c-body "><?php echo wp_kses_post( nl2br( $subtitle ) ); ?></p>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<p class="p-m c-body text-center mb-0"><?php echo wp_kses_post( nl2br( $text ) ); ?></p>
			<?php endif; ?>
			<div class="contact-popup-actions d-flex justify-content-center">
				<button type="button" class="c-btn c-btn-s c-btn-fill js-contact-popup-close"<?php echo $button_url ? ' data-contact-popup-redirect="' . esc_url( $button_url ) . '"' : ''; ?>>
					<span><?php echo esc_html( $button_label ); ?></span>
				</button>
			</div>
		</div>
	</div>
</div>

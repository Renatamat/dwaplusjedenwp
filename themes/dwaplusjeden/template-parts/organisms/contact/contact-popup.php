<?php
/**
 * Contact form success popup.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

?>

<div class="contact-popup js-contact-popup" role="dialog" aria-modal="true" aria-labelledby="contact-popup-title" hidden>
	<div class="contact-popup-backdrop js-contact-popup-close" aria-hidden="true"></div>
	<div class="contact-popup-dialog contact-form bg-white a-fade-in-up">
		<div class="contact-popup-content d-flex flex-column gap-24">
			<div class="contact-popup-heading d-flex flex-column gap-32 align-items-center">
				<div class="contact-item-icon pp-proces-item-number a-bubble-pop js-contact-popup-icon" data-animate-delay="0.10">
					<svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M46.1192 9.89888L19.6557 39.0088C19.1133 39.6054 18.1962 39.6665 17.5795 39.1471L1.88672 25.9308L3.81924 23.6362L18.4073 35.9221L43.8994 7.88086L46.1192 9.89888Z" fill="#E62E2E" stroke="#E62E2E" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/>
					</svg>
				</div>
				<p id="contact-popup-title" class="p-xl fw-bolder c-headline text-center mb-0 c-body "><?php esc_html_e( 'Otrzymaliśmy Twoją wiadomość!', 'dwaplusjeden' ); ?></p>
			</div>
			<p class="p-l fw-bolder c-secondary text-center mb-0 c-body "><?php esc_html_e( 'Skontaktujemy się z Tobą w ciągu 24h.', 'dwaplusjeden' ); ?></p>
			<p class="p-m c-body text-center mb-0">
				<?php esc_html_e( 'Potwierdzenie wysłania wiadomości otrzymasz', 'dwaplusjeden' ); ?><br class="d-none d-sm-block">
				<?php esc_html_e( 'na podany przez Ciebie adres e-mail.', 'dwaplusjeden' ); ?>
			</p>
			<div class="contact-popup-actions d-flex justify-content-center">
				<button type="button" class="c-btn c-btn-s c-btn-fill js-contact-popup-close">
					<span><?php esc_html_e( 'Ok', 'dwaplusjeden' ); ?></span>
				</button>
			</div>
		</div>
	</div>
</div>

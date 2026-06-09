( function () {
	const popup = document.querySelector( '.js-contact-popup' );

	if ( ! popup ) {
		return;
	}

	const closeButtons = popup.querySelectorAll( '.js-contact-popup-close' );
	const focusTarget = popup.querySelector( '.js-contact-popup-close:not(.contact-popup-backdrop)' );
	const dialog = popup.querySelector( '.contact-popup-dialog' );
	const icon = popup.querySelector( '.js-contact-popup-icon' );
	let isClosing = false;

	const animatePopup = function () {
		if ( ! window.gsap ) {
			return;
		}

		window.gsap.killTweensOf( [ dialog, icon ].filter( Boolean ) );

		if ( dialog ) {
			window.gsap.fromTo(
				dialog,
				{
					autoAlpha: 0,
					y: 34,
					scale: 0.94,
				},
				{
					autoAlpha: 1,
					y: 0,
					scale: 1,
					duration: 0.52,
					ease: 'back.out(1.35)',
					clearProps: 'transform,opacity,visibility',
				}
			);
		}

		if ( icon ) {
			window.gsap.fromTo(
				icon,
				{
					autoAlpha: 0,
					y: 22,
					scale: 0.48,
					rotation: -16,
					transformOrigin: '50% 50%',
				},
				{
					autoAlpha: 1,
					y: 0,
					scale: 1,
					rotation: 0,
					duration: 0.9,
					delay: 0.12,
					ease: 'elastic.out(1, 0.45)',
					clearProps: 'transform,opacity,visibility',
				}
			);
		}
	};

	const hidePopup = function () {
		popup.hidden = true;
		document.body.classList.remove( 'contact-popup-open' );
		isClosing = false;
	};

	const openPopup = function () {
		isClosing = false;
		popup.hidden = false;
		document.body.classList.add( 'contact-popup-open' );
		animatePopup();

		if ( focusTarget ) {
			focusTarget.focus();
		}
	};

	const closePopup = function () {
		if ( popup.hidden || isClosing ) {
			return;
		}

		if ( ! window.gsap || ! dialog ) {
			hidePopup();
			return;
		}

		isClosing = true;
		window.gsap.killTweensOf( [ dialog, icon ].filter( Boolean ) );

		window.gsap.to( icon, {
			autoAlpha: 0,
			y: -10,
			scale: 0.7,
			rotation: 10,
			duration: 0.22,
			ease: 'power2.in',
		} );

		window.gsap.to( dialog, {
			autoAlpha: 0,
			y: 18,
			scale: 0.96,
			duration: 0.28,
			ease: 'power2.in',
			onComplete: hidePopup,
		} );
	};

	document.addEventListener( 'wpcf7mailsent', function ( event ) {
		if ( event.target && event.target.closest( '.contact' ) ) {
			openPopup();
		}
	} );

	closeButtons.forEach( function ( button ) {
		button.addEventListener( 'click', closePopup );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && ! popup.hidden ) {
			closePopup();
		}
	} );
}() );

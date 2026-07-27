( function ( $ ) {
	'use strict';

	const fieldSelector = [
		'.acf-field[data-key="field_seo_section_text"]',
		'.acf-field[data-key="field_seo_section_text_desc"]',
		'.acf-field[data-name="seo_text"]',
		'.acf-field[data-name="seo_text_desc"]',
		'.acf-field[data-name*="_seo_"][data-name$="_text"]',
		'.acf-field[data-name*="_seo_"][data-name$="_text_desc"]',
	].join( ',' );
	const allowedAttributes = {
		a: [ 'href', 'title', 'target', 'rel', 'class', 'aria-label' ],
		b: [ 'class' ],
		blockquote: [ 'class', 'cite' ],
		br: [ 'class' ],
		caption: [ 'class' ],
		col: [ 'class', 'span' ],
		colgroup: [ 'class' ],
		del: [ 'class', 'cite', 'datetime' ],
		em: [ 'class' ],
		i: [ 'class' ],
		img: [ 'src', 'alt', 'title', 'width', 'height', 'class', 'loading', 'srcset', 'sizes', 'data-wp-more' ],
		ins: [ 'class', 'cite', 'datetime' ],
		code: [ 'class' ],
		li: [ 'class' ],
		ol: [ 'class' ],
		p: [ 'class' ],
		span: [ 'class' ],
		strong: [ 'class' ],
		sub: [ 'class' ],
		sup: [ 'class' ],
		table: [ 'class' ],
		tbody: [ 'class' ],
		td: [ 'class', 'colspan', 'rowspan', 'headers' ],
		tfoot: [ 'class' ],
		th: [ 'class', 'colspan', 'rowspan', 'headers', 'scope', 'abbr' ],
		thead: [ 'class' ],
		tr: [ 'class' ],
		ul: [ 'class' ],
	};

	const validElements = Object.entries( allowedAttributes )
		.map( ( [ tagName, attributes ] ) => `${ tagName }[${ attributes.join( '|' ) }]` )
		.join( ',' );

	const isSeoField = ( field ) => {
		if ( ! field || typeof field.get !== 'function' ) {
			return false;
		}

		const fieldKey = String( field.get( 'key' ) || '' );
		const fieldName = String( field.get( 'name' ) || '' );

		if ( [ 'field_seo_section_text', 'field_seo_section_text_desc' ].includes( fieldKey ) ) {
			return true;
		}

		return /(^|_)seo(?:_(?:left|right))?_(?:text|text_desc)$/.test( fieldName );
	};

	if ( window.acf && typeof window.acf.addFilter === 'function' ) {
		window.acf.addFilter( 'wysiwyg_tinymce_settings', ( settings, editorId, field ) => {
			if ( ! isSeoField( field ) ) {
				return settings;
			}

			settings.valid_elements = validElements;
			settings.extended_valid_elements = 'span[class]';
			settings.remove_empty = false;

			return settings;
		} );
	}
	const sanitizeContent = ( content ) => {
		const container = document.createElement( 'div' );

		container.innerHTML = String( content )
			.replace( /<h[1-6]\b([^>]*)>/gi, '<p$1>' )
			.replace( /<\/h[1-6]\s*>/gi, '</p>' );

		Array.from( container.querySelectorAll( '*' ) ).forEach( ( element ) => {
			const tagName = element.tagName.toLowerCase();
			const attributes = allowedAttributes[ tagName ];

			if ( ! attributes ) {
				element.replaceWith( ...Array.from( element.childNodes ) );
				return;
			}

			Array.from( element.attributes ).forEach( ( attribute ) => {
				if ( ! attributes.includes( attribute.name.toLowerCase() ) ) {
					element.removeAttribute( attribute.name );
				}
			} );
		} );

		return container.innerHTML;
	};

	const getField = ( editor ) => {
		const textarea = document.getElementById( editor.id );

		return textarea ? textarea.closest( fieldSelector ) : null;
	};

	const sanitizeEditor = ( editor ) => {
		const content = editor.getContent();
		const sanitizedContent = sanitizeContent( content );

		if ( content !== sanitizedContent ) {
			editor.setContent( sanitizedContent );
			editor.save();
		}
	};

	const attachSanitizer = ( editor ) => {
		if ( ! getField( editor ) || editor.settings.dwaplusjedenSeoSanitizer ) {
			return;
		}

		editor.settings.dwaplusjedenSeoSanitizer = true;

		editor.on( 'BeforeSetContent', ( event ) => {
			event.content = sanitizeContent( event.content );
		} );

		editor.on( 'PastePreProcess', ( event ) => {
			event.content = sanitizeContent( event.content );
		} );

		sanitizeEditor( editor );
	};

	$( document ).on( 'tinymce-editor-init', ( event, editor ) => {
		attachSanitizer( editor );
	} );

	$( document ).on( 'click', `${ fieldSelector } .wp-switch-editor.switch-tmce`, function () {
		const field = this.closest( fieldSelector );
		const textarea = field ? field.querySelector( 'textarea.wp-editor-area' ) : null;

		if ( ! textarea || ! window.tinymce ) {
			return;
		}

		window.setTimeout( () => {
			const editor = window.tinymce.get( textarea.id );

			if ( ! editor ) {
				return;
			}

			attachSanitizer( editor );
			sanitizeEditor( editor );
		}, 0 );
	} );
}( jQuery ) );
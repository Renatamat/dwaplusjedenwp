(function ($) {
	'use strict';

	var checkboxSelector = '#wp-link-nofollow';
	var activeAcfLink = null;
	var preservedRel = [];
	var submitRequested = false;

	function relTokens(value) {
		return String(value || '')
			.split(/\s+/)
			.filter(Boolean);
	}

	function uniqueTokens(tokens) {
		return tokens.filter(function (token, index) {
			return tokens.indexOf(token) === index;
		});
	}

	function ensureCheckbox() {
		if ($(checkboxSelector).length) {
			return $(checkboxSelector);
		}

		var $target = $('#wp-link-target').closest('.link-target');
		if (!$target.length) {
			return $();
		}

		var $row = $(
			'<div class="link-target link-nofollow">' +
				'<label><span></span>' +
					'<input type="checkbox" id="wp-link-nofollow"> Oznacz odnośnik jako nofollow' +
				'</label>' +
			'</div>'
		);

		$target.after($row);
		return $row.find(checkboxSelector);
	}

	function getSelectedEditorLink() {
		if (!window.tinymce || !window.wpActiveEditor) {
			return null;
		}

		var editor = window.tinymce.get(window.wpActiveEditor);
		if (!editor || editor.isHidden()) {
			return null;
		}

		var node = editor.selection.getNode();
		return editor.dom.getParent(node, 'a[href]');
	}

	function ensureAcfNofollowInput($control) {
		var $input = $control.find('.input-nofollow');
		if ($input.length) {
			return $input;
		}

		var $urlInput = $control.find('.input-url');
		var inputName = String($urlInput.attr('name') || '').replace(/\[url\]$/, '[nofollow]');
		if (!inputName) {
			return $();
		}

		$input = $('<input>', {
			type: 'hidden',
			class: 'input-nofollow',
			name: inputName,
			value: ''
		});
		$control.find('.acf-hidden').append($input);
		return $input;
	}

	function patchWpLink() {
		if (!window.wpLink || window.wpLink.dwaplusjedenNofollowPatched) {
			return;
		}

		var originalGetAttrs = window.wpLink.getAttrs;
		var originalBuildHtml = window.wpLink.buildHtml;

		window.wpLink.getAttrs = function () {
			var attrs = originalGetAttrs.apply(this, arguments);
			var tokens = preservedRel.slice();

			if ($(checkboxSelector).prop('checked')) {
				tokens.push('nofollow');
			}

			attrs.rel = uniqueTokens(tokens).join(' ') || null;
			return attrs;
		};

		window.wpLink.buildHtml = function (attrs) {
			var html = originalBuildHtml.apply(this, arguments);

			if (attrs.rel) {
				html = html.slice(0, -1) + ' rel="' + attrs.rel + '">';
			}

			return html;
		};

		window.wpLink.dwaplusjedenNofollowPatched = true;
	}

	document.addEventListener('click', function (event) {
		var trigger = event.target.closest(
			'.acf-field-link .acf-link a[data-name="add"], ' +
			'.acf-field-link .acf-link a[data-name="edit"]'
		);

		if (trigger) {
			activeAcfLink = $(trigger).closest('.acf-link');
		}
	}, true);

	$(document)
		.on('click', '.acf-field-link .acf-link a[data-name="remove"]', function () {
			var $control = $(this).closest('.acf-link');
			$control.find('.input-nofollow').val('');
			$control.find('.link-node').removeAttr('rel');
		})
		.on('mousedown click', '#wp-link-submit', function () {
			submitRequested = true;
		})
		.on('wplink-open', function () {
			var $checkbox = ensureCheckbox();
			var isAcfDialog = $('#acf-link-textarea').length > 0 && activeAcfLink && activeAcfLink.length;
			var nofollow = false;
			var rel = '';

			submitRequested = false;

			if (isAcfDialog) {
				nofollow = activeAcfLink.find('.input-nofollow').val() === '1';
				rel = activeAcfLink.find('.link-node').attr('rel') || '';
			} else {
				var link = getSelectedEditorLink();
				rel = link ? link.getAttribute('rel') || '' : '';
				nofollow = relTokens(rel).indexOf('nofollow') !== -1;
			}

			preservedRel = relTokens(rel).filter(function (token) {
				return token !== 'nofollow';
			});
			$checkbox.prop('checked', nofollow);
		})
		.on('wplink-close', function () {
			if (activeAcfLink && activeAcfLink.length && submitRequested) {
				var nofollow = $(checkboxSelector).prop('checked');
				var $input = ensureAcfNofollowInput(activeAcfLink);

				$input.val(nofollow ? '1' : '');
				activeAcfLink.find('.link-node').attr('rel', nofollow ? 'nofollow' : null);
				activeAcfLink.find('.input-url').trigger('change');
			}

			activeAcfLink = null;
			preservedRel = [];
			submitRequested = false;
		});

	$(function () {
		patchWpLink();
		ensureCheckbox();
	});
})(jQuery);
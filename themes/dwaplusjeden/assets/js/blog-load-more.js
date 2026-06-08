(function () {
	const buttons = document.querySelectorAll('[data-blog-load-more]');

	if (!buttons.length) {
		return;
	}

	buttons.forEach((button) => {
		const targetSelector = button.dataset.target;
		const target = targetSelector ? document.querySelector(targetSelector) : null;

		if (!target) {
			return;
		}

		button.addEventListener('click', async () => {
			if (button.disabled) {
				return;
			}

			const label = button.querySelector('span');
			const defaultLabel = label ? label.textContent : '';

			button.disabled = true;

			if (label) {
				label.textContent = button.dataset.loadingLabel || defaultLabel;
			}

			const body = new URLSearchParams({
				action: 'dwaplusjeden_load_blog_posts',
				nonce: button.dataset.nonce || '',
				offset: button.dataset.offset || '0',
				category: button.dataset.category || '',
				tag: button.dataset.tag || '',
				author: button.dataset.author || '',
				year: button.dataset.year || '',
				monthnum: button.dataset.monthnum || '',
				day: button.dataset.day || '',
				search: button.dataset.search || '',
			});

			try {
				const response = await fetch(button.dataset.ajaxUrl, {
					method: 'POST',
					credentials: 'same-origin',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
					},
					body,
				});
				const result = await response.json();

				if (!result.success || !result.data || !result.data.html) {
					button.remove();
					return;
				}

				target.insertAdjacentHTML('beforeend', result.data.html);
				button.dataset.offset = String(result.data.nextOffset || 0);

				if (!result.data.hasMore) {
					button.remove();
					return;
				}

				button.disabled = false;

				if (label) {
					label.textContent = defaultLabel;
				}
			} catch (error) {
				button.disabled = false;

				if (label) {
					label.textContent = defaultLabel;
				}
			}
		});
	});
})();

/**
 * Header interactions — mobile menu, search toggle, sticky state.
 *
 * @package Visitbest
 */
(function () {
	'use strict';

	var header = document.getElementById('vb-site-header');
	var menuToggle = document.getElementById('vb-menu-toggle');
	var searchToggle = document.getElementById('vb-search-toggle');
	var searchPanel = document.getElementById('vb-header-search');
	var nav = document.getElementById('vb-primary-nav');

	if (!header) {
		return;
	}

	function setExpanded(button, expanded) {
		if (button) {
			button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		}
	}

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', function () {
			var isOpen = header.classList.toggle('is-menu-open');
			setExpanded(menuToggle, isOpen);
			menuToggle.setAttribute(
				'aria-label',
				isOpen ? 'Close menu' : 'Open menu'
			);
		});
	}

	if (searchToggle && searchPanel) {
		searchToggle.addEventListener('click', function () {
			var isOpen = searchPanel.hasAttribute('hidden');
			if (isOpen) {
				searchPanel.removeAttribute('hidden');
				setExpanded(searchToggle, true);
				var input = searchPanel.querySelector('input[type="search"], input[type="text"]');
				if (input) {
					input.focus();
				}
			} else {
				searchPanel.setAttribute('hidden', '');
				setExpanded(searchToggle, false);
			}
		});
	}

	window.addEventListener(
		'scroll',
		function () {
			if (window.scrollY > 8) {
				header.classList.add('is-scrolled');
			} else {
				header.classList.remove('is-scrolled');
			}
		},
		{ passive: true }
	);
})();

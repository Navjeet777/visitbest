/**
 * Header interactions — mobile menu, search, accessibility.
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

	var labels = window.visitbestHeader || {};
	var menuOpenLabel = labels.menuOpen || 'Open menu';
	var menuCloseLabel = labels.menuClose || 'Close menu';
	var searchOpenLabel = labels.searchOpen || 'Open search';
	var searchCloseLabel = labels.searchClose || 'Close search';

	function setExpanded(button, expanded) {
		if (button) {
			button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		}
	}

	function isMenuOpen() {
		return header.classList.contains('is-menu-open');
	}

	function isSearchOpen() {
		return searchPanel && !searchPanel.hasAttribute('hidden');
	}

	function closeMenu() {
		header.classList.remove('is-menu-open');
		setExpanded(menuToggle, false);
		if (menuToggle) {
			menuToggle.setAttribute('aria-label', menuOpenLabel);
		}
	}

	function openMenu() {
		closeSearch();
		header.classList.add('is-menu-open');
		setExpanded(menuToggle, true);
		if (menuToggle) {
			menuToggle.setAttribute('aria-label', menuCloseLabel);
		}
	}

	function closeSearch() {
		if (!searchPanel) {
			return;
		}
		searchPanel.setAttribute('hidden', '');
		setExpanded(searchToggle, false);
		if (searchToggle) {
			searchToggle.setAttribute('aria-label', searchOpenLabel);
		}
	}

	function openSearch() {
		closeMenu();
		if (!searchPanel) {
			return;
		}
		searchPanel.removeAttribute('hidden');
		setExpanded(searchToggle, true);
		if (searchToggle) {
			searchToggle.setAttribute('aria-label', searchCloseLabel);
		}
		var input = searchPanel.querySelector('input[type="search"], input[type="text"]');
		if (input) {
			input.focus();
		}
	}

	function closeAll() {
		closeMenu();
		closeSearch();
	}

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', function () {
			if (isMenuOpen()) {
				closeMenu();
			} else {
				openMenu();
			}
		});
	}

	if (searchToggle && searchPanel) {
		searchToggle.addEventListener('click', function () {
			if (isSearchOpen()) {
				closeSearch();
			} else {
				openSearch();
			}
		});
	}

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			closeAll();
		}
	});

	document.addEventListener('click', function (event) {
		if (!header.contains(event.target)) {
			closeAll();
		}
	});

	window.addEventListener('resize', function () {
		if (window.innerWidth >= 1024) {
			closeMenu();
		}
	});

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

(function () {
	'use strict';

	var accordion = document.querySelector('.nch-accordion');
	if (!accordion) return;

	var courseId   = accordion.dataset.courseId || 'default';
	var storageKey = 'nch_progress_' + courseId;
	var items      = Array.from(accordion.querySelectorAll('.nch-accordion__item'));
	var progress   = JSON.parse(localStorage.getItem(storageKey) || '{}');
	var ytPlayers  = {};

	/* ── Helpers ───────────────────────────────────── */

	function isUnlocked(index) {
		return index === 0 || progress[String(index - 1)] === true;
	}

	function markDone(index) {
		progress[String(index)] = true;
		localStorage.setItem(storageKey, JSON.stringify(progress));
		render();
		var next = items[index + 1];
		if (next) openItem(next);
	}

	function openItem(item) {
		items.forEach(function (i) {
			i.classList.remove('nch-accordion__item--open');
		});
		item.classList.add('nch-accordion__item--open');
		updateChevrons();
	}

	function updateChevrons() {
		items.forEach(function (item) {
			var chevron = item.querySelector('.nch-accordion__chevron');
			if (!chevron) return;
			chevron.classList.toggle('nch-accordion__chevron--open', item.classList.contains('nch-accordion__item--open'));
		});
	}

	function render() {
		items.forEach(function (item, index) {
			var unlocked = isUnlocked(index);
			var done     = progress[String(index)] === true;
			var icon     = item.querySelector('.nch-accordion__icon');

			item.classList.toggle('nch-accordion__item--locked', !unlocked);
			item.classList.toggle('nch-accordion__item--done', done);

			if (icon) {
				if (done)          icon.textContent = '✓';
				else if (!unlocked) icon.textContent = '🔒';
				else               icon.textContent = '';
			}

			var hint = item.querySelector('.nch-accordion__hint');
			if (hint) {
				hint.style.display = done ? 'none' : '';
			}
		});
	}

	/* ── Click handlers ────────────────────────────── */

	items.forEach(function (item) {
		var header = item.querySelector('.nch-accordion__header');
		if (!header) return;
		header.addEventListener('click', function () {
			if (item.classList.contains('nch-accordion__item--locked')) return;
			if (!item.classList.contains('nch-accordion__item--open')) {
				openItem(item);
			}
		});
	});

	/* ── HTML5 video ───────────────────────────────── */

	items.forEach(function (item, index) {
		var video = item.querySelector('video');
		if (!video) return;
		video.addEventListener('ended', function () {
			markDone(index);
		});
	});

	/* ── YouTube Iframe API ────────────────────────── */

	function initYouTubePlayer(iframe, index) {
		ytPlayers[index] = new YT.Player(iframe, {
			events: {
				onStateChange: function (event) {
					if (event.data === YT.PlayerState.ENDED) {
						markDone(index);
					}
				}
			}
		});
	}

	window.onYouTubeIframeAPIReady = function () {
		items.forEach(function (item, index) {
			var iframe = item.querySelector('iframe[src*="youtube.com"]');
			if (iframe) initYouTubePlayer(iframe, index);
		});
	};

	if (accordion.querySelector('iframe[src*="youtube.com"]')) {
		var tag  = document.createElement('script');
		tag.src  = 'https://www.youtube.com/iframe_api';
		var first = document.getElementsByTagName('script')[0];
		first.parentNode.insertBefore(tag, first);
	}

	/* ── Init ──────────────────────────────────────── */

	render();
	if (items[0]) openItem(items[0]);

})();

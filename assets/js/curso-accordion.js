(function () {
	'use strict';

	var lessons    = Array.from(document.querySelectorAll('.nch-lesson'));
	if (!lessons.length) return;

	var container  = lessons[0].closest('[data-course-id]') || document.querySelector('.nch-lessons');
	var courseId   = container ? (container.dataset.courseId || window.location.pathname) : window.location.pathname;
	var storageKey = 'nch_progress_' + courseId;
	var progress   = JSON.parse(localStorage.getItem(storageKey) || '{}');

	/* ── Helpers ─────────────────────────────────── */

	function isDone(index)     { return progress[String(index)] === true; }
	function isUnlocked(index) { return index === 0 || isDone(index - 1); }

	function markDone(index) {
		progress[String(index)] = true;
		localStorage.setItem(storageKey, JSON.stringify(progress));
		render();
		var next = lessons[index + 1];
		if (next) openLesson(next);
	}

	function openLesson(details) {
		details.setAttribute('open', '');
	}

	/* ── Render state ─────────────────────────────── */

	function render() {
		lessons.forEach(function (details, index) {
			var unlocked = isUnlocked(index);
			var done     = isDone(index);
			var summary  = details.querySelector('summary');
			var hint     = details.querySelector('.nch-lesson__hint');

			details.classList.toggle('nch-lesson--locked', !unlocked);
			details.classList.toggle('nch-lesson--done', done);

			if (summary) {
				var icon = summary.querySelector('.nch-lesson__icon');
				if (!icon) {
					icon = document.createElement('span');
					icon.className = 'nch-lesson__icon';
					summary.insertBefore(icon, summary.firstChild);
				}
				icon.textContent = done ? '✓' : (!unlocked ? '🔒' : '');
			}

			if (hint) hint.style.display = done ? 'none' : '';
		});
	}

	/* ── Bloquear click en lecciones cerradas ─────── */

	lessons.forEach(function (details) {
		var summary = details.querySelector('summary');
		if (!summary) return;
		summary.addEventListener('click', function (e) {
			if (details.classList.contains('nch-lesson--locked')) {
				e.preventDefault();
			}
		});
	});

	/* ── Añadir enablejsapi=1 a iframes de YouTube ── */

	function patchYouTubeIframe(iframe) {
		var src = iframe.src || '';
		if (!src.includes('enablejsapi')) {
			iframe.src = src + (src.includes('?') ? '&' : '?') + 'enablejsapi=1';
		}
	}

	/* ── YouTube Iframe API ───────────────────────── */

	function initYouTube() {
		lessons.forEach(function (details, index) {
			var iframe = details.querySelector('iframe[src*="youtube"]');
			if (!iframe) return;
			patchYouTubeIframe(iframe);
			new YT.Player(iframe, {
				events: {
					onStateChange: function (e) {
						if (e.data === YT.PlayerState.ENDED) markDone(index);
					}
				}
			});
		});
	}

	window.onYouTubeIframeAPIReady = initYouTube;

	if (document.querySelector('.nch-lesson iframe[src*="youtube"]') ||
		document.querySelector('.nch-lesson .wp-block-embed-youtube')) {
		var tag   = document.createElement('script');
		tag.src   = 'https://www.youtube.com/iframe_api';
		var first = document.getElementsByTagName('script')[0];
		first.parentNode.insertBefore(tag, first);
	}

	/* ── HTML5 video fallback ─────────────────────── */

	lessons.forEach(function (details, index) {
		var video = details.querySelector('video');
		if (!video) return;
		video.addEventListener('ended', function () { markDone(index); });
	});

	/* ── Init ─────────────────────────────────────── */

	render();

})();

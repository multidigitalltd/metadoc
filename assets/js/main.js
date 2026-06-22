/**
 * Metadoc — JavaScript וניל בלבד (ללא ספריות).
 * 1. שליחת טופס לידים ל-REST (Nonce + ולידציה).
 * 2. ווידג'ט נגישות (ת"י 5568) עם שמירה ב-localStorage.
 */
(function () {
	'use strict';

	var data = window.metadocData || {};
	var i18n = data.i18n || {};

	/* ------------------------------------------------------------------ */
	/* טפסי לידים                                                          */
	/* ------------------------------------------------------------------ */
	var PHONE_RE = /^0\d[\d-]{7,11}$/;

	/**
	 * מחזיר nonce עדכני מה-endpoint; בכשל נופל ל-nonce המוטמע.
	 * @returns {Promise<string>}
	 */
	function getFreshNonce() {
		if (!data.nonceUrl) { return Promise.resolve(data.nonce); }
		return fetch(data.nonceUrl, { headers: { 'Accept': 'application/json' }, cache: 'no-store' })
			.then(function (res) { return res.ok ? res.json() : null; })
			.then(function (body) { return (body && body.nonce) ? body.nonce : data.nonce; })
			.catch(function () { return data.nonce; });
	}

	function setStatus(el, msg, ok) {
		if (!el) return;
		el.textContent = msg;
		el.style.color = ok ? '#16a34a' : '#f97316';
	}

	function handleForm(form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();

			var statusEl = form.querySelector('.md-form-status');
			var button = form.querySelector('button[type="submit"]');
			var label = form.querySelector('.md-btn-label');
			var labelText = label ? label.textContent : '';

			var name = (form.elements.name && form.elements.name.value || '').trim();
			var phone = (form.elements.phone && form.elements.phone.value || '').trim();
			var note = (form.elements.note && form.elements.note.value || '').trim();
			var hp = (form.elements.website && form.elements.website.value || '').trim();

			if (hp !== '') { return; } // honeypot
			if (name.length < 2) { setStatus(statusEl, i18n.invalidName || 'נא להזין שם מלא', false); return; }
			if (!PHONE_RE.test(phone)) { setStatus(statusEl, i18n.invalidPhone || 'מספר טלפון לא תקין', false); return; }

			if (button) { button.disabled = true; }
			if (label) { label.textContent = i18n.sending || 'שולח...'; }
			setStatus(statusEl, '', true);

			// שולפים nonce טרי בזמן ריצה כדי לא להישען על ה-nonce המוטמע ב-HTML,
			// שעלול להיות במטמון full-page (LiteSpeed/Cloudflare/WP Rocket) ולפוג.
			getFreshNonce()
				.then(function (nonce) {
					return fetch(data.restUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': nonce },
						body: JSON.stringify({ name: name, phone: phone, note: note, website: hp })
					});
				})
				.then(function (res) {
					return res.json().then(function (body) { return { ok: res.ok, body: body }; });
				})
				.then(function (result) {
					if (result.ok) {
						setStatus(statusEl, i18n.success || 'הפרטים נשלחו!', true);
						form.reset();
					} else {
						var msg = (result.body && result.body.message) ? result.body.message : (i18n.error || 'אירעה שגיאה.');
						setStatus(statusEl, msg, false);
					}
				})
				.catch(function () {
					setStatus(statusEl, i18n.error || 'אירעה שגיאה.', false);
				})
				.finally(function () {
					if (button) { button.disabled = false; }
					if (label) { label.textContent = labelText; }
				});
		});
	}

	/* ------------------------------------------------------------------ */
	/* ווידג'ט נגישות                                                      */
	/* ------------------------------------------------------------------ */
	var A11Y_KEY = 'md-a11y';
	var TOGGLE_CLASSES = {
		contrast: 'md-a11y-contrast',
		invert: 'md-a11y-invert',
		grayscale: 'md-a11y-grayscale',
		links: 'md-a11y-links',
		'highlight-headings': 'md-a11y-highlight-headings',
		readable: 'md-a11y-readable',
		'stop-anim': 'md-a11y-stop-anim'
	};

	var state = { toggles: {}, scale: 100, guide: false };

	function loadState() {
		try {
			var raw = localStorage.getItem(A11Y_KEY);
			if (raw) { state = Object.assign(state, JSON.parse(raw)); }
		} catch (e) {}
	}
	function saveState() {
		try { localStorage.setItem(A11Y_KEY, JSON.stringify(state)); } catch (e) {}
	}

	function applyState() {
		var html = document.documentElement;
		Object.keys(TOGGLE_CLASSES).forEach(function (key) {
			html.classList.toggle(TOGGLE_CLASSES[key], !!state.toggles[key]);
		});
		html.style.fontSize = state.scale !== 100 ? state.scale + '%' : '';
		var guide = document.querySelector('.md-reading-guide');
		if (guide) { guide.style.display = state.guide ? 'block' : 'none'; }
		// סנכרון aria-pressed.
		document.querySelectorAll('.md-a11y-btn').forEach(function (btn) {
			var k = btn.getAttribute('data-a11y');
			var pressed = false;
			if (TOGGLE_CLASSES[k]) { pressed = !!state.toggles[k]; }
			else if (k === 'reading-guide') { pressed = state.guide; }
			else if (k === 'text-bigger' || k === 'text-smaller') { pressed = state.scale !== 100; }
			btn.setAttribute('aria-pressed', pressed ? 'true' : 'false');
		});
	}

	function onGuideMove(e) {
		var guide = document.querySelector('.md-reading-guide');
		if (guide) { guide.style.top = (e.clientY - 18) + 'px'; }
	}

	function setupA11y() {
		var root = document.getElementById('md-a11y');
		if (!root) return;
		var toggleBtn = document.getElementById('md-a11y-toggle');
		var panel = document.getElementById('md-a11y-panel');
		var closeBtn = document.getElementById('md-a11y-close');
		var resetBtn = document.getElementById('md-a11y-reset');

		function openPanel() {
			panel.hidden = false;
			toggleBtn.setAttribute('aria-expanded', 'true');
			var first = panel.querySelector('button, a');
			if (first) { first.focus(); }
		}
		function closePanel() {
			panel.hidden = true;
			toggleBtn.setAttribute('aria-expanded', 'false');
			toggleBtn.focus();
		}

		toggleBtn.addEventListener('click', function () {
			if (panel.hidden) { openPanel(); } else { closePanel(); }
		});
		if (closeBtn) { closeBtn.addEventListener('click', closePanel); }

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !panel.hidden) { closePanel(); }
		});
		document.addEventListener('click', function (e) {
			if (!panel.hidden && !root.contains(e.target)) { closePanel(); }
		});

		panel.querySelectorAll('.md-a11y-btn').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var k = btn.getAttribute('data-a11y');
				if (TOGGLE_CLASSES[k]) {
					state.toggles[k] = !state.toggles[k];
				} else if (k === 'reading-guide') {
					state.guide = !state.guide;
					if (state.guide) { document.addEventListener('mousemove', onGuideMove); }
					else { document.removeEventListener('mousemove', onGuideMove); }
				} else if (k === 'text-bigger') {
					state.scale = Math.min(160, state.scale + 10);
				} else if (k === 'text-smaller') {
					state.scale = Math.max(90, state.scale - 10);
				}
				saveState();
				applyState();
			});
		});

		if (resetBtn) {
			resetBtn.addEventListener('click', function () {
				state = { toggles: {}, scale: 100, guide: false };
				document.removeEventListener('mousemove', onGuideMove);
				saveState();
				applyState();
			});
		}

		if (state.guide) { document.addEventListener('mousemove', onGuideMove); }
	}

	/* ------------------------------------------------------------------ */
	function init() {
		document.querySelectorAll('.md-lead-form').forEach(handleForm);
		loadState();
		applyState();
		setupA11y();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();

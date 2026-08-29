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
	// מקבל טלפון ישראלי במגוון פורמטים: מקומי (05X...), בינלאומי (+972 / 972),
	// עם/בלי מקפים, רווחים או סוגריים.
	function validPhone(raw) {
		var d = (raw || '').replace(/\D/g, '');
		return /^0\d{7,9}$/.test(d) || /^972\d{8,9}$/.test(d);
	}

	// בדיקת אימייל בסיסית (האימות המחייב נעשה בצד השרת).
	function validEmail(raw) {
		return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test((raw || '').trim());
	}

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

	/* ---- מקור הגעה (UTM / referrer / קמפיין) — אופציונלי, לעולם לא חוסם שליחה ---- */
	function captureSource() {
		var KEY = 'md-src';
		var stored = {};
		try { stored = JSON.parse(sessionStorage.getItem(KEY) || '{}'); } catch (e) {}
		if (!stored || !stored.captured) {
			try {
				var qs = new URLSearchParams(window.location.search);
				stored = {
					captured: 1,
					landing: window.location.href,
					referrer: document.referrer || '',
					utm_source: qs.get('utm_source') || '',
					utm_medium: qs.get('utm_medium') || '',
					utm_campaign: qs.get('utm_campaign') || '',
					utm_term: qs.get('utm_term') || '',
					utm_content: qs.get('utm_content') || '',
					cId: qs.get('UcId') || '',
					sId: qs.get('UsId') || '',
					aId: qs.get('UaId') || '',
					type: qs.get('Utype') || ''
				};
				sessionStorage.setItem(KEY, JSON.stringify(stored));
			} catch (e) { stored = {}; }
		}
		return stored || {};
	}
	// לכידה מיידית (first-touch) לפני ניווט פנימי. עטוף — כשל לא משפיע על דבר.
	var mdSource = {};
	try { mdSource = captureSource(); } catch (e) { mdSource = {}; }

	function getSource() {
		var s = mdSource || {};
		return {
			page: window.location.href,
			landing: s.landing || '',
			referrer: s.referrer || '',
			utm_source: s.utm_source || '',
			utm_medium: s.utm_medium || '',
			utm_campaign: s.utm_campaign || '',
			utm_term: s.utm_term || '',
			utm_content: s.utm_content || '',
			cId: s.cId || '',
			sId: s.sId || '',
			aId: s.aId || '',
			type: s.type || ''
		};
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
			var email = (form.elements.email && form.elements.email.value || '').trim();
			var note = (form.elements.note && form.elements.note.value || '').trim();
			var hp = (form.elements.website && form.elements.website.value || '').trim();
			var consentEl = form.querySelector('.md-consent');
			var consent = consentEl ? consentEl.checked : true;
			var captchaEl = form.querySelector('[name="cf-turnstile-response"]');
			var captcha = captchaEl ? captchaEl.value : '';

			// שדה משולב "טלפון / אימייל": אם הוזן אימייל — הוא עובר לשדה הנכון.
			var dual = form.querySelector('[data-md-dual]');
			if (dual && dual.value.indexOf('@') > -1) {
				email = dual.value.trim();
				phone = '';
			}

			// שדות בחירה נלווים (תחום השקעה, מועד מועדף) מצורפים לגוף הפנייה.
			var extras = form.querySelectorAll('[data-md-note]');
			var parts = [];
			for (var x = 0; x < extras.length; x++) {
				var val = (extras[x].value || '').trim();
				if (val !== '') { parts.push(extras[x].getAttribute('data-md-note') + ': ' + val); }
			}
			if (parts.length) { note = note ? note + ' · ' + parts.join(' · ') : parts.join(' · '); }

			var hasPhone = phone !== '' && validPhone(phone);
			var hasEmail = email !== '' && validEmail(email);
			var acceptsEmail = !!(form.elements.email || dual);

			if (hp !== '') { return; } // honeypot
			if (name.length < 2) { setStatus(statusEl, i18n.invalidName || 'נא להזין שם מלא', false); return; }
			if (!hasPhone && !hasEmail) {
				setStatus(
					statusEl,
					acceptsEmail
						? (i18n.invalidContact || 'נא להזין טלפון או אימייל תקינים')
						: (i18n.invalidPhone || 'מספר טלפון לא תקין'),
					false
				);
				return;
			}
			if (!consent) { setStatus(statusEl, i18n.invalidConsent || 'יש לאשר את מדיניות הפרטיות', false); return; }
			if (data.turnstile && !captcha) { setStatus(statusEl, i18n.invalidCaptcha || 'נא להשלים את אימות ה-CAPTCHA', false); return; }

			if (button) { button.disabled = true; }
			if (label) { label.textContent = i18n.sending || 'שולח...'; }
			setStatus(statusEl, '', true);

			// שולפים nonce טרי בזמן ריצה כדי לא להישען על ה-nonce המוטמע ב-HTML,
			// שעלול להיות במטמון full-page (LiteSpeed/Cloudflare/WP Rocket) ולפוג.
			var srcData = {};
			try { srcData = getSource(); } catch (e) { srcData = {}; }

			getFreshNonce()
				.then(function (nonce) {
					return fetch(data.restUrl, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify({ name: name, phone: phone, email: email, note: note, website: hp, consent: consent ? 1 : 0, captcha: captcha, md_nonce: nonce, source: srcData })
					});
				})
				.then(function (res) {
					return res.json().then(function (body) { return { ok: res.ok, body: body }; });
				})
				.then(function (result) {
					if (result.ok) {
						setStatus(statusEl, '', true);
						// אירוע ליד מוצלח — לשימוש אופציונלי של סקריפט מעקב קמפיין (אם נטען).
						try {
							document.dispatchEvent(new CustomEvent('metadoc:lead', { detail: { name: name, phone: phone, email: email, note: note } }));
						} catch (e) {}
						form.reset();
						if ('inline' === form.getAttribute('data-md-success')) {
							// אישור במקום — בלי מודאל, לפי עיצוב עמודי הנדל"ן.
							var done = form.getAttribute('data-md-success-label') || i18n.success || '';
							labelText = done;
							if (label) { label.textContent = done; }
							form.setAttribute('data-md-sent', '1');
							setStatus(statusEl, i18n.success || '', true);
						} else {
							openSuccessModal();
						}
					} else {
						var msg = (result.body && result.body.message) ? result.body.message : (i18n.error || 'אירעה שגיאה.');
						setStatus(statusEl, msg, false);
					}
				})
				.catch(function () {
					setStatus(statusEl, i18n.error || 'אירעה שגיאה.', false);
				})
				.finally(function () {
					if (button) { button.disabled = '1' === form.getAttribute('data-md-sent'); }
					if (label) { label.textContent = labelText; }
					if (window.turnstile && typeof window.turnstile.reset === 'function') {
						try { window.turnstile.reset(); } catch (e) {}
					}
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
		// פילטרים חזותיים מוחלים על #top (התוכן) ולא על html — כדי לא לשבור
		// position: fixed של הכפתורים הצפים (filter על אב הופך fixed ל-absolute).
		var fx = document.getElementById('top') || html;
		Object.keys(TOGGLE_CLASSES).forEach(function (key) {
			fx.classList.toggle(TOGGLE_CLASSES[key], !!state.toggles[key]);
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
	/* פופאפ עוגיות                                                        */
	/* ------------------------------------------------------------------ */
	var COOKIE_KEY = 'md-cookie-consent';

	function setupCookie() {
		var banner = document.getElementById('md-cookie');
		if (!banner) { return; }
		var choice;
		try { choice = localStorage.getItem(COOKIE_KEY); } catch (e) {}
		if (choice) { return; } // כבר הוחלט — לא מציגים.

		banner.hidden = false;
		function decide(value) {
			try { localStorage.setItem(COOKIE_KEY, value); } catch (e) {}
			banner.hidden = true;
		}
		var accept = document.getElementById('md-cookie-accept');
		var decline = document.getElementById('md-cookie-decline');
		if (accept) { accept.addEventListener('click', function () { decide('accepted'); }); }
		if (decline) { decline.addEventListener('click', function () { decide('declined'); }); }
	}

	/* ------------------------------------------------------------------ */
	/* מודאל אישור שליחה                                                   */
	/* ------------------------------------------------------------------ */
	var successReturnFocus = null;

	function openSuccessModal() {
		var modal = document.getElementById('md-success');
		if (!modal) { return; }
		successReturnFocus = document.activeElement;
		modal.hidden = false;
		var btn = modal.querySelector('[data-md-close]');
		if (btn && btn.focus) { btn.focus(); }
	}

	function closeSuccessModal() {
		var modal = document.getElementById('md-success');
		if (!modal || modal.hidden) { return; }
		modal.hidden = true;
		if (successReturnFocus && successReturnFocus.focus) {
			try { successReturnFocus.focus(); } catch (e) {}
		}
	}

	function setupSuccessModal() {
		var modal = document.getElementById('md-success');
		if (!modal) { return; }
		modal.querySelectorAll('[data-md-close]').forEach(function (el) {
			el.addEventListener('click', closeSuccessModal);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') { closeSuccessModal(); }
		});
	}

	/* ------------------------------------------------------------------ */
	/* תפריט מובייל                                                        */
	/* ------------------------------------------------------------------ */
	function setupMobileNav() {
		var toggle = document.getElementById('md-nav-toggle');
		var panel = document.getElementById('md-mobile-nav');
		if (!toggle || !panel) { return; }
		toggle.addEventListener('click', function () {
			var open = panel.hidden;
			panel.hidden = !open;
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		// סגירה בלחיצה על קישור.
		panel.addEventListener('click', function (e) {
			if (e.target.closest('a')) {
				panel.hidden = true;
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/* ------------------------------------------------------------------ */
	function init() {
		document.querySelectorAll('.md-lead-form').forEach(handleForm);
		loadState();
		applyState();
		setupA11y();
		setupCookie();
		setupSuccessModal();
		setupMobileNav();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();

/**
 * מטאדוק — אינטראקציות עמודי מחלקת הנדל"ן ועמוד הפרויקט.
 * JS וניל, ללא תלויות. נטען מותנה בשתי התבניות בלבד.
 *
 * כולל: חשיפה בגלילה (עמידה בכשל), קרוסלת הזדמנויות, זוהר עוקב-סמן,
 * אקורדיון שאלות נפוצות, רצועת מועדון, פרלקסת Hero, טאבים ותרשים, סרגל לידים.
 */
(function () {
	'use strict';

	var html = document.documentElement;
	var reduce = false;
	try {
		reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	} catch (e) { reduce = false; }

	function stopped() {
		return reduce || html.classList.contains('md-a11y-stop-anim');
	}

	/* ------------------------------------------------------------------ */
	/* חשיפה בגלילה                                                        */
	/* ------------------------------------------------------------------ */
	var framed = false;
	var revealed = false;

	// משטח את אנימציית התרשים כשאין ציור פריימים (טאב רקע, הדפסה, reduced motion).
	function flattenChart(root) {
		if (!root || !root.querySelectorAll) { return; }
		var sel = ['[data-ch-line]', '[data-ch-area]', '[data-ch-dot]'];
		for (var s = 0; s < sel.length; s++) {
			var nodes = root.querySelectorAll(sel[s]);
			for (var i = 0; i < nodes.length; i++) {
				nodes[i].style.transition = 'none';
				nodes[i].style.opacity = '1';
				nodes[i].style.transform = 'none';
				nodes[i].style.strokeDashoffset = '0';
			}
		}
	}

	function markIn(el, instant, index) {
		if (instant) {
			el.style.transition = 'none';
			el.style.opacity = '1';
			el.style.transform = 'none';
			flattenChart(el);
		} else {
			el.style.transitionDelay = (Math.min(index, 4) * 80) + 'ms';
		}
		if (el.hasAttribute('data-rv')) {
			el.classList.add('rv-in');
		} else {
			el.setAttribute('data-reveal', 'in');
		}
		revealed = true;
	}

	function revealAll() {
		var all = document.querySelectorAll('[data-reveal], [data-rv]');
		for (var i = 0; i < all.length; i++) { markIn(all[i], true, i); }
		flattenChart(document);
	}

	function pending() {
		return !!document.querySelector('[data-reveal]:not([data-reveal="in"]), [data-rv]:not(.rv-in)');
	}

	function revealTick() {
		var els = document.querySelectorAll('[data-reveal]:not([data-reveal="in"]), [data-rv]:not(.rv-in)');
		if (!els.length) { return; }
		var limit = window.innerHeight * 0.9;
		for (var i = 0; i < els.length; i++) {
			var el = els[i];
			if (stopped() || el.getBoundingClientRect().top < limit) {
				markIn(el, stopped() || !framed, i);
			}
		}
	}

	/* ------------------------------------------------------------------ */
	/* פרלקסת ה-Hero בעמוד הפרויקט                                         */
	/* ------------------------------------------------------------------ */
	var heroPx = null;
	var bandImg = null;
	var band = null;

	function parallaxTick() {
		if (stopped()) { return; }
		if (heroPx) {
			var y = window.scrollY || window.pageYOffset || 0;
			heroPx.style.transform = 'translateY(' + Math.min(y * 0.12, 70).toFixed(1) + 'px)';
		}
		// רצועת ה-CTA: התמונה נשארת "תלויה" במסך בזמן שהרצועה נגללת מעליה.
		if (band && bandImg) {
			var top = band.getBoundingClientRect().top;
			if (top < window.innerHeight && top > -band.offsetHeight - window.innerHeight) {
				bandImg.style.transform = 'translateY(' + (-top).toFixed(1) + 'px)';
			}
		}
	}

	function tick() {
		parallaxTick();
		revealTick();
	}

	// תזמון עדין: פעולה אחת לכל פריים, לא לכל אירוע גלילה.
	var rafPending = false;
	var poll = 0;

	function schedule() {
		if (rafPending) { return; }
		rafPending = true;
		window.requestAnimationFrame(function () {
			rafPending = false;
			framed = true;
			tick();
		});
	}

	// מפעיל מחדש את הטיימר כשנוצר תוכן חדש לחשיפה (מעבר בין טאבים).
	function rearm() {
		if (poll || !pending()) { return; }
		poll = setInterval(function () {
			tick();
			if (!pending()) {
				clearInterval(poll);
				poll = 0;
			}
		}, 200);
	}

	/* ------------------------------------------------------------------ */
	/* זוהר עוקב-סמן                                                       */
	/* ------------------------------------------------------------------ */
	function bindGlow(host, glow, always) {
		if (!host || !glow) { return; }
		host.addEventListener('pointermove', function (e) {
			var r = host.getBoundingClientRect();
			glow.style.setProperty('--mx', (e.clientX - r.left) + 'px');
			glow.style.setProperty('--my', (e.clientY - r.top) + 'px');
			glow.style.setProperty('--hx', (e.clientX - r.left) + 'px');
			glow.style.setProperty('--hy', (e.clientY - r.top) + 'px');
			if (!always) { glow.style.opacity = '1'; }
		}, { passive: true });
		if (!always) {
			host.addEventListener('pointerleave', function () { glow.style.opacity = '0'; });
		}
	}

	/* ------------------------------------------------------------------ */
	/* קרוסלת ההזדמנויות (Hero עמוד המחלקה)                                 */
	/* ------------------------------------------------------------------ */
	function setupDeals() {
		var wrap = document.querySelector('[data-md-deals]');
		if (!wrap) { return; }
		var cards = wrap.querySelectorAll('[data-md-deal]');
		if (cards.length < 2) { return; }
		var index = 0;
		var paused = false;

		wrap.addEventListener('pointerenter', function () { paused = true; });
		wrap.addEventListener('pointerleave', function () { paused = false; });
		wrap.addEventListener('focusin', function () { paused = true; });
		wrap.addEventListener('focusout', function () { paused = false; });

		setInterval(function () {
			if (paused || stopped() || document.hidden) { return; }
			index = (index + 1) % cards.length;
			for (var i = 0; i < cards.length; i++) {
				var on = i === index;
				cards[i].classList.toggle('is-on', on);
				if (on) {
					cards[i].removeAttribute('aria-hidden');
				} else {
					cards[i].setAttribute('aria-hidden', 'true');
				}
			}
		}, 3400);
	}

	/* ------------------------------------------------------------------ */
	/* אקורדיון שאלות נפוצות (פתיחה יחידה)                                  */
	/* ------------------------------------------------------------------ */
	function setupFaq() {
		var list = document.querySelector('[data-md-faq]');
		if (!list) { return; }
		var buttons = list.querySelectorAll('.md-re-faq-q');

		function setOpen(btn, open) {
			var panel = document.getElementById(btn.getAttribute('aria-controls'));
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			var mark = btn.querySelector('.md-re-faq-mark');
			if (mark) { mark.textContent = open ? '−' : '+'; }
			if (panel) { panel.hidden = !open; }
		}

		for (var i = 0; i < buttons.length; i++) {
			buttons[i].addEventListener('click', function () {
				var isOpen = 'true' === this.getAttribute('aria-expanded');
				for (var j = 0; j < buttons.length; j++) { setOpen(buttons[j], false); }
				if (!isOpen) { setOpen(this, true); }
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/* רצועת המועדון הקבועה                                                */
	/* ------------------------------------------------------------------ */
	var STRIP_KEY = 'md-re-strip-off';

	function setupStrip() {
		var strip = document.querySelector('[data-md-strip]');
		var page = document.querySelector('[data-md-dept]');
		if (!strip) { return; }

		function hide() {
			strip.hidden = true;
			if (page) { page.classList.remove('is-strip'); }
		}

		try {
			if ('1' === localStorage.getItem(STRIP_KEY)) { hide(); }
		} catch (e) {}

		var close = strip.querySelector('[data-md-strip-close]');
		if (close) {
			close.addEventListener('click', function () {
				hide();
				try { localStorage.setItem(STRIP_KEY, '1'); } catch (e) {}
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/* טאבים — תרחישי רווח                                                 */
	/* ------------------------------------------------------------------ */
	function setupTabs() {
		var list = document.querySelector('[data-md-tabs]');
		if (!list) { return; }
		var tabs = list.querySelectorAll('[role="tab"]');

		function activate(tab, focus) {
			for (var i = 0; i < tabs.length; i++) {
				var on = tabs[i] === tab;
				tabs[i].setAttribute('aria-selected', on ? 'true' : 'false');
				tabs[i].setAttribute('tabindex', on ? '0' : '-1');
				var panel = document.getElementById(tabs[i].getAttribute('aria-controls'));
				if (!panel) { continue; }
				panel.hidden = !on;
				if (on && !stopped() && framed) {
					// ציור מחדש של עקומת הצמיחה בכל מעבר טאב.
					var chart = panel.querySelector('[data-chart]');
					if (chart) { chart.classList.remove('rv-in'); }
				}
			}
			if (focus) { tab.focus(); }
			schedule();
			rearm();
		}

		for (var i = 0; i < tabs.length; i++) {
			tabs[i].addEventListener('click', function () { activate(this, false); });
			tabs[i].addEventListener('keydown', function (e) {
				var current = Array.prototype.indexOf.call(tabs, this);
				var next = -1;
				// RTL: חץ שמאל מתקדם, חץ ימין חוזר.
				if ('ArrowLeft' === e.key || 'ArrowDown' === e.key) { next = current + 1; }
				if ('ArrowRight' === e.key || 'ArrowUp' === e.key) { next = current - 1; }
				if ('Home' === e.key) { next = 0; }
				if ('End' === e.key) { next = tabs.length - 1; }
				if (next < 0 || next >= tabs.length) {
					if ('Home' !== e.key && 'End' !== e.key) { return; }
					next = next < 0 ? tabs.length - 1 : 0;
				}
				e.preventDefault();
				activate(tabs[next], true);
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/* סרגל הלידים הקבוע בעמוד הפרויקט                                      */
	/* ------------------------------------------------------------------ */
	function setupFab() {
		var fab = document.querySelector('[data-md-fab]');
		if (!fab) { return; }
		var form = fab.querySelector('[data-md-fab-form]');
		var mini = fab.querySelector('[data-md-fab-mini]');
		var foot = document.querySelector('[data-md-foot]');
		var toggles = fab.querySelectorAll('[data-md-fab-toggle]');

		function setOpen(open) {
			if (form) { form.hidden = !open; }
			if (mini) { mini.hidden = open; }
			if (foot) { foot.classList.toggle('is-open', open); }
			if (open && form) {
				var first = form.querySelector('input:not([type="hidden"]):not([tabindex="-1"])');
				if (first && first.offsetParent) { first.focus(); }
			}
		}

		for (var i = 0; i < toggles.length; i++) {
			toggles[i].addEventListener('click', function () {
				setOpen(!!(form && form.hidden));
			});
		}
	}

	/* ------------------------------------------------------------------ */
	/* אתחול                                                               */
	/* ------------------------------------------------------------------ */
	function init() {
		heroPx = document.querySelector('[data-md-hero-px]');
		band = document.querySelector('[data-md-band]');
		bandImg = band && band.querySelector('.md-re-band-img');

		bindGlow(document.querySelector('[data-md-ring]'), document.querySelector('[data-md-glow]'), true);
		bindGlow(document.querySelector('[data-md-hero-shell]'), document.querySelector('[data-md-hero-glow]'), false);

		setupDeals();
		setupFaq();
		setupStrip();
		setupTabs();
		setupFab();

		// שער האנימציה — בלי JS שום דבר אינו מוסתר.
		html.setAttribute('data-md-anim', '1');

		// מעבר ראשון סינכרוני: מה שכבר בתוך המסך נחשף מיד, ללא מעבר.
		tick();

		// אם הדפדפן מצייר פריימים — מכאן והלאה החשיפה מונפשת.
		window.requestAnimationFrame(function () { framed = true; });

		window.addEventListener('scroll', schedule, { passive: true });
		window.addEventListener('resize', schedule);
		window.addEventListener('load', schedule);

		// גיבוי לטיימר: מכסה מצבים שבהם אין אירועי גלילה או ציור פריימים.
		// נעצר מעצמו ברגע שאין עוד מה לחשוף.
		poll = setInterval(function () {
			tick();
			if (!pending()) {
				clearInterval(poll);
				poll = 0;
			}
		}, 200);

		// רשת ביטחון: אם דבר לא נחשף תוך שנייה — מציגים הכול מיד.
		setTimeout(function () {
			if (!revealed) { revealAll(); }
		}, 1000);
	}

	if ('loading' === document.readyState) {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();

/**
 * Metadoc — מעקב קמפיין (חדרי חרדים).
 * שולח ליד שנשלח בהצלחה ל-CRM החיצוני (fire-and-forget, ללא חסימה).
 *
 * שני מקורות נתמכים:
 *   1) טופס התבנית Metadoc — מאזין לאירוע 'metadoc:lead' (נשלח רק בהצלחה).
 *   2) טפסי Elementor — מאזין ל-submit של .elementor-form.
 *
 * פרמטרי הקמפיין (cId/sId/aId/type/utm_*) נקראים מה-Query של כתובת הנחיתה.
 */
(function () {
	'use strict';

	var cfg = window.mdctCampaign || {};
	if (!cfg.endpoint) { return; }

	var qs = new URLSearchParams(window.location.search);

	function send(detail) {
		try {
			var p = new URLSearchParams();
			p.append('fName', detail.name || '');
			p.append('email', detail.email || '');
			p.append('phone', detail.phone || '');
			p.append('cId', qs.get('UcId') || '');
			p.append('sId', qs.get('UsId') || '');
			p.append('aId', qs.get('UaId') || '');
			p.append('type', qs.get('Utype') || 'inread');
			p.append('utm_source', qs.get('utm_source') || '');
			p.append('utm_medium', qs.get('utm_medium') || '');
			p.append('utm_campaign', qs.get('utm_campaign') || '');
			p.append('skipAPI', '1');

			fetch(cfg.endpoint + '?' + p.toString(), {
				method: 'GET',
				mode: 'no-cors',
				keepalive: true
			}).catch(function () {});
		} catch (e) {}
	}

	// 1) טופס התבנית Metadoc — אירוע ליד מוצלח.
	document.addEventListener('metadoc:lead', function (e) {
		send((e && e.detail) || {});
	});

	// 2) טפסי Elementor (אם קיימים באתר).
	function fieldVal(form, name) {
		var f = form.querySelector('[name="' + name + '"]');
		return f ? f.value : '';
	}

	document.addEventListener('DOMContentLoaded', function () {
		var forms = document.querySelectorAll('.elementor-form');
		Array.prototype.forEach.call(forms, function (form) {
			form.addEventListener('submit', function () {
				send({
					name: fieldVal(form, 'form_fields[fName]'),
					email: fieldVal(form, 'form_fields[email]'),
					phone: fieldVal(form, 'form_fields[phone]')
				});
			});
		});
	});
})();

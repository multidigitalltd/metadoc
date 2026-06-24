/**
 * מעקב קמפיין (זמני) — שליחת ליד מוצלח ל-CRM חיצוני של מערכת הפרסום.
 * נטען רק כשההגדרה "מעקב קמפיין" מופעלת ב"מטאדוק — הגדרות".
 * אינו חוסם ואינו משפיע על שליחת הליד הרגילה (fire-and-forget).
 *
 * מקור הנתונים: אירוע 'metadoc:lead' שנורה אחרי שליחה מוצלחת ב-main.js.
 * פרמטרי הקמפיין (cId/sId/aId/type/utm) נקראים מה-Query של כתובת הנחיתה.
 */
(function () {
	'use strict';

	var cfg = window.metadocCampaign || {};
	if (!cfg.endpoint) { return; }

	// נשמרים בטעינת העמוד (לפני ניווט/איפוס טופס).
	var qs = new URLSearchParams(window.location.search);

	function send(detail) {
		try {
			var params = new URLSearchParams();
			params.append('fName', detail.name || '');
			params.append('email', detail.email || ''); // הטופס אינו אוסף מייל — נשלח ריק.
			params.append('phone', detail.phone || '');
			params.append('cId', qs.get('UcId') || '');
			params.append('sId', qs.get('UsId') || '');
			params.append('aId', qs.get('UaId') || '');
			params.append('type', qs.get('Utype') || 'inread');
			params.append('utm_source', qs.get('utm_source') || '');
			params.append('utm_medium', qs.get('utm_medium') || '');
			params.append('utm_campaign', qs.get('utm_campaign') || '');
			params.append('skipAPI', '1');

			var url = cfg.endpoint + '?' + params.toString();
			// fire-and-forget; no-cors כי זו מערכת חיצונית.
			fetch(url, { method: 'GET', mode: 'no-cors', keepalive: true }).catch(function () {});
		} catch (e) {}
	}

	document.addEventListener('metadoc:lead', function (e) {
		send((e && e.detail) || {});
	});
})();

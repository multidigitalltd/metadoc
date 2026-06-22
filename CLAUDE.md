# Metadoc — תבנית וורדפרס (Multi Digital)

עמוד נחיתה יחיד בעברית (RTL) ל"מטאדוק" — משכנתאות והלוואות למסורבי בנקים.
התבנית פותחה מתוך עיצוב Lovable (React + Tailwind v4) והומרה לתבנית וורדפרס
קסטום, תוך הצמדות 1:1 לעיצוב (פונטים, משקלים, צבעים, מרווחים).

מקור העיצוב המקורי שמור תחת `design-reference/` (לעיון בלבד, לא נטען לאתר).

## ארכיטקטורה

- **תבנית קלאסית קסטום** (`front-page.php` + `template-parts/`).
- **Tailwind v4 מקומפל** לקובץ CSS מוקטן יחיד `assets/css/app.min.css`.
  אין Tailwind בזמן ריצה ואין CDN. בנייה דרך `tooling/` (ראה למטה).
- **JavaScript וניל בלבד** (`assets/js/main.js`). אין jQuery, אין ספריות צד ג'.
- **אייקונים** — inline SVG (`inc/icons.php`), אין ספריית אייקונים.
- **טופס לידים** — REST endpoint עם Nonce + Sanitization + Honeypot,
  שמירה ל-CPT `md_lead` ושליחת מייל למשרד.

## מבנה קבצים

```
style.css            כותרת התבנית + הערה (הסגנון האמיתי ב-assets/css)
functions.php        טעינות מותנות, theme support, אבטחה, ביצועים
front-page.php       הרכבת עמוד הנחיתה מ-template-parts
header.php/footer.php עטיפת ה-<html>, skip link, ווידג'טים צפים
template-parts/      סקשן לכל בלוק עיצוב
inc/                 לוגיקה: לידים (REST+CPT), אייקונים, helpers
assets/css/app.min.css  Tailwind מקומפל (commit-ed, לא דורש build בפרודקשן)
assets/js/main.js    reveal-on-scroll, טופס, ווידג'ט נגישות
assets/fonts/        קבצי .woff (Barlev / Atlas / Anomalia)
assets/img/          תמונות התוכן + לוגו
tooling/             מקור ה-Tailwind + סקריפט build
```

## בנייה מחדש של ה-CSS

לאחר שינוי מחלקות Tailwind ב-PHP:
```
cd tooling && npm install && npm run build
```
זה סורק את כל קבצי ה-`.php` ומפיק `assets/css/app.min.css` מוקטן.

## תקן הפיתוח — Multi Digital (חובה)

### ביצועים
- הפתרון הקל והרזה ביותר. בלי ספריות צד ג' כשאפשר ליבת WP / JS וניל.
- טעינה מותנית לפי עמוד. אין טעינה גלובלית מיותרת. מינימום בקשות HTTP.
- CSS/JS מוקטנים, ללא כפילויות. `defer`/`async` ל-JS. בלי render-blocking.
- `loading="lazy"` לתמונות ול-iframes. תמונות WebP/AVIF כשניתן, עם `srcset`.
- בלי קריאות API בכל טעינה. Transient/Object cache למידע שאינו real-time.
- שאילתות SQL מינימליות, `$wpdb->prepare()` תמיד, בלי `SELECT *`, בלי N+1.
- יעד: Mobile PSI > 90, Desktop > 95, LCP < 2.5s, CLS < 0.1, INP תקין.
- תאימות LiteSpeed Cache / Redis / Memcached / Cloudflare / WP Rocket.

### אבטחה
- כל קלט → Sanitization (`sanitize_text_field`, `sanitize_email`, `absint`...).
- כל פלט → Escaping (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`).
- Nonce בכל פעולה משנת-נתונים וכל AJAX/REST. `permission_callback` לכל endpoint.
- בדיקת הרשאות בצד שרת (`current_user_can`). לא לסמוך על הדפדפן.
- בלי `eval/exec/shell_exec/system/base64` להסתרת קוד. בלי חשיפת שגיאות למשתמש.
- Honeypot + rate limiting לטפסים ציבוריים. `wp_safe_redirect` בלבד.

### איכות קוד
- WordPress Coding Standards, PHP 8.3+, בלי deprecated/Warning/Notice/Fatal.
- DRY, פונקציות קצרות, שמות ברורים, הפרדת לוגיקה/תצוגה, תיעוד לרכיב משמעותי.
- בלי קוד מת, בלי `var_dump`/`print_r`/`console.log` בפרודקשן.

### נגישות (ת"י 5568 + WCAG 2.2 AA)
- HTML5 סמנטי, RTL/LTR, ניגודיות 4.5:1 (טקסט רגיל) / 3:1 (גדול).
- ניווט מקלדת מלא, focus נראה, skip-to-content, בלי keyboard traps.
- `alt` משמעותי לכל תמונה; דקורטיבי → `aria-hidden`/`alt=""`.
- `<label>` לכל שדה (placeholder אינו תחליף), שגיאות מקושרות תכנותית.
- מודאלים: trap focus, ESC, החזרת פוקוס. `prefers-reduced-motion` מכובד.
- טקסט מתכוונן עד 200%. ווידג'ט נגישות (גודל טקסט, ניגודיות, עצירת אנימציות,
  הדגשת קישורים, מדריך קריאה) עם שמירה ב-localStorage. עמוד הצהרת נגישות.

### SEO
- HTML סמנטי, H1 יחיד, היררכיית כותרות, Open Graph, Schema, URL ידידותי,
  תאימות לתוספי SEO, מניעת תוכן כפול.

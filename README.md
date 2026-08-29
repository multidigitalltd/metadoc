# Metadoc — תבנית וורדפרס

עמוד נחיתה בעברית (RTL) ל"מטאדוק" — משכנתאות והלוואות למסורבי בנקים,
בתוספת שני עמודי **מחלקת הנדל"ן וההשקעות** (עמוד מחלקה + עמוד פרויקט).
הומר מעיצוב Lovable (React + Tailwind) לתבנית וורדפרס קסטום, צמוד 1:1 לעיצוב,
ופותח לפי **תקן Multi Digital** (ביצועים, אבטחה, נגישות ת"י 5568 / WCAG 2.2 AA).

## התקנה

1. העתיקו את התיקייה הזו ל-`wp-content/themes/metadoc`.
2. הפעילו את התבנית בלוח הניהול (Appearance → Themes). בהפעלה נוצר אוטומטית
   עמוד "הצהרת נגישות".
3. הפונטים (Atlas / Anomalia) כבר מצורפים ב-`assets/fonts/` בפורמט woff2 + woff.
4. **העלו את הלוגו** ל-`assets/img/metadoc-logo.svg` (מועדף) או `metadoc-logo.png`.
5. עמוד הבית מציג אוטומטית את עמוד הנחיתה (`front-page.php`).
6. בהפעלה נוצרים גם שני עמודי הנדל"ן: `/real-estate/` ו-`/shaar-hamifratz/`.

## מחלקת הנדל"ן — שני עמודים

| עמוד | תבנית | Slug |
|------|--------|------|
| מחלקת נדל"ן והשקעות (כולל מועדון המשקיעים) | `template-realestate.php` | `real-estate` |
| פרויקט "שער המפרץ · תמ"א 75" | `template-project.php` | `shaar-hamifratz` |

שני העמודים עצמאיים: כותרת, פוטר וסרגל תחתון משלהם (`header-realestate.php` /
`footer-realestate.php`), ו-CSS/JS ייעודיים שנטענים **רק** בהם:

- `assets/css/realestate.min.css` (~9KB בדחיסת gzip) — מקור: `tooling/realestate.css`
- `assets/js/realestate.js` — חשיפה בגלילה, קרוסלה, אקורדיון, טאבים, פרלקסה, סרגלים

### תמונות
כל חריצי התמונה ניתנים להחלפה ב**התאמה אישית → מחלקת נדל"ן — תמונות**
(העלאה למדיה, לא קבצים בתבנית). חריץ ריק מציג מסגרת מציין-מקום ואינו שובר
פריסה. תמונות הפרויקט (הדמיה, מפת גבהים, Hero) כבר מצורפות בתבנית.

**עדיין חסרות מהלקוח:** צילום פנורמי לעמוד המחלקה (16:5.5), תמונת צוות/משרד
(4:3), תמונת ליווי (4:5), תמונה רחבה לרצועת ה-CTA, שלוש תמונות פרויקטים.

### תוכן ממלא-מקום
כרטיסי הפרויקטים וההמלצות בעמוד המחלקה הם תוכן לדוגמה עד לקבלת נתונים
אמיתיים. אפשר להזרים נתונים דרך הפילטרים `metadoc_re_projects`,
`metadoc_re_testimonials` ו-`metadoc_re_hero_deals`.

### התאמת עיצוב לתקן הנגישות
כתום המותג `#fb7a00` נותן 2.66:1 על רקע לבן ואינו עומד ב-AA כטקסט.
לכן הוגדרו ב-`tooling/realestate.css` שני טוקנים לטקסט כתום **על רקע בהיר
בלבד**: `--acc-txt` (טקסט קטן, 5.1:1) ו-`--acc-txt-lg` (כותרות גדולות, 3.7:1).
על רקע כהה נשמר `#fb7a00` המקורי. לשחזור צבע העיצוב המקורי במדויק — הציבו
`var(--acc)` בשני הטוקנים והריצו `npm run build:re`.

## פיתוח

```bash
cd tooling
npm install
npm run build     # מקמפל Tailwind ל-assets/css/app.min.css
npm run build:re  # מקמפל את realestate.css ל-assets/css/realestate.min.css
npm run build:all # שניהם
npm run watch     # קימפול אוטומטי בזמן עבודה
npm run images    # המרת תמונות ב-assets/img (כולל תיקיות משנה) ל-WebP
npm run fonts     # המרת קבצי .woff ב-assets/fonts ל-.woff2
```

הסגנון המקומפל (`assets/css/app.min.css`) מאוחסן ב-Git כך שהפרודקשן אינו דורש
שלב build. הריצו `build` מחדש רק אחרי שינוי מחלקות Tailwind בקבצי ה-`.php`.

## מבנה

ראו `CLAUDE.md` לתיעוד מלא של הארכיטקטורה ותקן הפיתוח.

| נתיב | תיאור |
|------|-------|
| `front-page.php` | הרכבת עמוד הנחיתה |
| `template-parts/` | סקשן לכל בלוק עיצוב |
| `inc/` | לידים (REST+CPT), אייקונים SVG, helpers, התקנה |
| `assets/css/app.min.css` | Tailwind מקומפל |
| `assets/js/main.js` | טופס לידים + ווידג'ט נגישות (וניל) |
| `template-realestate.php` · `template-project.php` | שני עמודי מחלקת הנדל"ן |
| `template-parts/realestate/` | הסקשנים של שני העמודים |
| `assets/css/realestate.min.css` · `assets/js/realestate.js` | נכסי הנדל"ן (טעינה מותנית) |
| `tooling/` | מקור Tailwind + סקריפטים |
| `design-reference/` | מקור Lovable המקורי (לעיון) |

## טופס לידים

הפניות נשמרות כסוג תוכן `md_lead` (תפריט "לידים" בניהול) ונשלחת התראת מייל
ל-`office@metadoc.co.il`. ניתן לשנות יעד מייל דרך הפילטר `metadoc_lead_email`.
האבטחה כוללת Nonce, סניטציה, Honeypot ו-Rate limiting.

ארבעת הטפסים של עמודי הנדל"ן (הצטרפות למועדון, יצירת קשר, קביעת פגישה
וסרגל הלידים) משתמשים באותו endpoint. ה-endpoint מקבל כעת גם `email`,
ודורש **טלפון או אימייל תקינים** (לפחות אחד) — כך שהשדה המשולב
"טלפון / אימייל" עובד. הצלחה מוצגת במקום (החלפת תווית הכפתור) ולא במודאל.

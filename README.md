# Metadoc — תבנית וורדפרס

עמוד נחיתה יחיד בעברית (RTL) ל"מטאדוק" — משכנתאות והלוואות למסורבי בנקים.
הומר מעיצוב Lovable (React + Tailwind) לתבנית וורדפרס קסטום, צמוד 1:1 לעיצוב,
ופותח לפי **תקן Multi Digital** (ביצועים, אבטחה, נגישות ת"י 5568 / WCAG 2.2 AA).

## התקנה

1. העתיקו את התיקייה הזו ל-`wp-content/themes/metadoc`.
2. הפעילו את התבנית בלוח הניהול (Appearance → Themes). בהפעלה נוצר אוטומטית
   עמוד "הצהרת נגישות".
3. **העלו את קבצי הפונטים** ל-`assets/fonts/` — ראו `assets/fonts/README.md`.
4. **העלו את הלוגו** ל-`assets/img/metadoc-logo.svg` (מועדף) או `metadoc-logo.png`.
5. עמוד הבית מציג אוטומטית את עמוד הנחיתה (`front-page.php`).

## פיתוח

```bash
cd tooling
npm install
npm run build     # מקמפל Tailwind ל-assets/css/app.min.css
npm run watch     # קימפול אוטומטי בזמן עבודה
npm run images    # המרת תמונות ב-assets/img ל-WebP
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
| `tooling/` | מקור Tailwind + סקריפטים |
| `design-reference/` | מקור Lovable המקורי (לעיון) |

## טופס לידים

הפניות נשמרות כסוג תוכן `md_lead` (תפריט "לידים" בניהול) ונשלחת התראת מייל
ל-`office@metadoc.co.il`. ניתן לשנות יעד מייל דרך הפילטר `metadoc_lead_email`.
האבטחה כוללת Nonce, סניטציה, Honeypot ו-Rate limiting.

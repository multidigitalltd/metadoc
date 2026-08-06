<?php
/**
 * התקנת תוכן בעת הפעלת התבנית — עמוד הצהרת נגישות (חובת רגולציה) ועמוד תקנון.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * יוצר את עמוד הצהרת הנגישות אם אינו קיים.
 */
function metadoc_install_accessibility_page(): void {
	$existing = get_page_by_path( 'accessibility-statement' );
	if ( $existing instanceof WP_Post ) {
		return;
	}

	$content = implode(
		"\n\n",
		array(
			'<!-- wp:paragraph --><p>אתר מטאדוק שואף לאפשר שימוש נוח ונגיש לכלל הגולשים, לרבות אנשים עם מוגבלות, בהתאם לתקנות שוויון זכויות לאנשים עם מוגבלות (התאמות נגישות לשירות), התשע"ג–2013, ולתקן הישראלי ת"י 5568 המבוסס על הנחיות WCAG 2.2 ברמה AA.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>אמצעי הנגישות באתר</h2><!-- /wp:heading -->',
			'<!-- wp:list --><ul><li>תאימות לניווט מקלדת ולקוראי מסך.</li><li>מבנה HTML סמנטי והיררכיית כותרות תקינה.</li><li>ניגודיות צבעים תקינה וטקסט הניתן להגדלה.</li><li>סרגל נגישות הכולל הגדלת/הקטנת טקסט, ניגודיות גבוהה, היפוך צבעים, גווני אפור, הדגשת קישורים וכותרות, גופן קריא, עצירת אנימציות וסרגל קריאה.</li></ul><!-- /wp:list -->',
			'<!-- wp:heading --><h2>יצירת קשר בנושא נגישות</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>נתקלתם בבעיית נגישות? נשמח לסייע. ניתן לפנות אלינו בטלפון 050-600-1032 או בדוא"ל office@metadoc.co.il ונטפל בפנייה בהקדם.</p><!-- /wp:paragraph -->',
			'<!-- wp:paragraph --><p><em>הצהרה זו עודכנה לאחרונה בעת הקמת האתר ותתעדכן מעת לעת.</em></p><!-- /wp:paragraph -->',
		)
	);

	wp_insert_post(
		array(
			'post_title'   => 'הצהרת נגישות',
			'post_name'    => 'accessibility-statement',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
		)
	);
}

/**
 * יוצר עמוד "תקנון האתר" אם אינו קיים.
 * תוכן בסיסי לעריכה — מומלץ לאשר מול יועץ משפטי.
 */
function metadoc_install_terms_page(): void {
	$existing = get_page_by_path( 'terms' );
	if ( $existing instanceof WP_Post ) {
		return;
	}

	$content = implode(
		"\n\n",
		array(
			'<!-- wp:paragraph --><p>השימוש באתר מטאדוק (להלן: "האתר") כפוף לתנאים המפורטים בתקנון זה. הגלישה והשימוש באתר מהווים הסכמה מלאה לתנאים אלה. אם אינכם מסכימים לתנאי כלשהו, נא הימנעו משימוש באתר.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>כללי</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>האמור בתקנון מנוסח מטעמי נוחות בלשון זכר, אך מתייחס לכל המגדרים כאחד. כותרות הסעיפים נועדו לנוחות הקריאה בלבד.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>השירות והתכנים באתר</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>המידע באתר הוא מידע כללי בלבד ואינו מהווה ייעוץ פיננסי, משכנתאי, משפטי או אחר, ואין לראות בו תחליף לייעוץ אישי המותאם לנסיבותיו של כל לקוח. כל הסתמכות על המידע היא באחריות המשתמש בלבד.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>השארת פרטים ויצירת קשר</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>מסירת פרטים באמצעות הטפסים באתר נעשית מרצונכם החופשי ומהווה הסכמה ליצירת קשר מצד נציגי מטאדוק. השימוש בפרטים כפוף למדיניות הפרטיות של האתר.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>קניין רוחני</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>כל זכויות הקניין הרוחני באתר, לרבות העיצוב, הטקסטים, הלוגו והתכנים, שייכות למטאדוק או לבעלי הזכויות מטעמה. אין להעתיק, לשכפל או לעשות שימוש מסחרי בתכנים ללא אישור מראש ובכתב.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>הגבלת אחריות</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>האתר והתכנים מוצעים כפי שהם ("AS IS"). מטאדוק אינה אחראית לכל נזק ישיר או עקיף שייגרם כתוצאה משימוש באתר או מהסתמכות על תכניו.</p><!-- /wp:paragraph -->',
			'<!-- wp:heading --><h2>דין וסמכות שיפוט</h2><!-- /wp:heading -->',
			'<!-- wp:paragraph --><p>על תקנון זה יחולו דיני מדינת ישראל בלבד, וסמכות השיפוט הבלעדית תהא נתונה לבתי המשפט המוסמכים במחוז תל אביב.</p><!-- /wp:paragraph -->',
			'<!-- wp:paragraph --><p><em>תקנון זה הוא תבנית בסיס שנוצרה עם הקמת האתר. מומלץ לעדכנו ולאשרו מול יועץ משפטי בהתאם לפעילות העסק.</em></p><!-- /wp:paragraph -->',
		)
	);

	wp_insert_post(
		array(
			'post_title'   => 'תקנון האתר',
			'post_name'    => 'terms',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $content,
		)
	);
}

/**
 * מבטיח שעמודי החובה (נגישות, תקנון) קיימים — בהפעלת התבנית ובעדכון גרסה.
 * רץ פעם אחת לכל גרסה גם בהתקנות קיימות (לא רק בהפעלה מחדש).
 */
function metadoc_ensure_legal_pages(): void {
	metadoc_install_accessibility_page();
	metadoc_install_terms_page();
}
add_action( 'after_switch_theme', 'metadoc_ensure_legal_pages' );

/**
 * ריצה חד-פעמית בהתקנות קיימות (שאינן עוברות הפעלה מחדש) — יצירת עמוד התקנון.
 */
function metadoc_maybe_ensure_legal_pages(): void {
	if ( '1' === get_option( 'metadoc_legal_pages_v1' ) ) {
		return;
	}
	metadoc_ensure_legal_pages();
	update_option( 'metadoc_legal_pages_v1', '1' );
}
add_action( 'admin_init', 'metadoc_maybe_ensure_legal_pages' );

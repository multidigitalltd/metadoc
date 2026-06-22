<?php
/**
 * התקנת תוכן בעת הפעלת התבנית — עמוד הצהרת נגישות (חובת רגולציה).
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
add_action( 'after_switch_theme', 'metadoc_install_accessibility_page' );

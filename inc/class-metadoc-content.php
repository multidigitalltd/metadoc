<?php
/**
 * ניהול תוכן — כל טקסטי האתר ניתנים לעריכה ב-Customizer ("תוכן האתר").
 *
 * מקור אמת יחיד: metadoc_content_config() מגדיר סקשנים ושדות (כולל ברירות מחדל),
 * וממנו נגזרים גם רישום ה-Customizer וגם פונקציית השליפה metadoc_text().
 * אחסון: theme_mod בשם 'metadoc_{key}'.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** מספר חברי הצוות הניתנים לעריכה בעמוד "אודות". */
const METADOC_TEAM_MAX = 4;

/**
 * שדות חברי הצוות בעמוד "אודות" — נבנים בלולאה כדי למנוע כפילות.
 * שדות יצירת הקשר (טלפון/דוא"ל/לינקדאין) אופציונליים ומוצגים רק כשמולאו.
 *
 * @param callable $t בונה שדה: ( label, default, type ).
 * @return array<string,array{label:string,type:string,default:string}>
 */
function metadoc_team_fields_config( callable $t ): array {
	// ברירות מחדל לתפקיד ולתיאור, לכל חבר/ת צוות לפי הסדר.
	$presets = array(
		array( 'מנכ"ל ומייסד', 'מעל 15 שנות ניסיון בעולם המשכנתאות והמימון, עם התמחות במקרים מורכבים ובסירובי בנקים.' ),
		array( 'יועץ/ת משכנתאות בכיר/ה', 'מומחה/ית בבניית פתרונות מימון יצירתיים ובליווי לקוחות מול הבנקים והגופים החוץ-בנקאיים.' ),
		array( 'מנהל/ת קשרי לקוחות', 'מלווה את הלקוחות לאורך כל התהליך ודואג/ת לשירות אישי, זמין ושקוף מהפנייה ועד החתימה.' ),
		array( 'יועץ/ת מימון', 'מתמחה בליווי לקוחות עם אתגרי אשראי ובמציאת מסלולי מימון מותאמים אישית.' ),
	);

	$fields = array();
	for ( $i = 1; $i <= METADOC_TEAM_MAX; $i++ ) {
		$preset = $presets[ $i - 1 ] ?? array( '', '' );
		/* translators: 1: מספר חבר/ת הצוות. 2: שם השדה (שם, תפקיד, תמונה...). */
		$label = static fn( string $suffix ): string => sprintf( __( 'חבר/ת צוות %1$d – %2$s', 'metadoc' ), $i, $suffix );

		$fields[ 'about_team_' . $i . '_name' ]     = $t( $label( __( 'שם', 'metadoc' ) ), __( 'שם מלא', 'metadoc' ) );
		$fields[ 'about_team_' . $i . '_role' ]     = $t( $label( __( 'תפקיד', 'metadoc' ) ), $preset[0] );
		$fields[ 'about_team_' . $i . '_bio' ]      = $t( $label( __( 'אודות', 'metadoc' ) ), $preset[1], 'textarea' );
		$fields[ 'about_team_' . $i . '_photo' ]    = $t( $label( __( 'תמונה', 'metadoc' ) ), '', 'image' );
		$fields[ 'about_team_' . $i . '_phone' ]    = $t( $label( __( 'טלפון (לא חובה)', 'metadoc' ) ), '' );
		$fields[ 'about_team_' . $i . '_email' ]    = $t( $label( __( 'דוא"ל (לא חובה)', 'metadoc' ) ), '', 'email' );
		$fields[ 'about_team_' . $i . '_linkedin' ] = $t( $label( __( 'לינקדאין (לא חובה)', 'metadoc' ) ), '', 'url' );
	}
	return $fields;
}

/**
 * הגדרת כל הסקשנים והשדות הניתנים לעריכה.
 *
 * @return array<string,array{label:string,fields:array<string,array{label:string,type:string,default:string}>}>
 */
function metadoc_content_config(): array {
	$t = static function ( string $label, string $default, string $type = 'text' ): array {
		return array(
			'label'   => $label,
			'type'    => $type,
			'default' => $default,
		);
	};

	return array(
		'contact'    => array(
			'label'  => __( 'פרטי יצירת קשר', 'metadoc' ),
			'fields' => array(
				'phone_tel'      => $t( __( 'טלפון (לחיוג, ספרות בלבד)', 'metadoc' ), '0506001032' ),
				'phone_display'  => $t( __( 'טלפון (תצוגה)', 'metadoc' ), '050-600-1032' ),
				'email'          => $t( __( 'דוא"ל', 'metadoc' ), 'office@metadoc.co.il' ),
				'address'        => $t( __( 'כתובת', 'metadoc' ), 'הדובדבן 9, קריית אונו' ),
				'hours_week'     => $t( __( 'שעות א׳–ה׳', 'metadoc' ), 'א׳–ה׳ · 09:00–18:00' ),
				'hours_fri'      => $t( __( 'שעות ו׳', 'metadoc' ), 'ו׳ · 09:00–13:00' ),
				'whatsapp_text'  => $t( __( 'הודעת וואטסאפ פותחת', 'metadoc' ), 'שלום, אשמח לבדיקת זכאות למשכנתא' ),
				'header_cta'     => $t( __( 'כפתור עליון', 'metadoc' ), 'בדיקת זכאות' ),
			),
		),
		'hero'       => array(
			'label'  => __( 'Hero (ראש העמוד)', 'metadoc' ),
			'fields' => array(
				'hero_eyebrow'     => $t( __( 'תווית עליונה', 'metadoc' ), 'מומחי משכנתאות · מעל 15 שנות ניסיון' ),
				'hero_title_1'     => $t( __( 'כותרת – שורה 1', 'metadoc' ), 'סורבתם למשכנתא?' ),
				'hero_title_2'     => $t( __( 'כותרת – שורה 2 (כתום)', 'metadoc' ), 'אל תוותרו.' ),
				'hero_subtitle'    => $t( __( 'תת-כותרת', 'metadoc' ), 'מעל 15 שנות ניסיון במציאת פתרונות מימון לבעלי נכסים ולרוכשי דירות שנתקלו בסירוב מהבנק ובהליכי מימון מורכבים.', 'textarea' ),
				'hero_cta'         => $t( __( 'כפתור ראשי', 'metadoc' ), 'בדיקת זכאות חינם' ),
				'hero_badge_1'     => $t( __( 'תג 1', 'metadoc' ), 'ללא התחייבות' ),
				'hero_badge_2'     => $t( __( 'תג 2', 'metadoc' ), 'דיסקרטיות מלאה' ),
				'hero_badge_3'     => $t( __( 'תג 3', 'metadoc' ), 'מענה תוך 24ש׳' ),
				'hero_img_eyebrow' => $t( __( 'תמונה – תווית', 'metadoc' ), 'כשכולם אומרים "אי אפשר"' ),
				'hero_img_caption' => $t( __( 'תמונה – כיתוב', 'metadoc' ), '– אנחנו מתחילים לבדוק איך כן' ),
				'hero_stat_num'    => $t( __( 'תמונה – נתון', 'metadoc' ), '94%' ),
				'hero_stat_label'  => $t( __( 'תמונה – תיאור נתון', 'metadoc' ), 'מהתיקים מקבלים פתרון' ),
			),
		),
		'trust'      => array(
			'label'  => __( 'סרגל אמון', 'metadoc' ),
			'fields' => array(
				'trust_1_num'  => $t( __( 'נתון 1', 'metadoc' ), '+15' ),
				'trust_1_text' => $t( __( 'תיאור 1', 'metadoc' ), 'מעל 15 שנות ניסיון' ),
				'trust_2_num'  => $t( __( 'נתון 2', 'metadoc' ), '+800' ),
				'trust_2_text' => $t( __( 'תיאור 2', 'metadoc' ), 'לקוחות מרוצים' ),
				'trust_3_num'  => $t( __( 'נתון 3', 'metadoc' ), '94%' ),
				'trust_3_text' => $t( __( 'תיאור 3', 'metadoc' ), 'אחוזי הצלחה' ),
				'trust_4_num'  => $t( __( 'נתון 4', 'metadoc' ), '100%' ),
				'trust_4_text' => $t( __( 'תיאור 4', 'metadoc' ), 'דיסקרטיות' ),
			),
		),
		'identify'   => array(
			'label'  => __( 'נשמע מוכר?', 'metadoc' ),
			'fields' => array(
				'identify_eyebrow' => $t( __( 'תווית', 'metadoc' ), 'נשמע מוכר?' ),
				'identify_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'אם הגעתם לכאן —' ),
				'identify_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'אתם לא לבד' ),
				'identify_p1'      => $t( __( 'פסקה 1', 'metadoc' ), 'אנחנו פוגשים מדי חודש אנשים טובים, עובדים ומתפרנסים, שנדחים פעם אחר פעם — למרות שיש להם נכס, הכנסה ויכולת החזר.', 'textarea' ),
				'identify_p2'      => $t( __( 'פסקה 2', 'metadoc' ), 'אנחנו כאן כדי לפתוח דלתות גם כשנראה שאין סיכוי.', 'textarea' ),
				'identify_item_1'  => $t( __( 'פריט 1', 'metadoc' ), 'הבקשה למשכנתא נדחתה' ),
				'identify_item_2'  => $t( __( 'פריט 2', 'metadoc' ), 'סירוב מהבנק בגלל התנהלות חשבון' ),
				'identify_item_3'  => $t( __( 'פריט 3', 'metadoc' ), "חזרו צ'קים או הוראות קבע בעבר" ),
				'identify_item_4'  => $t( __( 'פריט 4', 'metadoc' ), 'דירוג האשראי פוגע בסיכויי האישור' ),
				'identify_item_5'  => $t( __( 'פריט 5', 'metadoc' ), 'ריבוי הלוואות והחזרים חודשיים גבוהים' ),
				'identify_item_6'  => $t( __( 'פריט 6', 'metadoc' ), 'אין מי שמוכן להילחם עבורכם' ),
			),
		),
		'solution'   => array(
			'label'  => __( 'הפתרון', 'metadoc' ),
			'fields' => array(
				'solution_eyebrow' => $t( __( 'תווית', 'metadoc' ), 'הפתרון' ),
				'solution_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'פתרונות המימון שלנו מתאימים במיוחד' ),
				'solution_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'למצבים כאלו' ),
				'solution_p1'      => $t( __( 'פסקה 1', 'metadoc' ), 'במשך יותר מ-15 שנים אנו מלווים לקוחות במצבים מורכבים מול גופי המימון והבנקים — כאלה שכבר שמעו "לא" יותר מפעם אחת.', 'textarea' ),
				'solution_p2'      => $t( __( 'פסקה 2', 'metadoc' ), 'אנחנו בוחנים כל תיק לעומק, מזהים את החסמים האמיתיים, בונים אסטרטגיית מימון יצירתית ומלווים אתכם לאורך כל הדרך עד החתימה.', 'textarea' ),
				'solution_quote'   => $t( __( 'משפט מודגש', 'metadoc' ), 'המטרה שלנו פשוטה: למצות עבורכם את כל האפשרויות הקיימות ולהביא לפתרון המימון המתאים ביותר.', 'textarea' ),
				'solution_tag'     => $t( __( 'תווית תמונה', 'metadoc' ), 'שותפים · לא ספקים' ),
			),
		),
		'whoisfor'   => array(
			'label'  => __( 'למי מתאים', 'metadoc' ),
			'fields' => array(
				'whoisfor_eyebrow'  => $t( __( 'תווית', 'metadoc' ), 'למי מתאים השירות' ),
				'whoisfor_title_1'  => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'אם יש לכם נכס או אתם בתהליך רכישה —' ),
				'whoisfor_title_2'  => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'אתם מתאימים!' ),
				'audience_1_title'  => $t( __( 'כרטיס 1 – כותרת', 'metadoc' ), 'דירה ראשונה' ),
				'audience_1_desc'   => $t( __( 'כרטיס 1 – תיאור', 'metadoc' ), 'זוגות צעירים ומשפחות שרוכשים נכס ראשון וצריכים ליווי מקצועי', 'textarea' ),
				'audience_2_title'  => $t( __( 'כרטיס 2 – כותרת', 'metadoc' ), 'מחזור משכנתא' ),
				'audience_2_desc'   => $t( __( 'כרטיס 2 – תיאור', 'metadoc' ), 'בעלי נכס קיים שרוצים לשפר תנאים, להוריד ריבית או למשוך הון', 'textarea' ),
				'audience_3_title'  => $t( __( 'כרטיס 3 – כותרת', 'metadoc' ), 'נדחו על ידי הבנק' ),
				'audience_3_desc'   => $t( __( 'כרטיס 3 – תיאור', 'metadoc' ), 'מי שסבל מסירוב בנקאי וזקוק למומחה שיודע איך לפתוח דלתות', 'textarea' ),
				'audience_4_title'  => $t( __( 'כרטיס 4 – כותרת', 'metadoc' ), 'עצמאיים ובעלי עסקים' ),
				'audience_4_desc'   => $t( __( 'כרטיס 4 – תיאור', 'metadoc' ), 'לקוחות עם הכנסה משתנה שבנקים רואים בה כאתגר', 'textarea' ),
				'audience_5_title'  => $t( __( 'כרטיס 5 – כותרת', 'metadoc' ), 'ריבוי התחייבויות' ),
				'audience_5_desc'   => $t( __( 'כרטיס 5 – תיאור', 'metadoc' ), 'בעלי הלוואות וחובות מרובים המעונינים לאחד הלוואות ולשפר את ההחזרים', 'textarea' ),
				'audience_6_title'  => $t( __( 'כרטיס 6 – כותרת', 'metadoc' ), 'נכס להשקעה' ),
				'audience_6_desc'   => $t( __( 'כרטיס 6 – תיאור', 'metadoc' ), 'מי שמעוניין לרכוש דירה להשקעה וזקוק למסלול מימון מתאים', 'textarea' ),
			),
		),
		'contactstrip' => array(
			'label'  => __( 'רצועת יצירת קשר', 'metadoc' ),
			'fields' => array(
				'contactstrip_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'צרו קשר לבדיקת זכאות' ),
				'contactstrip_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'ללא עלות' ),
			),
		),
		'whyus'      => array(
			'label'  => __( 'למה מטאדוק', 'metadoc' ),
			'fields' => array(
				'whyus_eyebrow' => $t( __( 'תווית', 'metadoc' ), 'למה דווקא מטאדוק' ),
				'whyus_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'כי הניסיון' ),
				'whyus_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'עושה את ההבדל' ),
				'whyus_1_title' => $t( __( 'נקודה 1 – כותרת', 'metadoc' ), 'ניסיון של מעל 15 שנים' ),
				'whyus_1_desc'  => $t( __( 'נקודה 1 – תיאור', 'metadoc' ), 'ידע מעשי בטיפול בתיקים מורכבים ובמקרים שנדחו בעבר על ידי שני בנקים ויותר.', 'textarea' ),
				'whyus_2_title' => $t( __( 'נקודה 2 – כותרת', 'metadoc' ), 'נלחמים על כל לקוח' ),
				'whyus_2_desc'  => $t( __( 'נקודה 2 – תיאור', 'metadoc' ), 'לא מסתפקים בתשובה הראשונה. ממשיכים לבדוק עד שמוצאים את הפתרון הנכון.', 'textarea' ),
				'whyus_3_title' => $t( __( 'נקודה 3 – כותרת', 'metadoc' ), 'מומחיות במקרים מורכבים' ),
				'whyus_3_desc'  => $t( __( 'נקודה 3 – תיאור', 'metadoc' ), 'לקוחות בעלי אתגרי אשראי, סירובי בנקים, BDI שלילי ותיקים חריגים.', 'textarea' ),
				'whyus_4_title' => $t( __( 'נקודה 4 – כותרת', 'metadoc' ), 'ליווי אישי וצמוד' ),
				'whyus_4_desc'  => $t( __( 'נקודה 4 – תיאור', 'metadoc' ), 'איש קשר אחד שמכיר את התיק שלכם לעומק, מההתחלה ועד לחתימה.', 'textarea' ),
				'whyus_5_title' => $t( __( 'נקודה 5 – כותרת', 'metadoc' ), 'מאות לקוחות מרוצים' ),
				'whyus_5_desc'  => $t( __( 'נקודה 5 – תיאור', 'metadoc' ), 'אנשים שכבר היו בטוחים שאין להם פתרון – וקיבלו הזדמנות נוספת.', 'textarea' ),
				'whyus_6_title' => $t( __( 'נקודה 6 – כותרת', 'metadoc' ), 'שקיפות מלאה' ),
				'whyus_6_desc'  => $t( __( 'נקודה 6 – תיאור', 'metadoc' ), 'אתם תמיד יודעים בדיוק איפה התיק עומד, מה הצעדים הבאים והעלויות הצפויות.', 'textarea' ),
			),
		),
		'process'    => array(
			'label'  => __( 'איך זה עובד', 'metadoc' ),
			'fields' => array(
				'process_eyebrow'  => $t( __( 'תווית', 'metadoc' ), 'התהליך · 4 שלבים פשוטים' ),
				'process_title_pre' => $t( __( 'כותרת – לפני', 'metadoc' ), 'איך זה' ),
				'process_title_em'  => $t( __( 'כותרת – מודגש (כתום)', 'metadoc' ), 'עובד' ),
				'step_1_title'     => $t( __( 'שלב 1 – כותרת', 'metadoc' ), 'משאירים פרטים' ),
				'step_1_desc'      => $t( __( 'שלב 1 – תיאור', 'metadoc' ), 'נציג מומחה יוצר איתכם קשר בהקדם לשיחת בדיקה ראשונית.', 'textarea' ),
				'step_2_title'     => $t( __( 'שלב 2 – כותרת', 'metadoc' ), 'בודקים את המקרה' ),
				'step_2_desc'      => $t( __( 'שלב 2 – תיאור', 'metadoc' ), 'אנחנו מנתחים את כל הנתונים ומבינים בדיוק מה גרם לסירוב.', 'textarea' ),
				'step_3_title'     => $t( __( 'שלב 3 – כותרת', 'metadoc' ), 'בונים פתרון' ),
				'step_3_desc'      => $t( __( 'שלב 3 – תיאור', 'metadoc' ), 'מתאימים את מסלול הפעולה הנכון והיצירתי ביותר עבורכם.', 'textarea' ),
				'step_4_title'     => $t( __( 'שלב 4 – כותרת', 'metadoc' ), 'מלווים עד לסיום' ),
				'step_4_desc'      => $t( __( 'שלב 4 – תיאור', 'metadoc' ), 'נמצאים לצידכם מהשלב הראשון ועד הרגע של קבלת הכסף לחשבון', 'textarea' ),
			),
		),
		'testimonials' => array(
			'label'  => __( 'המלצות', 'metadoc' ),
			'fields' => array(
				'testi_eyebrow' => $t( __( 'תווית', 'metadoc' ), 'מה אומרים עלינו' ),
				'testi_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'אנשים שהיו' ),
				'testi_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'בדיוק במקומכם' ),
				'testi_1_name'  => $t( __( 'המלצה 1 – שם', 'metadoc' ), 'יעקב ל.' ),
				'testi_1_city'  => $t( __( 'המלצה 1 – עיר', 'metadoc' ), 'בני ברק' ),
				'testi_1_quote' => $t( __( 'המלצה 1 – ציטוט', 'metadoc' ), 'סורבתי בשני בנקים. במטאדוק מצאו לי פתרון תוך 3 שבועות. שירות אישי לאורך כל הדרך.', 'textarea' ),
				'testi_2_name'  => $t( __( 'המלצה 2 – שם', 'metadoc' ), 'מרים פ.' ),
				'testi_2_city'  => $t( __( 'המלצה 2 – עיר', 'metadoc' ), 'מודיעין עילית' ),
				'testi_2_quote' => $t( __( 'המלצה 2 – ציטוט', 'metadoc' ), 'חשבתי שאין סיכוי שאקבל משכנתא. הם לא ויתרו עד שמצאו את המסלול הנכון בשבילי.', 'textarea' ),
				'testi_3_name'  => $t( __( 'המלצה 3 – שם', 'metadoc' ), 'דוד א.' ),
				'testi_3_city'  => $t( __( 'המלצה 3 – עיר', 'metadoc' ), 'אשדוד' ),
				'testi_3_quote' => $t( __( 'המלצה 3 – ציטוט', 'metadoc' ), 'אחרי שלוש שנים של ניסיונות, תוך חודש היה לנו אישור. אנשי מקצוע אמיתיים.', 'textarea' ),
			),
		),
		'success'    => array(
			'label'  => __( 'סיפור הצלחה', 'metadoc' ),
			'fields' => array(
				'success_badge'    => $t( __( 'תג תמונה', 'metadoc' ), 'סיפור הצלחה' ),
				'success_eyebrow'  => $t( __( 'תווית', 'metadoc' ), 'זה אפשרי' ),
				'success_title_1'  => $t( __( 'כותרת – לפני', 'metadoc' ), 'הם כבר קיבלו את' ),
				'success_title_em' => $t( __( 'כותרת – מודגש (כתום)', 'metadoc' ), 'המפתחות' ),
				'success_title_2'  => $t( __( 'כותרת – שורה 2', 'metadoc' ), 'תורכם.' ),
				'success_p'        => $t( __( 'פסקה', 'metadoc' ), 'מאות משפחות שכבר התייאשו מצאו אצלנו פתרון מימון אמיתי — וקיבלו את הבית, את ההלוואה ואת השקט הנפשי שמגיע להם.', 'textarea' ),
				'success_cta'      => $t( __( 'כפתור', 'metadoc' ), 'בדקו את התיק שלכם' ),
			),
		),
		'about'      => array(
			'label'  => __( 'עמוד אודות', 'metadoc' ),
			'fields' => array_merge(
				array(
					'about_eyebrow'        => $t( __( 'תווית עליונה', 'metadoc' ), 'אודות מטאדוק' ),
					'about_subtitle'       => $t( __( 'תת-כותרת (מתחת לכותרת)', 'metadoc' ), 'מומחים למימון ולמשכנתאות למסורבי בנקים — מעל 15 שנות ניסיון בפתרון תיקים מורכבים.', 'textarea' ),
					'about_image'          => $t( __( 'תמונה ראשית', 'metadoc' ), '', 'image' ),
					'about_story_eyebrow'  => $t( __( 'סיפור – תווית', 'metadoc' ), 'הסיפור שלנו' ),
					'about_story_title'    => $t( __( 'סיפור – כותרת', 'metadoc' ), 'למה הקמנו את מטאדוק' ),
					'about_lead'           => $t( __( 'פסקת פתיחה (מודגשת)', 'metadoc' ), 'מטאדוק הוקמה מתוך אמונה פשוטה: לכל אדם מגיעה הזדמנות הוגנת למימון — גם כשהבנק אמר "לא".', 'textarea' ),
					'about_quote'          => $t( __( 'ציטוט מודגש', 'metadoc' ), 'אנחנו לא מסתפקים בתשובה הראשונה — אנחנו מחפשים את הדרך שבה כן אפשר.', 'textarea' ),
					'about_quote_author'   => $t( __( 'ציטוט – ייחוס', 'metadoc' ), 'צוות מטאדוק' ),
					'about_values_eyebrow' => $t( __( 'ערכים – תווית', 'metadoc' ), 'הערכים שלנו' ),
					'about_values_title'   => $t( __( 'ערכים – כותרת', 'metadoc' ), 'הערכים שמובילים אותנו' ),
					'about_value_1_title'  => $t( __( 'ערך 1 – כותרת', 'metadoc' ), 'מקצועיות' ),
					'about_value_1_desc'   => $t( __( 'ערך 1 – תיאור', 'metadoc' ), 'ידע מעמיק וניסיון מוכח בטיפול בתיקים מורכבים מול כלל גופי המימון בישראל.', 'textarea' ),
					'about_value_2_title'  => $t( __( 'ערך 2 – כותרת', 'metadoc' ), 'אמינות ושקיפות' ),
					'about_value_2_desc'   => $t( __( 'ערך 2 – תיאור', 'metadoc' ), 'אתם תמיד יודעים בדיוק היכן התיק עומד, מה הצעדים הבאים ומה העלויות הצפויות.', 'textarea' ),
					'about_value_3_title'  => $t( __( 'ערך 3 – כותרת', 'metadoc' ), 'מחויבות אישית' ),
					'about_value_3_desc'   => $t( __( 'ערך 3 – תיאור', 'metadoc' ), 'איש קשר אחד שמלווה אתכם מההתחלה ועד החתימה, ונלחם על כל לקוח עד הפתרון.', 'textarea' ),
					'about_team_eyebrow'   => $t( __( 'צוות – תווית', 'metadoc' ), 'הצוות' ),
					'about_team_title'     => $t( __( 'צוות – כותרת', 'metadoc' ), 'הצוות שלנו' ),
					'about_team_subtitle'  => $t( __( 'צוות – תת-כותרת', 'metadoc' ), 'אנשי מקצוע מנוסים שמלווים אתכם אישית לאורך כל הדרך.', 'textarea' ),
				),
				metadoc_team_fields_config( $t )
			),
		),
		'leadform'   => array(
			'label'  => __( 'טופס בדיקת זכאות', 'metadoc' ),
			'fields' => array(
				'leadform_eyebrow'    => $t( __( 'תווית', 'metadoc' ), 'בדיקת זכאות' ),
				'leadform_title_1'    => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'ללא עלות.' ),
				'leadform_title_2'    => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'ללא התחייבות.' ),
				'leadform_p'          => $t( __( 'פסקה', 'metadoc' ), 'השאירו פרטים, מומחה מהצוות שלנו יחזור אליכם תוך 24 שעות לשיחת בדיקה ראשונית — אישית, חינמית, ובלי שום התחייבות מצדכם.', 'textarea' ),
				'leadform_benefit_1'  => $t( __( 'יתרון 1', 'metadoc' ), 'בדיקה ראשונית מקצועית' ),
				'leadform_benefit_2'  => $t( __( 'יתרון 2', 'metadoc' ), 'ליווי אישי וצמוד' ),
				'leadform_benefit_3'  => $t( __( 'יתרון 3', 'metadoc' ), 'ניסיון של מעל 15 שנים' ),
				'leadform_benefit_4'  => $t( __( 'יתרון 4', 'metadoc' ), 'דיסקרטיות מוחלטת' ),
				'leadform_box_eyebrow' => $t( __( 'תיבה – תווית', 'metadoc' ), 'טופס בדיקת זכאות' ),
				'leadform_box_title'  => $t( __( 'תיבה – כותרת', 'metadoc' ), 'השאירו פרטים — נחזור אליכם תוך 24 שעות.' ),
				'leadform_btn'        => $t( __( 'כפתור שליחה', 'metadoc' ), 'שלחו לבדיקה' ),
			),
		),
		'bottomcta'  => array(
			'label'  => __( 'קריאה לפעולה אחרונה', 'metadoc' ),
			'fields' => array(
				'bottomcta_eyebrow' => $t( __( 'תווית', 'metadoc' ), 'צעד אחד אחרון' ),
				'bottomcta_title_1' => $t( __( 'כותרת – חלק 1', 'metadoc' ), 'רוצים לבדוק את' ),
				'bottomcta_title_2' => $t( __( 'כותרת – חלק 2 (כתום)', 'metadoc' ), 'סיכויי המימון שלכם?' ),
				'bottomcta_p'       => $t( __( 'פסקה', 'metadoc' ), 'השאירו פרטים עכשיו ונחזור אליכם בהקדם. ללא עלות, ללא התחייבות, עם ניסיון של מעל 15 שנים.', 'textarea' ),
				'bottomcta_btn'     => $t( __( 'כפתור', 'metadoc' ), 'השאירו פרטים' ),
			),
		),
		'footer'     => array(
			'label'  => __( 'פוטר', 'metadoc' ),
			'fields' => array(
				'footer_tagline'   => $t( __( 'תיאור קצר', 'metadoc' ), 'פתרונות מימון יצירתיים לבעלי נכסים שהבנקים אמרו להם "לא".', 'textarea' ),
				'footer_col_contact' => $t( __( 'כותרת – צרו קשר', 'metadoc' ), 'צרו קשר' ),
				'footer_col_address' => $t( __( 'כותרת – כתובת', 'metadoc' ), 'כתובת' ),
				'footer_col_hours'   => $t( __( 'כותרת – שעות', 'metadoc' ), 'שעות פעילות' ),
				'footer_copyright' => $t( __( 'זכויות יוצרים', 'metadoc' ), 'מטאדוק. כל הזכויות שמורות.' ),
				'footer_legal'     => $t( __( 'הערה משפטית', 'metadoc' ), 'מתן ההלוואה בכפוף לאישור הגוף המממן.' ),
			),
		),
		'forms'      => array(
			'label'  => __( 'טפסים – תוויות', 'metadoc' ),
			'fields' => array(
				'form_label_name'   => $t( __( 'תווית – שם', 'metadoc' ), 'שם מלא' ),
				'form_ph_name'      => $t( __( 'Placeholder – שם', 'metadoc' ), 'ישראל ישראלי' ),
				'form_label_phone'  => $t( __( 'תווית – טלפון', 'metadoc' ), 'טלפון' ),
				'form_label_note'   => $t( __( 'תווית – פרטים', 'metadoc' ), 'פרטים נוספים (לא חובה)' ),
				'form_ph_note'      => $t( __( 'Placeholder – פרטים', 'metadoc' ), 'ספרו לנו בקצרה על המקרה שלכם' ),
				'form_consent'      => $t( __( 'טקסט אישור פרטיות', 'metadoc' ), 'קראתי ואני מאשר/ת את' ),
				'form_consent_link' => $t( __( 'טקסט קישור פרטיות', 'metadoc' ), 'מדיניות הפרטיות' ),
				'form_hint'         => $t( __( 'הערה מתחת לכפתור', 'metadoc' ), 'בלחיצה על השליחה אני מאשר/ת קבלת פנייה חוזרת.' ),
				'strip_badges'      => $t( __( 'רצועה – שורת תגים', 'metadoc' ), 'ללא התחייבות · דיסקרטיות מלאה · מענה תוך 24 שעות' ),
			),
		),
		'cookie'     => array(
			'label'  => __( 'באנר עוגיות', 'metadoc' ),
			'fields' => array(
				'cookie_text'    => $t( __( 'טקסט', 'metadoc' ), 'אנו משתמשים בעוגיות (Cookies) כדי לשפר את חוויית הגלישה ולנתח את השימוש באתר.', 'textarea' ),
				'cookie_more'    => $t( __( 'טקסט קישור', 'metadoc' ), 'מידע נוסף במדיניות הפרטיות' ),
				'cookie_accept'  => $t( __( 'כפתור אישור', 'metadoc' ), 'מאשר/ת' ),
				'cookie_decline' => $t( __( 'כפתור דחייה', 'metadoc' ), 'דחייה' ),
			),
		),
		'successmodal' => array(
			'label'  => __( 'חלון אישור שליחה', 'metadoc' ),
			'fields' => array(
				'successmodal_title' => $t( __( 'כותרת', 'metadoc' ), 'הפרטים נשלחו בהצלחה!' ),
				'successmodal_text'  => $t( __( 'טקסט', 'metadoc' ), 'מומחה מהצוות שלנו יחזור אליכם בהקדם, בדרך כלל תוך 24 שעות.', 'textarea' ),
				'successmodal_btn'   => $t( __( 'כפתור', 'metadoc' ), 'מצוין, תודה' ),
			),
		),
	);
}

/**
 * מפה שטוחה של key => default.
 *
 * @return array<string,string>
 */
function metadoc_content_defaults(): array {
	static $flat = null;
	if ( null !== $flat ) {
		return $flat;
	}
	$flat = array();
	foreach ( metadoc_content_config() as $section ) {
		foreach ( $section['fields'] as $key => $field ) {
			$flat[ $key ] = $field['default'];
		}
	}
	return $flat;
}

/**
 * מחזיר טקסט ערוך (theme_mod) עם נפילה לברירת המחדל מהקונפיג.
 *
 * @param string $key מפתח השדה.
 * @return string
 */
function metadoc_text( string $key ): string {
	$defaults = metadoc_content_defaults();
	$default  = $defaults[ $key ] ?? '';
	$value    = (string) get_theme_mod( 'metadoc_' . $key, $default );
	/**
	 * אפשרות לעקוף טקסט לפי הקשר (למשל טלפון מותאם לעמוד נחיתה/קמפיין).
	 *
	 * @param string $value הערך.
	 * @param string $key   מפתח השדה.
	 */
	return (string) apply_filters( 'metadoc_text', $value, $key );
}

/**
 * הדפסת טקסט ערוך עם escaping.
 *
 * @param string $key מפתח השדה.
 */
function metadoc_the_text( string $key ): void {
	echo esc_html( metadoc_text( $key ) );
}

/**
 * Class Metadoc_Content — רישום שדות התוכן ב-Customizer.
 */
final class Metadoc_Content {

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'customize_register', array( __CLASS__, 'customize' ) );
	}

	/**
	 * רישום פאנל "תוכן האתר" עם סקשן לכל אזור.
	 *
	 * @param WP_Customize_Manager $wp_customize מנהל ה-Customizer.
	 */
	public static function customize( $wp_customize ): void {
		$wp_customize->add_panel(
			'metadoc_content',
			array(
				'title'    => __( 'תוכן האתר', 'metadoc' ),
				'priority' => 25,
			)
		);

		$priority_section = 10;
		foreach ( metadoc_content_config() as $section_id => $section ) {
			$wp_customize->add_section(
				'metadoc_content_' . $section_id,
				array(
					'title'    => $section['label'],
					'panel'    => 'metadoc_content',
					'priority' => $priority_section,
				)
			);
			$priority_section += 10;

			// סניטציה וסוג פקד לפי סוג השדה (ברירת מחדל: טקסט חופשי).
			$sanitizers = array(
				'image'    => 'esc_url_raw',
				'url'      => 'esc_url_raw',
				'email'    => 'sanitize_email',
				'textarea' => 'sanitize_textarea_field',
			);
			$controls   = array(
				'textarea' => 'textarea',
				'url'      => 'url',
				'email'    => 'email',
			);

			$priority_field = 10;
			foreach ( $section['fields'] as $key => $field ) {
				$type     = $field['type'];
				$is_image = ( 'image' === $type );
				$wp_customize->add_setting(
					'metadoc_' . $key,
					array(
						'type'              => 'theme_mod',
						'capability'        => 'edit_theme_options',
						'default'           => $field['default'],
						'sanitize_callback' => $sanitizers[ $type ] ?? 'sanitize_text_field',
						'transport'         => 'refresh',
					)
				);
				if ( $is_image ) {
					$wp_customize->add_control(
						new WP_Customize_Image_Control(
							$wp_customize,
							'metadoc_' . $key,
							array(
								'label'    => $field['label'],
								'section'  => 'metadoc_content_' . $section_id,
								'priority' => $priority_field,
							)
						)
					);
				} else {
					$wp_customize->add_control(
						'metadoc_' . $key,
						array(
							'label'    => $field['label'],
							'section'  => 'metadoc_content_' . $section_id,
							'type'     => $controls[ $type ] ?? 'text',
							'priority' => $priority_field,
						)
					);
				}
				$priority_field += 10;
			}
		}
	}
}

Metadoc_Content::init();

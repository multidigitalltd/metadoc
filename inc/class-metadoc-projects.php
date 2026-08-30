<?php
/**
 * פרויקטים של מחלקת הנדל"ן — סוג תוכן ייעודי + מסכי ניהול.
 *
 * כל פרויקט הוא רשומה אחת שמרונדרת בתבנית של "שער המפרץ"
 * (single-md_project.php). ערכי ברירת המחדל של כל השדות הם התוכן של
 * שער המפרץ, כך שפרויקט חדש נפתח כשלד מלא וניתן לעריכה.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Metadoc_Projects
 */
final class Metadoc_Projects {

	public const CPT   = 'md_project';
	private const NONCE = 'metadoc_project_meta';
	private const PREFIX = '_md_pr_';

	/**
	 * אתחול.
	 */
	public static function init(): void {
		add_action( 'init', array( __CLASS__, 'register_cpt' ) );
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_boxes' ) );
		add_action( 'save_post_' . self::CPT, array( __CLASS__, 'save' ), 10, 2 );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'after_switch_theme', array( __CLASS__, 'flush_rewrites' ) );
		add_action( 'admin_init', array( __CLASS__, 'maybe_flush_rewrites' ) );
		add_filter( 'parent_file', array( __CLASS__, 'menu_parent' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_assets' ) );
		add_filter( 'manage_' . self::CPT . '_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', array( __CLASS__, 'column' ), 10, 2 );
	}

	/**
	 * רישום סוג התוכן.
	 */
	public static function register_cpt(): void {
		register_post_type(
			self::CPT,
			array(
				'labels'        => array(
					'name'               => __( 'פרויקטים', 'metadoc' ),
					'singular_name'      => __( 'פרויקט', 'metadoc' ),
					'add_new'            => __( 'הוספת פרויקט', 'metadoc' ),
					'add_new_item'       => __( 'פרויקט חדש', 'metadoc' ),
					'edit_item'          => __( 'עריכת פרויקט', 'metadoc' ),
					'new_item'           => __( 'פרויקט חדש', 'metadoc' ),
					'view_item'          => __( 'צפייה בפרויקט', 'metadoc' ),
					'search_items'       => __( 'חיפוש פרויקטים', 'metadoc' ),
					'not_found'          => __( 'לא נמצאו פרויקטים', 'metadoc' ),
					'all_items'          => __( 'כל הפרויקטים', 'metadoc' ),
					'menu_name'          => __( 'פרויקטים', 'metadoc' ),
				),
				'public'        => true,
				'show_in_menu'  => false, // מוצג תחת התפריט "מחלקת נדל"ן".
				'menu_icon'     => 'dashicons-building',
				'supports'      => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
				'has_archive'   => false,
				'rewrite'       => array( 'slug' => 'projects', 'with_front' => false ),
				'show_in_rest'  => false,
				'capability_type' => 'post',
			)
		);
	}

	/* --------------------------------------------------------------------
	 * סכמת השדות
	 * ----------------------------------------------------------------- */

	/**
	 * אייקוני כרטיסי הנתונים (מקטע 02).
	 *
	 * @return array<string,array{label:string,path:string}>
	 */
	public static function fact_icons(): array {
		return array(
			'parcel'  => array(
				'label' => __( 'מפת חלקה', 'metadoc' ),
				'path'  => '<path d="M4 6.5 9.5 4l5 2.5L20 4v13.5L14.5 20l-5-2.5L4 20V6.5z"></path><path d="M9.5 4v13.5"></path><path d="M14.5 6.5V20"></path>',
			),
			'skyline' => array(
				'label' => __( 'קו רקיע', 'metadoc' ),
				'path'  => '<path d="M3 21h18"></path><path d="M5 21V9l5-3.5V21"></path><path d="M10 21V11l5 3v7"></path><path d="M15 21v-9l4 2.5V21"></path><path d="M7.5 12h1"></path><path d="M7.5 16h1"></path>',
			),
			'offices' => array(
				'label' => __( 'תעסוקה ומסחר', 'metadoc' ),
				'path'  => '<path d="M3 20.5h18"></path><path d="M4.5 20.5V9.5h7v11"></path><path d="M11.5 20.5V13H20v7.5"></path><path d="M6.5 12.5h3"></path><path d="M6.5 16.5h3"></path><path d="M14 16h3.5"></path>',
			),
			'tree'    => array(
				'label' => __( 'שטחים פתוחים', 'metadoc' ),
				'path'  => '<path d="M12 20.5v-6"></path><path d="M12 14.5c-3.6 0-6.5-2.7-6.5-6 0-1.5.5-2.9 1.4-4 .6 2.2 2.6 3.4 5.1 3.4s4.5-1.2 5.1-3.4c.9 1.1 1.4 2.5 1.4 4 0 3.3-2.9 6-6.5 6z"></path><path d="M7.5 20.5h9"></path>',
			),
			'hotel'   => array(
				'label' => __( 'מלונאות', 'metadoc' ),
				'path'  => '<path d="M3 20.5h18"></path><path d="M5 20.5V7.5h14v13"></path><path d="M8.5 11h3"></path><path d="M15 11h1.5"></path><path d="M8.5 15h3"></path><path d="M15 15h1.5"></path><path d="M9 7.5V4.5h6v3"></path>',
			),
			'housepin' => array(
				'label' => __( 'יח"ד במתחם', 'metadoc' ),
				'path'  => '<path d="M4 20V8l8-4 8 4v12"></path><path d="M4 20h16"></path><path d="M9.5 20v-5h5v5"></path><circle cx="12" cy="10" r="1.6"></circle>',
			),
		);
	}

	/**
	 * סכמת השדות, מקובצת לפי מקטעי העמוד.
	 * type: text | textarea | media | icon
	 *
	 * @return array<string,array{title:string,fields:array<string,array>}>
	 */
	public static function schema(): array {
		static $cache = null;
		if ( null !== $cache ) {
			return $cache;
		}
		$icons = array_keys( self::fact_icons() );

		$facts = array(
			array( '12,400', 'דונם — שטח התכנית', 'parcel' ),
			array( '70,000', 'יח"ד מגורים', 'skyline' ),
			array( '1,800,000', 'מ"ר תעסוקה ומסחר', 'offices' ),
			array( '1,400', 'דונם שטחים פתוחים', 'tree' ),
			array( '1,000', 'חדרי מלונאות', 'hotel' ),
			array( '46,000', 'יח"ד במתחם 2.4 — שלנו', 'housepin' ),
		);
		$fact_fields = array();
		foreach ( $facts as $i => $fact ) {
			$n = $i + 1;
			/* translators: %d: מספר הכרטיס. */
			$fact_fields[ "s2_fact{$n}_num" ]   = array( 'label' => sprintf( __( 'כרטיס %d — מספר', 'metadoc' ), $n ), 'default' => $fact[0] );
			$fact_fields[ "s2_fact{$n}_label" ] = array( 'label' => sprintf( __( 'כרטיס %d — תיאור', 'metadoc' ), $n ), 'default' => $fact[1] );
			$fact_fields[ "s2_fact{$n}_icon" ]  = array( 'label' => sprintf( __( 'כרטיס %d — אייקון', 'metadoc' ), $n ), 'default' => $fact[2], 'type' => 'icon', 'options' => $icons );
		}

		$scen = array();
		$tabs = array(
			1 => array(
				'label' => 'אקזיט לפני בנייה',
				'note'  => 'מכירת הקרקע ברגע שהזכויות מאושרות — בלי לבנות.',
				'foot'  => 'הרווח מחושב בניכוי עלות הקרקע והיטל ההשבחה.',
				'cards' => array(
					array( 'שמרני', '6 קומות · 100 מ"ר', 'רווח פוטנציאלי', '400,000 ₪', '×2 על ההשקעה', '67%', 'שווי קרקע בהיתר', '900,000 ₪', 'היטל השבחה', '300,000 ₪', 'השקעה', '199,000 ₪' ),
					array( 'לפי שמאות תקן 22', '10 קומות · 167 מ"ר', 'רווח פוטנציאלי', '600,000 ₪', '×3 על ההשקעה', '100%', 'שווי קרקע בהיתר', '1,200,000 ₪', 'היטל השבחה', '500,000 ₪', 'השקעה', '199,000 ₪' ),
				),
			),
			2 => array(
				'label' => 'אקזיט לאחר בנייה',
				'note'  => 'בונים ומוכרים דירה גמורה. הרווח נטו, אחרי כל ההוצאות.',
				'foot'  => 'ההוצאות כוללות קרקע, בנייה והיטל השבחה.',
				'cards' => array(
					array( '6 קומות', 'מימוש דירה בנויה', 'רווח נטו', '600,000 ₪', '+43% על ההוצאה הכוללת', '53%', 'שווי דירה', '2,000,000 ₪', 'הוצאות כוללות', '1,400,000 ₪', 'מתוכן קרקע', '199,000 ₪' ),
					array( '10 קומות', 'מימוש דירה בנויה', 'רווח נטו', '1,137,000 ₪', '+52% על ההוצאה הכוללת', '100%', 'שווי דירה', '3,340,000 ₪', 'הוצאות כוללות', '2,203,000 ₪', 'מתוכן קרקע', '199,000 ₪' ),
				),
			),
		);
		foreach ( $tabs as $t => $tab ) {
			$scen[ "s4_tab{$t}_label" ] = array( 'label' => sprintf( __( 'לשונית %d — שם', 'metadoc' ), $t ), 'default' => $tab['label'] );
			$scen[ "s4_tab{$t}_note" ]  = array( 'label' => sprintf( __( 'לשונית %d — משפט מקדים', 'metadoc' ), $t ), 'default' => $tab['note'] );
			$scen[ "s4_tab{$t}_foot" ]  = array( 'label' => sprintf( __( 'לשונית %d — הערת שוליים', 'metadoc' ), $t ), 'default' => $tab['foot'] );
			foreach ( $tab['cards'] as $c => $card ) {
				$n    = $c + 1;
				$base = "s4_tab{$t}_card{$n}_";
				/* translators: 1: מספר הלשונית, 2: מספר הכרטיס. */
				$pre  = sprintf( __( 'לשונית %1$d · כרטיס %2$d — ', 'metadoc' ), $t, $n );
				$keys = array( 'name' => 'שם', 'spec' => 'תת-כותרת', 'klbl' => 'תווית הרווח', 'profit' => 'סכום הרווח', 'mult' => 'תגית מכפיל', 'w' => 'רוחב הפס (%)', 'k1' => 'שורה 1 — תווית', 'v1' => 'שורה 1 — ערך', 'k2' => 'שורה 2 — תווית', 'v2' => 'שורה 2 — ערך', 'k3' => 'שורה 3 — תווית', 'v3' => 'שורה 3 — ערך' );
				$i = 0;
				foreach ( $keys as $k => $lbl ) {
					$scen[ $base . $k ] = array( 'label' => $pre . $lbl, 'default' => $card[ $i ] );
					++$i;
				}
			}
		}

		$cache = array(
			'hero' => array(
				'title'  => __( 'ראש העמוד', 'metadoc' ),
				'fields' => array(
					'hero_eyebrow'     => array( 'label' => __( 'תווית עליונה', 'metadoc' ), 'default' => 'הזדמנות קרקע · תמ"א 75' ),
					'hero_sub'         => array( 'label' => __( 'תת-כותרת (מיקום)', 'metadoc' ), 'default' => 'קריית בנימין, קריית אתא' ),
					'hero_image'       => array( 'label' => __( 'תמונת ראש העמוד', 'metadoc' ), 'type' => 'media' ),
					'hero_stat1_num'   => array( 'label' => __( 'נתון 1 — ערך', 'metadoc' ), 'default' => '199,000 ₪' ),
					'hero_stat1_label' => array( 'label' => __( 'נתון 1 — תיאור', 'metadoc' ), 'default' => 'מחיר כניסה' ),
					'hero_stat2_num'   => array( 'label' => __( 'נתון 2 — ערך', 'metadoc' ), 'default' => 'עד 28' ),
					'hero_stat2_label' => array( 'label' => __( 'נתון 2 — תיאור', 'metadoc' ), 'default' => 'קומות · מתחם מגדלים' ),
					'hero_stat3_num'   => array( 'label' => __( 'נתון 3 — ערך', 'metadoc' ), 'default' => 'מתחם 2.4' ),
					'hero_stat3_label' => array( 'label' => __( 'נתון 3 — תיאור', 'metadoc' ), 'default' => 'מרקם עירוני חדש' ),
					'wa_text'          => array( 'label' => __( 'הודעת וואטסאפ פותחת', 'metadoc' ), 'default' => 'היי, מעניין אותי פרויקט שער המפרץ' ),
				),
			),
			's1' => array(
				'title'  => __( '01 · תמצית העסקה', 'metadoc' ),
				'fields' => array(
					's1_eyebrow'   => array( 'label' => __( 'תווית', 'metadoc' ), 'default' => '01 / תמצית העסקה' ),
					's1_title'     => array( 'label' => __( 'כותרת', 'metadoc' ), 'default' => 'כניסה מוקדמת,' ),
					's1_title_acc' => array( 'label' => __( 'כותרת — החלק הכתום', 'metadoc' ), 'default' => 'לפני נעילת הזכויות.' ),
					's1_lead'      => array( 'label' => __( 'פסקה', 'metadoc' ), 'type' => 'textarea', 'default' => 'קרקע במזרח שכונת קריית בנימין, צמודת דופן לרקמה הבנויה — בתוך מתחם 2.4 של תמ"א 75, המיועד למרקם עירוני חדש.' ),
					's1_row1_k'    => array( 'label' => __( 'שורה 1 — תווית', 'metadoc' ), 'default' => 'מיקום' ),
					's1_row1_v'    => array( 'label' => __( 'שורה 1 — ערך', 'metadoc' ), 'default' => 'קריית אתא, מזרח שכונת קריית בנימין, צמוד לרקמה הבנויה' ),
					's1_row2_k'    => array( 'label' => __( 'שורה 2 — תווית', 'metadoc' ), 'default' => 'מחיר כניסה' ),
					's1_row2_v'    => array( 'label' => __( 'שורה 2 — ערך', 'metadoc' ), 'default' => '199,000 ₪ בלבד' ),
					's1_row3_k'    => array( 'label' => __( 'שורה 3 — תווית', 'metadoc' ), 'default' => 'עיתוי' ),
					's1_row3_v'    => array( 'label' => __( 'שורה 3 — ערך', 'metadoc' ), 'default' => 'לפני נעילת הזכויות' ),
					's1_image'     => array( 'label' => __( 'תמונה (הדמיית בינוי)', 'metadoc' ), 'type' => 'media' ),
					's1_caption'   => array( 'label' => __( 'כיתוב התמונה', 'metadoc' ), 'default' => 'הדמיית הבינוי המתוכנן — מיקום החלקה מסומן בחץ.' ),
				),
			),
			's2' => array(
				'title'  => __( '02 · המצב התכנוני', 'metadoc' ),
				'fields' => array_merge(
					array(
						's2_eyebrow' => array( 'label' => __( 'תווית', 'metadoc' ), 'default' => '02 / המצב התכנוני' ),
						's2_title'   => array( 'label' => __( 'כותרת', 'metadoc' ), 'default' => 'תמ"א 75 "שער המפרץ"' ),
						's2_sub'     => array( 'label' => __( 'משפט לצד הכותרת', 'metadoc' ), 'type' => 'textarea', 'default' => 'תכנית מסגרת ארצית שמייצרת מרקם עירוני חדש בין חיפה, נשר וקריית אתא.' ),
					),
					$fact_fields,
					array(
						's2_edge_label' => array( 'label' => __( 'בלוק היתרון — תווית', 'metadoc' ), 'default' => 'היתרון של החלקה שלנו' ),
						's2_edge_title' => array( 'label' => __( 'בלוק היתרון — כותרת', 'metadoc' ), 'type' => 'textarea', 'default' => 'צמודת דופן לבנייה הקיימת — ולכן הבנייה במתחם צפויה להתחיל דווקא כאן.' ),
						's2_edge_body'  => array( 'label' => __( 'בלוק היתרון — טקסט', 'metadoc' ), 'type' => 'textarea', 'default' => 'מתחם 2.4 משתרע על 5,200 דונם וכולל כ-46,000 יח"ד מתוכננות. הפיתוח במתחמים כאלה מתקדם מהרקמה הבנויה החוצה, כשהתשתיות כבר קיימות בקצה — והחלקה שלנו יושבת בדיוק על הקו הזה.' ),
					)
				),
			),
			's3' => array(
				'title'  => __( '03 · מאפייני הבינוי', 'metadoc' ),
				'fields' => array(
					's3_eyebrow'    => array( 'label' => __( 'תווית', 'metadoc' ), 'default' => '03 / מאפייני הבינוי' ),
					's3_title'      => array( 'label' => __( 'כותרת', 'metadoc' ), 'default' => 'איפה עומדת' ),
					's3_title_acc'  => array( 'label' => __( 'כותרת — החלק הכתום', 'metadoc' ), 'default' => 'החלקה שלנו.' ),
					's3_image'      => array( 'label' => __( 'תמונה (מפת גבהים)', 'metadoc' ), 'type' => 'media' ),
					's3_caption'    => array( 'label' => __( 'כיתוב התמונה', 'metadoc' ), 'default' => 'תבנית הבנייה באזור — החלקה על ציר שד\' הקישון, בקטגוריית המגדלים.' ),
					's3_b1_title'   => array( 'label' => __( 'נקודה 1 — כותרת', 'metadoc' ), 'default' => 'על ציר שד\' הקישון החדש' ),
					's3_b1_body'    => array( 'label' => __( 'נקודה 1 — טקסט', 'metadoc' ), 'type' => 'textarea', 'default' => 'הציר המחבר את חיפה, נשר וקריית אתא לפארק המטרופוליני.' ),
					's3_b2_title'   => array( 'label' => __( 'נקודה 2 — כותרת', 'metadoc' ), 'default' => 'מעורב שימושים, עד 28 קומות' ),
					's3_b2_body'    => array( 'label' => __( 'נקודה 2 — טקסט', 'metadoc' ), 'type' => 'textarea', 'default' => 'מגורים ומסחר במתחם מגדלים.' ),
					's3_mix_title'  => array( 'label' => __( 'תמהיל — כותרת', 'metadoc' ), 'default' => 'תמהיל דירות מתוכנן' ),
					's3_mix1_label' => array( 'label' => __( 'תמהיל 1 — תיאור', 'metadoc' ), 'default' => 'דירות קטנות · 55–80 מ"ר' ),
					's3_mix1_pct'   => array( 'label' => __( 'תמהיל 1 — אחוז', 'metadoc' ), 'default' => '20%' ),
					's3_mix2_label' => array( 'label' => __( 'תמהיל 2 — תיאור', 'metadoc' ), 'default' => 'דירות רגילות · 80–110 מ"ר' ),
					's3_mix2_pct'   => array( 'label' => __( 'תמהיל 2 — אחוז', 'metadoc' ), 'default' => '60%' ),
					's3_mix3_label' => array( 'label' => __( 'תמהיל 3 — תיאור', 'metadoc' ), 'default' => 'דירות גדולות · מעל 110 מ"ר' ),
					's3_mix3_pct'   => array( 'label' => __( 'תמהיל 3 — אחוז', 'metadoc' ), 'default' => '20%' ),
					's3_mix_note'   => array( 'label' => __( 'תמהיל — הערה', 'metadoc' ), 'default' => 'ממוצע יח"ד: 95 מ"ר' ),
				),
			),
			's4' => array(
				'title'  => __( '04 · תרחישי רווח', 'metadoc' ),
				'fields' => array_merge(
					array(
						's4_eyebrow'   => array( 'label' => __( 'תווית', 'metadoc' ), 'default' => '04 / תרחישי רווח' ),
						's4_title'     => array( 'label' => __( 'כותרת', 'metadoc' ), 'default' => 'מה קורה ל-199,000 ₪' ),
						's4_title_acc' => array( 'label' => __( 'כותרת — החלק הכתום', 'metadoc' ), 'default' => 'שנכנסים היום.' ),
						's4_sub'       => array( 'label' => __( 'תת-כותרת', 'metadoc' ), 'type' => 'textarea', 'default' => 'שתי דרכי מימוש, לפי היקף הבנייה שיאושר בפועל.' ),
					),
					$scen
				),
			),
			's5' => array(
				'title'  => __( '05 · קריאה לפעולה ופוטר', 'metadoc' ),
				'fields' => array(
					's5_title'     => array( 'label' => __( 'כותרת', 'metadoc' ), 'default' => 'מבינים את הפוטנציאל?' ),
					's5_title_acc' => array( 'label' => __( 'כותרת — החלק הכתום', 'metadoc' ), 'default' => 'בואו להיות חלק מההצלחה.' ),
					's5_body'      => array( 'label' => __( 'פסקה', 'metadoc' ), 'type' => 'textarea', 'default' => 'השאירו טלפון ומייל, נקבע פגישה ונעבור יחד על התיק המלא — נסח החלקה, המצב התכנוני ולוחות הזמנים למימוש.' ),
					'foot_label'   => array( 'label' => __( 'פוטר — תווית', 'metadoc' ), 'default' => 'הבהרה משפטית' ),
					'foot_text'    => array( 'label' => __( 'פוטר — הבהרה משפטית', 'metadoc' ), 'type' => 'textarea', 'default' => 'המידע מבוסס על נתוני תמ"א 75, מנהל התכנון ומסמכי אדריכלים. המסמך מהווה חומר שיווקי/פנימי ואינו שומת מקרקעין, ייעוץ השקעות או הבטחה לתשואה.' ),
				),
			),
			'card' => array(
				'title'  => __( 'כרטיס הפרויקט בעמוד המחלקה', 'metadoc' ),
				'fields' => array(
					'card_tag'      => array( 'label' => __( 'תגית (פינה ימנית)', 'metadoc' ), 'default' => 'קרקע למכירה' ),
					'card_status'   => array( 'label' => __( 'סטטוס (פינה שמאלית)', 'metadoc' ), 'default' => 'בשיווק' ),
					'card_loc'      => array( 'label' => __( 'מיקום', 'metadoc' ), 'default' => 'קריית אתא · מתחם 2.4' ),
					'card_spec1_k'  => array( 'label' => __( 'נתון 1 — תווית', 'metadoc' ), 'default' => 'מחיר כניסה' ),
					'card_spec1_v'  => array( 'label' => __( 'נתון 1 — ערך', 'metadoc' ), 'default' => '199,000 ₪' ),
					'card_spec2_k'  => array( 'label' => __( 'נתון 2 — תווית', 'metadoc' ), 'default' => 'סטטוס תכנוני' ),
					'card_spec2_v'  => array( 'label' => __( 'נתון 2 — ערך', 'metadoc' ), 'default' => 'תמ"א 75' ),
					'card_spec3_k'  => array( 'label' => __( 'נתון 3 — תווית', 'metadoc' ), 'default' => 'קומות' ),
					'card_spec3_v'  => array( 'label' => __( 'נתון 3 — ערך', 'metadoc' ), 'default' => 'עד 28' ),
				),
			),
		);

		return $cache;
	}

	/**
	 * מחזיר את כל השדות כמפה שטוחה key => הגדרה.
	 *
	 * @return array<string,array>
	 */
	public static function flat_fields(): array {
		static $flat = null;
		if ( null !== $flat ) {
			return $flat;
		}
		$flat = array();
		foreach ( self::schema() as $group ) {
			foreach ( $group['fields'] as $key => $field ) {
				$flat[ $key ] = $field;
			}
		}
		return $flat;
	}

	/* --------------------------------------------------------------------
	 * מסכי הניהול
	 * ----------------------------------------------------------------- */

	/**
	 * תפריט ניהול ייעודי למחלקת הנדל"ן.
	 */
	public static function admin_menu(): void {
		add_menu_page(
			__( 'מחלקת נדל"ן', 'metadoc' ),
			__( 'מחלקת נדל"ן', 'metadoc' ),
			'edit_posts',
			'metadoc-realestate',
			array( __CLASS__, 'render_dashboard' ),
			'dashicons-building',
			26
		);
		add_submenu_page( 'metadoc-realestate', __( 'סקירה', 'metadoc' ), __( 'סקירה', 'metadoc' ), 'edit_posts', 'metadoc-realestate', array( __CLASS__, 'render_dashboard' ) );
		add_submenu_page( 'metadoc-realestate', __( 'פרויקטים', 'metadoc' ), __( 'פרויקטים', 'metadoc' ), 'edit_posts', 'edit.php?post_type=' . self::CPT );
		add_submenu_page( 'metadoc-realestate', __( 'פרויקט חדש', 'metadoc' ), __( 'פרויקט חדש', 'metadoc' ), 'edit_posts', 'post-new.php?post_type=' . self::CPT );
		add_submenu_page( 'metadoc-realestate', __( 'לידים', 'metadoc' ), __( 'לידים', 'metadoc' ), 'edit_posts', 'edit.php?post_type=md_lead' );
	}

	/**
	 * שמירה על הדגשת התפריט "מחלקת נדל\"ן" במסכי הפרויקטים והלידים.
	 *
	 * @param string $parent הורה נוכחי.
	 * @return string
	 */
	public static function menu_parent( $parent ) {
		global $typenow;
		if ( in_array( (string) $typenow, array( self::CPT, 'md_lead' ), true ) ) {
			return 'metadoc-realestate';
		}
		return $parent;
	}

	/**
	 * רענון כללי ה-Permalink אחרי רישום סוג התוכן (חד-פעמי).
	 */
	public static function flush_rewrites(): void {
		self::register_cpt();
		flush_rewrite_rules();
		update_option( 'metadoc_projects_rewrites_v1', '1' );
	}

	/**
	 * רענון חד-פעמי גם בהתקנות קיימות.
	 */
	public static function maybe_flush_rewrites(): void {
		if ( '1' === get_option( 'metadoc_projects_rewrites_v1' ) ) {
			return;
		}
		self::flush_rewrites();
	}

	/**
	 * מסך הסקירה — קישורים מהירים וסטטוס תוכן.
	 */
	public static function render_dashboard(): void {
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		$dept    = Metadoc_RealEstate::page_url( Metadoc_RealEstate::TPL_DEPT );
		$count   = (int) wp_count_posts( self::CPT )->publish;
		$leads   = (int) wp_count_posts( 'md_lead' )->private;
		$slots   = Metadoc_RealEstate::image_slots();
		$missing = 0;
		foreach ( $slots as $key => $slot ) {
			if ( '' === (string) $slot['file'] && ! get_theme_mod( 'metadoc_re_img_' . $key, 0 ) ) {
				++$missing;
			}
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'מחלקת נדל"ן — ניהול תוכן', 'metadoc' ); ?></h1>
			<p class="description" style="max-width:70em"><?php esc_html_e( 'כל התוכן של עמוד המחלקה ועמודי הפרויקטים במקום אחד. כל פרויקט חדש מקבל עמוד משלו בתבנית של "שער המפרץ", ומופיע אוטומטית ברשימת הפרויקטים בעמוד המחלקה.', 'metadoc' ); ?></p>

			<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-top:20px;max-width:1100px">
				<div class="card" style="padding:16px">
					<h2 style="margin-top:0"><?php esc_html_e( 'פרויקטים', 'metadoc' ); ?></h2>
					<p style="font-size:32px;font-weight:700;margin:0 0 8px"><?php echo esc_html( (string) $count ); ?></p>
					<p><a class="button button-primary" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=' . self::CPT ) ); ?>"><?php esc_html_e( 'הוספת פרויקט', 'metadoc' ); ?></a>
					<a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=' . self::CPT ) ); ?>"><?php esc_html_e( 'לכל הפרויקטים', 'metadoc' ); ?></a></p>
				</div>
				<div class="card" style="padding:16px">
					<h2 style="margin-top:0"><?php esc_html_e( 'לידים', 'metadoc' ); ?></h2>
					<p style="font-size:32px;font-weight:700;margin:0 0 8px"><?php echo esc_html( (string) $leads ); ?></p>
					<p><a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=md_lead' ) ); ?>"><?php esc_html_e( 'לכל הפניות', 'metadoc' ); ?></a></p>
				</div>
				<div class="card" style="padding:16px">
					<h2 style="margin-top:0"><?php esc_html_e( 'תמונות העמודים', 'metadoc' ); ?></h2>
					<p style="margin:0 0 8px">
						<?php
						if ( $missing > 0 ) {
							/* translators: %d: מספר החריצים החסרים. */
							printf( esc_html__( 'חסרות %d תמונות — מוצג מציין-מקום.', 'metadoc' ), (int) $missing );
						} else {
							esc_html_e( 'כל התמונות הוגדרו.', 'metadoc' );
						}
						?>
					</p>
					<p><a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=metadoc-re-images' ) ); ?>"><?php esc_html_e( 'ניהול התמונות', 'metadoc' ); ?></a></p>
				</div>
			</div>

			<h2 style="margin-top:28px"><?php esc_html_e( 'עמודי המחלקה', 'metadoc' ); ?></h2>
			<p>
				<?php if ( '' !== $dept ) : ?>
					<a class="button" href="<?php echo esc_url( $dept ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'צפייה בעמוד המחלקה', 'metadoc' ); ?></a>
				<?php endif; ?>
				<a class="button" href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>"><?php esc_html_e( 'כל העמודים', 'metadoc' ); ?></a>
				<a class="button" href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'טלפון, כתובת ושעות מענה', 'metadoc' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * טעינת סקריפט בורר המדיה במסך עריכת פרויקט.
	 *
	 * @param string $hook מזהה המסך.
	 */
	public static function admin_assets( string $hook ): void {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			return;
		}
		if ( self::CPT !== get_post_type() ) {
			return;
		}
		wp_enqueue_media();
		wp_enqueue_script(
			'metadoc-admin-projects',
			METADOC_URI . '/assets/js/admin-projects.js',
			array( 'jquery', 'media-editor' ),
			metadoc_asset_ver( 'assets/js/admin-projects.js' ),
			true
		);
	}

	/**
	 * תיבות העריכה.
	 */
	public static function meta_boxes(): void {
		foreach ( self::schema() as $id => $group ) {
			add_meta_box(
				'metadoc_pr_' . $id,
				$group['title'],
				array( __CLASS__, 'render_box' ),
				self::CPT,
				'normal',
				'default',
				array( 'group' => $id )
			);
		}
	}

	/**
	 * רינדור תיבת עריכה.
	 *
	 * @param WP_Post $post הפוסט.
	 * @param array   $box  ארגומנטים.
	 */
	public static function render_box( WP_Post $post, array $box ): void {
		$schema = self::schema();
		$group  = $box['args']['group'] ?? '';
		if ( ! isset( $schema[ $group ] ) ) {
			return;
		}
		wp_nonce_field( self::NONCE, self::NONCE . '_nonce' );
		echo '<table class="form-table" role="presentation"><tbody>';
		foreach ( $schema[ $group ]['fields'] as $key => $field ) {
			$type  = $field['type'] ?? 'text';
			$value = get_post_meta( $post->ID, self::PREFIX . $key, true );
			if ( '' === $value && ! metadoc_project_is_saved( $post->ID ) ) {
				$value = (string) ( $field['default'] ?? '' );
			}
			printf( '<tr><th scope="row"><label for="%1$s">%2$s</label></th><td>', esc_attr( 'md_pr_' . $key ), esc_html( $field['label'] ) );
			if ( 'textarea' === $type ) {
				printf(
					'<textarea id="%1$s" name="%1$s" rows="3" class="large-text">%2$s</textarea>',
					esc_attr( 'md_pr_' . $key ),
					esc_textarea( (string) $value )
				);
			} elseif ( 'media' === $type ) {
				$id  = (int) $value;
				$img = $id ? wp_get_attachment_image( $id, 'medium', false, array( 'style' => 'max-width:180px;height:auto;display:block' ) ) : '';
				printf(
					'<div class="md-pr-media"><div class="md-pr-thumb">%1$s</div><input type="hidden" id="%2$s" name="%2$s" value="%3$d"><p><button type="button" class="button md-pr-pick" data-title="%4$s" data-choose="%8$s">%5$s</button> <button type="button" class="button-link md-pr-clear" style="%6$s">%7$s</button></p></div>',
					$img, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- פלט ליבה מאובטח.
					esc_attr( 'md_pr_' . $key ),
					$id,
					esc_attr( $field['label'] ),
					esc_html__( 'בחירת תמונה', 'metadoc' ),
					$id ? '' : 'display:none',
					esc_html__( 'הסרה', 'metadoc' ),
					esc_attr__( 'בחירה', 'metadoc' )
				);
			} elseif ( 'icon' === $type ) {
				$icons = self::fact_icons();
				printf( '<select id="%1$s" name="%1$s">', esc_attr( 'md_pr_' . $key ) );
				foreach ( $icons as $icon_key => $icon ) {
					printf(
						'<option value="%1$s"%2$s>%3$s</option>',
						esc_attr( $icon_key ),
						selected( (string) $value, $icon_key, false ),
						esc_html( $icon['label'] )
					);
				}
				echo '</select>';
			} else {
				printf(
					'<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text">',
					esc_attr( 'md_pr_' . $key ),
					esc_attr( (string) $value )
				);
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	/**
	 * שמירה — Nonce, הרשאות וסניטציה לפי סוג השדה.
	 *
	 * @param int     $post_id מזהה הפוסט.
	 * @param WP_Post $post    הפוסט.
	 */
	public static function save( int $post_id, WP_Post $post ): void {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		$nonce = isset( $_POST[ self::NONCE . '_nonce' ] ) ? sanitize_text_field( wp_unslash( (string) $_POST[ self::NONCE . '_nonce' ] ) ) : '';
		if ( '' === $nonce || ! wp_verify_nonce( $nonce, self::NONCE ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		foreach ( self::flat_fields() as $key => $field ) {
			$name = 'md_pr_' . $key;
			if ( ! isset( $_POST[ $name ] ) ) {
				continue;
			}
			$type = $field['type'] ?? 'text';
			$raw  = wp_unslash( $_POST[ $name ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- מסונן מיד לפי סוג.
			if ( is_array( $raw ) ) {
				continue; // כל השדות סקלריים; מערך הוא קלט זדוני.
			}
			if ( 'media' === $type ) {
				$value = (string) absint( $raw );
				$value = '0' === $value ? '' : $value;
			} elseif ( 'textarea' === $type ) {
				$value = sanitize_textarea_field( (string) $raw );
			} elseif ( 'icon' === $type ) {
				$options = array_keys( self::fact_icons() );
				$value   = in_array( (string) $raw, $options, true ) ? (string) $raw : (string) ( $field['default'] ?? '' );
			} else {
				$value = sanitize_text_field( (string) $raw );
			}
			update_post_meta( $post_id, self::PREFIX . $key, $value );
		}
		update_post_meta( $post_id, '_md_pr_saved', '1' );
		unset( $post );
	}

	/**
	 * עמודות ברשימת הפרויקטים.
	 *
	 * @param array $cols עמודות.
	 * @return array
	 */
	public static function columns( array $cols ): array {
		$new = array(
			'cb'         => $cols['cb'] ?? '',
			'title'      => __( 'פרויקט', 'metadoc' ),
			'md_loc'     => __( 'מיקום', 'metadoc' ),
			'md_status'  => __( 'סטטוס', 'metadoc' ),
			'md_price'   => __( 'מחיר כניסה', 'metadoc' ),
			'date'       => __( 'תאריך', 'metadoc' ),
		);
		return $new;
	}

	/**
	 * תוכן עמודה.
	 *
	 * @param string $column  מזהה עמודה.
	 * @param int    $post_id מזהה הפוסט.
	 */
	public static function column( string $column, int $post_id ): void {
		$map = array(
			'md_loc'    => 'card_loc',
			'md_status' => 'card_status',
			'md_price'  => 'hero_stat1_num',
		);
		if ( isset( $map[ $column ] ) ) {
			echo esc_html( metadoc_project_field( $map[ $column ], $post_id ) );
		}
	}

	/**
	 * מחזיר את הפרויקטים המפורסמים, לתצוגה בעמוד המחלקה.
	 *
	 * @param int $limit מספר מרבי.
	 * @return int[] מזהי פוסטים.
	 */
	public static function published( int $limit = 3 ): array {
		return get_posts(
			array(
				'post_type'      => self::CPT,
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'fields'         => 'ids',
				'no_found_rows'  => true,
				'orderby'        => 'menu_order date',
				'order'          => 'DESC',
			)
		);
	}
}

Metadoc_Projects::init();

/**
 * האם הפרויקט כבר נשמר פעם אחת (ולכן ערכים ריקים הם בחירה מכוונת).
 *
 * @param int $post_id מזהה הפוסט.
 * @return bool
 */
function metadoc_project_is_saved( int $post_id ): bool {
	return '1' === (string) get_post_meta( $post_id, '_md_pr_saved', true );
}

/**
 * מחזיר ערך שדה של פרויקט, עם נפילה לברירת המחדל (תוכן "שער המפרץ").
 *
 * @param string   $key     מפתח השדה.
 * @param int|null $post_id מזהה הפרויקט; ברירת מחדל — הפוסט הנוכחי.
 * @return string
 */
function metadoc_project_field( string $key, ?int $post_id = null ): string {
	$fields = Metadoc_Projects::flat_fields();
	$field  = $fields[ $key ] ?? array();
	$id     = $post_id ?? ( is_singular( Metadoc_Projects::CPT ) ? (int) get_the_ID() : 0 );

	if ( $id > 0 ) {
		$value = (string) get_post_meta( $id, '_md_pr_' . $key, true );
		if ( '' !== $value || metadoc_project_is_saved( $id ) ) {
			return $value;
		}
	}
	return (string) ( $field['default'] ?? '' );
}

/**
 * הדפסת ערך שדה של פרויקט.
 *
 * @param string $key מפתח השדה.
 */
function metadoc_project_the( string $key ): void {
	echo esc_html( metadoc_project_field( $key ) );
}

/**
 * מדפיס תמונה של פרויקט: קודם התמונה שהוגדרה ברשומת הפרויקט,
 * אחרת חריץ התמונה הגלובלי (התאמה אישית), אחרת מציין-מקום.
 *
 * @param string $key  מפתח שדה המדיה ברשומת הפרויקט.
 * @param string $slot מפתח חריץ התמונה הגלובלי.
 * @param string $alt  טקסט חלופי.
 * @param string $ph   טקסט מציין-המקום.
 * @param array  $args sizes, dark, eager.
 */
function metadoc_project_image( string $key, string $slot, string $alt, string $ph = '', array $args = array() ): void {
	$id = (int) metadoc_project_field( $key );
	if ( $id > 0 && wp_attachment_is_image( $id ) ) {
		echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- פלט ליבה מאובטח.
			$id,
			'full',
			false,
			array(
				'alt'           => $alt,
				'loading'       => empty( $args['eager'] ) ? 'lazy' : 'eager',
				'decoding'      => 'async',
				'sizes'         => isset( $args['sizes'] ) ? (string) $args['sizes'] : '100vw',
				'fetchpriority' => empty( $args['eager'] ) ? 'auto' : 'high',
			)
		);
		return;
	}
	metadoc_re_image( $slot, $alt, $ph, $args );
}

<?php
/**
 * מחלקת נדל"ן — שאלות נפוצות (אקורדיון נגיש, פתיחה יחידה).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$faqs = array(
	array(
		__( 'האם השירות מתאים גם למשקיעים מתחילים?', 'metadoc' ),
		__( 'בהחלט. אנו מלווים גם משקיעים ראשונים — מאפיינים יחד את סוג ההשקעה המתאים לכם, לתקציב וליעדים שלכם, ומלווים אתכם צעד אחר צעד עד לסגירת העסקה.', 'metadoc' ),
	),
	array(
		__( 'כמה עולה הליווי?', 'metadoc' ),
		__( 'שיחת הייעוץ הראשונית חינם וללא התחייבות. מודל התשלום נקבע בהתאם לסוג העסקה והיקף הליווי, ומוצג בשקיפות מלאה מראש.', 'metadoc' ),
	),
	array(
		__( 'אילו בדיקות אתם מבצעים לפני עסקה?', 'metadoc' ),
		__( 'בדיקות משפטיות מקיפות, בדיקות שמאות, בחינת כדאיות כלכלית וניתוח סיכונים — כדי שתיכנסו לעסקה בעיניים פקוחות.', 'metadoc' ),
	),
	array(
		__( 'האם אתם מסייעים גם במימון העסקה?', 'metadoc' ),
		__( 'כן. אנו בוחנים אפשרויות מימון בנקאיות וחוץ־בנקאיות, מלווים מול הבנקים ומעניקים ייעוץ משכנתאות — ליצירת מעטפת מימון מותאמת אישית.', 'metadoc' ),
	),
	array(
		__( 'מה קורה אחרי שהעסקה נסגרת?', 'metadoc' ),
		__( 'על פי הצורך נפעל לשיפוץ והשבחת הנכס, ואף נספק טיפול שוטף בנכס לאחר ביצוע העסקה.', 'metadoc' ),
	),
);
?>
<section id="faq" class="md-re-faq">
	<div class="md-re-faq-grid">
		<div class="md-re-faq-head">
			<p class="md-re-eyebrow"><?php esc_html_e( '05 / שאלות נפוצות', 'metadoc' ); ?></p>
			<h2><?php esc_html_e( 'כל מה שרציתם', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'לשאול.', 'metadoc' ); ?></span></h2>
			<p><?php esc_html_e( 'לא מצאתם את התשובה? נשמח לענות בשיחה קצרה.', 'metadoc' ); ?></p>
			<a class="md-re-dark-pill" href="#contact">
				<span><?php esc_html_e( 'לשיחת ייעוץ', 'metadoc' ); ?></span>
				<span aria-hidden="true">←</span>
			</a>
		</div>
		<div class="md-re-faq-list" data-reveal data-md-faq>
			<?php foreach ( $faqs as $i => $faq ) : ?>
				<?php
				$open  = 0 === $i;
				$q_id  = 'md-re-faq-q-' . $i;
				$a_id  = 'md-re-faq-a-' . $i;
				?>
				<div class="md-re-faq-item">
					<h3 style="margin:0">
						<button type="button" class="md-re-faq-q" id="<?php echo esc_attr( $q_id ); ?>" aria-expanded="<?php echo $open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $a_id ); ?>">
							<span><?php echo esc_html( $faq[0] ); ?></span>
							<span class="md-re-faq-mark" aria-hidden="true"><?php echo $open ? '−' : '+'; ?></span>
						</button>
					</h3>
					<div class="md-re-faq-a" id="<?php echo esc_attr( $a_id ); ?>" role="region" aria-labelledby="<?php echo esc_attr( $q_id ); ?>" <?php echo $open ? '' : 'hidden'; ?>>
						<?php echo esc_html( $faq[1] ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

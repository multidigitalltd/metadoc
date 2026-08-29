<?php
/**
 * אישור מדיניות פרטיות לטפסי מחלקת הנדל"ן (חובה, נבדק גם בצד השרת).
 * $args: id (ייחוד מזהה), dark (על רקע כהה), compact (טקסט מקוצר לסרגל).
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$re_id      = isset( $args['id'] ) ? (string) $args['id'] : 'form';
$re_dark    = ! empty( $args['dark'] );
$re_compact = ! empty( $args['compact'] );
$re_privacy = metadoc_privacy_url();
$re_field   = 'md-re-consent-' . $re_id;
?>
<div class="<?php echo $re_compact ? 'md-pr-fab-consent' : 'md-re-consent ' . ( $re_dark ? 'md-re-consent--dark' : 'md-re-consent--light' ); ?>">
	<input type="checkbox" class="md-consent" id="<?php echo esc_attr( $re_field ); ?>" name="consent" value="1" required
		<?php echo $re_compact ? 'aria-label="' . esc_attr__( 'אני מאשר/ת את מדיניות הפרטיות', 'metadoc' ) . '"' : ''; ?>>
	<label for="<?php echo esc_attr( $re_field ); ?>">
		<?php if ( $re_compact ) : ?>
			<span><?php esc_html_e( 'מאשר/ת', 'metadoc' ); ?>
				<a href="<?php echo esc_url( $re_privacy ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'מדיניות פרטיות', 'metadoc' ); ?></a>
			</span>
		<?php else : ?>
			<?php esc_html_e( 'אני מאשר/ת קבלת פנייה חוזרת ואת', 'metadoc' ); ?>
			<a href="<?php echo esc_url( $re_privacy ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'מדיניות הפרטיות', 'metadoc' ); ?></a>
		<?php endif; ?>
	</label>
</div>

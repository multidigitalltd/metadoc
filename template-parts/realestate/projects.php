<?php
/**
 * מחלקת נדל"ן — פרויקטים וקרקעות.
 *
 * התוכן כאן הוא ממלא-מקום עד לקבלת נתוני הפרויקטים האמיתיים.
 * ניתן להזרים נתונים אמיתיים דרך הפילטר metadoc_re_projects.
 *
 * @package Metadoc
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// פרויקטים אמיתיים מסוג התוכן md_project; אם אין — ממלאי-מקום לעריכה.
$projects = array();
foreach ( Metadoc_Projects::published( 3 ) as $pid ) {
	$projects[] = array(
		'id'     => $pid,
		'tag'    => metadoc_project_field( 'card_tag', $pid ),
		'status' => metadoc_project_field( 'card_status', $pid ),
		'title'  => get_the_title( $pid ),
		'loc'    => metadoc_project_field( 'card_loc', $pid ),
		'specs'  => array(
			array( metadoc_project_field( 'card_spec1_k', $pid ), metadoc_project_field( 'card_spec1_v', $pid ) ),
			array( metadoc_project_field( 'card_spec2_k', $pid ), metadoc_project_field( 'card_spec2_v', $pid ) ),
			array( metadoc_project_field( 'card_spec3_k', $pid ), metadoc_project_field( 'card_spec3_v', $pid ) ),
		),
		'url'    => (string) get_permalink( $pid ),
	);
}

/**
 * כרטיסי הפרויקטים בעמוד המחלקה.
 *
 * @param array $projects רשימת פרויקטים (id|slot, tag, status, title, loc, specs, url).
 */
$projects = apply_filters(
	'metadoc_re_projects',
	! empty( $projects ) ? $projects : array(
		array(
			'slot'   => 'proj1',
			'tag'    => __( 'פרויקט מגורים', 'metadoc' ),
			'status' => __( 'בשיווק', 'metadoc' ),
			'title'  => __( 'שם הפרויקט', 'metadoc' ),
			'loc'    => __( 'מיקום · עיר', 'metadoc' ),
			'specs'  => array(
				array( __( 'יחידות', 'metadoc' ), __( '00 דירות', 'metadoc' ) ),
				array( __( 'תמהיל', 'metadoc' ), __( '3–5 חד׳', 'metadoc' ) ),
				array( __( 'אכלוס משוער', 'metadoc' ), '0000' ),
			),
			'url'    => '#contact',
		),
		array(
			'slot'   => 'proj2',
			'tag'    => __( 'קרקע למכירה', 'metadoc' ),
			'status' => __( 'הזדמנות', 'metadoc' ),
			'title'  => __( 'שם הקרקע / המיקום', 'metadoc' ),
			'loc'    => __( 'גוש · חלקה', 'metadoc' ),
			'specs'  => array(
				array( __( 'שטח', 'metadoc' ), __( '000 מ"ר', 'metadoc' ) ),
				array( __( 'סטטוס תכנוני', 'metadoc' ), __( 'לעדכון', 'metadoc' ) ),
				array( __( 'פוטנציאל השבחה', 'metadoc' ), __( 'לעדכון', 'metadoc' ) ),
			),
			'url'    => '#contact',
		),
		array(
			'slot'   => 'proj3',
			'tag'    => __( 'נכס מניב', 'metadoc' ),
			'status' => __( 'למכירה', 'metadoc' ),
			'title'  => __( 'שם הנכס', 'metadoc' ),
			'loc'    => __( 'אזור מסחרי · עיר', 'metadoc' ),
			'specs'  => array(
				array( __( 'שטח', 'metadoc' ), __( '000 מ"ר', 'metadoc' ) ),
				array( __( 'תשואה', 'metadoc' ), '0.0%' ),
				array( __( 'שוכר', 'metadoc' ), __( 'לעדכון', 'metadoc' ) ),
			),
			'url'    => '#contact',
		),
	)
);
?>
<section id="projects" class="md-re-projects">
	<div class="md-re-in">
		<p class="md-re-eyebrow"><?php esc_html_e( '03 / פרויקטים וקרקעות', 'metadoc' ); ?></p>
		<h2><?php esc_html_e( 'הזדמנויות נבחרות', 'metadoc' ); ?> <span class="md-re-acc"><?php esc_html_e( 'למכירה.', 'metadoc' ); ?></span></h2>
		<p><?php esc_html_e( 'מבחר פרויקטים וקרקעות שנבדקו לעומק על ידי הצוות שלנו. לפרטים מלאים ומחירים — צרו קשר.', 'metadoc' ); ?></p>
		<div class="md-re-proj-grid" data-reveal>
			<?php foreach ( $projects as $project ) : ?>
				<article class="md-re-proj">
					<div class="md-re-proj-shot">
						<?php
						$md_sizes = '(max-width: 700px) 100vw, (max-width: 900px) 50vw, 390px';
						if ( ! empty( $project['id'] ) && has_post_thumbnail( (int) $project['id'] ) ) {
							echo get_the_post_thumbnail( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- פלט ליבה מאובטח.
								(int) $project['id'],
								'large',
								array(
									'alt'      => (string) $project['title'],
									'loading'  => 'lazy',
									'decoding' => 'async',
									'sizes'    => $md_sizes,
								)
							);
						} else {
							metadoc_re_image(
								isset( $project['slot'] ) ? (string) $project['slot'] : '',
								(string) $project['title'],
								__( 'תמונת פרויקט', 'metadoc' ),
								array( 'sizes' => $md_sizes )
							);
						}
						?>
						<span class="md-re-proj-tag"><?php echo esc_html( $project['tag'] ); ?></span>
						<span class="md-re-proj-status"><?php echo esc_html( $project['status'] ); ?></span>
					</div>
					<div class="md-re-proj-head">
						<h3><?php echo esc_html( $project['title'] ); ?></h3>
						<p><?php echo esc_html( $project['loc'] ); ?></p>
					</div>
					<div class="md-re-proj-specs">
						<?php foreach ( $project['specs'] as $spec ) : ?>
							<div class="md-re-proj-spec">
								<span><?php echo esc_html( $spec[0] ); ?></span>
								<b><?php echo esc_html( $spec[1] ); ?></b>
							</div>
						<?php endforeach; ?>
					</div>
					<a class="md-re-proj-link" href="<?php echo esc_url( (string) $project['url'] ); ?>">
						<span><?php esc_html_e( 'לפרטים ולתיאום שיחה', 'metadoc' ); ?></span>
						<span aria-hidden="true">←</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

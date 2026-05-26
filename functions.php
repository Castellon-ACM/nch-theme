<?php
defined( 'ABSPATH' ) || exit;

require_once get_template_directory() . '/post-types/escuela-curso.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'nch-theme-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);

	if ( is_singular( 'nch_curso' ) ) {
		wp_enqueue_script(
			'nch-curso-accordion',
			get_template_directory_uri() . '/assets/js/curso-accordion.js',
			[],
			wp_get_theme()->get( 'Version' ),
			true
		);
	}
} );

add_action( 'init', function () {
	register_block_pattern_category( 'nch', [ 'label' => __( 'NCH', 'nch-theme' ) ] );
} );

/**
 * Gating de lecciones con PMPro.
 *
 * Los details con clase nch-lesson--locked requieren membresía activa.
 * Sin membresía se reemplaza el contenido por un CTA de suscripción.
 * Con membresía activa se elimina --locked y la lección se abre normalmente.
 */
add_filter( 'render_block', 'nch_gate_locked_lessons', 10, 2 );
function nch_gate_locked_lessons( $block_content, $block ) {
	if ( is_admin() ) {
		return $block_content;
	}

	if ( 'core/details' !== $block['blockName'] ) {
		return $block_content;
	}

	$classes = $block['attrs']['className'] ?? '';
	if ( ! str_contains( $classes, 'nch-lesson--locked' ) ) {
		return $block_content;
	}

	$has_access = function_exists( 'pmpro_hasMembershipLevel' ) && pmpro_hasMembershipLevel();

	if ( $has_access ) {
		return str_replace( 'nch-lesson--locked', '', $block_content );
	}

	$checkout_url = function_exists( 'pmpro_url' )
		? pmpro_url( 'checkout', '?level=1' )
		: home_url( '/suscripcion/' );

	preg_match( '/<summary>(.*?)<\/summary>/s', $block_content, $matches );
	$summary = isset( $matches[0] ) ? $matches[0] : '<summary>Lección bloqueada</summary>';

	return sprintf(
		'<details class="wp-block-details nch-lesson nch-lesson--locked">
			%s
			<div class="nch-lesson__cta">
				<p class="nch-lesson__cta-text">Activa tu suscripción para desbloquear esta lección.</p>
				<a href="%s" class="nch-lesson__cta-btn">Suscribirme ahora</a>
			</div>
		</details>',
		$summary,
		esc_url( $checkout_url )
	);
}

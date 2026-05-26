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
 * Gating de lecciones con PMS.
 *
 * Sin suscripción "Cursos" activa:
 *  - Todas las lecciones aparecen bloqueadas (solo el título, sin contenido).
 *  - El contenedor nch-lessons añade un CTA único al final.
 * Con suscripción activa: todo se muestra normal y se elimina --locked.
 */
function nch_cursos_has_access(): bool {
	static $result = null;
	if ( $result !== null ) return $result;

	$plan = function_exists( 'pms_get_subscription_plans' )
		? current( array_filter( pms_get_subscription_plans(), fn( $p ) => $p->name === 'Cursos' ) )
		: false;

	$result = $plan && function_exists( 'pms_is_member' ) && pms_is_member( get_current_user_id(), $plan->id );
	return $result;
}

add_filter( 'render_block', 'nch_gate_lessons_block', 10, 2 );
function nch_gate_lessons_block( $block_content, $block ) {
	if ( is_admin() ) return $block_content;

	// Bloquea cada lección individual — todas, no solo las marcadas --locked
	if ( 'core/details' === $block['blockName'] ) {
		$classes = $block['attrs']['className'] ?? '';
		if ( ! str_contains( $classes, 'nch-lesson' ) ) return $block_content;

		if ( nch_cursos_has_access() ) {
			return str_replace( 'nch-lesson--locked', '', $block_content );
		}

		preg_match( '/<summary>(.*?)<\/summary>/s', $block_content, $m );
		$summary = $m[0] ?? '<summary>Lección</summary>';
		return '<details class="wp-block-details nch-lesson nch-lesson--locked">' . $summary . '</details>';
	}

	// Añade CTA único al contenedor de lecciones
	if ( 'core/group' === $block['blockName'] ) {
		$classes = $block['attrs']['className'] ?? '';
		if ( ! str_contains( $classes, 'nch-lessons' ) ) return $block_content;
		if ( nch_cursos_has_access() ) return $block_content;

		$pms_settings  = get_option( 'pms_general_settings', [] );
		$register_id   = $pms_settings['register_page'] ?? 0;
		$checkout_url  = $register_id ? get_permalink( $register_id ) : home_url( '/login/' );

		$cta = sprintf(
			'<div class="nch-lessons__cta">
				<p class="nch-lessons__cta-text">Podrás acceder a esta funcionalidad suscribiéndote a los cursos de NCH.</p>
				<a href="%s" class="nch-lessons__cta-btn">Suscribirme a los Cursos</a>
			</div>',
			esc_url( $checkout_url )
		);

		$pos = strrpos( $block_content, '</div>' );
		if ( $pos !== false ) {
			$block_content = substr_replace( $block_content, $cta, $pos, 0 );
		}
		return $block_content;
	}

	return $block_content;
}

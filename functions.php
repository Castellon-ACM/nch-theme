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

add_filter( 'template_include', function ( $template ) {
	if ( is_page( 'login' ) ) {
		$custom = get_template_directory() . '/templates/page-login.php';
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}
	return $template;
} );

/**
 * Registro nativo con contraseña propia.
 */
add_action( 'admin_post_nopriv_nch_register', 'nch_handle_register' );
function nch_handle_register() {
	$login_url = home_url( '/login/' );

	if ( ! isset( $_POST['nch_nonce'] ) || ! wp_verify_nonce( $_POST['nch_nonce'], 'nch_register_nonce' ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Petición no válida.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	$username = sanitize_user( wp_unslash( $_POST['user_login'] ?? '' ) );
	$email    = sanitize_email( wp_unslash( $_POST['user_email'] ?? '' ) );
	$pass     = wp_unslash( $_POST['user_pass'] ?? '' );
	$pass2    = wp_unslash( $_POST['user_pass_confirm'] ?? '' );

	if ( empty( $username ) || empty( $email ) || empty( $pass ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Todos los campos son obligatorios.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	if ( $pass !== $pass2 ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Las contraseñas no coinciden.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	if ( strlen( $pass ) < 8 ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'La contraseña debe tener al menos 8 caracteres.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	if ( username_exists( $username ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Ese nombre de usuario ya existe.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	if ( email_exists( $email ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Ese correo ya está registrado.' ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	$user_id = wp_insert_user( [
		'user_login' => $username,
		'user_email' => $email,
		'user_pass'  => $pass,
		'role'       => 'subscriber',
	] );

	if ( is_wp_error( $user_id ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( $user_id->get_error_message() ), $login_url . '#nch-panel-register' ) );
		exit;
	}

	wp_set_auth_cookie( $user_id, false );
	wp_redirect( home_url( '/' ) );
	exit;
}

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

		$checkout_url = home_url( '/suscripcion/' );

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

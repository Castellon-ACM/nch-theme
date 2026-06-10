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
		if ( file_exists( $custom ) ) return $custom;
	}
	if ( is_page( 'mi-cuenta' ) ) {
		$custom = get_template_directory() . '/templates/page-account.php';
		if ( file_exists( $custom ) ) return $custom;
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
 * Actualización de perfil desde el frontend.
 */
add_action( 'admin_post_nch_update_profile', 'nch_handle_update_profile' );
function nch_handle_update_profile(): void {
	$account_url = home_url( '/mi-cuenta/' );
	$edit_url    = add_query_arg( 'editar', '1', $account_url );

	if ( ! is_user_logged_in() ) {
		wp_redirect( home_url( '/login/' ) );
		exit;
	}

	if ( ! isset( $_POST['nch_nonce'] ) || ! wp_verify_nonce( $_POST['nch_nonce'], 'nch_update_profile_nonce' ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Petición no válida.' ), $edit_url ) );
		exit;
	}

	$user_id      = get_current_user_id();
	$display_name = sanitize_text_field( wp_unslash( $_POST['display_name'] ?? '' ) );
	$email        = sanitize_email( wp_unslash( $_POST['user_email'] ?? '' ) );
	$pass_current = wp_unslash( $_POST['pass_current'] ?? '' );
	$pass_new     = wp_unslash( $_POST['pass_new'] ?? '' );
	$pass_confirm = wp_unslash( $_POST['pass_confirm'] ?? '' );

	if ( empty( $display_name ) || empty( $email ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'El nombre y el email son obligatorios.' ), $edit_url ) );
		exit;
	}

	if ( ! is_email( $email ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'El formato del email no es válido.' ), $edit_url ) );
		exit;
	}

	// Comprueba que el email no pertenezca a otro usuario
	$email_owner = email_exists( $email );
	if ( $email_owner && (int) $email_owner !== $user_id ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( 'Ese correo ya está en uso por otra cuenta.' ), $edit_url ) );
		exit;
	}

	$update_args = [
		'ID'           => $user_id,
		'display_name' => $display_name,
		'user_email'   => $email,
	];

	// Cambio de contraseña — solo si se rellenó algún campo
	if ( $pass_current !== '' || $pass_new !== '' || $pass_confirm !== '' ) {
		if ( $pass_current === '' ) {
			wp_redirect( add_query_arg( 'nch_error', urlencode( 'Introduce tu contraseña actual para cambiarla.' ), $edit_url ) );
			exit;
		}
		$user_obj = get_user_by( 'id', $user_id );
		if ( ! wp_check_password( $pass_current, $user_obj->user_pass, $user_id ) ) {
			wp_redirect( add_query_arg( 'nch_error', urlencode( 'La contraseña actual no es correcta.' ), $edit_url ) );
			exit;
		}
		if ( strlen( $pass_new ) < 8 ) {
			wp_redirect( add_query_arg( 'nch_error', urlencode( 'La nueva contraseña debe tener al menos 8 caracteres.' ), $edit_url ) );
			exit;
		}
		if ( $pass_new !== $pass_confirm ) {
			wp_redirect( add_query_arg( 'nch_error', urlencode( 'Las nuevas contraseñas no coinciden.' ), $edit_url ) );
			exit;
		}
		$update_args['user_pass'] = $pass_new;
	}

	$result = wp_update_user( $update_args );

	if ( is_wp_error( $result ) ) {
		wp_redirect( add_query_arg( 'nch_error', urlencode( $result->get_error_message() ), $edit_url ) );
		exit;
	}

	// Si cambió la contraseña renovamos la cookie para no desloguear al usuario
	if ( ! empty( $update_args['user_pass'] ) ) {
		wp_set_auth_cookie( $user_id, false );
	}

	wp_redirect( add_query_arg( 'guardado', '1', $account_url ) );
	exit;
}

/**
 * Botón de cuenta en el header.
 */
add_shortcode( 'nch_account_btn', 'nch_render_account_btn' );
function nch_render_account_btn(): string {
	if ( is_user_logged_in() ) {
		$user        = wp_get_current_user();
		$initial     = strtoupper( mb_substr( $user->display_name, 0, 1 ) );
		$account_url = home_url( '/mi-cuenta/' );
		$logout_url  = wp_logout_url( home_url( '/' ) );
		return sprintf(
			'<div class="nch-account-btn">
				<button class="nch-account-circle" aria-label="Mi cuenta" aria-expanded="false" aria-controls="nch-account-dropdown">%s</button>
				<div class="nch-account-dropdown" id="nch-account-dropdown" hidden><a href="%s">Mi cuenta</a><a href="%s">Cerrar sesión</a></div>
			</div>',
			esc_html( $initial ),
			esc_url( $account_url ),
			esc_url( $logout_url )
		);
	}
	return sprintf(
		'<a href="%s" class="nch-account-circle nch-account-circle--guest" aria-label="Iniciar sesión">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
		</a>',
		esc_url( home_url( '/login/' ) )
	);
}

add_action( 'wp_footer', 'nch_account_btn_script' );
function nch_account_btn_script(): void {
	?>
	<script>
	(function(){
		const btn = document.querySelector('.nch-account-circle[aria-controls]');
		const drop = document.getElementById('nch-account-dropdown');
		if(!btn||!drop) return;
		btn.addEventListener('click',function(e){
			e.stopPropagation();
			const open = !drop.hidden;
			drop.hidden = open;
			btn.setAttribute('aria-expanded', String(!open));
		});
		document.addEventListener('click',function(){
			drop.hidden=true;
			btn.setAttribute('aria-expanded','false');
		});
		drop.addEventListener('click',function(e){e.stopPropagation();});
	})();
	</script>
	<?php
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

	if ( ! is_user_logged_in() ) {
		$result = false;
		return $result;
	}

	$result = nch_user_has_active_subscription( get_current_user_id() );
	return $result;
}

function nch_user_has_active_subscription( int $user_id ): bool {
	$subs = nch_get_pms_subscriptions( $user_id );
	foreach ( $subs as $s ) {
		$status = is_object( $s ) ? ( $s->status ?? '' ) : ( $s['status'] ?? '' );
		if ( $status === 'active' ) return true;
	}
	return false;
}

function nch_get_pms_subscriptions( int $user_id ): array {
	// PMS 3.x — acepta array de args
	if ( function_exists( 'pms_get_member_subscriptions' ) ) {
		$subs = pms_get_member_subscriptions( [ 'user_id' => $user_id ] );
		if ( is_array( $subs ) && ! empty( $subs ) ) return $subs;

		// PMS 2.x — acepta user_id directo
		$subs = pms_get_member_subscriptions( $user_id );
		if ( is_array( $subs ) && ! empty( $subs ) ) return $subs;
	}

	// Fallback: consulta directa a la tabla de PMS
	global $wpdb;
	$table = $wpdb->prefix . 'pms_member_subscriptions';
	if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) !== $table ) return [];

	return $wpdb->get_results(
		$wpdb->prepare( "SELECT * FROM `{$table}` WHERE user_id = %d", $user_id )
	) ?: [];
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

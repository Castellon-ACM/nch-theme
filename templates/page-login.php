<?php
defined( 'ABSPATH' ) || exit;
nocache_headers();

$login_url    = home_url( '/login/' );
$error        = isset( $_GET['nch_error'] ) ? urldecode( sanitize_text_field( wp_unslash( $_GET['nch_error'] ) ) ) : '';
$show_register = ! empty( $_GET['nch_error'] ) || isset( $_GET['registro'] );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'nch-auth-body' ); ?>>
<?php wp_body_open(); ?>

<?php block_template_part( 'header' ); ?>

<div class="wp-block-group alignfull nch-section has-base-background-color has-background nch-auth-page">
	<div class="wp-block-group has-base-2-background-color has-background nch-auth-card">

		<div class="wp-block-site-title nch-auth-logo has-primary-color has-text-color has-large-font-size" style="text-align:center">
			<?php bloginfo( 'name' ); ?>
		</div>

		<p class="has-text-align-center has-secondary-color has-text-color has-small-font-size nch-auth-tagline">
			La plataforma de música para DJs y productores
		</p>

		<div class="nch-auth-tab-nav">
			<button class="nch-auth-tab-btn<?php echo $show_register ? '' : ' nch-active'; ?>" data-target="nch-panel-login">Iniciar Sesión</button>
			<button class="nch-auth-tab-btn<?php echo $show_register ? ' nch-active' : ''; ?>" data-target="nch-panel-register">Registrarse</button>
		</div>

		<script>
		(function () {
			var btns = document.querySelectorAll('.nch-auth-tab-btn');
			btns.forEach(function (btn) {
				btn.addEventListener('click', function () {
					var targetId = this.dataset.target;
					btns.forEach(function (b) { b.classList.remove('nch-active'); });
					this.classList.add('nch-active');
					document.querySelectorAll('.nch-auth-panel').forEach(function (p) {
						p.classList.add('nch-auth-panel--hidden');
					});
					document.getElementById(targetId).classList.remove('nch-auth-panel--hidden');
				});
			});
			document.querySelectorAll('.nch-tab-switch').forEach(function (link) {
				link.addEventListener('click', function (e) {
					e.preventDefault();
					document.querySelector('[data-target="' + this.dataset.target + '"]').click();
				});
			});
		})();
		</script>

		<!-- Panel Login -->
		<div class="wp-block-group nch-auth-panel<?php echo $show_register ? ' nch-auth-panel--hidden' : ''; ?>" id="nch-panel-login">
			<?php
			wp_login_form( [
				'redirect'       => home_url( '/' ),
				'label_username' => 'Nombre de usuario',
				'label_password' => 'Contraseña',
				'label_remember' => 'Recuérdame',
				'label_log_in'   => 'Iniciar Sesión',
			] );
			?>
			<p class="has-text-align-center has-small-font-size nch-auth-footer">
				<a href="/wp-login.php?action=lostpassword">¿Olvidaste tu contraseña?</a> ·
				<a href="#" class="nch-tab-switch" data-target="nch-panel-register">Crear cuenta</a>
			</p>
		</div>

		<!-- Panel Register -->
		<div class="wp-block-group nch-auth-panel<?php echo $show_register ? '' : ' nch-auth-panel--hidden'; ?>" id="nch-panel-register">
			<?php if ( $error ) : ?>
			<p class="nch-auth-error"><?php echo esc_html( $error ); ?></p>
			<?php endif; ?>
			<form class="nch-auth-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="nch_register">
				<?php wp_nonce_field( 'nch_register_nonce', 'nch_nonce' ); ?>
				<label for="nch-reg-user">Nombre de usuario</label>
				<input type="text" id="nch-reg-user" name="user_login" required placeholder="tunombre" autocomplete="username">
				<label for="nch-reg-email">Correo electrónico</label>
				<input type="email" id="nch-reg-email" name="user_email" required placeholder="tu@email.com" autocomplete="email">
				<label for="nch-reg-pass">Contraseña</label>
				<input type="password" id="nch-reg-pass" name="user_pass" required placeholder="Mínimo 8 caracteres" minlength="8" autocomplete="new-password">
				<label for="nch-reg-pass2">Confirmar contraseña</label>
				<input type="password" id="nch-reg-pass2" name="user_pass_confirm" required placeholder="Repite la contraseña" minlength="8" autocomplete="new-password">
				<button type="submit" class="nch-auth-submit">Crear Cuenta</button>
			</form>
			<p class="has-text-align-center has-small-font-size nch-auth-footer">
				¿Ya tienes cuenta? <a href="#" class="nch-tab-switch" data-target="nch-panel-login">Inicia sesión</a>
			</p>
		</div>

	</div>
</div>

<?php block_template_part( 'footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

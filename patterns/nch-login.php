<?php
/**
 * Title: NCH Login & Register
 * Slug: nch-theme/login-register
 * Categories: nch, featured
 * Description: Página de login y registro con tabs y fondo oscuro.
 * Keywords: login, register, auth, acceso, nch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-auth-page","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background nch-auth-page">

	<!-- wp:group {"backgroundColor":"base-2","className":"nch-auth-card","layout":{"type":"constrained"}} -->
	<div class="wp-block-group has-base-2-background-color has-background nch-auth-card">

		<!-- Logo -->
		<!-- wp:site-title {"textAlign":"center","isLink":false,"textColor":"primary","fontSize":"large","className":"nch-auth-logo"} /-->

		<!-- wp:paragraph {"align":"center","textColor":"secondary","fontSize":"small","className":"nch-auth-tagline"} -->
		<p class="has-text-align-center has-secondary-color has-text-color has-small-font-size nch-auth-tagline">La plataforma de música para DJs y productores</p>
		<!-- /wp:paragraph -->

		<!-- Tabs nav + JS -->
		<!-- wp:html -->
		<div class="nch-auth-tab-nav">
			<button class="nch-auth-tab-btn nch-active" data-target="nch-panel-login">Iniciar Sesión</button>
			<button class="nch-auth-tab-btn" data-target="nch-panel-register">Registrarse</button>
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
		<!-- /wp:html -->

		<!-- Panel Login -->
		<!-- wp:group {"anchor":"nch-panel-login","className":"nch-auth-panel","layout":{"type":"constrained"}} -->
		<div class="wp-block-group nch-auth-panel" id="nch-panel-login">

			<!-- wp:shortcode -->
			[wp_login_form redirect="" label_username="Email o usuario" label_password="Contraseña" label_log_in="Iniciar Sesión" label_remember="Recordarme"]
			<!-- /wp:shortcode -->

			<!-- wp:paragraph {"align":"center","fontSize":"small","className":"nch-auth-footer"} -->
			<p class="has-text-align-center has-small-font-size nch-auth-footer"><a href="/wp-login.php?action=lostpassword">¿Olvidaste tu contraseña?</a> · <a href="#" class="nch-tab-switch" data-target="nch-panel-register">Crear cuenta</a></p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:group -->

		<!-- Panel Register -->
		<!-- wp:group {"anchor":"nch-panel-register","className":"nch-auth-panel nch-auth-panel--hidden","layout":{"type":"constrained"}} -->
		<div class="wp-block-group nch-auth-panel nch-auth-panel--hidden" id="nch-panel-register">

			<!-- wp:html -->
			<form class="nch-auth-form" method="post" action="/wp-login.php?action=register">
				<label for="nch-reg-user">Nombre de usuario</label>
				<input type="text" id="nch-reg-user" name="user_login" required placeholder="tunombre">
				<label for="nch-reg-email">Email</label>
				<input type="email" id="nch-reg-email" name="user_email" required placeholder="tu@email.com">
				<p class="nch-auth-hint">Recibirás tu contraseña por email. Sin tarjeta de crédito.</p>
				<button type="submit" class="nch-auth-submit">Crear Cuenta Gratis</button>
			</form>
			<!-- /wp:html -->

			<!-- wp:paragraph {"align":"center","fontSize":"small","className":"nch-auth-footer"} -->
			<p class="has-text-align-center has-small-font-size nch-auth-footer">¿Ya tienes cuenta? <a href="#" class="nch-tab-switch" data-target="nch-panel-login">Inicia sesión</a></p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->

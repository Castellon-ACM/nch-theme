<?php
/**
 * Title: NCH Suscripción — Página de Plan
 * Slug: nch-theme/subscription-page
 * Categories: nch
 * Description: Página completa de suscripción con detalles del plan y formulario de registro PMS.
 * Keywords: suscripcion, plan, cursos, registro, pago, nch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-section nch-sub-page","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull nch-section nch-sub-page has-base-background-color has-background">

<!-- wp:paragraph {"className":"nch-label","textColor":"primary"} -->
<p class="nch-label has-primary-color has-text-color">Acceso completo</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"contrast","fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size">Suscríbete a los Cursos de NCH</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Accede a todo el contenido formativo. Cancela cuando quieras.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"className":"nch-sub-layout","style":{"spacing":{"blockGap":{"top":"0","left":"3rem"}}}} -->
<div class="wp-block-columns nch-sub-layout">

	<!-- wp:column {"width":"45%","className":"nch-sub-features"} -->
	<div class="wp-block-column nch-sub-features" style="flex-basis:45%">

		<!-- wp:group {"backgroundColor":"base-2","className":"nch-plan-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group nch-plan-card has-base-2-background-color has-background">

			<!-- wp:paragraph {"className":"nch-plan-name","textColor":"primary","fontSize":"small"} -->
			<p class="nch-plan-name has-primary-color has-text-color has-small-font-size">Plan Cursos</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"textColor":"contrast","fontSize":"x-large","className":"nch-plan-price"} -->
			<h3 class="wp-block-heading nch-plan-price has-contrast-color has-text-color has-x-large-font-size">10$<span class="nch-plan-period"> / mes</span></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
			<p class="has-secondary-color has-text-color has-small-font-size">Sin permanencia. Cancela en cualquier momento desde tu cuenta.</p>
			<!-- /wp:paragraph -->

			<!-- wp:separator {"backgroundColor":"base-3","className":"nch-plan-divider"} -->
			<hr class="wp-block-separator nch-plan-divider has-base-3-background-color has-background"/>
			<!-- /wp:separator -->

			<!-- wp:list {"className":"nch-plan-features","textColor":"contrast"} -->
			<ul class="wp-block-list nch-plan-features has-contrast-color has-text-color">
				<!-- wp:list-item -->
				<li>Acceso a todas las lecciones del curso</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item -->
				<li>Vídeos en alta calidad</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item -->
				<li>Nuevas lecciones cada mes</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item -->
				<li>Soporte directo vía comunidad</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item -->
				<li>Acceso desde cualquier dispositivo</li>
				<!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:column -->

	<!-- wp:column {"width":"55%","className":"nch-sub-form-col"} -->
	<div class="wp-block-column nch-sub-form-col" style="flex-basis:55%">

		<!-- wp:group {"backgroundColor":"base-2","className":"nch-sub-form-card","layout":{"type":"constrained"}} -->
		<div class="wp-block-group nch-sub-form-card has-base-2-background-color has-background">

			<!-- wp:heading {"level":4,"textColor":"contrast","fontSize":"medium","className":"nch-sub-form-title"} -->
			<h4 class="wp-block-heading nch-sub-form-title has-contrast-color has-text-color has-medium-font-size">Crea tu cuenta y activa el plan</h4>
			<!-- /wp:heading -->

			<!-- wp:shortcode -->
			[pms-register]
			<!-- /wp:shortcode -->

			<!-- wp:paragraph {"align":"center","textColor":"secondary","fontSize":"small"} -->
			<p class="has-text-align-center has-secondary-color has-text-color has-small-font-size">¿Ya tienes cuenta? <a href="/login/">Inicia sesión</a></p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

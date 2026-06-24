<?php
/**
 * Title: NCH Split Hero
 * Slug: nch-theme/split-hero
 * Categories: nch, featured
 * Description: Hero en dos columnas con enfoque en ventas, catálogo y comunidad.
 * Keywords: hero, split, music, dj, producer
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-section nch-split-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background nch-section nch-split-hero">

	<!-- wp:columns {"verticalAlignment":"center","className":"nch-split-hero__grid"} -->
	<div class="wp-block-columns are-vertically-aligned-center nch-split-hero__grid">

		<!-- wp:column {"width":"58%"} -->
		<div class="wp-block-column" style="flex-basis:58%">
			<!-- wp:paragraph {"textColor":"primary","className":"nch-label"} -->
			<p class="has-primary-color has-text-color nch-label">Nueva forma de vender música</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":2,"textColor":"contrast","fontSize":"huge","className":"nch-hero__title"} -->
			<h2 class="wp-block-heading has-contrast-color has-text-color has-huge-font-size nch-hero__title">Tu catálogo, listo para abrir puertas.</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"secondary","fontSize":"large"} -->
			<p class="has-secondary-color has-text-color has-large-font-size">Llega a DJs, productores y clubes con un flujo de ventas simple, rápido y profesional.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"base","className":"nch-btn-primary"} -->
				<div class="wp-block-button nch-btn-primary"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button" href="/registro/">Empieza hoy</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline nch-btn-outline","textColor":"contrast"} -->
				<div class="wp-block-button is-style-outline nch-btn-outline"><a class="wp-block-button__link has-contrast-color has-text-color wp-element-button" href="/cursos/">Ver escuela</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:group {"backgroundColor":"base-2","className":"nch-split-hero__panel","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-base-2-background-color has-background nch-split-hero__panel">
				<!-- wp:paragraph {"className":"nch-badge"} -->
				<p class="nch-badge">Más que un marketplace</p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":3,"textColor":"contrast","fontSize":"large"} -->
				<h3 class="wp-block-heading has-contrast-color has-text-color has-large-font-size">Una plataforma hecha para crecer</h3>
				<!-- /wp:heading -->

				<!-- wp:list {"className":"nch-split-hero__list","textColor":"secondary"} -->
				<ul class="wp-block-list nch-split-hero__list has-secondary-color has-text-color">
					<li>Distribución directa a DJs de todo el mundo</li>
					<li>Panel claro para ver ingresos y descargas</li>
					<li>Clases y recursos para mejorar tu sonido</li>
				</ul>
				<!-- /wp:list -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->

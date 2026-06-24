<?php
/**
 * Title: NCH Release Spotlight
 * Slug: nch-theme/release-spotlight
 * Categories: nch, featured
 * Description: Bloque de destaque para presentar un lanzamiento, una edición especial o un curso destacado.
 * Keywords: spotlight, release, featured, music, nch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background nch-section">

	<!-- wp:columns {"verticalAlignment":"center","className":"nch-spotlight"} -->
	<div class="wp-block-columns are-vertically-aligned-center nch-spotlight">

		<!-- wp:column {"width":"60%"} -->
		<div class="wp-block-column" style="flex-basis:60%">
			<!-- wp:group {"backgroundColor":"base-2","className":"nch-spotlight__panel","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-base-2-background-color has-background nch-spotlight__panel">
				<!-- wp:paragraph {"textColor":"primary","className":"nch-label"} -->
				<p class="has-primary-color has-text-color nch-label">Lanzamiento del mes</p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":2,"textColor":"contrast","fontSize":"xx-large"} -->
				<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size">Midnight Session</h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"secondary"} -->
				<p class="has-secondary-color has-text-color">Una edición con energía de club, bajos profundos y una estética moderna pensada para DJs que quieren destacar en cada set.</p>
				<!-- /wp:paragraph -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"backgroundColor":"primary","textColor":"base","className":"nch-btn-primary"} -->
					<div class="wp-block-button nch-btn-primary"><a class="wp-block-button__link has-base-color has-primary-background-color has-text-color has-background wp-element-button" href="/catalogo/">Ver catálogo</a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:group {"backgroundColor":"base-2","className":"nch-card","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-base-2-background-color has-background nch-card">
				<!-- wp:heading {"level":3,"textColor":"contrast","fontSize":"large"} -->
				<h3 class="wp-block-heading has-contrast-color has-text-color has-large-font-size">Por qué destaca</h3>
				<!-- /wp:heading -->

				<!-- wp:group {"className":"nch-spotlight__stats"} -->
				<div class="wp-block-group nch-spotlight__stats">
					<!-- wp:paragraph {"textColor":"primary"} -->
					<p class="has-primary-color has-text-color"><strong>24 tracks</strong> en la edición</p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"primary"} -->
					<p class="has-primary-color has-text-color"><strong>320kbps</strong> + WAV disponible</p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"primary"} -->
					<p class="has-primary-color has-text-color"><strong>100%</strong> de derechos para el artista</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->

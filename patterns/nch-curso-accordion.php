<?php
/**
 * Title: NCH Curso — Acordeón con Vídeo
 * Slug: nch-theme/curso-accordion
 * Categories: nch
 * Description: Acordeón nativo de WordPress con vídeos de YouTube. Cada lección se desbloquea al terminar el vídeo anterior.
 * Keywords: curso, acordeon, video, leccion, tutorial, escuela, nch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background nch-section">

	<!-- wp:paragraph {"textColor":"primary","className":"nch-label"} -->
	<p class="has-primary-color has-text-color nch-label">Contenido del Curso</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"contrast","fontSize":"xx-large"} -->
	<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size">Lecciones</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
	<p class="has-secondary-color has-text-color has-small-font-size">Completa el vídeo de cada lección para desbloquear la siguiente.</p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"className":"nch-lessons","layout":{"type":"constrained"}} -->
	<div class="wp-block-group nch-lessons">

		<!-- Lección 1 — abierta por defecto -->
		<!-- wp:details {"showContent":true,"className":"nch-lesson"} -->
		<details class="wp-block-details nch-lesson" open>
			<summary>01 — Lección 1: Introducción al curso</summary>

			<!-- wp:embed {"url":"https://www.youtube.com/watch?v=VIDEO_ID_AQUI","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
			<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
			https://www.youtube.com/watch?v=VIDEO_ID_AQUI
			</div></figure>
			<!-- /wp:embed -->

			<!-- wp:paragraph {"textColor":"secondary","fontSize":"small","className":"nch-lesson__hint"} -->
			<p class="has-secondary-color has-text-color has-small-font-size nch-lesson__hint">▶ Termina el vídeo para desbloquear la siguiente lección</p>
			<!-- /wp:paragraph -->

		</details>
		<!-- /wp:details -->

		<!-- Lección 2 — bloqueada -->
		<!-- wp:details {"showContent":false,"className":"nch-lesson nch-lesson--locked"} -->
		<details class="wp-block-details nch-lesson nch-lesson--locked">
			<summary>02 — Lección 2: Fundamentos de producción</summary>

			<!-- wp:embed {"url":"https://www.youtube.com/watch?v=VIDEO_ID_AQUI","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
			<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
			https://www.youtube.com/watch?v=VIDEO_ID_AQUI
			</div></figure>
			<!-- /wp:embed -->

			<!-- wp:paragraph {"textColor":"secondary","fontSize":"small","className":"nch-lesson__hint"} -->
			<p class="has-secondary-color has-text-color has-small-font-size nch-lesson__hint">▶ Termina el vídeo para desbloquear la siguiente lección</p>
			<!-- /wp:paragraph -->

		</details>
		<!-- /wp:details -->

		<!-- Lección 3 — bloqueada -->
		<!-- wp:details {"showContent":false,"className":"nch-lesson nch-lesson--locked"} -->
		<details class="wp-block-details nch-lesson nch-lesson--locked">
			<summary>03 — Lección 3: Mezcla y exportación</summary>

			<!-- wp:embed {"url":"https://www.youtube.com/watch?v=VIDEO_ID_AQUI","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
			<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
			https://www.youtube.com/watch?v=VIDEO_ID_AQUI
			</div></figure>
			<!-- /wp:embed -->

		</details>
		<!-- /wp:details -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->

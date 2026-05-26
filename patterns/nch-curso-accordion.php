<?php
/**
 * Title: NCH Curso — Acordeón con Vídeo
 * Slug: nch-theme/curso-accordion
 * Categories: nch
 * Description: Acordeón de lecciones con vídeo incrustado. No puedes abrir la siguiente lección hasta terminar el vídeo anterior.
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

	<!-- wp:html -->
	<div class="nch-accordion" data-course-id="<?php echo esc_attr( get_the_ID() ); ?>">

		<!-- LECCIÓN 1 -->
		<div class="nch-accordion__item" data-index="0">
			<button class="nch-accordion__header" type="button">
				<span class="nch-accordion__icon"></span>
				<span class="nch-accordion__number">01</span>
				<span class="nch-accordion__title">Lección 1: Introducción al curso</span>
				<span class="nch-accordion__chevron"></span>
			</button>
			<div class="nch-accordion__body">
				<div class="nch-accordion__body-inner">
					<div class="nch-video-wrapper">
						<iframe src="https://www.youtube.com/embed/VIDEO_ID_AQUI?enablejsapi=1&rel=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<p class="nch-accordion__hint">▶ Termina el vídeo para desbloquear la siguiente lección</p>
				</div>
			</div>
		</div>

		<!-- LECCIÓN 2 -->
		<div class="nch-accordion__item nch-accordion__item--locked" data-index="1">
			<button class="nch-accordion__header" type="button">
				<span class="nch-accordion__icon">🔒</span>
				<span class="nch-accordion__number">02</span>
				<span class="nch-accordion__title">Lección 2: Fundamentos de producción</span>
				<span class="nch-accordion__chevron"></span>
			</button>
			<div class="nch-accordion__body">
				<div class="nch-accordion__body-inner">
					<div class="nch-video-wrapper">
						<iframe src="https://www.youtube.com/embed/VIDEO_ID_AQUI?enablejsapi=1&rel=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<p class="nch-accordion__hint">▶ Termina el vídeo para desbloquear la siguiente lección</p>
				</div>
			</div>
		</div>

		<!-- LECCIÓN 3 -->
		<div class="nch-accordion__item nch-accordion__item--locked" data-index="2">
			<button class="nch-accordion__header" type="button">
				<span class="nch-accordion__icon">🔒</span>
				<span class="nch-accordion__number">03</span>
				<span class="nch-accordion__title">Lección 3: Mezcla y exportación</span>
				<span class="nch-accordion__chevron"></span>
			</button>
			<div class="nch-accordion__body">
				<div class="nch-accordion__body-inner">
					<div class="nch-video-wrapper">
						<iframe src="https://www.youtube.com/embed/VIDEO_ID_AQUI?enablejsapi=1&rel=0&modestbranding=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- /wp:html -->

</div>
<!-- /wp:group -->

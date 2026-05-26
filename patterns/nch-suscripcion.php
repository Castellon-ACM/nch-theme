<?php
/**
 * Title: NCH Suscripción — Checkout
 * Slug: nch-theme/suscripcion
 * Categories: nch
 * Description: Página de checkout para suscribirse a los cursos de NCH via PMS.
 * Keywords: suscripcion, checkout, pago, cursos, nch
 * Viewport Width: 1280
 */
?>
<!-- wp:group {"align":"full","backgroundColor":"base","className":"nch-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull nch-section has-base-background-color has-background">

<!-- wp:paragraph {"className":"nch-label","textColor":"primary"} -->
<p class="nch-label has-primary-color has-text-color">Acceso completo</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textColor":"contrast","fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-contrast-color has-text-color has-xx-large-font-size">Suscríbete a los Cursos de NCH</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"secondary","fontSize":"small"} -->
<p class="has-secondary-color has-text-color has-small-font-size">Accede a todas las lecciones con una suscripción mensual. Cancela cuando quieras.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[pms-checkout subscription_plans="15"]
<!-- /wp:shortcode -->

</div>
<!-- /wp:group -->

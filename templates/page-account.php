<?php
defined( 'ABSPATH' ) || exit;
nocache_headers();

if ( ! is_user_logged_in() ) {
	wp_redirect( home_url( '/login/' ) );
	exit;
}

$user        = wp_get_current_user();
$initial     = strtoupper( mb_substr( $user->display_name, 0, 1 ) );
$logout_url  = wp_logout_url( home_url( '/' ) );

// Suscripciones PMS
$subscriptions = [];
if ( function_exists( 'pms_get_member_subscriptions' ) ) {
	$subscriptions = pms_get_member_subscriptions( $user->ID );
}

$status_labels = [
	'active'    => [ 'label' => 'Activa',    'class' => 'nch-sub-status--active' ],
	'expired'   => [ 'label' => 'Expirada',  'class' => 'nch-sub-status--expired' ],
	'canceled'  => [ 'label' => 'Cancelada', 'class' => 'nch-sub-status--expired' ],
	'pending'   => [ 'label' => 'Pendiente', 'class' => 'nch-sub-status--pending' ],
];
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mi Cuenta — <?php bloginfo( 'name' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'nch-account-body' ); ?>>
<?php wp_body_open(); ?>

<?php block_template_part( 'header' ); ?>

<div class="wp-block-group alignfull has-base-background-color has-background nch-section nch-account-page">
	<div class="nch-account-wrap">

		<!-- Avatar + nombre -->
		<div class="nch-account-hero">
			<div class="nch-account-avatar"><?php echo esc_html( $initial ); ?></div>
			<div class="nch-account-identity">
				<h1 class="nch-account-name"><?php echo esc_html( $user->display_name ); ?></h1>
				<p class="nch-account-email"><?php echo esc_html( $user->user_email ); ?></p>
			</div>
		</div>

		<!-- Grid: datos + suscripciones -->
		<div class="nch-account-grid">

			<!-- Datos de cuenta -->
			<section class="nch-account-card">
				<h2 class="nch-account-card__title">Datos de cuenta</h2>
				<ul class="nch-account-info-list">
					<li>
						<span class="nch-account-info-list__key">Usuario</span>
						<span class="nch-account-info-list__val"><?php echo esc_html( $user->user_login ); ?></span>
					</li>
					<li>
						<span class="nch-account-info-list__key">Nombre</span>
						<span class="nch-account-info-list__val"><?php echo esc_html( $user->display_name ); ?></span>
					</li>
					<li>
						<span class="nch-account-info-list__key">Email</span>
						<span class="nch-account-info-list__val"><?php echo esc_html( $user->user_email ); ?></span>
					</li>
					<li>
						<span class="nch-account-info-list__key">Miembro desde</span>
						<span class="nch-account-info-list__val"><?php echo esc_html( date_i18n( 'j \d\e F, Y', strtotime( $user->user_registered ) ) ); ?></span>
					</li>
				</ul>
				<div class="nch-account-card__actions">
					<a href="<?php echo esc_url( get_edit_profile_url( $user->ID ) ); ?>" class="nch-account-action-btn">Editar perfil</a>
					<a href="<?php echo esc_url( $logout_url ); ?>" class="nch-account-action-btn nch-account-action-btn--ghost">Cerrar sesión</a>
				</div>
			</section>

			<!-- Suscripciones -->
			<section class="nch-account-card">
				<h2 class="nch-account-card__title">Suscripciones</h2>

				<?php if ( empty( $subscriptions ) ) : ?>
				<p class="nch-account-empty">No tienes ninguna suscripción activa.</p>
				<a href="<?php echo esc_url( home_url( '/suscripcion/' ) ); ?>" class="nch-account-action-btn" style="display:inline-block;margin-top:1rem;">Ver planes</a>

				<?php else : ?>
				<ul class="nch-sub-list">
					<?php foreach ( $subscriptions as $sub ) :
						$plan = function_exists( 'pms_get_subscription_plan' ) ? pms_get_subscription_plan( $sub->subscription_plan_id ) : null;
						$plan_name = $plan ? $plan->name : 'Plan #' . $sub->subscription_plan_id;
						$status    = $sub->status ?? 'unknown';
						$status_info = $status_labels[ $status ] ?? [ 'label' => ucfirst( $status ), 'class' => '' ];
						$exp_date  = ! empty( $sub->expiration_date ) && $sub->expiration_date !== '0000-00-00' ? date_i18n( 'j \d\e F, Y', strtotime( $sub->expiration_date ) ) : null;
						$next_pay  = ! empty( $sub->billing_next_payment ) && $sub->billing_next_payment !== '0000-00-00' ? date_i18n( 'j \d\e F, Y', strtotime( $sub->billing_next_payment ) ) : null;
					?>
					<li class="nch-sub-item">
						<div class="nch-sub-item__header">
							<span class="nch-sub-item__name"><?php echo esc_html( $plan_name ); ?></span>
							<span class="nch-sub-status <?php echo esc_attr( $status_info['class'] ); ?>"><?php echo esc_html( $status_info['label'] ); ?></span>
						</div>
						<?php if ( $next_pay ) : ?>
						<p class="nch-sub-item__meta">Próximo cobro: <?php echo esc_html( $next_pay ); ?></p>
						<?php elseif ( $exp_date ) : ?>
						<p class="nch-sub-item__meta">Expira: <?php echo esc_html( $exp_date ); ?></p>
						<?php endif; ?>
					</li>
					<?php endforeach; ?>
				</ul>
				<div class="nch-account-card__actions">
					<a href="<?php echo esc_url( home_url( '/suscripcion/' ) ); ?>" class="nch-account-action-btn">Gestionar suscripción</a>
				</div>
				<?php endif; ?>
			</section>

		</div><!-- .nch-account-grid -->
	</div><!-- .nch-account-wrap -->
</div>

<?php block_template_part( 'footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>

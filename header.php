<?php
/**
 * Cabeçalho do site: marca, busca e menu principal.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="hbv-skip" href="#conteudo"><?php esc_html_e( 'Pular para o conteúdo', 'hbv' ); ?></a>

<header class="hbv-header" role="banner">
	<div class="hbv-container hbv-header__inner">
		<div class="hbv-brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php endif; ?>
			<div>
				<p class="hbv-brand__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php if ( get_bloginfo( 'description' ) ) : ?>
					<p class="hbv-brand__tagline"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php get_search_form(); ?>
		<?php hbv_theme_toggle(); ?>
	</div>

	<div class="hbv-navbar">
		<button class="hbv-nav-toggle" type="button" aria-controls="hbv-primary-nav" aria-expanded="false">
			<span><?php esc_html_e( 'Menu', 'hbv' ); ?></span>
			<span class="hbv-nav-toggle__bars" aria-hidden="true"></span>
		</button>
		<div class="hbv-container">
			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'primary',
					'container'            => 'nav',
					'container_id'         => 'hbv-primary-nav',
					'container_class'      => 'hbv-nav',
					'container_aria_label' => __( 'Menu principal', 'hbv' ),
					'menu_class'           => 'hbv-menu',
					'depth'                => 4,
					'fallback_cb'          => 'hbv_nav_fallback',
				)
			);
			?>
		</div>
	</div>
</header>

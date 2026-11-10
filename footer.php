<?php
/**
 * Rodapé do site.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$has_widgets = is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' );
$rights      = get_page_by_path( 'direitos-autorais' );
$contact     = get_page_by_path( 'fale-conosco' );
?>

<footer class="hbv-footer" role="contentinfo">
	<div class="hbv-container">
		<?php if ( $has_widgets ) : ?>
			<div class="hbv-footer__widgets">
				<?php
				for ( $i = 1; $i <= 3; $i++ ) {
					if ( is_active_sidebar( 'footer-' . $i ) ) {
						echo '<div>';
						dynamic_sidebar( 'footer-' . $i );
						echo '</div>';
					}
				}
				?>
			</div>
		<?php endif; ?>

		<div class="hbv-footer__bar">
			<p>
				&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
				<?php esc_html_e( 'Textos e imagens protegidos por direitos autorais.', 'hbv' ); ?>
			</p>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location'       => 'footer',
						'container'            => 'nav',
						'container_aria_label' => __( 'Menu do rodapé', 'hbv' ),
						'menu_class'           => 'hbv-footer__menu',
						'depth'                => 1,
					)
				);
			} else {
				echo '<ul class="hbv-footer__menu">';
				if ( $rights ) {
					echo '<li><a href="' . esc_url( get_permalink( $rights ) ) . '">' . esc_html__( 'Direitos autorais', 'hbv' ) . '</a></li>';
				}
				if ( $contact ) {
					echo '<li><a href="' . esc_url( get_permalink( $contact ) ) . '">' . esc_html__( 'Fale conosco', 'hbv' ) . '</a></li>';
				}
				echo '<li><a href="' . esc_url( get_privacy_policy_url() ? get_privacy_policy_url() : home_url( '/' ) ) . '">' . esc_html__( 'Privacidade', 'hbv' ) . '</a></li>';
				echo '</ul>';
			}
			?>
		</div>
	</div>
</footer>

<button type="button" class="hbv-totop" hidden aria-label="<?php esc_attr_e( 'Voltar ao topo', 'hbv' ); ?>">&uarr;</button>

<?php wp_footer(); ?>
</body>
</html>

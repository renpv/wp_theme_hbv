<?php
/**
 * Template padrão (publicações).
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<div class="hbv-layout hbv-layout--sidebar">
			<div class="hbv-content">
				<header class="hbv-page-head hbv-page-head--wide">
					<h1><?php echo is_home() && ! is_front_page() ? esc_html( single_post_title( '', false ) ) : esc_html__( 'Publicações', 'hbv' ); ?></h1>
				</header>
				<?php if ( have_posts() ) : ?>
					<ul class="hbv-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							echo '<li>';
							get_template_part( 'template-parts/card' );
							echo '</li>';
						endwhile;
						?>
					</ul>
					<?php hbv_pagination(); ?>
				<?php else : ?>
					<p class="hbv-empty"><?php esc_html_e( 'Nenhuma publicação ainda.', 'hbv' ); ?></p>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();

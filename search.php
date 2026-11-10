<?php
/**
 * Resultados de busca em todo o acervo.
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
					<h1>
						<?php
						/* translators: %s: termo buscado */
						printf( esc_html__( 'Resultados para “%s”', 'hbv' ), esc_html( get_search_query() ) );
						?>
					</h1>
					<?php global $wp_query; ?>
					<p class="hbv-page-head__desc">
						<?php
						/* translators: %s: número de resultados */
						printf( esc_html( _n( '%s item encontrado no acervo.', '%s itens encontrados no acervo.', (int) $wp_query->found_posts, 'hbv' ) ), esc_html( number_format_i18n( (int) $wp_query->found_posts ) ) );
						?>
					</p>
				</header>

				<?php if ( have_posts() ) : ?>
					<ul class="hbv-grid">
						<?php
						while ( have_posts() ) :
							the_post();
							echo '<li>';
							get_template_part( 'template-parts/card', null, array( 'variant' => 'hbv_pessoa' === get_post_type() ? 'pessoa' : 'default' ) );
							echo '</li>';
						endwhile;
						?>
					</ul>
					<?php hbv_pagination(); ?>
				<?php else : ?>
					<div class="hbv-empty">
						<p><?php esc_html_e( 'Nada encontrado. Tente outra palavra, um sobrenome ou o nome de um bairro.', 'hbv' ); ?></p>
						<?php get_search_form(); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();

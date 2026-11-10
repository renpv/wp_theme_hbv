<?php
/**
 * Arquivos de taxonomia (tema, período, tipo de lugar...), data, autor e categorias.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$term = is_tax() || is_category() || is_tag() ? get_queried_object() : null;
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<div class="hbv-layout hbv-layout--sidebar">
			<div class="hbv-content">
				<header class="hbv-page-head hbv-page-head--wide">
					<?php if ( $term && 'hbv_periodo' === $term->taxonomy ) : ?>
						<p class="hbv-eyebrow"><?php echo esc_html( hbv_periodo_range( $term ) ); ?></p>
					<?php elseif ( $term ) : ?>
						<p class="hbv-eyebrow"><?php echo esc_html( get_taxonomy( $term->taxonomy )->labels->singular_name ); ?></p>
					<?php endif; ?>
					<h1><?php the_archive_title(); ?></h1>
					<?php the_archive_description( '<div class="hbv-page-head__desc">', '</div>' ); ?>
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
					<p class="hbv-empty"><?php esc_html_e( 'Ainda não há conteúdo nesta seção.', 'hbv' ); ?></p>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();

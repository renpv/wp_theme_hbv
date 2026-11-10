<?php
/**
 * Conteúdo individual dos tipos do acervo (biografia, lugar, logradouro, fato, obra, instituição).
 * Estrutura: selos de tema e período, título, ficha técnica, texto, fontes e relacionados.
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
				<?php
				while ( have_posts() ) :
					the_post();
					$pt = get_post_type();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="hbv-page-head">
							<p class="hbv-eyebrow"><?php echo esc_html( hbv_type_label() ); ?></p>
							<?php hbv_badges(); ?>
							<h1><?php the_title(); ?></h1>
							<?php
							if ( 'hbv_pessoa' === $pt && get_post_meta( get_the_ID(), 'hbv_ocupacao', true ) ) {
								echo '<p class="hbv-page-head__desc">' . esc_html( get_post_meta( get_the_ID(), 'hbv_ocupacao', true ) ) . '</p>';
							}
							?>
						</header>

						<div class="hbv-media-and-ficha">
							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="hbv-prose">
									<?php the_post_thumbnail( 'large' ); ?>
									<?php if ( get_the_post_thumbnail_caption() ) : ?>
										<figcaption><?php echo esc_html( get_the_post_thumbnail_caption() ); ?></figcaption>
									<?php endif; ?>
								</figure>
							<?php endif; ?>
							<?php hbv_ficha(); ?>
						</div>

						<div class="hbv-prose"><?php the_content(); ?></div>

						<?php hbv_fontes(); ?>

						<?php
						/* Logradouros: mostra a biografia do homenageado, se existir. */
						if ( 'hbv_logradouro' === $pt ) {
							$h = (int) get_post_meta( get_the_ID(), 'hbv_homenageado_id', true );
							if ( $h && 'publish' === get_post_status( $h ) ) {
								echo '<aside class="hbv-nota hbv-prose" style="margin-top:var(--hbv-space-6)"><p><strong>' . esc_html__( 'Sobre o homenageado:', 'hbv' ) . '</strong> <a href="' . esc_url( get_permalink( $h ) ) . '">' . esc_html( get_the_title( $h ) ) . '</a></p></aside>';
							}
						}
						?>

						<?php hbv_share_links(); ?>
					</article>

					<?php
					/* Relacionados: mesmo tema, outros tipos de conteúdo. */
					$tema_ids = wp_get_post_terms( get_the_ID(), 'hbv_tema', array( 'fields' => 'ids' ) );
					if ( $tema_ids && ! is_wp_error( $tema_ids ) ) :
						$rel = new WP_Query(
							array(
								'post_type'      => array_merge( array( 'post' ), hbv_cpts() ),
								'posts_per_page' => 3,
								'post__not_in'   => array( get_the_ID() ),
								'no_found_rows'  => true,
								'orderby'        => 'rand',
								'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
									array(
										'taxonomy' => 'hbv_tema',
										'terms'    => $tema_ids,
									),
								),
							)
						);
						if ( $rel->have_posts() ) :
							?>
							<section class="hbv-section" aria-labelledby="rel-title">
								<div class="hbv-section__head"><h2 id="rel-title"><?php esc_html_e( 'Veja também', 'hbv' ); ?></h2></div>
								<ul class="hbv-grid hbv-grid--3">
									<?php
									while ( $rel->have_posts() ) :
										$rel->the_post();
										echo '<li>';
										get_template_part( 'template-parts/card' );
										echo '</li>';
									endwhile;
									wp_reset_postdata();
									?>
								</ul>
							</section>
							<?php
						endif;
					endif;

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();

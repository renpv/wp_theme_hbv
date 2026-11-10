<?php
/**
 * Template Name: Seção (portal de assunto)
 * Template Post Type: page
 *
 * Página de entrada de uma seção: texto de apresentação, subpáginas em cartões
 * e os conteúdos do acervo marcados com o mesmo tema.
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

		<?php
		while ( have_posts() ) :
			the_post();
			$section_id = get_the_ID();
			?>
			<header class="hbv-page-head hbv-page-head--wide">
				<p class="hbv-eyebrow"><?php esc_html_e( 'Seção', 'hbv' ); ?></p>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_excerpt() ) : ?>
					<p class="hbv-page-head__desc"><?php echo esc_html( get_the_excerpt() ); ?></p>
				<?php endif; ?>
			</header>

			<?php if ( '' !== trim( get_the_content() ) ) : ?>
				<div class="hbv-prose"><?php the_content(); ?></div>
			<?php endif; ?>
			<?php
		endwhile;

		/* Subpáginas. */
		$children = get_pages(
			array(
				'parent'      => $section_id,
				'sort_column' => 'menu_order,post_title',
			)
		);
		if ( $children ) :
			?>
			<section class="hbv-section" aria-labelledby="sub-title">
				<div class="hbv-section__head"><h2 id="sub-title"><?php esc_html_e( 'Nesta seção', 'hbv' ); ?></h2></div>
				<ul class="hbv-grid">
					<?php
					global $post;
					foreach ( $children as $post ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $post );
						echo '<li>';
						get_template_part( 'template-parts/card', null, array( 'variant' => 'secao' ) );
						echo '</li>';
					}
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		/* Conteúdos do acervo com o mesmo tema da página. */
		$tema_ids = wp_get_post_terms( $section_id, 'hbv_tema', array( 'fields' => 'ids' ) );
		if ( $tema_ids && ! is_wp_error( $tema_ids ) ) :
			$items = new WP_Query(
				array(
					'post_type'      => array_merge( array( 'post' ), hbv_cpts() ),
					'posts_per_page' => 9,
					'no_found_rows'  => true,
					'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						array(
							'taxonomy' => 'hbv_tema',
							'terms'    => $tema_ids,
						),
					),
				)
			);
			if ( $items->have_posts() ) :
				?>
				<section class="hbv-section" aria-labelledby="acervo-title">
					<div class="hbv-section__head">
						<h2 id="acervo-title"><?php esc_html_e( 'No acervo', 'hbv' ); ?></h2>
						<?php $first = get_term( $tema_ids[0], 'hbv_tema' ); ?>
						<?php if ( $first && ! is_wp_error( $first ) ) : ?>
							<a class="hbv-section__more" href="<?php echo esc_url( get_term_link( $first ) ); ?>"><?php esc_html_e( 'Ver tudo', 'hbv' ); ?> &rarr;</a>
						<?php endif; ?>
					</div>
					<ul class="hbv-grid">
						<?php
						while ( $items->have_posts() ) :
							$items->the_post();
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
		?>
	</div>
</main>
<?php
get_footer();

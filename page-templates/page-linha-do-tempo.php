<?php
/**
 * Template Name: Linha do tempo
 * Template Post Type: page
 *
 * Os períodos históricos (taxonomia "Período") em ordem cronológica,
 * cada um com os conteúdos mais recentes associados.
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
			?>
			<header class="hbv-page-head">
				<h1><?php the_title(); ?></h1>
			</header>
			<?php if ( '' !== trim( get_the_content() ) ) : ?>
				<div class="hbv-prose" style="margin-bottom:var(--hbv-space-7)"><?php the_content(); ?></div>
			<?php endif; ?>
		<?php endwhile; ?>

		<ol class="hbv-timeline">
			<?php foreach ( hbv_get_periodos() as $periodo ) : ?>
				<li class="hbv-timeline__item" id="<?php echo esc_attr( $periodo->slug ); ?>">
					<p class="hbv-timeline__range"><?php echo esc_html( hbv_periodo_range( $periodo ) ); ?></p>
					<h2 class="hbv-timeline__title"><a href="<?php echo esc_url( get_term_link( $periodo ) ); ?>"><?php echo esc_html( $periodo->name ); ?></a></h2>
					<?php if ( $periodo->description ) : ?>
						<p class="hbv-timeline__desc"><?php echo esc_html( $periodo->description ); ?></p>
					<?php endif; ?>
					<?php
					$items = new WP_Query(
						array(
							'post_type'      => array_merge( array( 'post', 'page' ), hbv_cpts() ),
							'posts_per_page' => 5,
							'no_found_rows'  => true,
							'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
								array(
									'taxonomy' => 'hbv_periodo',
									'terms'    => array( $periodo->term_id ),
								),
							),
						)
					);
					if ( $items->have_posts() ) :
						?>
						<ul class="hbv-timeline__list">
							<?php
							while ( $items->have_posts() ) :
								$items->the_post();
								?>
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <small>(<?php echo esc_html( hbv_type_label() ); ?>)</small></li>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</main>
<?php
get_footer();

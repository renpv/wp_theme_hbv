<?php
/**
 * Barra lateral. Sem widgets configurados, mostra busca, temas e conteúdos recentes.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="hbv-sidebar" aria-label="<?php esc_attr_e( 'Barra lateral', 'hbv' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-main' ); ?>
	<?php else : ?>
		<section class="hbv-widget">
			<h2 class="hbv-widget__title"><?php esc_html_e( 'Temas', 'hbv' ); ?></h2>
			<ul>
				<?php
				wp_list_categories(
					array(
						'taxonomy'   => 'hbv_tema',
						'title_li'   => '',
						'hide_empty' => true,
					)
				);
				?>
			</ul>
		</section>

		<section class="hbv-widget">
			<h2 class="hbv-widget__title"><?php esc_html_e( 'Períodos', 'hbv' ); ?></h2>
			<ul>
				<?php foreach ( hbv_get_periodos() as $periodo ) : ?>
					<li>
						<a href="<?php echo esc_url( get_term_link( $periodo ) ); ?>"><?php echo esc_html( $periodo->name ); ?></a>
						<small>(<?php echo esc_html( hbv_periodo_range( $periodo ) ); ?>)</small>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="hbv-widget">
			<h2 class="hbv-widget__title"><?php esc_html_e( 'Mais recentes', 'hbv' ); ?></h2>
			<ul>
				<?php
				$recent = new WP_Query(
					array(
						'post_type'           => array_merge( array( 'post' ), hbv_cpts() ),
						'posts_per_page'      => 6,
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					)
				);
				while ( $recent->have_posts() ) :
					$recent->the_post();
					?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; wp_reset_postdata(); ?>
			</ul>
		</section>
	<?php endif; ?>
</aside>

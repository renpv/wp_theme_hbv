<?php
/**
 * Página inicial: apresentação, seções, linha do tempo, fatos do mês, biografias e novidades.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$header_image = get_header_image();
$hero_style   = $header_image ? ' style="background-image:url(' . esc_url( $header_image ) . ')"' : '';
$contact      = get_page_by_path( 'fale-conosco' );
?>

<section class="hbv-hero"<?php echo $hero_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- URL escapada acima. ?>>
	<div class="hbv-container hbv-hero__inner">
		<p class="hbv-eyebrow"><?php esc_html_e( 'Sertão Central do Ceará', 'hbv' ); ?></p>
		<h1 class="hbv-hero__title"><?php bloginfo( 'name' ); ?></h1>
		<p class="hbv-hero__lead">
			<?php echo esc_html( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : __( 'A história do Município de Boa Viagem em fatos e fotos.', 'hbv' ) ); ?>
		</p>
		<?php get_search_form(); ?>
		<ul class="hbv-stats">
			<?php
			$stats = array(
				'hbv_pessoa'     => array( 'biografia', 'biografias' ),
				'hbv_lugar'      => array( 'lugar', 'lugares' ),
				'hbv_logradouro' => array( 'logradouro', 'logradouros' ),
				'hbv_fato'       => array( 'data e fato', 'datas e fatos' ),
			);
			foreach ( $stats as $type => $labels ) {
				$n = hbv_count( $type );
				if ( ! $n ) {
					continue;
				}
				echo '<li><strong>' . esc_html( number_format_i18n( $n ) ) . '</strong>' . esc_html( 1 === $n ? $labels[0] : $labels[1] ) . '</li>';
			}
			?>
		</ul>
	</div>
</section>

<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">

		<?php
		/* Texto de abertura (Editorial), se a página inicial for uma página estática. */
		if ( is_page() && have_posts() ) :
			while ( have_posts() ) :
				the_post();
				if ( '' !== trim( get_the_content() ) ) :
					?>
					<section class="hbv-section" aria-labelledby="editorial-title">
						<div class="hbv-section__head"><h2 id="editorial-title"><?php the_title(); ?></h2></div>
						<div class="hbv-prose"><?php the_content(); ?></div>
					</section>
					<?php
				endif;
			endwhile;
		endif;
		?>

		<?php
		/* Seções do site (páginas com o modelo "Seção"). */
		$sections = get_pages(
			array(
				'parent'      => 0,
				'meta_key'    => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => 'page-templates/page-secao.php', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'sort_column' => 'menu_order,post_title',
			)
		);
		if ( $sections ) :
			?>
			<section class="hbv-section" aria-labelledby="secoes-title">
				<div class="hbv-section__head"><h2 id="secoes-title"><?php esc_html_e( 'Explore por seção', 'hbv' ); ?></h2></div>
				<ul class="hbv-grid">
					<?php
					global $post;
					foreach ( $sections as $post ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
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
		/* Linha do tempo: sete momentos. */
		$periodos = hbv_get_periodos();
		if ( $periodos ) :
			$timeline = get_page_by_path( 'linha-do-tempo' );
			?>
			<section class="hbv-section" aria-labelledby="tempo-title">
				<div class="hbv-section__head">
					<h2 id="tempo-title"><?php esc_html_e( 'Sete momentos da história', 'hbv' ); ?></h2>
					<?php if ( $timeline ) : ?>
						<a class="hbv-section__more" href="<?php echo esc_url( get_permalink( $timeline ) ); ?>"><?php esc_html_e( 'Ver a linha do tempo', 'hbv' ); ?> &rarr;</a>
					<?php endif; ?>
				</div>
				<ol class="hbv-timeline">
					<?php foreach ( $periodos as $p ) : ?>
						<li class="hbv-timeline__item">
							<p class="hbv-timeline__range"><?php echo esc_html( hbv_periodo_range( $p ) ); ?></p>
							<h3 class="hbv-timeline__title"><a href="<?php echo esc_url( get_term_link( $p ) ); ?>"><?php echo esc_html( $p->name ); ?></a></h3>
							<?php if ( $p->description ) : ?>
								<p class="hbv-timeline__desc"><?php echo esc_html( $p->description ); ?></p>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ol>
			</section>
		<?php endif; ?>

		<?php
		/* Datas e fatos do mês corrente. */
		$mes_atual = (int) wp_date( 'n' );
		$fatos     = new WP_Query(
			array(
				'post_type'      => 'hbv_fato',
				'posts_per_page' => 6,
				'no_found_rows'  => true,
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					'relation'       => 'AND',
					'hbv_mes_clause' => array(
						'key'   => 'hbv_mes',
						'value' => $mes_atual,
						'type'  => 'NUMERIC',
					),
					'hbv_dia_clause' => array(
						'key'     => 'hbv_dia',
						'type'    => 'NUMERIC',
						'compare' => 'EXISTS',
					),
				),
				'orderby'        => array( 'hbv_dia_clause' => 'ASC' ),
			)
		);
		if ( $fatos->have_posts() ) :
			$meses = hbv_month_names();
			?>
			<section class="hbv-section" aria-labelledby="fatos-title">
				<div class="hbv-section__head">
					<h2 id="fatos-title">
						<?php
						/* translators: %s: nome do mês */
						printf( esc_html__( 'Datas e fatos de %s', 'hbv' ), esc_html( strtolower( $meses[ $mes_atual ] ) ) );
						?>
					</h2>
					<a class="hbv-section__more" href="<?php echo esc_url( add_query_arg( 'hbv_mes', $mes_atual, get_post_type_archive_link( 'hbv_fato' ) ) ); ?>"><?php esc_html_e( 'Ver o mês completo', 'hbv' ); ?> &rarr;</a>
				</div>
				<ul class="hbv-fatos">
					<?php
					while ( $fatos->have_posts() ) :
						$fatos->the_post();
						get_template_part( 'template-parts/fato' );
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		/* Biografias em destaque (sorteio a cada visita). */
		$bios = new WP_Query(
			array(
				'post_type'      => 'hbv_pessoa',
				'posts_per_page' => 6,
				'orderby'        => 'rand',
				'no_found_rows'  => true,
			)
		);
		if ( $bios->have_posts() ) :
			?>
			<section class="hbv-section" aria-labelledby="bios-title">
				<div class="hbv-section__head">
					<h2 id="bios-title"><?php esc_html_e( 'Biografias', 'hbv' ); ?></h2>
					<a class="hbv-section__more" href="<?php echo esc_url( get_post_type_archive_link( 'hbv_pessoa' ) ); ?>"><?php esc_html_e( 'Índice de A a Z', 'hbv' ); ?> &rarr;</a>
				</div>
				<ul class="hbv-grid">
					<?php
					while ( $bios->have_posts() ) :
						$bios->the_post();
						echo '<li>';
						get_template_part( 'template-parts/card', null, array( 'variant' => 'pessoa' ) );
						echo '</li>';
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>

		<?php
		/* Novidades. */
		$recent = new WP_Query(
			array(
				'post_type'           => array_merge( array( 'post' ), hbv_cpts() ),
				'posts_per_page'      => 6,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		if ( $recent->have_posts() ) :
			?>
			<section class="hbv-section" aria-labelledby="recentes-title">
				<div class="hbv-section__head"><h2 id="recentes-title"><?php esc_html_e( 'Publicados recentemente', 'hbv' ); ?></h2></div>
				<ul class="hbv-grid">
					<?php
					while ( $recent->have_posts() ) :
						$recent->the_post();
						echo '<li>';
						get_template_part( 'template-parts/card' );
						echo '</li>';
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</section>
		<?php endif; ?>

		<?php if ( $contact ) : ?>
			<section class="hbv-section" aria-labelledby="colabore-title">
				<div class="hbv-nota hbv-prose" style="max-width:none">
					<h2 id="colabore-title" style="margin-top:0;border:0;padding:0"><?php esc_html_e( 'Tem uma foto, um documento ou uma lembrança?', 'hbv' ); ?></h2>
					<p><?php esc_html_e( 'O acervo cresce com a colaboração de quem viveu essa história. Envie o material e informe a fonte.', 'hbv' ); ?></p>
					<p><a class="hbv-btn" href="<?php echo esc_url( get_permalink( $contact ) ); ?>"><?php esc_html_e( 'Fale conosco', 'hbv' ); ?></a></p>
				</div>
			</section>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();

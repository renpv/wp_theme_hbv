<?php
/**
 * Calendário de datas e fatos: abas de mês e lista agrupada.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$meses       = hbv_month_names();
$mes_ativo   = absint( get_query_var( 'hbv_mes' ) );
$mes_ativo   = ( $mes_ativo >= 1 && $mes_ativo <= 12 ) ? $mes_ativo : 0;
$archive_url = get_post_type_archive_link( 'hbv_fato' );

// Visão de um mês: abertura, aniversários e bibliografia vêm do plugin HBV Core (0.4.0 ou superior).
$mes_info = array(
	'abertura_html' => '',
	'bibliografia'  => array(),
);
if ( $mes_ativo && hbv_core_active() ) {
	$mes_info = hbv_get_mes_info( $mes_ativo );
}

// Agrupa por mês.
$groups = array();
while ( have_posts() ) {
	the_post();
	$m = (int) get_post_meta( get_the_ID(), 'hbv_mes', true );
	$groups[ $m ][] = get_the_ID();
}
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<header class="hbv-page-head hbv-page-head--wide">
			<h1><?php post_type_archive_title(); ?></h1>
			<p class="hbv-page-head__desc"><?php echo esc_html( get_post_type_object( 'hbv_fato' )->description ); ?></p>
		</header>

		<nav aria-label="<?php esc_attr_e( 'Escolha o mês', 'hbv' ); ?>">
			<ul class="hbv-tabs">
				<li><a href="<?php echo esc_url( $archive_url ); ?>"<?php echo $mes_ativo ? '' : ' aria-current="true"'; ?>><?php esc_html_e( 'Ano todo', 'hbv' ); ?></a></li>
				<?php foreach ( $meses as $n => $nome ) : ?>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'hbv_mes', $n, $archive_url ) ); ?>"<?php echo $mes_ativo === $n ? ' aria-current="true"' : ''; ?>><?php echo esc_html( mb_substr( $nome, 0, 3 ) ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		<?php if ( $mes_info['abertura_html'] ) : ?>
			<section class="hbv-mes-abertura hbv-prose" aria-labelledby="mes-abertura">
				<h2 id="mes-abertura" class="hbv-basicas"><?php esc_html_e( 'As informações básicas', 'hbv' ); ?></h2>
				<?php echo wp_kses_post( $mes_info['abertura_html'] ); ?>
			</section>
		<?php endif; ?>

		<?php if ( $groups ) : ?>
			<?php foreach ( $groups as $m => $ids ) : ?>
				<section class="hbv-letra" aria-labelledby="mes-<?php echo esc_attr( $m ); ?>">
					<h2 id="mes-<?php echo esc_attr( $m ); ?>">
						<?php
						if ( $mes_ativo && isset( $meses[ $m ] ) ) {
							/* translators: %s: nome do mês, em minúsculas */
							echo esc_html( sprintf( __( 'Datas e fatos de %s', 'hbv' ), mb_strtolower( $meses[ $m ] ) ) );
						} else {
							echo esc_html( isset( $meses[ $m ] ) ? $meses[ $m ] : __( 'Sem data', 'hbv' ) );
						}
						?>
					</h2>
					<ul class="hbv-fatos">
						<?php
						global $post;
						foreach ( $ids as $id ) {
							$post = get_post( $id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
							setup_postdata( $post );
							get_template_part( 'template-parts/fato' );
						}
						wp_reset_postdata();
						?>
					</ul>
				</section>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="hbv-empty"><?php esc_html_e( 'Nenhum fato cadastrado para este período.', 'hbv' ); ?></p>
		<?php endif; ?>

		<?php if ( $mes_ativo && hbv_core_active() ) : ?>
			<?php get_template_part( 'template-parts/aniversarios', null, array( 'tipo' => 'nascimento', 'mes' => $mes_ativo ) ); ?>
			<?php get_template_part( 'template-parts/aniversarios', null, array( 'tipo' => 'falecimento', 'mes' => $mes_ativo ) ); ?>
		<?php endif; ?>

		<?php if ( $mes_info['bibliografia'] ) : ?>
			<section class="hbv-fontes" aria-labelledby="mes-bibliografia">
				<h2 id="mes-bibliografia"><?php esc_html_e( 'Bibliografia', 'hbv' ); ?></h2>
				<ol>
					<?php foreach ( $mes_info['bibliografia'] as $ref ) : ?>
						<li><?php echo esc_html( $ref ); ?></li>
					<?php endforeach; ?>
				</ol>
			</section>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();

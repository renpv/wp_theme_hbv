<?php
/**
 * Página não encontrada.
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
		<header class="hbv-page-head">
			<p class="hbv-eyebrow">404</p>
			<h1><?php esc_html_e( 'Esta página não foi encontrada', 'hbv' ); ?></h1>
			<p class="hbv-page-head__desc"><?php esc_html_e( 'O endereço pode ter mudado. Pesquise no acervo ou escolha uma seção.', 'hbv' ); ?></p>
		</header>
		<?php get_search_form(); ?>
		<ul class="hbv-tabs" style="margin-top:var(--hbv-space-6)">
			<?php foreach ( hbv_post_type_defs() as $slug => $def ) : ?>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( $slug ) ); ?>"><?php echo esc_html( $def['plural'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</main>
<?php
get_footer();

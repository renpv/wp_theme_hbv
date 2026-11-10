<?php
/**
 * Arquivo genérico dos tipos de conteúdo (lugares, obras, instituições).
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$type = get_queried_object();
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<header class="hbv-page-head hbv-page-head--wide">
			<h1><?php post_type_archive_title(); ?></h1>
			<?php if ( $type && ! empty( $type->description ) ) : ?>
				<p class="hbv-page-head__desc"><?php echo esc_html( $type->description ); ?></p>
			<?php endif; ?>
		</header>

		<?php
		/* Filtros pelas taxonomias do tipo. */
		$tax_map = array(
			'hbv_lugar'       => 'hbv_tipo_lugar',
			'hbv_obra'        => 'hbv_tipo_obra',
			'hbv_instituicao' => 'hbv_tipo_instituicao',
		);
		$pt      = get_query_var( 'post_type' );
		$pt      = is_array( $pt ) ? reset( $pt ) : $pt;
		if ( isset( $tax_map[ $pt ] ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $tax_map[ $pt ],
					'hide_empty' => true,
					'parent'     => 0,
				)
			);
			if ( $terms && ! is_wp_error( $terms ) ) {
				echo '<ul class="hbv-tabs" aria-label="' . esc_attr__( 'Filtrar por tipo', 'hbv' ) . '">';
				foreach ( $terms as $t ) {
					echo '<li><a href="' . esc_url( get_term_link( $t ) ) . '">' . esc_html( $t->name ) . '</a></li>';
				}
				echo '</ul>';
			}
		}
		?>

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
			<p class="hbv-empty"><?php esc_html_e( 'Ainda não há itens cadastrados.', 'hbv' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();

<?php
/**
 * Relação de avenidas, ruas, travessas e becos, em listas numeradas por tipo.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$type_labels = array(
	'avenida'  => 'Avenidas',
	'rua'      => 'Ruas',
	'travessa' => 'Travessas',
	'beco'     => 'Becos',
	'estrada'  => 'Estradas',
	''         => 'Outros logradouros',
);

$groups = array();
while ( have_posts() ) {
	the_post();
	$tipo = (string) get_post_meta( get_the_ID(), 'hbv_tipo', true );
	if ( ! isset( $type_labels[ $tipo ] ) ) {
		$tipo = '';
	}
	$honoree_id = (int) get_post_meta( get_the_ID(), 'hbv_homenageado_id', true );
	$groups[ $tipo ][] = array(
		'url'     => get_permalink(),
		'title'   => get_the_title(),
		'honoree' => $honoree_id ? get_permalink( $honoree_id ) : '',
	);
}
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<header class="hbv-page-head hbv-page-head--wide">
			<h1><?php post_type_archive_title(); ?></h1>
			<p class="hbv-page-head__desc"><?php echo esc_html( get_post_type_object( 'hbv_logradouro' )->description ); ?></p>
		</header>

		<?php if ( $groups ) : ?>
			<div class="hbv-filter">
				<label for="hbv-filtro-ruas"><?php esc_html_e( 'Filtrar por nome', 'hbv' ); ?></label>
				<input type="search" id="hbv-filtro-ruas" data-hbv-filter="#hbv-ruas" autocomplete="off" />
				<p class="hbv-filter__count" id="hbv-filtro-ruas-count" aria-live="polite"></p>
			</div>

			<div id="hbv-ruas">
				<?php foreach ( $type_labels as $key => $label ) : ?>
					<?php
					if ( empty( $groups[ $key ] ) ) {
						continue;
					}
					?>
					<section class="hbv-letra" data-hbv-group aria-labelledby="tipo-<?php echo esc_attr( $key ? $key : 'outros' ); ?>">
						<h2 id="tipo-<?php echo esc_attr( $key ? $key : 'outros' ); ?>">
							<?php echo esc_html( $label ); ?>
							<small style="font-size:var(--hbv-fs-sm);color:var(--hbv-text-muted);font-weight:400">(<?php echo esc_html( count( $groups[ $key ] ) ); ?>)</small>
						</h2>
						<ol class="hbv-numlist">
							<?php foreach ( $groups[ $key ] as $item ) : ?>
								<li data-hbv-item>
									<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
								</li>
							<?php endforeach; ?>
						</ol>
					</section>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="hbv-empty"><?php esc_html_e( 'Nenhum logradouro cadastrado ainda.', 'hbv' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();

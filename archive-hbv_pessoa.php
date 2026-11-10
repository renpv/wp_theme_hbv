<?php
/**
 * Índice alfabético de biografias (A–Z), com filtro por nome e ocupação.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// Agrupa por inicial.
$groups = array();
while ( have_posts() ) {
	the_post();
	$groups[ hbv_initial( get_the_title() ) ][] = array(
		'url'   => get_permalink(),
		'title' => get_the_title(),
		'role'  => (string) get_post_meta( get_the_ID(), 'hbv_ocupacao', true ),
	);
}
ksort( $groups );
$letters = range( 'A', 'Z' );
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<header class="hbv-page-head hbv-page-head--wide">
			<h1><?php post_type_archive_title(); ?></h1>
			<p class="hbv-page-head__desc"><?php echo esc_html( get_post_type_object( 'hbv_pessoa' )->description ); ?></p>
		</header>

		<?php if ( $groups ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Índice alfabético', 'hbv' ); ?>">
				<ul class="hbv-az">
					<?php foreach ( $letters as $l ) : ?>
						<li>
							<?php if ( isset( $groups[ $l ] ) ) : ?>
								<a href="#letra-<?php echo esc_attr( $l ); ?>"><?php echo esc_html( $l ); ?></a>
							<?php else : ?>
								<span aria-hidden="true"><?php echo esc_html( $l ); ?></span>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<div class="hbv-filter">
				<label for="hbv-filtro-pessoas"><?php esc_html_e( 'Filtrar por nome ou ocupação', 'hbv' ); ?></label>
				<input type="search" id="hbv-filtro-pessoas" data-hbv-filter="#hbv-pessoas" autocomplete="off" />
				<p class="hbv-filter__count" id="hbv-filtro-pessoas-count" aria-live="polite"></p>
			</div>

			<div id="hbv-pessoas">
				<?php foreach ( $groups as $letter => $people ) : ?>
					<section class="hbv-letra" id="letra-<?php echo esc_attr( '#' === $letter ? 'outros' : $letter ); ?>" data-hbv-group aria-labelledby="h-<?php echo esc_attr( '#' === $letter ? 'outros' : $letter ); ?>">
						<h2 id="h-<?php echo esc_attr( '#' === $letter ? 'outros' : $letter ); ?>"><?php echo esc_html( $letter ); ?></h2>
						<ul class="hbv-index">
							<?php foreach ( $people as $p ) : ?>
								<li data-hbv-item>
									<a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a>
									<?php if ( $p['role'] ) : ?>
										<span class="hbv-index__meta"><?php echo esc_html( $p['role'] ); ?></span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="hbv-empty"><?php esc_html_e( 'Nenhuma biografia cadastrada ainda.', 'hbv' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();

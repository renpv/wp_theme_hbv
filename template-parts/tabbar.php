<?php
/**
 * Barra de navegação inferior (só no celular) e painel "Menu" com as seções.
 *
 * Os itens podem ser ajustados com o filtro hbv_tabbar_items. "Linha do tempo" e "Mapa"
 * só aparecem se a página existir (endereços linha-do-tempo e mapa).
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$timeline = get_page_by_path( 'linha-do-tempo' );
$map_page = get_page_by_path( 'mapa' );

$items = array(
	'inicio' => array(
		'label'   => __( 'Início', 'hbv' ),
		'url'     => home_url( '/' ),
		'icon'    => 'home',
		'current' => is_front_page(),
	),
	'buscar' => array(
		'label'   => __( 'Buscar', 'hbv' ),
		'url'     => home_url( '/?s=' ),
		'icon'    => 'search',
		'current' => is_search(),
		'search'  => true,
	),
);
if ( $timeline ) {
	$items['tempo'] = array(
		'label'   => __( 'Linha do tempo', 'hbv' ),
		'url'     => get_permalink( $timeline ),
		'icon'    => 'clock',
		'current' => is_page( $timeline->ID ),
	);
}
if ( $map_page ) {
	$items['mapa'] = array(
		'label'   => __( 'Mapa', 'hbv' ),
		'url'     => get_permalink( $map_page ),
		'icon'    => 'pin',
		'current' => is_page( $map_page->ID ),
	);
}
$items = apply_filters( 'hbv_tabbar_items', $items );

/* Seções do menu principal (só o primeiro nível). */
$sections  = array();
$locations = get_nav_menu_locations();
if ( ! empty( $locations['primary'] ) ) {
	$menu_items = wp_get_nav_menu_items( $locations['primary'] );
	if ( $menu_items ) {
		foreach ( $menu_items as $menu_item ) {
			if ( 0 === (int) $menu_item->menu_item_parent ) {
				$sections[] = $menu_item;
			}
		}
	}
}

/* Links de apoio, como no rodapé. */
$extra = array();
foreach ( array( 'fale-conosco' => __( 'Fale conosco', 'hbv' ), 'direitos-autorais' => __( 'Direitos autorais', 'hbv' ) ) as $slug => $label ) {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		$extra[ get_permalink( $page ) ] = $label;
	}
}
if ( get_privacy_policy_url() ) {
	$extra[ get_privacy_policy_url() ] = __( 'Privacidade', 'hbv' );
}
?>

<div class="hbv-sheet" id="hbv-sheet" role="region" aria-label="<?php esc_attr_e( 'Menu de seções', 'hbv' ); ?>" hidden>
	<?php if ( $sections ) : ?>
		<h2><?php esc_html_e( 'Seções', 'hbv' ); ?></h2>
		<ul class="hbv-sheet__list">
			<?php foreach ( $sections as $section ) : ?>
				<?php $slug = ( 'page' === $section->object ) ? get_post_field( 'post_name', (int) $section->object_id ) : ''; ?>
				<li>
					<a href="<?php echo esc_url( $section->url ); ?>">
						<?php echo hbv_section_icon( $slug ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de lista fixa, escapado em hbv_icon(). ?>
						<?php echo esc_html( $section->title ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<div class="hbv-sheet__row">
		<span id="hbv-sheet-tema"><?php esc_html_e( 'Aparência', 'hbv' ); ?></span>
		<?php hbv_theme_toggle( 'hbv-sheet-tema' ); ?>
	</div>

	<?php if ( $extra ) : ?>
		<ul class="hbv-sheet__list hbv-sheet__list--extra">
			<?php foreach ( $extra as $url => $label ) : ?>
				<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>

<nav class="hbv-tabbar" aria-label="<?php esc_attr_e( 'Navegação no celular', 'hbv' ); ?>">
	<ul>
		<?php foreach ( $items as $item ) : ?>
			<li>
				<a href="<?php echo esc_url( $item['url'] ); ?>"<?php echo ! empty( $item['current'] ) ? ' aria-current="page"' : ''; ?><?php echo ! empty( $item['search'] ) ? ' data-hbv-focus-search' : ''; ?>>
					<?php echo hbv_icon( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de lista fixa, escapado em hbv_icon(). ?>
					<span><?php echo esc_html( $item['label'] ); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
		<li>
			<button type="button" aria-expanded="false" aria-controls="hbv-sheet">
				<?php echo hbv_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de lista fixa, escapado em hbv_icon(). ?>
				<span><?php esc_html_e( 'Menu', 'hbv' ); ?></span>
			</button>
		</li>
	</ul>
</nav>

<?php
/**
 * Estrutura inicial: cria as páginas de seção e o menu principal em um clique.
 * Ferramentas > Estrutura inicial HBV.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Páginas a criar (slug => título, modelo).
 * Slugs seguem os endereços atuais do site para preservar links.
 *
 * @return array
 */
function hbv_starter_pages() {
	$secao = 'page-templates/page-secao.php';
	return array(
		'editorial'                              => array( 'Editorial', $secao ),
		'direitos-autorais'                      => array( 'Direitos Autorais', '' ),
		'fale-conosco'                           => array( 'Fale Conosco', '' ),
		'quem-somos'                             => array( 'Quem Somos', '' ),
		'a-historia-do-municipio-de-boa-viagem'  => array( 'A História do Município', $secao ),
		'os-simbolos-municipais'                 => array( 'Os Símbolos Municipais', '' ),
		'a-historia-da-cidade-de-boa-viagem'     => array( 'A Cidade', $secao ),
		'o-acesso'                               => array( 'O Acesso', '' ),
		'a-urbanizacao-da-cidade'                => array( 'A Urbanização da Cidade', '' ),
		'cultura'                                => array( 'A Cultura', $secao ),
		'educacao'                               => array( 'A Educação', $secao ),
		'historia-politica'                      => array( 'A História Política', $secao ),
		'saude'                                  => array( 'A Saúde', $secao ),
		'turismo'                                => array( 'O Turismo', $secao ),
		'linha-do-tempo'                         => array( 'Linha do tempo', 'page-templates/page-linha-do-tempo.php' ),
	);
}

/**
 * Menu principal. Cada item: título + destino.
 * Destinos: page (slug), archive (tipo de conteúdo), term (taxonomia, slug).
 *
 * @return array
 */
function hbv_starter_menu() {
	return array(
		array(
			'Editorial',
			array( 'page' => 'editorial' ),
			array(
				array( 'Direitos Autorais', array( 'page' => 'direitos-autorais' ) ),
				array( 'Fale Conosco', array( 'page' => 'fale-conosco' ) ),
				array( 'Quem Somos', array( 'page' => 'quem-somos' ) ),
			),
		),
		array(
			'A História do Município',
			array( 'page' => 'a-historia-do-municipio-de-boa-viagem' ),
			array(
				array(
					'A Economia',
					array( 'term' => array( 'hbv_tema', 'economia' ) ),
					array(
						array( 'Os Recursos Hídricos', array( 'term' => array( 'hbv_tema', 'recursos-hidricos' ) ) ),
					),
				),
				array(
					'Os Distritos',
					array( 'term' => array( 'hbv_tipo_lugar', 'distrito' ) ),
					array(
						array( 'As Localidades', array( 'term' => array( 'hbv_tipo_lugar', 'localidade' ) ) ),
					),
				),
				array( 'Os Cartórios', array( 'term' => array( 'hbv_tipo_instituicao', 'cartorio' ) ) ),
				array( 'Os Símbolos Municipais', array( 'page' => 'os-simbolos-municipais' ) ),
			),
		),
		array(
			'A Cidade',
			array( 'page' => 'a-historia-da-cidade-de-boa-viagem' ),
			array(
				array( 'O Acesso', array( 'page' => 'o-acesso' ) ),
				array(
					'Os Bairros',
					array( 'term' => array( 'hbv_tipo_lugar', 'bairro' ) ),
					array(
						array(
							'A Urbanização da Cidade',
							array( 'page' => 'a-urbanizacao-da-cidade' ),
							array(
								array( 'Avenidas, Ruas e Travessas', array( 'archive' => 'hbv_logradouro' ) ),
								array( 'As Praças', array( 'term' => array( 'hbv_tipo_lugar', 'praca' ) ) ),
							),
						),
					),
				),
			),
		),
		array(
			'A Cultura',
			array( 'page' => 'cultura' ),
			array(
				array( 'A Literatura Boa-viagense', array( 'term' => array( 'hbv_tipo_obra', 'literatura' ) ) ),
				array( 'A Música Boa-viagense', array( 'term' => array( 'hbv_tipo_obra', 'musica' ) ) ),
				array( 'A Religiosidade Boa-viagense', array( 'term' => array( 'hbv_tema', 'religiosidade' ) ) ),
				array( 'As Biografias', array( 'archive' => 'hbv_pessoa' ) ),
				array( 'As Datas e os Fatos', array( 'archive' => 'hbv_fato' ) ),
				array( 'As Necrópoles', array( 'term' => array( 'hbv_tipo_lugar', 'necropole' ) ) ),
				array( 'O Cinema Boa-viagense', array( 'term' => array( 'hbv_tipo_obra', 'cinema' ) ) ),
			),
		),
		array(
			'A Educação',
			array( 'page' => 'educacao' ),
			array(
				array( 'O Esporte', array( 'term' => array( 'hbv_tema', 'esporte' ) ) ),
			),
		),
		array(
			'A História Política',
			array( 'page' => 'historia-politica' ),
			array(
				array( 'O Governo', array( 'term' => array( 'hbv_papel', 'prefeito' ) ) ),
				array( 'As Primeiras-damas', array( 'term' => array( 'hbv_papel', 'primeira-dama' ) ) ),
			),
		),
		array(
			'A Saúde',
			array( 'page' => 'saude' ),
			array(
				array(
					'Rede Pública',
					array( 'term' => array( 'hbv_tipo_instituicao', 'rede-publica' ) ),
					array(
						array( 'Atenção Primária', array( 'term' => array( 'hbv_tipo_instituicao', 'atencao-primaria' ) ) ),
						array( 'Atenção Secundária', array( 'term' => array( 'hbv_tipo_instituicao', 'atencao-secundaria' ) ) ),
						array( 'Atenção Terciária', array( 'term' => array( 'hbv_tipo_instituicao', 'atencao-terciaria' ) ) ),
					),
				),
				array( 'Rede Privada', array( 'term' => array( 'hbv_tipo_instituicao', 'rede-privada' ) ) ),
			),
		),
		array(
			'O Turismo',
			array( 'page' => 'turismo' ),
			array(
				array( 'A Hospedagem', array( 'term' => array( 'hbv_tipo_instituicao', 'hospedagem' ) ) ),
				array( 'Clubes e Casas de Shows', array( 'term' => array( 'hbv_tipo_instituicao', 'clubes-e-casas-de-shows' ) ) ),
			),
		),
	);
}

/**
 * Cria (ou reaproveita) uma página.
 *
 * @param string $slug Slug.
 * @return int ID da página, ou 0.
 */
function hbv_starter_page( $slug ) {
	$pages = hbv_starter_pages();
	if ( ! isset( $pages[ $slug ] ) ) {
		return 0;
	}
	$existing = get_page_by_path( $slug );
	if ( $existing ) {
		return (int) $existing->ID;
	}
	$args = array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => $pages[ $slug ][0],
		'post_name'    => $slug,
		'post_content' => '<!-- wp:paragraph --><p>Conteúdo em elaboração.</p><!-- /wp:paragraph -->',
	);
	if ( $pages[ $slug ][1] ) {
		$args['page_template'] = $pages[ $slug ][1];
	}
	$id = wp_insert_post( $args, true );
	return is_wp_error( $id ) ? 0 : (int) $id;
}

/**
 * Adiciona itens ao menu, recursivamente.
 *
 * @param int   $menu_id Menu.
 * @param array $items   Itens.
 * @param int   $parent  ID do item pai.
 */
function hbv_starter_add_items( $menu_id, $items, $parent = 0 ) {
	foreach ( $items as $item ) {
		$title  = $item[0];
		$target = $item[1];
		$kids   = isset( $item[2] ) ? $item[2] : array();

		$args = array(
			'menu-item-title'     => $title,
			'menu-item-status'    => 'publish',
			'menu-item-parent-id' => $parent,
		);

		if ( isset( $target['page'] ) ) {
			$page_id = hbv_starter_page( $target['page'] );
			if ( ! $page_id ) {
				continue;
			}
			$args['menu-item-type']      = 'post_type';
			$args['menu-item-object']    = 'page';
			$args['menu-item-object-id'] = $page_id;
		} elseif ( isset( $target['archive'] ) ) {
			$args['menu-item-type']   = 'post_type_archive';
			$args['menu-item-object'] = $target['archive'];
		} elseif ( isset( $target['term'] ) ) {
			$term = get_term_by( 'slug', $target['term'][1], $target['term'][0] );
			if ( ! $term ) {
				continue;
			}
			$args['menu-item-type']      = 'taxonomy';
			$args['menu-item-object']    = $target['term'][0];
			$args['menu-item-object-id'] = (int) $term->term_id;
		} else {
			continue;
		}

		$item_id = wp_update_nav_menu_item( $menu_id, 0, $args );
		if ( ! is_wp_error( $item_id ) && $kids ) {
			hbv_starter_add_items( $menu_id, $kids, (int) $item_id );
		}
	}
}

/**
 * Executa a criação da estrutura.
 *
 * @return string Mensagem de resultado.
 */
function hbv_starter_run() {
	hbv_seed_terms();

	foreach ( array_keys( hbv_starter_pages() ) as $slug ) {
		hbv_starter_page( $slug );
	}

	$name = 'Menu principal HBV';
	if ( wp_get_nav_menu_object( $name ) ) {
		return __( 'O menu "Menu principal HBV" já existe. Nada foi alterado no menu; páginas e termos faltantes foram criados.', 'hbv' );
	}

	$menu_id = wp_create_nav_menu( $name );
	if ( is_wp_error( $menu_id ) ) {
		return $menu_id->get_error_message();
	}

	hbv_starter_add_items( $menu_id, hbv_starter_menu() );

	$locations            = get_theme_mod( 'nav_menu_locations', array() );
	$locations['primary'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );

	return __( 'Pronto: páginas de seção, termos padrão e menu principal criados.', 'hbv' );
}

/**
 * Tela em Ferramentas.
 */
function hbv_starter_menu_page() {
	add_management_page(
		__( 'Estrutura inicial HBV', 'hbv' ),
		__( 'Estrutura inicial HBV', 'hbv' ),
		'manage_options',
		'hbv-starter',
		'hbv_starter_screen'
	);
}
add_action( 'admin_menu', 'hbv_starter_menu_page' );

/**
 * Conteúdo da tela.
 */
function hbv_starter_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$msg = '';
	if ( isset( $_POST['hbv_starter_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hbv_starter_nonce'] ) ), 'hbv_starter' ) ) {
		$msg = hbv_starter_run();
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Estrutura inicial HBV', 'hbv' ); ?></h1>
		<?php if ( $msg ) : ?>
			<div class="notice notice-success"><p><?php echo esc_html( $msg ); ?></p></div>
		<?php endif; ?>
		<p><?php esc_html_e( 'Cria as páginas de seção (Editorial, A Cidade, A Cultura, A Educação, A História Política, A Saúde, O Turismo e outras), os termos padrão de temas, períodos e tipos, e o menu principal com três níveis, igual ao mapa do site. Pode ser executado mais de uma vez: o que já existe é reaproveitado.', 'hbv' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'hbv_starter', 'hbv_starter_nonce' ); ?>
			<?php submit_button( __( 'Criar estrutura inicial', 'hbv' ) ); ?>
		</form>
	</div>
	<?php
}

<?php
/**
 * História de Boa Viagem — Memória: funções do tema.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HBV_VERSION', '1.2.0' );
define( 'HBV_DIR', get_template_directory() );
define( 'HBV_URI', get_template_directory_uri() );

// Tipos, taxonomias e campos ficam no plugin HBV Core (ver inc/compat.php).
require_once HBV_DIR . '/inc/compat.php';
require_once HBV_DIR . '/inc/template-tags.php';
require_once HBV_DIR . '/inc/patterns.php';
require_once HBV_DIR . '/inc/starter.php';

/**
 * Suportes do tema, menus e tamanhos de imagem.
 */
function hbv_setup() {
	load_theme_textdomain( 'hbv', HBV_DIR . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	add_theme_support(
		'custom-header',
		array(
			'width'       => 1600,
			'height'      => 560,
			'flex-width'  => true,
			'flex-height' => true,
			'header-text' => false,
		)
	);
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/tokens.css', 'assets/css/editor.css' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Menu principal', 'hbv' ),
			'footer'  => __( 'Menu do rodapé', 'hbv' ),
		)
	);

	add_image_size( 'hbv-card', 640, 400, true );
	add_image_size( 'hbv-hero', 1600, 560, true );
}
add_action( 'after_setup_theme', 'hbv_setup' );

/**
 * Largura de conteúdo para embeds.
 */
function hbv_content_width() {
	$GLOBALS['content_width'] = 720;
}
add_action( 'after_setup_theme', 'hbv_content_width', 0 );

/**
 * Áreas de widgets.
 */
function hbv_widgets_init() {
	$base = array(
		'before_widget' => '<section id="%1$s" class="hbv-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="hbv-widget__title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array_merge(
			$base,
			array(
				'name'        => __( 'Barra lateral', 'hbv' ),
				'id'          => 'sidebar-main',
				'description' => __( 'Aparece ao lado de artigos, páginas e arquivos.', 'hbv' ),
			)
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array_merge(
				$base,
				array(
					/* translators: %d: número da coluna */
					'name' => sprintf( __( 'Rodapé, coluna %d', 'hbv' ), $i ),
					'id'   => 'footer-' . $i,
				)
			)
		);
	}
}
add_action( 'widgets_init', 'hbv_widgets_init' );

/**
 * Estilos e scripts. Sem fontes ou scripts de terceiros (LGPD e desempenho).
 */
function hbv_enqueue() {
	wp_enqueue_style( 'hbv-tokens', HBV_URI . '/assets/css/tokens.css', array(), HBV_VERSION );
	wp_enqueue_style( 'hbv-style', get_stylesheet_uri(), array( 'hbv-tokens' ), HBV_VERSION );
	wp_enqueue_script(
		'hbv-main',
		HBV_URI . '/assets/js/main.js',
		array(),
		HBV_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hbv_enqueue' );

/**
 * Remove o script de emoji (menos requisições).
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Resumos curtos.
 */
add_filter(
	'excerpt_length',
	static function () {
		return 28;
	}
);
add_filter(
	'excerpt_more',
	static function () {
		return '…';
	}
);

/**
 * Títulos de arquivo sem o prefixo "Categoria:", "Tag:" etc.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Query var para filtrar "Datas e fatos" por mês (?hbv_mes=1..12).
 */
add_filter(
	'query_vars',
	static function ( $vars ) {
		$vars[] = 'hbv_mes';
		return $vars;
	}
);

/**
 * Ajustes das consultas de arquivo.
 *
 * @param WP_Query $q Consulta principal.
 */
function hbv_pre_get_posts( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}

	// Índices completos: tudo em uma página, em ordem alfabética.
	if ( $q->is_post_type_archive( array( 'hbv_pessoa', 'hbv_logradouro' ) ) ) {
		$q->set( 'posts_per_page', -1 );
		$q->set( 'orderby', 'title' );
		$q->set( 'order', 'ASC' );
		$q->set( 'no_found_rows', true );
	}

	// Calendário de fatos: ordena por mês e dia.
	if ( $q->is_post_type_archive( 'hbv_fato' ) ) {
		$mes  = absint( $q->get( 'hbv_mes' ) );
		$meta = array(
			'relation'        => 'AND',
			'hbv_mes_clause'  => array(
				'key'     => 'hbv_mes',
				'type'    => 'NUMERIC',
				'compare' => 'EXISTS',
			),
			// Fatos sem dia (só mês) também entram: EXISTS OR NOT EXISTS. Sem dia, o valor
			// é NULL e vem primeiro no mês (ordem crescente).
			'hbv_dia_group'   => array(
				'relation'           => 'OR',
				'hbv_dia_clause'     => array(
					'key'     => 'hbv_dia',
					'type'    => 'NUMERIC',
					'compare' => 'EXISTS',
				),
				'hbv_sem_dia_clause' => array(
					'key'     => 'hbv_dia',
					'compare' => 'NOT EXISTS',
				),
			),
		);
		if ( $mes >= 1 && $mes <= 12 ) {
			$meta['hbv_mes_clause'] = array(
				'key'     => 'hbv_mes',
				'value'   => $mes,
				'type'    => 'NUMERIC',
				'compare' => '=',
			);
		}
		$q->set( 'meta_query', $meta );
		$q->set(
			'orderby',
			array(
				'hbv_mes_clause' => 'ASC',
				'hbv_dia_clause' => 'ASC',
				'title'          => 'ASC',
			)
		);
		$q->set( 'posts_per_page', -1 );
		$q->set( 'no_found_rows', true );
	}

	// Lugares e demais arquivos: ordem alfabética.
	if ( $q->is_post_type_archive( array( 'hbv_lugar', 'hbv_instituicao', 'hbv_obra' ) ) || $q->is_tax( array( 'hbv_tipo_lugar', 'hbv_tipo_instituicao', 'hbv_tipo_obra', 'hbv_papel' ) ) ) {
		$q->set( 'orderby', 'title' );
		$q->set( 'order', 'ASC' );
	}

	// Períodos em ordem cronológica.
	if ( $q->is_tax( 'hbv_periodo' ) ) {
		$q->set( 'orderby', 'date' );
		$q->set( 'order', 'ASC' );
	}

	// A busca procura em todos os tipos de conteúdo.
	if ( $q->is_search() ) {
		$q->set( 'post_type', array_merge( array( 'post', 'page' ), hbv_cpts() ) );
	}
}
add_action( 'pre_get_posts', 'hbv_pre_get_posts' );

/**
 * Taxonomias aplicam-se também aos tipos de conteúdo (arquivos de termo mostram todos).
 *
 * @param WP_Query $q Consulta.
 */
function hbv_tax_all_types( $q ) {
	if ( is_admin() || ! $q->is_main_query() ) {
		return;
	}
	if ( $q->is_tax( array( 'hbv_tema', 'hbv_periodo' ) ) ) {
		$q->set( 'post_type', array_merge( array( 'post', 'page' ), hbv_cpts() ) );
	}
}
add_action( 'pre_get_posts', 'hbv_tax_all_types' );

/**
 * Templates genéricos para os tipos de conteúdo do tema.
 * single-hbv.php e archive-hbv.php entram antes do fallback single.php / archive.php.
 */
add_filter(
	'single_template_hierarchy',
	static function ( $templates ) {
		if ( is_singular( hbv_cpts() ) ) {
			array_splice( $templates, -1, 0, 'single-hbv.php' );
		}
		return $templates;
	}
);
add_filter(
	'archive_template_hierarchy',
	static function ( $templates ) {
		if ( is_post_type_archive( hbv_cpts() ) ) {
			array_splice( $templates, -1, 0, 'archive-hbv.php' );
		}
		return $templates;
	}
);

/**
 * Classes de corpo úteis.
 *
 * @param string[] $classes Classes.
 * @return string[]
 */
function hbv_body_classes( $classes ) {
	if ( is_singular( hbv_cpts() ) ) {
		$classes[] = 'hbv-cpt-' . get_post_type();
	}
	return $classes;
}
add_filter( 'body_class', 'hbv_body_classes' );

/**
 * Ao ativar o tema: cria os termos padrão (se o HBV Core estiver ativo) e
 * atualiza os links permanentes.
 */
function hbv_after_switch_theme() {
	if ( function_exists( 'hbv_seed_terms' ) ) {
		hbv_seed_terms();
	}
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'hbv_after_switch_theme' );

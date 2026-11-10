<?php
/**
 * Padrões de bloco e estilos de bloco para o texto histórico.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Estilos de bloco.
 */
function hbv_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'hbv-fonte',
			'label' => __( 'Citação de fonte', 'hbv' ),
		)
	);
	register_block_style(
		'core/quote',
		array(
			'name'  => 'hbv-lei',
			'label' => __( 'Texto de lei', 'hbv' ),
		)
	);
	register_block_style(
		'core/image',
		array(
			'name'  => 'hbv-historica',
			'label' => __( 'Imagem histórica', 'hbv' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'hbv-nota',
			'label' => __( 'Nota do editor', 'hbv' ),
		)
	);
}
add_action( 'init', 'hbv_register_block_styles' );

/**
 * Categoria e padrões de bloco.
 */
function hbv_register_patterns() {
	register_block_pattern_category(
		'hbv-memoria',
		array( 'label' => __( 'História de Boa Viagem', 'hbv' ) )
	);

	$patterns = array(
		'hbv/informacoes-basicas' => array(
			'title'       => __( 'As informações básicas', 'hbv' ),
			'description' => __( 'Abertura de artigo com título de seção e parágrafo introdutório.', 'hbv' ),
			'content'     => '<!-- wp:heading {"level":2,"className":"hbv-basicas"} -->
<h2 class="wp-block-heading hbv-basicas">As informações básicas</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Apresente o assunto em um ou dois parágrafos: o que é, onde fica, quando surgiu e por que importa para a história do Município.</p>
<!-- /wp:paragraph -->',
		),
		'hbv/momento-historico'   => array(
			'title'       => __( 'Momento histórico', 'hbv' ),
			'description' => __( 'Bloco para cada período do texto: faixa de anos, título e texto.', 'hbv' ),
			'content'     => '<!-- wp:group {"className":"hbv-momento","layout":{"type":"constrained"}} -->
<div class="wp-block-group hbv-momento"><!-- wp:paragraph {"className":"hbv-momento__periodo"} -->
<p class="hbv-momento__periodo">1743 a 1864</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">1º Momento: título do período</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Texto do período.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
		),
		'hbv/citacao-fonte'       => array(
			'title'       => __( 'Citação com fonte', 'hbv' ),
			'description' => __( 'Trecho de livro, jornal ou documento com a referência (AUTOR, ano: p. n).', 'hbv' ),
			'content'     => '<!-- wp:quote {"className":"is-style-hbv-fonte"} -->
<blockquote class="wp-block-quote is-style-hbv-fonte"><!-- wp:paragraph -->
<p>Transcreva o trecho mantendo a grafia original.</p>
<!-- /wp:paragraph --><cite>SOBRENOME, ano: p. 00</cite></blockquote>
<!-- /wp:quote -->',
		),
		'hbv/texto-de-lei'        => array(
			'title'       => __( 'Texto de lei ou decreto', 'hbv' ),
			'description' => __( 'Artigo de lei, decreto ou código de posturas citado.', 'hbv' ),
			'content'     => '<!-- wp:quote {"className":"is-style-hbv-lei"} -->
<blockquote class="wp-block-quote is-style-hbv-lei"><!-- wp:paragraph -->
<p>Art. 1º – Texto do artigo.</p>
<!-- /wp:paragraph --><cite>Lei nº 000, de 00 de mês de ano</cite></blockquote>
<!-- /wp:quote -->',
		),
		'hbv/imagem-historica'    => array(
			'title'       => __( 'Imagem histórica com legenda', 'hbv' ),
			'description' => __( 'Fotografia antiga com legenda padrão: assunto, local e ano.', 'hbv' ),
			'content'     => '<!-- wp:image {"sizeSlug":"large","linkDestination":"none","className":"is-style-hbv-historica"} -->
<figure class="wp-block-image size-large is-style-hbv-historica"><img alt=""/><figcaption class="wp-element-caption">Imagem de [assunto], [local], [ano]. Acervo: [fonte].</figcaption></figure>
<!-- /wp:image -->',
		),
		'hbv/cronologia'          => array(
			'title'       => __( 'Cronologia', 'hbv' ),
			'description' => __( 'Lista de anos e fatos.', 'hbv' ),
			'content'     => '<!-- wp:list {"className":"hbv-cronologia"} -->
<ul class="wp-block-list hbv-cronologia"><!-- wp:list-item -->
<li><strong>1743</strong> Primeiras habitações no Cavalo Morto.</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><strong>1864</strong> Emancipação política.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->',
		),
		'hbv/nota-do-editor'      => array(
			'title'       => __( 'Nota do editor', 'hbv' ),
			'description' => __( 'Esclarecimento, correção ou convite à colaboração.', 'hbv' ),
			'content'     => '<!-- wp:group {"className":"is-style-hbv-nota","layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-hbv-nota"><!-- wp:paragraph -->
<p><strong>Nota do editor.</strong> Se você tem informações ou fotografias sobre este assunto, escreva pela página Fale Conosco.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->',
		),
		'hbv/bibliografia'        => array(
			'title'       => __( 'Bibliografia', 'hbv' ),
			'description' => __( 'Lista numerada de referências no fim do artigo.', 'hbv' ),
			'content'     => '<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Bibliografia</h2>
<!-- /wp:heading -->
<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>SOBRENOME, Nome. <em>Título da obra</em>. Cidade: Editora, ano.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->',
		),
	);

	foreach ( $patterns as $name => $pattern ) {
		register_block_pattern(
			$name,
			array(
				'title'       => $pattern['title'],
				'description' => $pattern['description'],
				'categories'  => array( 'hbv-memoria' ),
				'content'     => $pattern['content'],
			)
		);
	}
}
add_action( 'init', 'hbv_register_patterns' );

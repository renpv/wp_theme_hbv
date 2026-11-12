<?php
/**
 * Funções de apoio dos templates.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rótulo do tipo de conteúdo ("Biografia", "Lugar", "Artigo"...).
 *
 * @param int|WP_Post|null $post Conteúdo.
 * @return string
 */
function hbv_type_label( $post = null ) {
	$type = get_post_type( $post );
	$defs = hbv_post_type_defs();
	if ( isset( $defs[ $type ] ) ) {
		return $defs[ $type ]['singular'];
	}
	return 'page' === $type ? __( 'Página', 'hbv' ) : __( 'Artigo', 'hbv' );
}

/**
 * Formata o valor de um campo da ficha (retorna HTML já escapado).
 *
 * @param mixed $value Valor salvo.
 * @param array $field Definição do campo.
 * @return string
 */
function hbv_format_field( $value, $field ) {
	switch ( $field['type'] ) {
		case 'select':
			return esc_html( isset( $field['options'][ $value ] ) ? $field['options'][ $value ] : $value );
		case 'url':
			$label = preg_replace( '#^https?://(www\.)?#', '', (string) $value );
			return '<a href="' . esc_url( $value ) . '" rel="noopener">' . esc_html( rtrim( $label, '/' ) ) . '</a>';
		case 'post':
			$target = get_post( (int) $value );
			if ( $target && 'publish' === $target->post_status ) {
				return '<a href="' . esc_url( get_permalink( $target ) ) . '">' . esc_html( get_the_title( $target ) ) . '</a>';
			}
			return '';
		case 'textarea':
			return nl2br( esc_html( $value ) );
		default:
			return esc_html( $value );
	}
}

/**
 * Ficha técnica: lista de campos preenchidos.
 *
 * @param int $post_id ID do conteúdo.
 */
function hbv_ficha( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$rows    = array();

	foreach ( hbv_fields_for( get_post_type( $post_id ) ) as $key => $field ) {
		if ( 'fontes' === $key ) {
			continue;
		}
		$value = get_post_meta( $post_id, 'hbv_' . $key, true );
		if ( '' === $value || false === $value || 0 === $value || '0' === $value ) {
			continue;
		}
		$html = hbv_format_field( $value, $field );
		if ( '' === $html ) {
			continue;
		}
		$rows[] = array( $field['label'], $html );
	}

	if ( ! $rows ) {
		return;
	}

	echo '<dl class="hbv-ficha">';
	foreach ( $rows as $row ) {
		echo '<div><dt>' . esc_html( $row[0] ) . '</dt><dd>' . wp_kses_post( $row[1] ) . '</dd></div>';
	}
	echo '</dl>';
}

/**
 * Seção "Fontes e bibliografia" (uma fonte por linha).
 *
 * @param int $post_id ID do conteúdo.
 */
function hbv_fontes( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$raw     = (string) get_post_meta( $post_id, 'hbv_fontes', true );
	$lines   = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) ) );

	if ( ! $lines ) {
		return;
	}

	echo '<section class="hbv-fontes" aria-labelledby="hbv-fontes-title"><h2 id="hbv-fontes-title">' . esc_html__( 'Fontes e bibliografia', 'hbv' ) . '</h2><ol>';
	foreach ( $lines as $line ) {
		echo '<li>' . esc_html( $line ) . '</li>';
	}
	echo '</ol></section>';
}

/**
 * Data de publicação e de atualização.
 */
function hbv_posted_on() {
	$published = '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'j \d\e F \d\e Y' ) ) . '</time>';
	echo '<ul class="hbv-meta"><li>' . esc_html__( 'Publicado em', 'hbv' ) . ' ' . $published . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado acima.

	if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) {
		echo '<li>' . esc_html__( 'Atualizado em', 'hbv' ) . ' <time datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date( 'j \d\e F \d\e Y' ) ) . '</time></li>';
	}

	if ( 'page' !== get_post_type() ) {
		echo '<li>' . esc_html__( 'Por', 'hbv' ) . ' <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Selos de tema e período do conteúdo atual.
 */
function hbv_badges() {
	$out = '';
	foreach ( array( 'hbv_tema' => 'hbv-badge--tema', 'hbv_periodo' => 'hbv-badge--periodo' ) as $tax => $class ) {
		$terms = get_the_terms( get_the_ID(), $tax );
		if ( ! $terms || is_wp_error( $terms ) ) {
			continue;
		}
		foreach ( $terms as $term ) {
			$out .= '<li><a class="hbv-badge ' . esc_attr( $class ) . '" href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
		}
	}
	if ( $out ) {
		echo '<ul class="hbv-badges">' . $out . '</ul>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado acima.
	}
}

/**
 * Links de compartilhamento sem scripts de terceiros.
 */
function hbv_share_links() {
	$url   = get_permalink();
	$title = get_the_title();
	$u     = rawurlencode( $url );
	$t     = rawurlencode( $title );
	?>
	<ul class="hbv-share" aria-label="<?php esc_attr_e( 'Compartilhar', 'hbv' ); ?>">
		<li class="hbv-share__label"><?php esc_html_e( 'Compartilhar', 'hbv' ); ?></li>
		<li><a href="<?php echo esc_url( 'https://wa.me/?text=' . $t . '%20' . $u ); ?>" target="_blank" rel="noopener noreferrer">WhatsApp</a></li>
		<li><a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $u ); ?>" target="_blank" rel="noopener noreferrer">Facebook</a></li>
		<li><a href="<?php echo esc_url( 'mailto:?subject=' . $t . '&body=' . $u, array( 'mailto' ) ); ?>"><?php esc_html_e( 'E-mail', 'hbv' ); ?></a></li>
		<li><button type="button" data-hbv-copy="<?php echo esc_attr( $url ); ?>"><?php esc_html_e( 'Copiar link', 'hbv' ); ?></button></li>
	</ul>
	<?php
}

/**
 * Trilha de navegação (breadcrumbs).
 */
function hbv_breadcrumbs() {
	if ( is_front_page() ) {
		return;
	}

	$items   = array();
	$items[] = array( __( 'Início', 'hbv' ), home_url( '/' ) );

	if ( is_singular() ) {
		$post = get_queried_object();
		$type = get_post_type_object( $post->post_type );

		if ( in_array( $post->post_type, hbv_cpts(), true ) && $type && $type->has_archive ) {
			$items[] = array( $type->labels->name, get_post_type_archive_link( $post->post_type ) );
		}
		if ( 'post' === $post->post_type && get_option( 'page_for_posts' ) ) {
			$items[] = array( get_the_title( get_option( 'page_for_posts' ) ), get_permalink( get_option( 'page_for_posts' ) ) );
		}
		if ( is_post_type_hierarchical( $post->post_type ) ) {
			$ancestors = array_reverse( get_post_ancestors( $post ) );
			foreach ( $ancestors as $ancestor_id ) {
				$items[] = array( get_the_title( $ancestor_id ), get_permalink( $ancestor_id ) );
			}
		}
		$items[] = array( get_the_title( $post ), '' );
	} elseif ( is_post_type_archive() ) {
		$items[] = array( post_type_archive_title( '', false ), '' );
	} elseif ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();
		if ( $term && is_taxonomy_hierarchical( $term->taxonomy ) ) {
			foreach ( array_reverse( get_ancestors( $term->term_id, $term->taxonomy, 'taxonomy' ) ) as $ancestor_id ) {
				$ancestor = get_term( $ancestor_id, $term->taxonomy );
				if ( $ancestor && ! is_wp_error( $ancestor ) ) {
					$items[] = array( $ancestor->name, get_term_link( $ancestor ) );
				}
			}
		}
		$items[] = array( single_term_title( '', false ), '' );
	} elseif ( is_search() ) {
		$items[] = array( __( 'Busca', 'hbv' ), '' );
	} elseif ( is_404() ) {
		$items[] = array( __( 'Página não encontrada', 'hbv' ), '' );
	} elseif ( is_home() ) {
		$items[] = array( __( 'Publicações', 'hbv' ), '' );
	}

	echo '<nav class="hbv-breadcrumbs" aria-label="' . esc_attr__( 'Você está em', 'hbv' ) . '"><ol>';
	$last = count( $items ) - 1;
	foreach ( $items as $i => $item ) {
		if ( $i === $last || '' === $item[1] ) {
			echo '<li aria-current="page">' . esc_html( $item[0] ) . '</li>';
		} else {
			echo '<li><a href="' . esc_url( $item[1] ) . '">' . esc_html( $item[0] ) . '</a></li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * Paginação em português.
 */
function hbv_pagination() {
	the_posts_pagination(
		array(
			'mid_size'           => 2,
			'prev_text'          => __( '← Anteriores', 'hbv' ),
			'next_text'          => __( 'Próximos →', 'hbv' ),
			'screen_reader_text' => __( 'Navegação entre páginas', 'hbv' ),
			'class'              => 'hbv-pagination',
		)
	);
}

/**
 * Períodos históricos em ordem cronológica.
 *
 * @return WP_Term[]
 */
function hbv_get_periodos() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'hbv_periodo',
			'hide_empty' => false,
			'meta_key'   => 'hbv_ano_inicio', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
		)
	);
	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Texto do intervalo de anos de um período ("1743 a 1864", "desde 1985").
 *
 * @param WP_Term $term Período.
 * @return string
 */
function hbv_periodo_range( $term ) {
	$a = (int) get_term_meta( $term->term_id, 'hbv_ano_inicio', true );
	$b = (int) get_term_meta( $term->term_id, 'hbv_ano_fim', true );
	if ( $a && $b ) {
		return $a . ' a ' . $b;
	}
	if ( $a ) {
		return sprintf( /* translators: %d: ano */ __( 'desde %d', 'hbv' ), $a );
	}
	return '';
}

/**
 * Número de itens publicados de um tipo, com rótulo.
 *
 * @param string $post_type Tipo.
 * @return int
 */
function hbv_count( $post_type ) {
	$c = wp_count_posts( $post_type );
	return isset( $c->publish ) ? (int) $c->publish : 0;
}

/**
 * Formulário de busca padrão do tema.
 *
 * @return string
 */
function hbv_search_form_markup() {
	$id = wp_unique_id( 'hbv-search-' );
	return '<form role="search" method="get" class="hbv-search" action="' . esc_url( home_url( '/' ) ) . '">'
		. '<label class="screen-reader-text" for="' . esc_attr( $id ) . '">' . esc_html__( 'Pesquisar no acervo', 'hbv' ) . '</label>'
		. '<input type="search" id="' . esc_attr( $id ) . '" name="s" placeholder="' . esc_attr__( 'Pesquisar no acervo', 'hbv' ) . '" value="' . esc_attr( get_search_query() ) . '" />'
		. '<button type="submit" class="hbv-btn">' . esc_html__( 'Buscar', 'hbv' ) . '</button>'
		. '</form>';
}
add_filter( 'get_search_form', 'hbv_search_form_markup' );

/**
 * Primeira letra (A–Z) de um título, sem acento. Outros caracteres viram "#".
 *
 * @param string $title Título.
 * @return string
 */
function hbv_initial( $title ) {
	$clean = strtoupper( substr( remove_accents( trim( wp_strip_all_tags( $title ) ) ), 0, 1 ) );
	return preg_match( '/[A-Z]/', $clean ) ? $clean : '#';
}

/**
 * Menu de fallback enquanto nenhum menu foi definido.
 */
function hbv_nav_fallback() {
	echo '<ul class="hbv-menu"><li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Início', 'hbv' ) . '</a></li>';
	foreach ( hbv_post_type_defs() as $slug => $def ) {
		echo '<li><a href="' . esc_url( get_post_type_archive_link( $slug ) ) . '">' . esc_html( $def['plural'] ) . '</a></li>';
	}
	echo '</ul>';
}

/**
 * Texto de abertura e bibliografia de um mês (option `hbv_meses`, gravada pelo plugin HBV Core).
 *
 * A option é um array indexado de 1 a 12:
 * `array( 'abertura_html' => '<p>…</p>', 'bibliografia' => array( 'FRANCO, 2007…', … ) )`.
 * Aceita também JSON em texto. Devolve sempre as duas chaves, vazias se não houver dados.
 *
 * @param int $mes Mês, de 1 a 12.
 * @return array{abertura_html:string,bibliografia:string[]}
 */
function hbv_get_mes_info( $mes ) {
	$info = array(
		'abertura_html' => '',
		'bibliografia'  => array(),
	);
	$mes  = absint( $mes );
	if ( $mes < 1 || $mes > 12 ) {
		return $info;
	}

	$all = get_option( 'hbv_meses', array() );
	if ( is_string( $all ) ) {
		$all = json_decode( $all, true );
	}
	if ( ! is_array( $all ) || ! isset( $all[ $mes ] ) || ! is_array( $all[ $mes ] ) ) {
		return $info;
	}

	if ( isset( $all[ $mes ]['abertura_html'] ) && is_string( $all[ $mes ]['abertura_html'] ) ) {
		$info['abertura_html'] = trim( $all[ $mes ]['abertura_html'] );
	}
	if ( isset( $all[ $mes ]['bibliografia'] ) && is_array( $all[ $mes ]['bibliografia'] ) ) {
		foreach ( $all[ $mes ]['bibliografia'] as $ref ) {
			if ( is_string( $ref ) && '' !== trim( $ref ) ) {
				$info['bibliografia'][] = trim( $ref );
			}
		}
	}
	return $info;
}

/**
 * Biografias que nasceram ou morreram em um mês (ou em um dia).
 *
 * Usa as metas numéricas `hbv_nascimento_*` e `hbv_falecimento_*` (plugin HBV Core 0.4.0 ou
 * superior). Consulta limitada, sem contagem total e sem cache de termos; a ordem é feita em
 * PHP: dia crescente (quem não tem dia no fim) e nome em ordem alfabética, sem acento.
 *
 * @param string $tipo  'nascimento' ou 'falecimento'.
 * @param int    $mes   Mês, de 1 a 12.
 * @param int    $dia   Dia, de 1 a 31; 0 para o mês inteiro.
 * @param int    $limit Máximo de biografias.
 * @return array<int,array{id:int,title:string,url:string,dia:int,ano:int}>
 */
function hbv_get_pessoas_por_data( $tipo, $mes, $dia = 0, $limit = 400 ) {
	$mes   = absint( $mes );
	$dia   = absint( $dia );
	$limit = max( 1, min( 400, absint( $limit ) ) );
	if ( ! in_array( $tipo, array( 'nascimento', 'falecimento' ), true ) || $mes < 1 || $mes > 12 || $dia > 31 || ! function_exists( 'hbv_core_active' ) || ! hbv_core_active() ) {
		return array();
	}

	$meta = array(
		'relation' => 'AND',
		array(
			'key'     => 'hbv_' . $tipo . '_mes',
			'value'   => $mes,
			'type'    => 'NUMERIC',
			'compare' => '=',
		),
	);
	if ( $dia ) {
		$meta[] = array(
			'key'     => 'hbv_' . $tipo . '_dia',
			'value'   => $dia,
			'type'    => 'NUMERIC',
			'compare' => '=',
		);
	}

	$q = new WP_Query(
		array(
			'post_type'              => 'hbv_pessoa',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => true,
			'meta_query'             => $meta, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- limitada por posts_per_page.
		)
	);

	$items = array();
	foreach ( $q->posts as $p ) {
		$items[] = array(
			'id'    => (int) $p->ID,
			'title' => get_the_title( $p ),
			'url'   => get_permalink( $p ),
			'dia'   => (int) get_post_meta( $p->ID, 'hbv_' . $tipo . '_dia', true ),
			'ano'   => (int) get_post_meta( $p->ID, 'hbv_' . $tipo . '_ano', true ),
			'key'   => strtolower( remove_accents( wp_strip_all_tags( get_the_title( $p ) ) ) ),
		);
	}

	usort(
		$items,
		static function ( $a, $b ) {
			$da = $a['dia'] ? $a['dia'] : 99; // Sem dia vai para o fim.
			$db = $b['dia'] ? $b['dia'] : 99;
			if ( $da !== $db ) {
				return $da - $db;
			}
			return strcmp( $a['key'], $b['key'] );
		}
	);

	return $items;
}

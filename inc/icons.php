<?php
/**
 * Ícones SVG próprios do tema (traço em currentColor, sem biblioteca externa).
 *
 * Cada ícone é um único caminho (atributo d) numa grade de 24 x 24. A cor vem do
 * texto do elemento, então os ícones valem nos temas claro e escuro.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Caminhos dos ícones, por nome.
 *
 * @return array<string,string>
 */
function hbv_icon_paths() {
	return array(
		// Seções.
		'pen'        => 'M4 20l4-1 11-11a2.1 2.1 0 0 0-3-3L5 16l-1 4z M14 7l3 3',
		'landmark'   => 'M3 21h18 M5 21V10 M9 21V10 M15 21V10 M19 21V10 M2 10l10-6 10 6z',
		'buildings'  => 'M4 21V8l6-3v16 M10 21V11h10v10 M3 21h18 M13 14h2 M13 17h2 M6.5 10h1 M6.5 13h1 M6.5 16h1',
		'music'      => 'M9 18V5l11-2v13 M9 18a3 3 0 1 1-3-3 3 3 0 0 1 3 3z M20 16a3 3 0 1 1-3-3 3 3 0 0 1 3 3z',
		'graduation' => 'M2 9l10-5 10 5-10 5z M6 11.5V16c0 1.5 3 3 6 3s6-1.5 6-3v-4.5 M22 9v6',
		'flag'       => 'M5 21V4 M5 4h12l-2 4 2 4H5',
		'cross'      => 'M9 3h6v6h6v6h-6v6H9v-6H3V9h6z',
		'compass'    => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z M15.5 8.5l-2 5-5 2 2-5z',
		// Números do acervo.
		'person'     => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M4 21c0-4 3.6-7 8-7s8 3 8 7',
		'signpost'   => 'M12 3v18 M6 5h10l3 3-3 3H6z M18 14H8l-3 3 3 3h10z',
		'clock'      => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z M12 7v5l3 2',
		'pin'        => 'M12 21s7-6 7-12a7 7 0 1 0-14 0c0 6 7 12 7 12z M12 11.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z',
		'calendar'   => 'M5 5h14v16H5z M5 10h14 M9 3v4 M15 3v4',
		// Barra inferior.
		'home'       => 'M3 11l9-8 9 8 M5 10v10h14V10 M10 20v-6h4v6',
		'search'     => 'M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14z M21 21l-4.3-4.3',
		'menu'       => 'M4 7h16 M4 12h16 M4 17h16',
		// Alternar tema.
		'contrast'   => 'M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z M12 3v18',
		'sun'        => 'M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8z M12 2v2 M12 20v2 M4.9 4.9l1.4 1.4 M17.7 17.7l1.4 1.4 M2 12h2 M20 12h2 M4.9 19.1l1.4-1.4 M17.7 6.3l1.4-1.4',
		'moon'       => 'M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z',
	);
}

/**
 * Marcação de um ícone SVG decorativo (aria-hidden). Devolve texto vazio se o nome não existir.
 *
 * O nome de ícone vem sempre de uma lista fixa do tema; o caminho é escapado com esc_attr().
 *
 * @param string $name  Nome do ícone (chave de hbv_icon_paths()).
 * @param string $class Classe extra opcional.
 * @return string
 */
function hbv_icon( $name, $class = '' ) {
	$paths = hbv_icon_paths();
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	$classes = 'hbv-icon' . ( $class ? ' ' . sanitize_html_class( $class ) : '' );
	return '<svg class="' . esc_attr( $classes ) . '" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="' . esc_attr( $paths[ $name ] ) . '"/></svg>';
}

/**
 * Ícone de cada seção, pelo endereço (slug) da página. Os endereços são os da estrutura inicial.
 * Use o filtro hbv_section_icons para ajustar ou acrescentar seções.
 *
 * @return array<string,string> slug => nome do ícone.
 */
function hbv_section_icon_map() {
	return apply_filters(
		'hbv_section_icons',
		array(
			'editorial'                             => 'pen',
			'a-historia-do-municipio-de-boa-viagem' => 'landmark',
			'a-historia-da-cidade-de-boa-viagem'    => 'buildings',
			'cultura'                               => 'music',
			'educacao'                              => 'graduation',
			'historia-politica'                     => 'flag',
			'saude'                                 => 'cross',
			'turismo'                               => 'compass',
		)
	);
}

/**
 * Ícone de uma seção pelo slug da página; vazio se a seção não tiver ícone.
 *
 * @param string $slug Slug da página.
 * @return string
 */
function hbv_section_icon( $slug ) {
	$map = hbv_section_icon_map();
	return isset( $map[ $slug ] ) ? hbv_icon( $map[ $slug ] ) : '';
}

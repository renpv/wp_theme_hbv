<?php
/**
 * Substitutos neutros para as funções do plugin HBV Core.
 * Carregado só quando o plugin não está ativo (ver inc/compat.php).
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sem o plugin, não há tipos de conteúdo próprios.
 *
 * @return array
 */
function hbv_post_type_defs() {
	return array();
}

/**
 * Sem o plugin, não há tipos de conteúdo próprios.
 *
 * @return string[]
 */
function hbv_cpts() {
	return array();
}

/**
 * Sem o plugin, não há campos de ficha.
 *
 * @param string $post_type Tipo de conteúdo.
 * @return array
 */
function hbv_fields_for( $post_type ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
	return array();
}

/**
 * Nomes dos meses (usados por templates mesmo sem o plugin).
 *
 * @return string[] Chaves 1 a 12.
 */
function hbv_month_names() {
	return array(
		1  => 'Janeiro',
		2  => 'Fevereiro',
		3  => 'Março',
		4  => 'Abril',
		5  => 'Maio',
		6  => 'Junho',
		7  => 'Julho',
		8  => 'Agosto',
		9  => 'Setembro',
		10 => 'Outubro',
		11 => 'Novembro',
		12 => 'Dezembro',
	);
}

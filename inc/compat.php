<?php
/**
 * Compatibilidade com o plugin HBV Core.
 *
 * O modelo de conteúdo (tipos, taxonomias e campos da ficha) fica no plugin
 * HBV Core desde a versão 1.1.0 do tema. Sem o plugin, o tema continua
 * funcionando como um tema de blog: as funções abaixo devolvem listas vazias
 * e o painel mostra um aviso.
 *
 * Roda em after_setup_theme com prioridade 20, depois que o plugin carrega o
 * modelo (prioridade 1), para não declarar as mesmas funções duas vezes.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Se o plugin não carregou o modelo, define substitutos neutros e avisa.
 */
function hbv_compat_check_core() {
	if ( function_exists( 'hbv_post_type_defs' ) ) {
		return;
	}
	require_once HBV_DIR . '/inc/compat-fallbacks.php';
	add_action( 'admin_notices', 'hbv_compat_missing_core_notice' );
}
add_action( 'after_setup_theme', 'hbv_compat_check_core', 20 );

/**
 * O plugin está ativo e carregou o modelo de conteúdo?
 *
 * @return bool
 */
function hbv_core_active() {
	return defined( 'HBV_CORE_VERSION' ) && function_exists( 'hbv_seed_terms' );
}

/**
 * Aviso no painel quando o plugin não está ativo.
 */
function hbv_compat_missing_core_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-warning"><p>';
	echo esc_html__( 'O tema História de Boa Viagem — Memória precisa do plugin HBV Core para mostrar biografias, lugares, logradouros, datas e fatos, obras e instituições. Instale e ative o plugin.', 'hbv' );
	echo '</p></div>';
}

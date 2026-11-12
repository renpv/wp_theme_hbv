<?php
/**
 * Item de "Datas e fatos": selo de data + título + local.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$dia   = (int) get_post_meta( get_the_ID(), 'hbv_dia', true );
$mes   = (int) get_post_meta( get_the_ID(), 'hbv_mes', true );
$ano   = (int) get_post_meta( get_the_ID(), 'hbv_ano', true );
$local = (string) get_post_meta( get_the_ID(), 'hbv_local', true );
$mn    = hbv_month_names();
$abbr  = isset( $mn[ $mes ] ) ? mb_strtolower( mb_substr( $mn[ $mes ], 0, 3 ) ) : '';
// Fato com mês, mas sem dia (ex.: campanhas do mês inteiro).
$sem_dia = ! $dia && isset( $mn[ $mes ] );
?>
<li class="hbv-fato">
	<span class="hbv-dia<?php echo $sem_dia ? ' hbv-dia--mes' : ''; ?>" aria-hidden="true">
		<span class="hbv-dia__n"><?php echo $dia ? esc_html( $dia ) : ( $sem_dia ? esc_html__( 'mês', 'hbv' ) : '–' ); ?></span>
		<span class="hbv-dia__m"><?php echo esc_html( $abbr ); ?></span>
	</span>
	<div>
		<h3 class="hbv-fato__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="hbv-fato__meta">
			<?php
			$parts = array();
			if ( $dia && $mes && isset( $mn[ $mes ] ) ) {
				$parts[] = $dia . ' de ' . mb_strtolower( $mn[ $mes ] ) . ( $ano ? ' de ' . $ano : '' );
			} elseif ( $sem_dia ) {
				// O selo é aria-hidden: o texto abaixo é o que o leitor de tela lê.
				/* translators: %s: nome do mês, em minúsculas */
				$parts[] = sprintf( __( 'Ao longo de %s', 'hbv' ), mb_strtolower( $mn[ $mes ] ) ) . ( $ano ? ' de ' . $ano : '' );
			}
			if ( $local ) {
				$parts[] = $local;
			}
			echo esc_html( implode( ' · ', $parts ) );
			?>
		</p>
	</div>
</li>

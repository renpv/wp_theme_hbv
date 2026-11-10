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
?>
<li class="hbv-fato">
	<span class="hbv-dia" aria-hidden="true">
		<span class="hbv-dia__n"><?php echo $dia ? esc_html( $dia ) : '–'; ?></span>
		<span class="hbv-dia__m"><?php echo esc_html( $abbr ); ?></span>
	</span>
	<div>
		<h3 class="hbv-fato__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="hbv-fato__meta">
			<?php
			$parts = array();
			if ( $dia && $mes ) {
				$parts[] = $dia . ' de ' . mb_strtolower( $mn[ $mes ] ) . ( $ano ? ' de ' . $ano : '' );
			}
			if ( $local ) {
				$parts[] = $local;
			}
			echo esc_html( implode( ' · ', $parts ) );
			?>
		</p>
	</div>
</li>

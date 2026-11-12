<?php
/**
 * Biografias que nasceram ou morreram em um mês, agrupadas por dia.
 *
 * Argumentos: $args['tipo'] = 'nascimento' | 'falecimento'; $args['mes'] = 1 a 12.
 * Não imprime nada se não houver biografias.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tipo = isset( $args['tipo'] ) ? $args['tipo'] : '';
$mes  = isset( $args['mes'] ) ? absint( $args['mes'] ) : 0;
$mn   = hbv_month_names();

if ( ! in_array( $tipo, array( 'nascimento', 'falecimento' ), true ) || ! isset( $mn[ $mes ] ) ) {
	return;
}

$items = hbv_get_pessoas_por_data( $tipo, $mes );
if ( ! $items ) {
	return;
}

$mes_nome = mb_strtolower( $mn[ $mes ] );
$grupos   = array();
foreach ( $items as $item ) {
	$grupos[ $item['dia'] ][] = $item;
}

$id = 'aniv-' . $tipo;
/* translators: %s: nome do mês, em minúsculas */
$titulo = 'nascimento' === $tipo ? sprintf( __( 'Nasceram em %s', 'hbv' ), $mes_nome ) : sprintf( __( 'Morreram em %s', 'hbv' ), $mes_nome );
?>
<section class="hbv-letra hbv-aniversarios" aria-labelledby="<?php echo esc_attr( $id ); ?>">
	<h2 id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $titulo ); ?></h2>
	<dl class="hbv-aniv">
		<?php foreach ( $grupos as $dia => $pessoas ) : ?>
			<div class="hbv-aniv__grupo">
				<dt class="hbv-aniv__dia">
					<?php
					if ( $dia ) {
						/* translators: 1: dia do mês, 2: nome do mês */
						echo esc_html( sprintf( __( '%1$d de %2$s', 'hbv' ), $dia, $mes_nome ) );
					} else {
						esc_html_e( 'Dia não informado', 'hbv' );
					}
					?>
				</dt>
				<dd class="hbv-aniv__itens">
					<ul class="hbv-aniv__nomes">
						<?php foreach ( $pessoas as $p ) : ?>
							<li>
								<a href="<?php echo esc_url( $p['url'] ); ?>"><?php echo esc_html( $p['title'] ); ?></a>
								<?php if ( $p['ano'] ) : ?>
									<span class="hbv-aniv__ano">(<?php echo esc_html( $p['ano'] ); ?>)</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</dd>
			</div>
		<?php endforeach; ?>
	</dl>
</section>

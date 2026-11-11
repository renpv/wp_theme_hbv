<?php
/**
 * Cartão de conteúdo (usado em listagens e na home).
 *
 * Variantes: $args['variant'] = 'default' | 'pessoa' | 'secao'.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$variant = isset( $args['variant'] ) ? $args['variant'] : 'default';
$classes = 'hbv-card' . ( 'default' !== $variant ? ' hbv-card--' . $variant : '' );
$kicker  = hbv_type_label();
$theme   = get_the_terms( get_the_ID(), 'hbv_tema' );
if ( $theme && ! is_wp_error( $theme ) ) {
	$kicker .= ' · ' . $theme[0]->name;
}

$meta = '';
if ( 'hbv_pessoa' === get_post_type() ) {
	$meta = (string) get_post_meta( get_the_ID(), 'hbv_ocupacao', true );
} elseif ( 'hbv_fato' === get_post_type() ) {
	$dia = (int) get_post_meta( get_the_ID(), 'hbv_dia', true );
	$mes = (int) get_post_meta( get_the_ID(), 'hbv_mes', true );
	$ano = (int) get_post_meta( get_the_ID(), 'hbv_ano', true );
	$mn  = hbv_month_names();
	if ( $dia && $mes && isset( $mn[ $mes ] ) ) {
		$meta = $dia . ' de ' . strtolower( $mn[ $mes ] ) . ( $ano ? ' de ' . $ano : '' );
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="hbv-card__media" aria-hidden="true">
			<?php the_post_thumbnail( 'hbv-card', array( 'loading' => 'lazy', 'alt' => '' ) ); ?>
		</div>
	<?php endif; ?>
	<div class="hbv-card__body">
		<?php if ( 'secao' !== $variant ) : ?>
			<p class="hbv-card__kicker"><?php echo esc_html( $kicker ); ?></p>
		<?php else : ?>
			<?php $section_icon = hbv_section_icon( get_post_field( 'post_name', get_the_ID() ) ); ?>
			<?php if ( $section_icon ) : ?>
				<span class="hbv-card__icon"><?php echo $section_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG de lista fixa, escapado em hbv_icon(). ?></span>
			<?php endif; ?>
		<?php endif; ?>
		<h3 class="hbv-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( 'pessoa' !== $variant ) : ?>
			<p class="hbv-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '…' ) ); ?></p>
		<?php endif; ?>
		<?php if ( $meta ) : ?>
			<p class="hbv-card__meta"><?php echo esc_html( $meta ); ?></p>
		<?php elseif ( 'default' === $variant ) : ?>
			<p class="hbv-card__meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j \d\e F \d\e Y' ) ); ?></time></p>
		<?php endif; ?>
	</div>
</article>

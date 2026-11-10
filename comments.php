<?php
/**
 * Comentários.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>
<section id="comments" class="hbv-comments" aria-labelledby="comments-title">
	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
			printf(
				/* translators: %s: número de comentários */
				esc_html( _n( '%s comentário', '%s comentários', get_comments_number(), 'hbv' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>
		<ol>
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 40,
				)
			);
			?>
		</ol>
		<?php the_comments_navigation(); ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="hbv-alert"><?php esc_html_e( 'Os comentários estão encerrados.', 'hbv' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'        => __( 'Contribua com informações', 'hbv' ),
			'title_reply_to'     => __( 'Responder a %s', 'hbv' ),
			'label_submit'       => __( 'Enviar comentário', 'hbv' ),
			'comment_notes_before' => '<p>' . esc_html__( 'Seu e-mail não será publicado. Se possível, cite a fonte da informação.', 'hbv' ) . '</p>',
			'class_submit'       => 'hbv-btn',
		)
	);
	?>
</section>

<?php
/**
 * Artigo (publicação) com texto histórico, fontes, compartilhamento e comentários.
 *
 * @package hbv
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="conteudo" class="hbv-main" tabindex="-1">
	<div class="hbv-container">
		<?php hbv_breadcrumbs(); ?>
		<div class="hbv-layout hbv-layout--sidebar">
			<div class="hbv-content">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="hbv-page-head">
							<?php hbv_badges(); ?>
							<h1><?php the_title(); ?></h1>
							<?php hbv_posted_on(); ?>
						</header>

						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="hbv-prose">
								<?php the_post_thumbnail( 'large' ); ?>
								<?php if ( get_the_post_thumbnail_caption() ) : ?>
									<figcaption><?php echo esc_html( get_the_post_thumbnail_caption() ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>

						<?php hbv_ficha(); ?>

						<div class="hbv-prose">
							<?php
							the_content();
							wp_link_pages();
							?>
						</div>

						<?php hbv_fontes(); ?>
						<?php hbv_share_links(); ?>
					</article>

					<nav class="hbv-postnav" aria-label="<?php esc_attr_e( 'Outras publicações', 'hbv' ); ?>">
						<?php
						$prev = get_previous_post();
						$next = get_next_post();
						if ( $prev ) {
							echo '<a class="prev" href="' . esc_url( get_permalink( $prev ) ) . '" rel="prev"><span>' . esc_html__( 'Anterior', 'hbv' ) . '</span><strong>' . esc_html( get_the_title( $prev ) ) . '</strong></a>';
						}
						if ( $next ) {
							echo '<a class="next" href="' . esc_url( get_permalink( $next ) ) . '" rel="next"><span>' . esc_html__( 'Próxima', 'hbv' ) . '</span><strong>' . esc_html( get_the_title( $next ) ) . '</strong></a>';
						}
						?>
					</nav>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
<?php
get_footer();

<?php
/**
 * Página comum (Direitos autorais, Fale conosco, Quem somos, artigos de página).
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
						</header>
						<?php if ( has_post_thumbnail() ) : ?>
							<figure class="hbv-prose"><?php the_post_thumbnail( 'large' ); ?></figure>
						<?php endif; ?>
						<div class="hbv-prose">
							<?php
							the_content();
							wp_link_pages();
							?>
						</div>
						<?php hbv_fontes(); ?>
						<?php hbv_share_links(); ?>
					</article>
					<?php
					if ( comments_open() ) {
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

<?php
/**
 * The template for displaying all single posts.
 *
 * @package coral-parallax
 */

get_header(); ?>

	<div id="primary" class="content-area egrid <?php coral_parallax_column_class('content'); ?>">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>
			<?php $parg = array(
				'prev_text'          => esc_html__( 'Previous post', 'coral-parallax' ),
				'next_text'          => esc_html__( 'Next post', 'coral-parallax' ),
				'screen_reader_text' => esc_html__( 'Post navigation', 'coral-parallax' )); ?>
			<?php the_post_navigation($parg); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

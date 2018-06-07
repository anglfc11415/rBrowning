<?php
/**
 * @package coral-parallax
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php coral_parallax_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			coral_parallax_excerpt();
			coral_parallax_post_thumbnail();
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Read more %s <i class="read-more"></i>', 'coral-parallax' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'coral-parallax' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php coral_parallax_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
			<?php the_content( stf_more( ) ); ?>
			<?php stf_entry_pages(); ?>
	</div><!-- .entry-content -->
	<?php get_template_part('entry', 'footer'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php 
	$post_index = 1; while ( have_posts() ): the_post(); 
	$posts_displayed[] = $post->ID;
?>
	<div class="entry-wrap">
		<div id="subpage-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
		
			<!-- Post Thumbnail -->
			<?php stf_entry_thumbnail( array(100,100) ); ?>
			<!-- [End] Post Thumbnail -->

			<div class="entry-body">

				<div class="entry-header">
					<!-- Entry Title -->
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'stf' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" <?php if(false){ ?>xref="page#<?php the_ID(); ?>" class="ajax"<?php } ?>><?php the_title(); ?></a></h2>
					<!-- [End] Entry Title -->
				</div>
				
				<!-- Entry Content -->
				<div class="entry-content">
				<?php 
				 
						the_excerpt(); 
				
				?>
				</div>
				<!-- [End] Entry Content -->

				<?php get_template_part('entry', 'footer'); ?>
			</div>
		</div>
	</div>
<?php endwhile; /* End The Loop */ ?>
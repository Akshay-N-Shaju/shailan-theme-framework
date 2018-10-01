<article id="post-0" class="post hentry no-results not-found clearfix">
	<header class="entry-header">
	<h1 class="entry-title"><?php _e( 'Nothing Found', 'stf' ); ?></h1>
	</header><!-- .entry-header -->
	<div class="entry-content">
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'stf' ); ?></p>
	
	<?php get_search_form(); ?>

	<div class="row">
		<div class="one_half">
			<h4>Most read posts</h4>
			<?php stf_most_viewed_posts( 7, 'list' ); ?>
		</div>
		<div class="one_half last">
			<?php if(function_exists('stats_get_csv')){ 
			$top_posts = stats_get_csv( 'postviews', "days=15&limit=7" );

			?> <h4>Most popular posts</h4>
			<ul>
			<?php foreach ( $top_posts as $post ) : if ( !get_post( $post['post_id'] ) || $post['post_title'] == 'Home page' ) continue; ?>
			<li><a href="<?php echo get_permalink( $post['post_id'] ); ?>"><?php echo get_the_title( $post['post_id'] ); ?></a></li>
			<?php endforeach; ?>
			</ul>
			<?php } else { ?>

			<h4>Some random posts</h4>
			<?php stf_random_posts( 7, 'list' ); ?>

			<?php } ?>
		</div>
	</div>

	</div><!-- .entry-content -->
	<p> copyright &copy; 2018 </p>
</article><!-- #post-0 -->

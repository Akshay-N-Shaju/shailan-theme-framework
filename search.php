<?php get_header(); ?>
<!-- PAGE START -->
<div id="page" class="clearfix">
	<div id="container">
		<div id="content" role="main">
		<?php if ( have_posts() ) { ?>
		<h1 class="page-title">Search Results for <?php $key = esc_html($s, 1); _e('<span class="alt search-terms">'); echo $key; _e('</span>'); ?></h1>
		<span class="sub-title">Showing results <strong><?php 
		/* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $total_count = $allsearch->post_count; _e(''); wp_reset_query();
		
			$post_count = get_query_var('posts_per_page'); 
			$current_page = get_query_var('paged'); 
			
			if($current_page > 0)
				$current_page = $current_page - 1;
			
			$start = $current_page * $post_count; 
			$end = $start + $post_count; 
			if ($end>$total_count)
				$end = $total_count;
			echo $start . '&dash;' . $end; ?></strong> of <strong><?php echo $total_count; ?></strong>.</span>
		<?php } //if ( have_posts() ) { ?>
		<?php stf_content(); ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
</div>
<!--/ PAGE END -->
<?php get_footer(); ?>
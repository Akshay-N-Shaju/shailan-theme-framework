<?php get_header(); ?>
<!-- PAGE START -->
<div id="page" class="clearfix">
	<div id="container">
		<div id="content" role="main">
		<?php stf_archive_header(); ?>
		<span class="sub-title"><?php 
		
		$category_description = category_description();
		if ( ! empty( $category_description ) )
			echo $category_description;
		
		?></span>
		<?php stf_content(); ?>
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
</div>
<!--/ PAGE END -->
<?php get_footer(); ?>
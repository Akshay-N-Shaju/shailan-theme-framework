<?php 

/* Template Name: Links Page */

get_header() ?>

<!-- Content Wrapper -->
<div id="content-wrapper">

	<!-- Page -->
	<div id="page" class="container_12 clearfix">
	
		<!-- Billboard -->
		<div id="billboard-wrapper" class="clearfix">
			<?php stf_breadcrumbs() ?>			
			<?php stf_widget_area( 'billboard' ) ?>
		</div>
		<!-- [End] Billboard -->

		<!-- Content -->
		<div id="content" class="grid_8 clearfix">
			<?php stf_widget_area( 'before-content' ); ?>
			
			<!-- Main -->
			<div id="content-main">
			
				<div class="entry-wrap">
					<!-- Post -->
					<div id="entry-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-body">
						<?php get_template_part('entry', 'header'); ?>
						
						<!-- Entry Content -->
						<div class="entry-content">
							<?php 
							
								if( is_archive() ){ 
									the_excerpt(); 
								} else {
									the_content( stf_more() ); 
								}
							
							?>
							<?php stf_entry_pages_navigation(); ?>
						
						<!-- Links list -->
						<?php $args = array(
							'orderby'          => 'name',
							'order'            => 'ASC',
							'limit'            => -1,
							'category'         => '',
							'exclude_category' => '',
							'category_name'    => '',
							'hide_invisible'   => 1,
							'show_updated'     => 0,
							'echo'             => 1,
							'categorize'       => 1,
							'title_li'         => '' ,
							'title_before'     => '<h3>',
							'title_after'      => '</h3>',
							'category_orderby' => 'name',
							'category_order'   => 'ASC',
							'class'            => 'linkcat',
							'category_before'  => '<div id=%id class="%class link-category">',
							'category_after'   => '</div>' ); 
							
							wp_list_bookmarks( $args );
							
						?> 
							
						</div>
						<!-- [End] Entry Content -->

						<?php get_template_part('entry', 'footer'); ?>
					</div>

					<div class="clear"></div>
					</div>
					<!-- [End] Post -->
				</div>
				

				<?php stf_comments(); ?>
				
			</div>
			<!-- [End] Main -->
			
			<?php stf_widget_area( 'after-content' ); ?>
		</div>
		<!-- [End] Content -->
		
		<!-- Sidebars -->
		<div id="sidebars" class="grid_4">
			<?php get_sidebar() ?>
		</div>		
		<!-- [End] Sidebars -->
		
	</div>
	<!-- [End] Page -->
		
</div>
<!-- [End] Content Wrapper -->

<?php get_footer() ?>
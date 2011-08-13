<?php

	// Get page width for images
	$stf_page_width = stf_get_setting('stf_page_width');
	$w = $stf_page_width;
	$h = floor( $w * 320 / 940 );

 while ( have_posts() ) : the_post(); ?>				
	<a href="<?php the_permalink(); ?>" rel="bookmark" >
		<?php /* the current post has a thumbnail */
			if( has_post_thumbnail() ){
				$thumbnail_size = array( $w, $h );
				$thumbnail_align = 'center';
				$thumb_id = get_post_thumbnail_id();
				$alt = the_title('','',false);
				$src = wp_get_attachment_image_src( $thumb_id, 'large' );
				$src = $src[0];
				
				echo '<img src="' . get_bloginfo('template_directory') . '/app/scripts/timthumb.php?src='.$src.'&amp;h='.$h.'&amp;w='.$w.'&amp;zc=1&amp;a=b" title="'.the_title('','',false).'" width="'.$w.'" height="'.$h.'" />';
				//echo get_image_tag($thumb_id, $alt, $alt, $thumbnail_align, $thumbnail_size);
			} else {
				global $post;
				$src = stf_get_first_image_src( $post->ID, 'large' );
			
				echo '<img src="' . get_bloginfo('template_directory') . '/app/scripts/timthumb.php?src='.$src.'&amp;h='.$h.'&amp;w='.$w.'&amp;zc=1&amp;a=b" title="'.the_title('','',false).'" width="'.$w.'" height="'.$h.'" />';
			} ?>
	</a>
<?php endwhile; ?>
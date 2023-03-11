<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<!--
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
-->
	<div class="entry-content">

		<?php 
		
//		the_content(); 

	$do_php = get_post_meta( get_the_ID(), '_diwp_text_field', true );


        // SET UPLOAD FOLDER IF MULTISITE
        if( is_multisite() ) {
            switch_to_blog(1);
            $upload_dir = wp_upload_dir();
            restore_current_blog();
        } else { $upload_dir = wp_upload_dir(); } 
//        $bh_dir = $upload_dir['basedir'] . '/bluehaze';
//        if (file_exists($bh_dir."/myFunctions.php")) { 
//            include $bh_dir . "/myFunctions.php"; 
//        }

//	$upload_dir   = wp_upload_dir();
	include $upload_dir['basedir'] . "/bluehaze/" . $do_php;
	?>

		<div class="clearfix"></div>
		<?php
		/**
		 * This wp_link_pages option adapt to use bootstrap pagination style.
		 * The other part of this pager is in inc/template-tags.php function name bootstrapBasicLinkPagesLink() which is called by wp_link_pages_link filter.
		 */
		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'bootstrap-basic') . ' <ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		));
		?>
	</div><!-- .entry-content -->
	
	<footer class="entry-meta">
		<?php bootstrapBasicEditPostLink(); ?> 
	</footer>
</article><!-- #post-## -->
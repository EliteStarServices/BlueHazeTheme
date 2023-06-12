<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<h3 class="entry-title"><?php the_title(); ?></h3>

		<div class="entry-meta">
			<?php bootstrapBasicPostOn(); ?> 
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?> 
		<div class="clearfix"></div>
		<?php
		/**
		 * This wp_link_pages option adapt to use bootstrap pagination style.
		 * The other part of this pager is in inc/template-tags.php function name bootstrapBasicLinkPagesLink() which is called by wp_link_pages_link filter.
		 */
		wp_link_pages(array(
			'before' => '<div class="page-links">' . __('Pages:', 'blue-haze') . ' <ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		));
		?> 
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list(__(', ', 'blue-haze'));

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list('', __(', ', 'blue-haze'));
			
			echo bootstrapBasicCategoriesList($category_list);
			if ($tag_list) {
				echo ' ';
				echo bootstrapBasicTagsList($tag_list);
			}
			echo ' ';
			/* translators: %1$s URL, %2$s: Post title. */
			printf(__('<span class="glyphicon glyphicon-link"></span> <a href="%1$s" title="Permalink to %2$s" rel="bookmark">permalink</a>.', 'blue-haze'), get_permalink(), the_title_attribute('echo=0'));
		?> 

		<?php bootstrapBasicEditPostLink(); ?> 
	</footer><!-- .entry-meta -->
</article><!-- #post -->
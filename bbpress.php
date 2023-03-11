<?php
/* BBPress Template */

get_header();

// determine main column size from active sidebars
//$main_column_size = bootstrapBasicGetMainColumnSize();
$main_column_size = 12;

?> 
<?php //get_sidebar('left'); ?> 
				<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
					<main id="main" class="site-main" role="main">
						<?php 
						while (have_posts()) {
							the_post();

							get_template_part('content', 'page');
							
							// If comments are open or we have at least one comment, load up the comment template
							if (comments_open() || '0' != get_comments_number()) {
								comments_template();
							}

						} //endwhile;
						?> 
					</main>
				</div>
<?php //get_sidebar('right'); ?> 
<?php get_footer(); ?> 
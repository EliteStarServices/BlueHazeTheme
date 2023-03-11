<?php

/* Template Name: Default wide */

get_header('title');

// MAKE PAGE WIDE HERE (sort of a cheat outside the header, but it never seems to matter with modern browsers)
echo "<link rel='stylesheet' href='https://elite-star-services.com/wp-content/themes/blue-haze/css/wide.css' type='text/css'>";

/**
 * determine main column size from actived sidebars
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
?> 

<?php get_sidebar('left'); ?> 
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
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 
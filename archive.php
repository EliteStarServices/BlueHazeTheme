<?php 
/**
 * Displaying archive page (category, tag, archives post, author's post)
 * 
 * @package bootstrap-basic
 */


// Show Header?
if (esc_html( get_theme_mod('header_ap') == "1") ) {
	get_header('title');
} else {
	get_header();
}


/**
 * determine main column size from actived sidebar
 */
$main_column_size = bootstrapBasicGetMainColumnSize();
?> 
<?php get_sidebar('left'); ?> 
				<div class="col-md-<?php echo $main_column_size; ?> content-area" id="main-column">
					<main id="main" class="site-main" role="main">
						<?php if (have_posts()) { ?> 

						<header class="panel panel-default">
							<h3 class="panel-body neg-margins">
								<?php
								if (is_category()) :
									single_cat_title();

								elseif (is_tag()) :
									single_tag_title();

								elseif (is_author()) :
									/* 
									 * Queue the first post, that way we know
									 * what author we're dealing with (if that is the case).
									 */
									the_post();
									/* translators: %s Author name. */
									printf(__('Author: %s', 'blue-haze'), '<span class="vcard">' . get_the_author() . '</span>');
									/* 
									 * Since we called the_post() above, we need to
									 * rewind the loop back to the beginning that way
									 * we can run the loop properly, in full.
									 */
									rewind_posts();

								elseif (is_day()) :
									/* translators: %s Date value. */
									printf(__('Day: %s', 'blue-haze'), '<span>' . get_the_date() . '</span>');

								elseif (is_month()) :
									/* translators: %s Month value. */
									printf(__('Month: %s', 'blue-haze'), '<span>' . get_the_date('F Y') . '</span>');

								elseif (is_year()) :
									/* translators: %s Year value. */
									printf(__('Year: %s', 'blue-haze'), '<span>' . get_the_date('Y') . '</span>');

								elseif (is_tax('post_format', 'post-format-aside')) :
									_e('Asides', 'blue-haze');

								elseif (is_tax('post_format', 'post-format-image')) :
									_e('Images', 'blue-haze');

								elseif (is_tax('post_format', 'post-format-video')) :
									_e('Videos', 'blue-haze');

								elseif (is_tax('post_format', 'post-format-quote')) :
									_e('Quotes', 'blue-haze');

								elseif (is_tax('post_format', 'post-format-link')) :
									_e('Links', 'blue-haze');

								else :
									_e('Archives', 'blue-haze');

								endif;
								?> 
							</h3>
							
							<?php
							// Show an optional term description.
							$term_description = term_description();
							if (!empty($term_description)) {
								/* translators: %s Description. */
								printf('<div class="taxonomy-description">%s</div>', $term_description);
							} //endif;
							?>
						</header><!-- .page-header -->
						
						<?php 
						/* Start the Loop */
						while (have_posts()) {
							the_post();

							/* 
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part('content', get_post_format());
// POST SEPARATION
echo "<hr>";
						} //endwhile; 
						?> 
<div style="margin-top:-26px;"></div><!-- Hides last HR -->
						<?php bootstrapBasicPagination(); ?> 

						<?php } else { ?> 

						<?php get_template_part('no-results', 'archive'); ?> 

						<?php } //endif; ?> 
					</main>
				</div>
<?php get_sidebar('right'); ?> 
<?php get_footer(); ?> 
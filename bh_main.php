


// LOAD TEMPLATE OPTIONS
$sb_opt = get_post_meta( get_the_ID(), '_diwp_radio_field', true );
$ct_opt = get_post_meta( get_the_ID(), '_diwp_radio_two', true );
$bh_opt = get_post_meta( get_the_ID(), '_diwp_checkbox_field', true );
$do_php = get_post_meta( get_the_ID(), '_diwp_text_field', true );


// Sidebar Options
if ($sb_opt == "none") {
	$main_column_size = 12;
}
elseif ($sb_opt == "left") {
	$lsbOn = "yes";
	$main_column_size = 9;
}
elseif ($sb_opt == "right") {
	$rsbOn = "yes";
	$main_column_size = 9;
} else {
	$main_column_size = 6;
	$lsbOn = "yes";
	$rsbOn = "yes";
//	$main_column_size = bootstrapBasicGetMainColumnSize();
}


// Container Options
if ($ct_opt == "blue") {
	$bs_container = "";
	$bs_blue = "on";
}
elseif ($ct_opt == "thin") {
	$bs_container = 'id="main-column"';
}
else {
	$bs_container = "";
}


// Show Header?
if (in_array('head',$bh_opt)) {
	get_header();
} else {
	get_header('title');
}


// MAKE PAGE WIDE HERE
if (in_array('wide',$bh_opt)) {
	echo "<link rel='stylesheet' href='".get_template_directory_uri()."/css/wide.css' type='text/css'>";
}
?> 


<?php if ($lsbOn == "yes") { get_sidebar('left'); } ?> 
				<div class="col-md-<?php echo $main_column_size; ?> content-area" <?php echo $bs_container; ?>>
					<main id="main" class="site-main" role="main">
						<?php 
						while (have_posts()) {
							the_post();

if ($bs_blue == "on") {
							?>
							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
							<div class="panel-heading bh-page-title"><?php single_post_title(); ?></div>
										<div class="panel-body">
							<?php

// USE CONTENT OR PHP FILE INCLUDE
if ($do_php == "") {
	get_template_part('content', 'page');
} else {
	get_template_part('content', 'insert');
}

							?>
										</div>
									</div>
								</div>
							</div>
							<?php
} else {

// USE CONTENT OR PHP FILE INCLUDE
if ($do_php == "") {
	get_template_part('content', 'page');
} else {
	get_template_part('content', 'insert');
}

}

							// If comments are open or we have at least one comment, load up the comment template
							if (comments_open() || '0' != get_comments_number()) {
								comments_template();
							}

						} //endwhile;
						?> 
					</main>
				</div>
<?php if ($rsbOn == "yes") { get_sidebar('right'); } ?> 

<?php
// Select Footer
if (in_array('foot',$bh_opt)) {
	get_footer();
} else {
	get_footer('widget');
}
?>
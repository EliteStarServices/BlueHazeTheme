<?php
/**
 * Blue Haze Simple / Custom Theme Footer
 */
?>

</div><!--.site-content-->


<?php
// INCLUDE USER FOOTER IF SUPPLIED OTHERWISE SIMPLE FOOTER
if( is_multisite() ) {
    switch_to_blog(1);
    $upload_dir = wp_upload_dir();
    restore_current_blog();
} else { $upload_dir = wp_upload_dir(); }  
$bh_dir = $upload_dir['basedir'] . '/bluehaze';
if (file_exists($bh_dir."/myFooter.php")) { 
    include $bh_dir . "/myFooter.php"; 
} elseif (dynamic_sidebar('footer-simple')) {
// sidebar area
} else {

// CHECK: ClassicPress or WordPress
global $cp_version;
if (!$cp_version) {
	$cmsLink = '<a href="https://wordpress.org">WordPress</a>';
} else {
	$cmsLink = '<a href="https://classicpress.net">ClassicPress</a>';
}

?>

<div class="container-fluid">
<hr class="footer-thin">
	<div class="text-center center-block">
	
<p class="txt-railway"><a href="https://elite-star-services.com/blue-haze/">Blue Haze</a> for <?php echo $cmsLink; ?> 
| © <?php echo date("Y"); ?> <a href="https://elite-star-services.com">Elite Star Services</a></p>
	</div>
</div>

<?php } ?>

		</div><!--.container page-container-->

		<?php wp_footer(); ?> 
	</body>
</html>
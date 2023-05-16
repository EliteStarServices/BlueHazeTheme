<?php
/**
 * Blue Haze Widget Enabled Theme Footer
 */
?>


<?php
// CHECK: ClassicPress or WordPress
global $cp_version;
if (!$cp_version) {
	$cmsLink = '<a href="https://wordpress.org">WordPress</a>';
} else {
	$cmsLink = '<a href="https://classicpress.net">ClassicPress</a>';
}
?>


</div><!--.site-content-->
			
			
			<!-- <footer id="site-footer" role="contentinfo">
				<div id="footer-row" class="row site-footer"> -->
					<div class="col-md-6 footer-left">
						<?php if (!dynamic_sidebar('footer-left')) { ?>
							<div class="container-fluid">
							<hr class="footer-thin">
								<div class="text-center center-block">
							<p class="txt-railway"><a href="https://elite-star-services.com/blue-haze/">Blue Haze</a> for <?php echo $cmsLink; ?></p>
								</div>
							</div>
						<?php } ?> 
					</div>
					<div class="col-md-6 footer-right text-right">
					<?php if (!dynamic_sidebar('footer-right')) { ?>
							<div class="container-fluid">
							<hr class="footer-thin">
								<div class="text-center center-block">
							<p class="txt-railway">© <?php echo date("Y"); ?> <a href="https://elite-star-services.com">Elite Star Services</a></p>
								</div>
							</div>
						<?php } ?> 
					</div>
				<!-- </div>
			</footer> -->
		</div><!--.container page-container-->
		
		
		<!--wordpress footer-->
		<?php wp_footer(); ?> 
	</body>
</html>

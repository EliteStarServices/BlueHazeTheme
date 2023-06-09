<?php
/**
 * The theme header
 * 
 * @package bootstrap-basic
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width">

		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
	<!--wordpress head-->
	<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?>>
		<?php 
		if ( function_exists( 'wp_body_open' ) ) {
			wp_body_open();
		} else {
			do_action( 'wp_body_open' );
		}


// CHECK IF PRIMARY MENU ASSIGNED
$is_assigned = has_nav_menu('primary');


// HEADER SETTINGS
if (esc_html( get_theme_mod('header_mg') == "1") ) { $hmg = "margin-left:0px; margin-right:0px;";
	$istxt = "active";
	if ($is_assigned) { $hmm = "margin-bottom:10px;"; }
}
$hbg = "background-color:".esc_html( get_theme_mod('header_bg', '#FFFFFF') ).";";
$hrd = "border-radius:".esc_html( get_theme_mod('header_rd', '6') )."px;";
$hst = $hbg.$hrd.$hmg.$hmm;

		?> 

		<!--[if lt IE 8]>
			<p class="ancient-browser-alert">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/" target="_blank">upgrade your browser</a>.</p>
		<![endif]-->
		
		<div class="container page-container">
			<?php do_action('before'); ?> 
			<header role="banner">
				<div class="row site-branding" style="<?php echo $hst; ?>">
					<div class="col-md-6 site-title">



<?php
// DISPLAY CUSTOM LOGO IF DEFINED
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
if ( has_custom_logo() ) {
		echo "<a href='".esc_url(home_url('/'))."' title='".esc_attr(get_bloginfo('name', 'display'))."' rel='home'>";
        echo '<img src="' . esc_url( $logo[0]) . '" style="margin-top:5px;" class="logo-margins" alt="' . get_bloginfo( 'name' ) . '"></a>';
} else {
// DISPLAY NAME AND DESCRIPTION
?>
	<h2 class="site-title-heading">
	<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
	</h2>
	<div class="site-description" <?php if ($istxt) { echo 'style="margin-bottom:10px;"'; } ?>>
	<small>
	<?php bloginfo('description'); ?> 
	</small>
	</div>
<?php
}
?>



					</div>
					<div class="col-md-6 page-header-top-right">
						<div class="sr-only">
							<a href="#content" title="<?php esc_attr_e('Skip to content', 'blue-haze'); ?>"><?php _e('Skip to content', 'blue-haze'); ?></a>
						</div>
						<?php if (is_active_sidebar('header-right')) { ?> 
						<div class="pull-right">
							<?php dynamic_sidebar('header-right'); ?> 
						</div>
						<div class="clearfix"></div>
						<?php } // endif; ?> 
					</div>
				</div><!--.site-branding-->


<?php
// DISPLAY PRIMARY MENU UNLESS EXCLUDED
$checkPage = get_the_title();

global $bh_nomenu;
if (!$bh_nomenu) { $bh_nomenu = array(); }

//if ($is_assigned) {
if ($is_assigned && !in_array($checkPage, $bh_nomenu)) {
?>

				<div class="row main-navigation">
					<div class="col-md-12">
						<nav class=" navbar-default" role="navigation">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-primary-collapse">
									<span class="sr-only"><?php _e('Toggle navigation', 'blue-haze'); ?></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							
							<div class="collapse navbar-collapse navbar-primary-collapse">
								<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav navbar-nav', 'walker' => new BootstrapBasicMyWalkerNavMenu())); ?> 
								<?php dynamic_sidebar('navbar-right'); ?> 
							</div><!--.navbar-collapse-->
						</nav>
					</div>
				</div><!--.main-navigation-->

<?php } ?>

			</header>	
			<br>
			<div id="content" class="row row-with-vspace site-content">
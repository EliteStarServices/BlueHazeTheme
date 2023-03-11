<?php
/**
 * Blue Haze Options Menu
 * 
 * https://www.wpexplorer.com/wordpress-theme-options/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Theme_Options' ) ) {

	class WPEX_Theme_Options {

		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_menu', array( 'WPEX_Theme_Options', 'add_admin_menu' ) );
				add_action( 'admin_init', array( 'WPEX_Theme_Options', 'register_settings' ) );
			}

		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_options() {
			return get_option( 'theme_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_theme_option( $id ) {
			$options = self::get_theme_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
		}

		/**
		 * Add sub menu page
		 *
		 * @since 1.0.0
		 */
		public static function add_admin_menu() {
			add_menu_page(
				esc_html__( 'Blue Haze Menu', 'text-domain' ),
				esc_html__( 'Blue Haze Menu', 'text-domain' ),
				'manage_options',
				'theme-settings',
				array( 'WPEX_Theme_Options', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function register_settings() {
			register_setting( 'theme_options', 'theme_options', array( 'WPEX_Theme_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {

			// If we have options lets sanitize them
			if ( $options ) {

				// Global Checkbox
				if ( ! empty( $options['global_mode'] ) ) {
					$options['global_mode'] = 'on';
				} else {
					unset( $options['global_mode'] ); // Remove from options if not checked
				}
                
                // DataTables Checkbox
				if ( ! empty( $options['data_tables'] ) ) {
					$options['data_tables'] = 'on';
				} else {
					unset( $options['data_tables'] ); // Remove from options if not checked
				}

                // Editor Checkbox
				if ( ! empty( $options['visual_editor'] ) ) {
					$options['visual_editor'] = 'on';
				} else {
					unset( $options['visual_editor'] ); // Remove from options if not checked
				}

			    // Editor Checkbox
				if ( ! empty( $options['more_plugins'] ) ) {
					$options['more_plugins'] = 'on';
				} else {
					unset( $options['more_plugins'] ); // Remove from options if not checked
				}

				// Input CSS URL
				if ( ! empty( $options['user_css'] ) ) {
					$options['user_css'] = sanitize_text_field( $options['user_css'] );
				} else {
					unset( $options['user_css'] ); // Remove from options if empty
				}

				// Template Selection
				if ( ! empty( $options['select_templates[]'] ) ) {
					$options['select_templates[]'] = sanitize_text_field( $options['select_templates[]'] );
				} else {
					unset( $options['select_templates[]'] ); // Remove from options if empty
				}
/*
				// Select
				if ( ! empty( $options['select_example'] ) ) {
					$options['select_example'] = sanitize_text_field( $options['select_example'] );
				}
*/
			}

			// Return sanitized options
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h1><?php esc_html_e( 'Blue Haze Options Menu', 'text-domain' ); ?></h1><hr>

				<form method="post" action="options.php">

					<?php settings_fields( 'theme_options' ); ?>

					<table class="form-table wpex-custom-admin-login-table">

						<?php // Global Mode ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Global Mode', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'global_mode' ); ?>
								<input type="checkbox" name="theme_options[global_mode]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Activate Blue Haze Global Mode', 'text-domain' ); ?>
							</td>
						</tr>

						<?php // Disable Visual Editor ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Disable Visual Editor', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'visual_editor' ); ?>
								<input type="checkbox" name="theme_options[visual_editor]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Disable Visual Editor for All Users', 'text-domain' ); ?>
							</td>
						</tr>

						<?php // Extend Plugin List ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'Extended Plugins', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'more_plugins' ); ?>
								<input type="checkbox" name="theme_options[more_plugins]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Enable Extended List of Plugin Suggestions', 'text-domain' ); ?>
							</td>
						</tr>

						<?php // DataTables Support ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'DataTables Support', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'data_tables' ); ?>
								<input type="checkbox" name="theme_options[data_tables]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Activate DataTables Support', 'text-domain' ); ?>
							</td>
						</tr>

						<?php // User CSS URL ?>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( 'User CSS File URL', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'user_css' ); ?>
								<input type="text" name="theme_options[user_css]" value="<?php echo esc_attr( $value ); ?>" size="70">
							</td>
						</tr>

						<?php // Multiple Select / Post Types ?>
						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Offer BH Template', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'select_templates' ); ?>
								<select multiple="multiple" name="theme_options[select_templates][]">
									<?php
									$options = get_post_types(array(
										'publicly_queryable'   => true,
										'_builtin' => false,
									) );

									if ($options) {
										array_unshift($options,"post");
									} else {
										$options = array("post");
									}		

									foreach ( $options as $label ) { 

										$exclude = array('forum','reply','topic');
										if( TRUE === in_array( $label, $exclude ) ) { continue; }
										$found = array_intersect($value, $options);

									?>
										<option value="<?php echo esc_attr( $label ); ?>" <?php selected( TRUE, in_array($label, $found ) ); ?>><?php echo $label; ?>
											<?php //echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
							</td>
						</tr>						


<?php /*
						<?php // Select example ?>
						<tr valign="top" class="wpex-custom-admin-screen-background-section">
							<th scope="row"><?php esc_html_e( 'Select Example', 'text-domain' ); ?></th>
							<td>
								<?php $value = self::get_theme_option( 'select_example' ); ?>
								<select name="theme_options[select_example]">
									<?php
									$options = array(
										'1' => esc_html__( 'Option 1', 'text-domain' ),
										'2' => esc_html__( 'Option 2', 'text-domain' ),
										'3' => esc_html__( 'Option 3', 'text-domain' ),
									);
									foreach ( $options as $id => $label ) { ?>
										<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
											<?php echo strip_tags( $label ); ?>
										</option>
									<?php } ?>
								</select>
							</td>
						</tr>
*/ ?>
					</table>

					<?php submit_button(); ?>

				</form>



<?php
// DYNAMIC TEMPLATE REWRITE
if (file_exists(get_template_directory().'/bh_top.php')){
	unlink(get_template_directory().'/bh_top.php');
}

// DETERMINE WHERE TO OFFER BLUE HAZE TEMPLATE
$getTpl = myprefix_get_theme_option( 'select_templates' );
foreach ( $getTpl as $sglTpl ) { $shoTpl = $shoTpl.",".$sglTpl; }
$allTpl = "Template Post Type: page".$shoTpl;

// CREATE DYNAMIC COMMENT
$write_top = "<?php

/* Template Name: Blue Haze Template */
/* ".$allTpl." */

// DO NOT EDIT THIS FILE - IT IS A DYNAMIC FILE
// The editable Blue Haze Template is 'bh_main.php'";

// WRITE TO FILE
$cnf = fopen(get_template_directory().'/bh_top.php', 'a');
fwrite($cnf, $write_top);
fclose($cnf);



// THIS SHOWS THE TEMPLATE UPDATE INFO (could turn off)
$tester = myprefix_get_theme_option( 'select_templates' );
foreach ( $tester as $test ) { $tested = $tested.",".$test; }
echo "<li>BH Template Status (page".$tested.")</li>";



// COMBINE TEMPLATE PARTS INTO SINGLE FILE
$files = ["bh_top.php", "bh_main.php"];
$combined_contents;
foreach ($files as $single_file)
{
    $combined_contents .= file_get_contents(get_template_directory().'/'.$single_file);
}
file_put_contents(get_template_directory()."/page-blue.php",$combined_contents);

?>

			</div><!-- .wrap -->
		<?php }

	}
}
new WPEX_Theme_Options();

// Helper function to use in your theme to return a theme option value
function myprefix_get_theme_option( $id = '' ) {
	return WPEX_Theme_Options::get_theme_option( $id );
}
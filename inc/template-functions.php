<?php
/**
 * Template Functions
 * 
 * @package bootstrap-basic
 */


// Create Folder = /wp-content/uploads/bluehaze
if( is_multisite() ) {
    switch_to_blog(1);
    $upload_dir = wp_upload_dir();
    restore_current_blog();
} else { $upload_dir = wp_upload_dir(); }
$bh_dir = $upload_dir['basedir'] . '/bluehaze';
if(!file_exists($bh_dir)) wp_mkdir_p($bh_dir);


    /*--------------------------------------------------
        BEGIN BLUE HAZE TEMPLATE OPTIONS
    ----------------------------------------------------*/
  
    function diwp_metabox_mutiple_fields() {
 
        
// DETERMINE WHERE TO OFFER BH TEMPLATE OPTIONS
$avTpl = myprefix_get_theme_option( 'select_templates' );
if ($avTpl) {
	array_unshift($avTpl, "page");
} else {
	$avTpl = array("page");
}

        add_meta_box(
                'diwp-metabox-multiple-fields',
                'BH Template Options',
                'diwp_add_multiple_fields',
                $avTpl,
                'side',
            );
    }
     
    add_action('add_meta_boxes', 'diwp_metabox_mutiple_fields');


    function diwp_add_multiple_fields() {
     
        global $post;
     
        // Get Value of Fields From Database
        $diwp_textfield = get_post_meta( $post->ID, '_diwp_text_field', true);
        $diwp_radiofield = get_post_meta( $post->ID, '_diwp_radio_field', true);
        $diwp_radiotwo = get_post_meta( $post->ID, '_diwp_radio_two', true);
        $diwp_checkboxfield = get_post_meta( $post->ID, '_diwp_checkbox_field', true);
//        $diwp_selectfield = get_post_meta( $post->ID, '_diwp_select_field', true);
//        $diwp_textareafield = get_post_meta( $post->ID, '_diwp_textarea_field', true);
         
    ?>

<div class="row">
    <small><i class="dashicons dashicons-warning"></i>&nbsp;&nbsp;These Options are for the Blue Haze Template</small><hr>
        <div class="label"><strong>Select Sidebars</strong></div>
        <div class="fields">
            <label><input type="radio" name="_diwp_radio_field" value="none" <?php if($diwp_radiofield == 'none') echo 'checked'; ?> /> No Sidebars</label>
            <br><label><input type="radio" name="_diwp_radio_field" value="left"  <?php if($diwp_radiofield == 'left') echo 'checked'; ?> /> Left Sidebar Only</label>
            <br><label><input type="radio" name="_diwp_radio_field" value="right"  <?php if($diwp_radiofield == 'right') echo 'checked'; ?>/> Right Sidebar Only</label>
            <br><label><input type="radio" name="_diwp_radio_field" value="both"  <?php if($diwp_radiofield == 'both') echo 'checked'; ?>/> Both Sidebars</label>
        </div>
    </div>
     
    <br/>

    <div class="row">
        <div class="label"><strong>Select Container</strong></div>
        <div class="fields">
            <label><input type="radio" name="_diwp_radio_two" value="none" <?php if($diwp_radiotwo == 'none') echo 'checked'; ?> /> No Container</label>
            <br><label><input type="radio" name="_diwp_radio_two" value="blue"  <?php if($diwp_radiotwo == 'blue') echo 'checked'; ?> /> Bootstrap Blue</label>
            <br><label><input type="radio" name="_diwp_radio_two" value="thin"  <?php if($diwp_radiotwo == 'thin') echo 'checked'; ?>/> Thin Border</label>
        </div>
    </div>

    <br/>
     
    <div class="row">
        <div class="label"><strong>Select Format</strong></div>
        <div class="fields">
            <label><input type="checkbox" name="_diwp_checkbox_field[]" value="wide" <?php if(in_array('wide', $diwp_checkboxfield)) echo 'checked'; ?> /> Full Width Page</label>
            <br><label><input type="checkbox" name="_diwp_checkbox_field[]" value="head" <?php if(in_array('head', $diwp_checkboxfield)) echo 'checked'; ?>/> Disable Header</label>
            <br><label><input type="checkbox" name="_diwp_checkbox_field[]" value="foot" <?php if(in_array('foot', $diwp_checkboxfield)) echo 'checked'; ?>/> Simple Footer</label>
        </div>
    </div>

    <br/>
     
    <div class="row">
        <div class="label"><hr><strong>Replace Content with PHP File</strong><br><small>/wp-content/uploads/bluehaze/</small></div>
        <div class="fields"><input type="text" name="_diwp_text_field" value="<?php echo $diwp_textfield; ?>"></div>
    </div>

    <?php
    /*
     <br/>
     
     <div class="row">
         <div class="label">Select Dropdown</div>
         <div class="fields">
             <select name="_diwp_select_field">
                 <option value="">Select Option</option>
                 <option value="1" <?php if($diwp_selectfield == '1') echo 'selected'; ?>>Option 1</option>
                 <option value="2" <?php if($diwp_selectfield == '2') echo 'selected'; ?>>Option 2</option>
                 <option value="3" <?php if($diwp_selectfield == '3') echo 'selected'; ?>>Option 3</option>
             </select>
         </div>
     </div>
      
     <br/>
      
     <div class="row">
         <div class="label">Textarea</div>
         <div class="fields">
             <textarea rows="5" name="_diwp_textarea_field"><?php echo $diwp_textareafield; ?></textarea>
         </div>
     </div>
    */
    }


// Now Save the Template Options in the Database
 
function diwp_save_multiple_fields_metabox(){
 
    global $post;
 
    if(isset($_POST["_diwp_radio_field"])) :
    update_post_meta($post->ID, '_diwp_radio_field', $_POST["_diwp_radio_field"]);
    endif;

    if(isset($_POST["_diwp_radio_two"])) :
    update_post_meta($post->ID, '_diwp_radio_two', $_POST["_diwp_radio_two"]);
    endif;
 
//    if(isset($_POST["_diwp_checkbox_field"])) :
    update_post_meta($post->ID, '_diwp_checkbox_field', $_POST["_diwp_checkbox_field"]);
//    endif;

    if(isset($_POST["_diwp_text_field"])) :
    update_post_meta($post->ID, '_diwp_text_field', $_POST["_diwp_text_field"]);
    endif;

/* 
    if(isset($_POST["_diwp_select_field"])) :
    update_post_meta($post->ID, '_diwp_select_field', $_POST["_diwp_select_field"]);
    endif;
 
    if(isset($_POST["_diwp_textarea_field"])) :
    update_post_meta($post->ID, '_diwp_textarea_field', $_POST["_diwp_textarea_field"]);
    endif;
*/ 
}
 
add_action('save_post', 'diwp_save_multiple_fields_metabox');





	/**
	 * Determine main column size for the DEFAULT TEMPLATE based on actived sidebars
	 * 
	 * For theme designer:
	 * Both sidebars active - Main column size is 6.
	 * Only one sidebar active - Main column size is 9.
	 * No sidebars active. Main column is 12.
	 * 
	 * @return integer return column size.
	 */
if (!function_exists('bootstrapBasicGetMainColumnSize')) {
	function bootstrapBasicGetMainColumnSize() 
	{
        if (is_active_sidebar('sidebar-left') && is_active_sidebar('sidebar-right')) {
			// if both sidebar actived.
			$main_column_size = 6;
		} elseif (
				(is_active_sidebar('sidebar-left') && !is_active_sidebar('sidebar-right')) || 
				(is_active_sidebar('sidebar-right') && !is_active_sidebar('sidebar-left'))
		) {
			// if only one sidebar actived.
			$main_column_size = 9;
		} else {
			// if no sidebar actived.
			$main_column_size = 12;
		}

		return $main_column_size;
	}
}



if (!function_exists('bootstrapBasicHasWidgetBlock')) {
    /**
     * Check if currently there are any selected widget block name.
     * 
     * @link https://wordpress.stackexchange.com/a/392496/41315 Original source code.
     * @param string $blockName The widget block name to check.
     * @return bool Return `true` if found, return `false` if not found or this site is using older version of WordPress that is not supported widget blocks.
     */
    function bootstrapBasicHasWidgetBlock($blockName)
    {
        if (!is_string($blockName)) {
            return false;
        }

        $widget_blocks = get_option('widget_block');
        if (
            (is_array($widget_blocks) || is_object($widget_blocks)) && 
            !empty($widget_blocks) && 
            function_exists('has_block')
        ) {
            foreach ($widget_blocks as $widget_block) {
                if (
                    isset($widget_block['content']) && 
                    !empty($widget_block['content']) && 
                    has_block($blockName, $widget_block['content'])
                ) {
                    // if found selected widget block name.
                    unset($widget_block, $widget_blocks);
                    return true;
                }
            }// endforeach;
            unset($widget_block);
        }

        unset($widget_blocks);
        return false;
    }// bootstrapBasicHasWidgetBlock
}
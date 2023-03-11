<?php

if (!class_exists('BootstrapBasicAdminHelp')) {
    class BootstrapBasicAdminHelp
        {


        /**
         * Add help menu to admin sidebar and add help page.
         */
        public function themeHelpMenu()
        {
            add_theme_page(__('Blue Haze Info', 'bootstrap-basic'), __('Blue Haze Info', 'bootstrap-basic'), 'edit_posts', 'theme_help', array($this, 'themeHelpPage'));
        }// themeHelpMenu


        /**
         * Display theme help page.
         */
        public function themeHelpPage()
        {
            // display page content to view file.
            include get_template_directory() . '/inc/views/BlueHazeAdminHelp_v.php';
        }// themeHelpPage


    }// end class -------------------------------------------------------------------------------
}
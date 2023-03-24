<?php

/**
 *  Contants
 */
if (!function_exists('fw_ext_ad_sp_prepare_constants')) {

    function fw_ext_ad_sp_prepare_constants() {
        $is_loggedin = 'false';
        if (is_user_logged_in()) {
            $is_loggedin = 'true';
        }
        wp_localize_script('fw_ext_deals_callback', 'fw_ext_deals_scripts_vars', array(
            'ajaxurl' => admin_url('admin-ajax.php'),            
            'delete_ad_title' => esc_html__('Ad delete notification.', 'cannalisting_core'),
			'delete_ad_msg' => esc_html__('Are you sure, you want to delete this ad?', 'cannalisting_core'),
            'fav_message' => esc_html__('Please login first', 'cannalisting_core'),
            'is_loggedin' => $is_loggedin,
            'sp_upload_nonce' => wp_create_nonce('sp_upload_nonce'),
            'sp_upload_gallery' => esc_html__('Gallery Upload', 'cannalisting_core'),
            'delete_all_ad_title' => esc_html__('Deals delete notification.', 'cannalisting_core'),
			'delete_all_ad_msg' => esc_html__('Are you sure, you want to delete all Deals?', 'cannalisting_core'),
			'cannalisting_featured_nounce' => wp_create_nonce ( 'cannalisting_featured_nounce' ),
			'file_upload_title' => esc_html__('Feature image upload','cannalisting_core'),
			'theme_path_uri' => get_template_directory_uri(),
			'theme_path' => get_template_directory(),
        ));
    }

    add_action('wp_enqueue_scripts', 'fw_ext_ad_sp_prepare_constants', 90);
}
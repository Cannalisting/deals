<?php

if (!defined('FW')) {
    die('Forbidden');
}

/**
 * Enqueue Script on frontend
 * Check if this is not admin
 */
if (!is_admin()) {

    $fw_ext_instance = fw()->extensions->get('deals');

    wp_register_script(
        'fw_ext_deals_callback', $fw_ext_instance->get_declared_URI('/static/js/fw_ext_deals_callbacks.js'), array('jquery','cannalisting_callbacks'), '1.0', true
    );
	
    wp_register_script(
        'cannalisting_ad_gmaps', $fw_ext_instance->get_declared_URI('/static/js/maps/ad_gmaps.js'), array('jquery', 'jquery-googleapis','markerclusterer','cannalisting_infobox','oms','sticky-kit','cannalisting_callbacks'), '1.0', true
    );
    
//     wp_register_script(
//         'pogoslider', $fw_ext_instance->get_declared_URI('/static/js/pogoslider.js'), array('jquery', 'jquery-googleapis','markerclusterer','cannalisting_infobox','oms','sticky-kit','cannalisting_callbacks'), '1.0', true
//     );
	
// 	wp_register_script(
//         'cannalisting_maps', $fw_ext_instance->get_declared_URI('/static/js/cannalisting_maps.js'), array('jquery', 'jquery-googleapis','markerclusterer','cannalisting_infobox','oms','sticky-kit','cannalisting_callbacks'), '1.0', true
//     );
    
//     wp_register_style(
//         'pogoslidercss', $fw_ext_instance->get_declared_URI('/static/css/pogoslider.css')
//     );
    
    
    // wp_enqueue_script('pogoslider');
    // wp_enqueue_script('cannalisting_maps');
    // wp_enqueue_style('pogoslidercss');
	
	if (is_singular()) {

		$_post = get_post();
		if ($_post != null) {
			if ($_post && 
				( 
					preg_match('/sp_recent_deals/', $_post->post_content)
					||
					preg_match('/cannalisting_vc_recent_deals/', $_post->post_content)
				)
			) {
				wp_enqueue_script('fw_ext_deals_callback');
			}
		}
	}
	
	if(is_page_template('directory/dashboard.php') 
	   || is_page_template('directory/provider-deals.php') 
	   || is_author() 
	   || is_singular( array( 'sp_deals' ) ) ) {      
		wp_enqueue_script('fw_ext_deals_callback');
	}

    if( is_tax( array( 'ad_category', 'ad_tags', 'ad_amenity' ) )  
        || is_page_template('directory/deals-search.php')
    ) {      
        wp_enqueue_script('cannalisting_ad_gmaps'); 
        wp_enqueue_script('fw_ext_deals_callback');
    }     

}
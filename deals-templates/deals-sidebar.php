<?php 
/**
 *
 * The template used for displaying ad sidebar
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      cannalisting-theme-uri
 * @since 1.0
 */
global $post;
?>
<aside id="tg-sidebarvtwo" class="tg-sidebarvtwo">
	<?php
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-contact.php';
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-categories.php';
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-userdetails.php';
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-form.php';
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-social.php';
		include plugin_dir_path(__DIR__) . 'deals-templates/sidebar-deals-related.php';    
    ?>      
    <?php if (is_active_sidebar('ad-detail-sidebar')) {?>      
        <div class="tg-listingiaad">        	
            <?php dynamic_sidebar('ad-detail-sidebar'); ?>        	
        </div> 
    <?php } ?>
</aside>
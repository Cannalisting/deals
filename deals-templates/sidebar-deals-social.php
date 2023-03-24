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
<div class="tg-asideauthor tg-authorscan">
    <?php do_action('cannalisting_get_qr_code', 'post', $post->ID ); ?>
    <div class="qr-socailicons">
        <?php cannalisting_get_social_share_v2(''); ?>                
    </div>
</div>
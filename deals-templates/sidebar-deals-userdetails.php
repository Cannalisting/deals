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
$post_author_id = get_post_field( 'post_author', $post->ID );
do_action('cannalisting_get_ad_author_box', $post_author_id);

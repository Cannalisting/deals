<?php
/**
 *
 * The template used for displaying default provider search result
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      cannalisting-theme-uri
 * @since 1.0
 */
global $wp_query;
get_header();
	get_template_part( '/directory/deals-search' );
get_footer();
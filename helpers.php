<?php

if (!defined('FW')) {
    die('Forbidden');
}

/**
 * Return the ad listing view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_deals_listing')) {
	function fw_ext_get_render_deals_listing() {
		return fw()->extensions->get('deals')->render_ad_listing();
	}
}

/**
 * Return the favorite deals
 * @return string
 */
if (!function_exists('fw_ext_get_render_favorite_deals')) {
	function fw_ext_get_render_favorite_deals() {
		return fw()->extensions->get('deals')->render_favorite_deals();
	}
}

/**
 * Return the deals add view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_deals_add')  ) {
	function fw_ext_get_render_deals_add() {
		return fw()->extensions->get('deals')->render_add_deals();
	}
}

/**
 * Return the deals edit view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_deals_edit')) {
	function fw_ext_get_render_deals_edit() {
		return fw()->extensions->get('deals')->render_edit_deals();
	}
}

/**
 * Return the deals dashboard display view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_deals_dashboard_view')) {
	function fw_ext_get_render_deals_dashboard_view() {
		return fw()->extensions->get('deals')->render_display_dashboard_deals();
	}
}

/**
 * Return the deals dashboard display view.
 * @return string
 */
if (!function_exists('fw_ext_get_render_deals_search')) {
	function fw_ext_get_render_deals_search() {
		return fw()->extensions->get('deals')->render_display_search_result();
	}
}

/**
 * Return the provider detail page deals
 * @return string
 */
if (!function_exists('fw_ext_get_render_profile_deals_view')) {
	function fw_ext_get_render_profile_deals_view() {
		return fw()->extensions->get('deals')->render_display_profile_deals();
	}
}

/**
 * Return the deals dashboard display view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_view_v2')) {
	function filter_fw_ext_ad_view_v2() {
		return fw()->extensions->get('deals')->render_list_deals();
	}
}

/**
 * Return the deals detail view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_detail_view')) {
	function filter_fw_ext_ad_detail_view() {
		return fw()->extensions->get('deals')->render_display_profile_deals_detail_view();
	}
}

/**
 * Return the deals archive view.
 * @return string
 */
if (!function_exists('filter_fw_ext_ad_archive_view_deals')) {
	function filter_fw_ext_ad_archive_view_deals() {
		return fw()->extensions->get('deals')->render_display_deals_archive_view_deals();
	}
}
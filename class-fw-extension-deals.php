<?php

if (!defined('FW')) {
    die('Forbidden');
}

class FW_Extension_deals extends FW_Extension {

    /**
     * @internal
     */
    public function _init() {     
		add_action('init',array(&$this,'register_post_type'));
		add_filter('manage_sp_deals_posts_columns', array(&$this, 'directory_columns_add'),10,1);
		add_action('manage_sp_deals_posts_custom_column', array(&$this, 'directory_columns'),10, 1);
        add_filter('template_include', array(&$this, 'render_sp_deals_detail_page_view'));
    }


    /**
     * @Render deals detail page view
     * @return type
     */
    public function render_sp_deals_detail_page_view( $template ) {
        $post_types = array('sp_deals');
        $taxonomies = array('ad_tags', 'ad_category', 'ad_amenity');
        if (is_singular($post_types)) {
            $template = do_action('render_sp_display_detail_deals_view');            
        }
        if ( is_tax( $taxonomies ) ) {
            // die($template);
            $template = do_action('render_sp_display_archive_view_deals');            
        }
        return $template;
    }


    /**
     * @Render deals Listing
     * @return type
     */
    public function render_ad_listing() {
        return $this->render_view('listing');
    }
	
	/**
     * @Render favorite deals
     * @return type
     */
    public function render_favorite_deals() {
        return $this->render_view('favorites');
    }

    /**
     * @Render deals Add View
     * @return type
     */
    public function render_add_deals() {
        return $this->render_view('add');
    }

    /**
     * @Render deals Edit View
     * @return type
     */
    public function render_edit_deals() {
        return $this->render_view('edit');
    }
	
	/**
     * @Render deals Edit View
     * @return type
     */
    public function render_display_dashboard_deals() {
        return $this->render_view('deals');
    }

    /**
     * @Render deals detail page View
     * @return type
     */
    public function render_ad_detail_page() {
        return $this->render_view('single-ad');
    }
	
	/**
     * @Render deals search result
     * @return type
     */
    public function render_display_search_result() {
        return $this->render_view('deals-search');
    }
	
	/**
     * @Render deals provider detail page
     * @return type
     */
    public function render_display_profile_deals() {
        return $this->render_view('provider_detail');
    }

    /**
     * @Render deals provider detail page
     * @return type
     */
    public function render_display_profile_deals_detail_view() {
        return $this->render_view('deals_detail');
    }
	
    /**
     * @Render deals archive page
     * @return type
     */
    public function render_display_deals_archive_view_deals() {
        return $this->render_view('ad-archive');
    }

	/**
     * @Render deals Edit View
     * @return type
     */
    public function render_list_deals() {
        return $this->render_view('grid');
    }

    /**
     * @access Private
     * @Register Post Type
     */
    public function register_post_type() {
		if( function_exists('cannalisting_get_theme_settings') ){
			$ad_slug	= cannalisting_get_theme_settings('ad_slug');
		}
		
		//$ad_slug	=  !empty( $ad_slug ) ? $ad_slug : 'ad';
		$ad_slug	=  'deal';
		
        register_post_type('sp_deals', array(
            'labels' => array(
                'name' => esc_html__('Deals', 'cannalisting_core'),
                'all_items' => esc_html__('Deals', 'cannalisting_core'),
                'singular_name' => esc_html__('Deal', 'cannalisting_core'),
                'add_new' => esc_html__('Create Deal', 'cannalisting_core'),
                'add_new_item' => esc_html__('Create New deal', 'cannalisting_core'),
                'edit' => esc_html__('Edit', 'cannalisting_core'),
                'edit_item' => esc_html__('Edit deal', 'cannalisting_core'),
                'new_item' => esc_html__('New deal', 'cannalisting_core'),
                'view' => esc_html__('View deal', 'cannalisting_core'),
                'view_item' => esc_html__('View deal', 'cannalisting_core'),
                'search_items' => esc_html__('Search deal', 'cannalisting_core'),
                'not_found' => esc_html__('No deal found', 'cannalisting_core'),
                'not_found_in_trash' => esc_html__('No deal found in trash', 'cannalisting_core'),
                'parent' => esc_html__('Parent deal', 'cannalisting_core'),
            ),
            'description' => esc_html__('This is where you can create new deal.', 'cannalisting_core'),
            'public' => true,
            'supports' => array('title', 'editor','thumbnail','author', 'comments'),
            'show_ui' => true,
            'capability_type' => 'post',
            'map_meta_cap' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'hierarchical' => true,
            'menu_position' => 10,
            'rewrite' => array('slug' => $ad_slug, 'with_front' => true),
            'query_var' => true,
            'has_archive' => true
        ));
        	register_taxonomy('ad_tags', 'sp_deals', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Tags', 'cannalisting_core'),
                'singular_name' => esc_html__('Tag', 'cannalisting_core'),
                'search_items' => esc_html__('Search Tags', 'cannalisting_core'),
                'popular_items' => esc_html__('Popular Tags', 'cannalisting_core'),
                'all_items' => esc_html__('All Tags', 'cannalisting_core'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Tag', 'cannalisting_core'),
                'update_item' => esc_html__('Update Tag', 'cannalisting_core'),
                'add_new_item' => esc_html__('Add New Tag', 'cannalisting_core'),
                'new_item_name' => esc_html__('New Tag Name', 'cannalisting_core'),
                'separate_items_with_commas' => esc_html__('Separate tags with commas', 'cannalisting_core'),
                'add_or_remove_items' => esc_html__('Add or remove tags', 'cannalisting_core'),
                'choose_from_most_used' => esc_html__('Choose from the most used tags', 'cannalisting_core'),
                'menu_name' => esc_html__('Tags', 'cannalisting_core'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_tags'),
        ));

        //Register category
        register_taxonomy('ad_category', 'sp_deals', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Category', 'cannalisting_core'),
                'singular_name' => esc_html__('Category', 'cannalisting_core'),
                'search_items' => esc_html__('Search Categories', 'cannalisting_core'),
                'popular_items' => esc_html__('Popular Categories', 'cannalisting_core'),
                'all_items' => esc_html__('All Categories', 'cannalisting_core'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Category', 'cannalisting_core'),
                'update_item' => esc_html__('Update Category', 'cannalisting_core'),
                'add_new_item' => esc_html__('Add New Category', 'cannalisting_core'),
                'new_item_name' => esc_html__('New Category Name', 'cannalisting_core'),
                'separate_items_with_commas' => esc_html__('Separate Categories with commas', 'cannalisting_core'),
                'add_or_remove_items' => esc_html__('Add or remove Categories', 'cannalisting_core'),
                'choose_from_most_used' => esc_html__('Choose from the most used Categories', 'cannalisting_core'),
                'menu_name' => esc_html__('Categories', 'cannalisting_core'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_category'),
        ));

        //Register amenity
        register_taxonomy('ad_amenity', 'sp_deals', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => esc_html__('Amenity', 'cannalisting_core'),
                'singular_name' => esc_html__('Amenity', 'cannalisting_core'),
                'search_items' => esc_html__('Search amenities', 'cannalisting_core'),
                'popular_items' => esc_html__('Popular amenities', 'cannalisting_core'),
                'all_items' => esc_html__('All amenities', 'cannalisting_core'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => esc_html__('Edit Amenity', 'cannalisting_core'),
                'update_item' => esc_html__('Update Amenity', 'cannalisting_core'),
                'add_new_item' => esc_html__('Add New Amenity', 'cannalisting_core'),
                'new_item_name' => esc_html__('New Amenity Name', 'cannalisting_core'),
                'separate_items_with_commas' => esc_html__('Separate amenities with commas', 'cannalisting_core'),
                'add_or_remove_items' => esc_html__('Add or remove amenities', 'cannalisting_core'),
                'choose_from_most_used' => esc_html__('Choose from the most used amenities', 'cannalisting_core'),
                'menu_name' => esc_html__('Amenities', 'cannalisting_core'),
            ),
            'show_ui' => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'ad_amenity'),
        ));
		
    }
	
	/**
	 * @Prepare Columns
	 * @return {post}
	 */
	public function directory_columns_add($columns) {
		$columns['author'] 			= esc_html__('Author','cannalisting_core');
		return $columns;
	}

	/**
	 * @Get Columns
	 * @return {}
	 */
	public function directory_columns($name) {
		global $post;


		switch ($name) {
			case 'author':
				echo ( get_the_author );
			break;
		}
	}

}
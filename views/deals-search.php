<?php
/**
 *
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      http://cannalisting-theme-author.com/
 * @since 1.0
 */
global $paged, $query_args, $showposts, $wp_query;
// $per_page = get_option('posts_per_page');;
$per_page = 12;
$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$json = array();
$meta_query_args	= array();
$tax_query_args		= array();
$tax_category_query_args	= array();
$tax_amenity_query_args		= array();
$tax_tag_query_args			= array();

//search filters
$s 				= !empty($_GET['keyword']) ? sanitize_text_field( $_GET['keyword'] ) : '';
$category 		= !empty($_GET['category']) ? $_GET['category'] : '';
$sort_by 		= !empty($_GET['sortby']) ? $_GET['sortby'] : 'date';
$price_type		= !empty($_GET['price_type']) ? $_GET['price_type'] : '';
$showposts 		= !empty($_GET['showposts']) ? $_GET['showposts'] : $per_page;
$s_amenities	= !empty( $_GET['amenities'] ) ? $_GET['amenities'] : array();
$s_tags			= !empty( $_GET['tags'] ) ? $_GET['tags'] : array();
$lat			= !empty( $_GET['lat'] ) ? $_GET['lat'] : array();
$long			= !empty( $_GET['long'] ) ? $_GET['long'] : array();
$geo			= !empty( $_GET['geo'] ) ? $_GET['geo'] : array();


//Order
$order = 'DESC';
if (!empty($_GET['orderby'])) {
    $order = esc_attr($_GET['orderby']);
}



//price type 
if( !empty( $price_type ) ){
	$meta_query_args[] = array(
		'key' 		=> 'pricing_type',
		'value' 	=> $price_type,
		'compare' 	=> '='
	);
}


// //latitude type 
// if( !empty( $lat ) ){
// 	$meta_query_args[] = array(
// 		'key' 		=> 'latitude',
// 		'value' 	=> $lat,
// 		'compare' 	=> '='
// 	);
// }

// //longitude type 
// if( !empty( $long ) ){
// 	$meta_query_args[] = array(
// 		'key' 		=> 'longitude',
// 		'value' 	=> $long,
// 		'compare' 	=> '='
// 	);
// }


// //longitude type 
// if( !empty( $geo ) ){
// 	$meta_query_args[] = array(
// 		'key' 		=> 'address',
// 		'value' 	=> $geo,
// 		'compare' 	=> '='
// 	);
// }

//Radius Search
if ( !empty($_GET['geo']) ) {

    $Latitude = '';
    $Longitude = '';
    $prepAddr = '';
    $minLat = '';
    $maxLat = '';
    $minLong = '';
    $maxLong = '';
	
	$address = sanitize_text_field($_GET['geo']);
    $prepAddr = str_replace(' ', '+', $address);
	

    if (isset($_GET['geo_distance']) && !empty($_GET['geo_distance'])) {
        $radius = $_GET['geo_distance'];
    } else {
        $radius = 300;
    }

    //Distance in miles or kilometers
    if (function_exists('fw_get_db_settings_option')) {
        $dir_distance_type = fw_get_db_settings_option('dir_distance_type');
    } else {
        $dir_distance_type = 'mi';
    }

    if ($dir_distance_type === 'km') {
        $radius = $radius * 0.621371;
    }
	
	$Latitude	= isset( $_GET['lat'] ) ? esc_attr( $_GET['lat'] ) : '';
	$Longitude	= isset( $_GET['long'] ) ? esc_attr( $_GET['long'] ) : '';
	
	if( !empty( $Latitude ) && !empty( $Longitude ) ){
		$Latitude	 = $Latitude;
		$Longitude   = $Longitude;

	} else{
		$args = array(
			'timeout'     => 15,
			'headers' => array('Accept-Encoding' => ''),
			'sslverify' => false
		);

		$url	    = 'https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key='.$google_key;;
		$response   = wp_remote_get( $url, $args );
		$geocode	= wp_remote_retrieve_body($response);

		$output	  = json_decode($geocode);

		if( isset( $output->results ) && !empty( $output->results ) ) {
			$Latitude	 = $output->results[0]->geometry->location->lat;
			$Longitude   = $output->results[0]->geometry->location->lng;
		}
	}
	
	if( !empty( $Latitude ) && !empty( $Longitude ) ){
		$zcdRadius = new RadiusCheck($Latitude, $Longitude, $radius);
		$minLat = $zcdRadius->MinLatitude();
		$maxLat = $zcdRadius->MaxLatitude();
		$minLong = $zcdRadius->MinLongitude();
		$maxLong = $zcdRadius->MaxLongitude();

		$meta_query_args = array(
			'relation' => 'AND',
			array(
				'key' 		=> 'latitude',
				'value' 	=> array($minLat, $maxLat),
				'compare' 	=> 'BETWEEN',
				'type' 		=> 'DECIMAL(20,10)',
			),
			array(
				'key' 		=> 'longitude',
				'value' 	=> array($minLong, $maxLong),
				'compare' 	=> 'BETWEEN',
				'type' 		=> 'DECIMAL(20,10)',
			)
		);

		if (isset($query_args['meta_query']) && !empty($query_args['meta_query'])) {
			$meta_query = array_merge($meta_query_args, $query_args['meta_query']);
		} else {
			$meta_query = $meta_query_args;
		}

		$query_args['meta_query'] = $meta_query;
	}
}

//Category seearch
if (is_tax('ad_category') && empty( $category )) {    
    $cat = $wp_query->get_queried_object();
    if (!empty($cat->slug)) {
        $category = $cat->slug;         
    }
} 

if( !empty( $category ) ){
    $tax_category_query_args[] = array(
        'taxonomy'  => 'ad_category',
        'field'     => 'slug',
        'terms'     => $category,
    );
}
 
//Amenity seearch
if (is_tax('ad_amenity') && empty( $s_amenities )) {    
    $amenity = $wp_query->get_queried_object();
    if (!empty($amenity->slug)) {
        $s_amenities = array($amenity->slug);          
    }
}

if( !empty( $s_amenities ) ){
    $tax_amenity_query_args[] = array(
        'taxonomy'  => 'ad_amenity',
        'field'     => 'slug',
        'terms'     => $s_amenities,
    );
}

//Tag search
if (is_tax('ad_tags') && empty( $s_tags )) {    
    $adtags = $wp_query->get_queried_object();
    if (!empty($adtags->slug)) {
        $s_tags = array($adtags->slug);                
    }
}

if( !empty( $s_tags ) ){
    $tax_tag_query_args[] = array(
        'taxonomy'  => 'ad_tags',
        'field'     => 'slug',
        'terms'     => $s_tags,
    );
}

$query_args = array(
    'posts_per_page'        => $showposts,
    'post_type'             => 'sp_deals',
    'paged'                 => $paged,
    'orderby'               => $sort_by,
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1
);

$query_args['meta_key'] = '_featured_timestamp';

$query_args['orderby']	 = array( 
	'meta_value' 	=> 'DESC', 
	$sort_by => $order,
);

 

//meta query
if (!empty($meta_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $meta_query_args = array_merge($query_relation, $meta_query_args);
    $query_args['meta_query'] = $meta_query_args;
}

//tax query
if (!empty($tax_amenity_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_amenity_query_args = array_merge($query_relation, $tax_amenity_query_args);
    $tax_query_args [] = $tax_amenity_query_args;
}

if (!empty($tax_tag_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_tag_query_args = array_merge($query_relation, $tax_tag_query_args);
    $tax_query_args[] = $tax_tag_query_args;
}

if (!empty($tax_category_query_args)) {
    $query_relation = array('relation' => 'OR',);
    $tax_category_query_args = array_merge($query_relation, $tax_category_query_args);
    $tax_query_args[] = $tax_category_query_args;
}

if (!empty($tax_query_args)) {
    $query_relation = array('relation' => 'AND',);
    $tax_query_args = array_merge($query_relation, $tax_query_args);
    $query_args['tax_query'] = $tax_query_args;
}

if (!empty($_GET['keyword'])) {
    $query_args['s'] = $s;
}

include plugin_dir_path( __FILE__ ) . '/search-deals-grid.php';

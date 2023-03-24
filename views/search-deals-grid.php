<?php
/**
 *
 * Search template for deals grid view
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      http://cannalisting-theme-author.com/
 * @since 1.0
 */
global $paged, $wp_query, $query_args, $showposts;
get_header(); ?>
<style>
@media only screen and (min-width: 767px) {
.tg-formsearchresult .tg-formsearchvtwo fieldset .form-group:first-child {
    width: 25% !important;
}
.tg-formsearchresult .tg-formsearchvtwo fieldset .form-group:nth-child(2) {
    width: 25%;
}
.tg-formsearchresult .tg-formsearchvtwo fieldset .form-group:nth-child(3) {
    width: 25%;
}
.tg-formsearchresult .tg-formsearchvtwo fieldset .form-group:nth-child(4) {
    width: 20%;
}
.tg-formsearchresult .tg-formsearchvtwo {
    width: 100% !important;
} .tg-select span {
    font-size: 12px !important;
}
.tg-formtheme fieldset {
    display: flex !important;
    gap: 6px !important;
}
.tg-btnsearchvtwo{
    position: relative;
    width: 44%;
    margin: 0;
}
/*.ad-search-result .tg-mapclustring {*/
/*    width: 100%;*/
/*}*/

}
.tg-btnsearchvtwo{
    position: relative;
    width: 100%;
}
.ad-media-wrap img {
    width: 100%;
}


@media (min-width: 1198px) {
.ad-search-result .tg-mapclustring {
    width: 33% ;
}
}
</style>


<?php 


if (function_exists('fw_get_db_settings_option')) {
    $dir_map_marker_default = fw_get_db_settings_option('dir_map_marker');
	$dir_radius = fw_get_db_settings_option('dir_radius');
	$dir_location = fw_get_db_settings_option('dir_location');
} else {
    $dir_map_marker_default = '';
	$dir_radius = '';
	$dir_location = '';
}

// print_r($query_args);

$deals_data = new WP_Query($query_args);
$total_posts	= $deals_data->found_posts;
$direction		= cannalisting_get_location_lat_long();
?>
<div class="ad-search-result tg-listingvtwo tg-haslayout">
	<div class="container-fluid spv-map">
	   <div class="row">
		  <?php do_action('cannalisting_get_search_map_right'); ?>
		  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
			 <div class="spv-formtheme tg-ad-search-form">
				<form class="sp-form-search" action="<?php echo cannalisting_get_deals_search_page_uri();?>" method="get">
					<div class="tg-searchtitle">
						<h3><?php esc_html_e('Search Result', 'cannalisting_core'); ?></h3>
						<span><?php esc_html_e('About', 'cannalisting_core'); ?> <?php echo intval( $total_posts );?> <?php esc_html_e('result(s)', 'cannalisting_core'); ?></span>
					</div>
					<div class="tg-sortfilters tg-searchheadform">
						<div class="tg-sortfilter tg-show">
							<?php do_action('cannalisting_get_deals_sortby'); ?>
						</div>
						<div class="tg-sortfilter tg-show">
							<?php do_action('cannalisting_get_orderby'); ?>
						</div>
						<div class="tg-sortfilter tg-show">
							<?php do_action('cannalisting_get_showposts'); ?>
						</div>
					</div>
					<div class="tg-formsearchresult">
				
					    <!-- tg-formsearchvtwo-->
						<div class="tg-formtheme ">
							<fieldset>
								<div class="form-group tg-inputwithicon">
									<?php do_action('cannalisting_get_search_keyword'); ?>
								</div>
								<div class="form-group tg-inputwithicon">
									<?php do_action('cannalisting_get_ad_category_filter');?>
								</div>
								<div class="form-group tg-inputwithicon">
									<?php do_action('cannalisting_get_price_type');?>
								</div>
								<div class="form-group tg-inputwithicon">
									<div class="tg-inputwithicon">
										<?php do_action('cannalisting_get_search_geolocation'); ?>
									</div>
								</div>
								<?php do_action('cannalisting_get_search_permalink_setting'); ?>
								<button class="tg-btnsearchvtwo" type="submit" ><i class="lnr lnr-magnifier"></i></button>
							</fieldset>
						</div>
						<?php do_action('cannalisting_get_deals_search_filtrs'); ?>
					</div>
				</form>
				<?php if (is_active_sidebar('ad-deals-filter-image')) {?>
    			<?php dynamic_sidebar('ad-deals-filter-image'); ?>
    			<?php }?>
			 </div>
			 <div class="tg-custom-search-grid">
				<div class="row">
				<?php
				$sp_addata	=  array();
				$sp_dealslist	=  array();
				$sp_dealslist['status'] = 'none';
				$sp_dealslist['lat']  = floatval ( $direction['lat'] );
				$sp_dealslist['long'] = floatval ( $direction['long'] );
				if ($deals_data->have_posts()) {
					$sp_dealslist['status'] = 'found';
					while ($deals_data->have_posts()) : $deals_data->the_post();
						global $post;						
						$width 	= intval(480);
						$height = intval(380);
						$thumbnail  = cannalisting_prepare_thumbnail($post->ID, $width, $height);
						if( empty( $thumbnail ) ) {
                        	$thumbnail = get_template_directory_uri().'/images/placeholder-360x240.jpg';
                    	} 
					
						$post_author_id	= $post->post_author;						
						$post_title	= get_the_title();
						$post_link	= get_the_permalink();
											
						$sp_addata['latitude']  = get_post_meta($post->ID,'latitude' ,true);
						$sp_addata['longitude'] = get_post_meta($post->ID,'longitude' ,true);
						$address = fw_get_db_post_option($post->ID, 'address', true);
						$sp_addata['title'] 	= $post_title;
					
						$featured_timestamp  = get_post_meta($post->ID,'_featured_timestamp' ,true);

						$infoBox = '';
						$infoBox .= '<div class="tg-infoBox svp-ad-infobox">';
						$infoBox .= '<div class="tg-serviceprovider">';
						$infoBox .= '<div class="tg-featuredimg"><img src="' . esc_url($thumbnail) . '" alt="' . $post_title . '"></div>';
						$infoBox .= '<div class="tg-companycontent">';
						$infoBox .= apply_filters('cannalisting_get_ad_category',$post->ID,'filter');
						$infoBox .= '<div class="tg-title">';
						$infoBox .= '<h3><a href="' . $post_link . '">' . $post_title . '</a></h3>';
						$infoBox .= '</div>';
						$infoBox .= '<p>'.$address.'</p>';
						$infoBox .= '</div>';
						$infoBox .= '</div>';
						$infoBox .= '</div>';

						if (isset($map_marker['url']) && !empty($map_marker['url'])) {
							$sp_addata['icon'] = $map_marker['url'];
						} else {
							if (!empty($dir_map_marker_default['url'])) {
								$sp_addata['icon'] = $dir_map_marker_default['url'];
							} else {
								$sp_addata['icon'] = get_template_directory_uri() . '/images/map-marker.png';
							}
						}

						$sp_addata['html']['content'] = $infoBox;
						$sp_dealslist['deals_list'][] = $sp_addata;
					?>
				   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 tg-verticaltop" data-date="<?php echo esc_attr($featured_timestamp);?>">
					   <div class="tg-oneslides  tg-automotivegrid" >
						  <div class="tg-automotive" style="cursor: pointer;">
								<figure class="tg-featuredimg tg-authorlink">				
									<?php do_action('cannalisting_get_ad_featured_tag', $post->ID ); ?>									
									<div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
									<?php do_action('cannalisting_get_ad_category',$post->ID);?>
									<?php do_action('cannalisting_print_favorite_deals',$post->ID,$post_author_id);?>
								</figure>
								<div class="tg-companycontent tg-authorfeature">
									<div class="tg-featuredetails">
										<div class="tg-title">
											<h2><?php do_action('cannalisting_get_ad_title',$post->ID,get_the_title());?></h2>		
										</div>									
										<?php do_action('cannalisting_get_ad_address',$post->ID);?>
									</div>
									<?php do_action('cannalisting_get_ad_provider_detail',$post->ID,$post_author_id);?>
									<?php do_action('cannalisting_get_ad_meta',$post->ID,$post_author_id);?>
								</div>
							</div>
						</div>
				   </div>
				   <?php
						endwhile;
						wp_reset_postdata();
					}else{
						cannalisting_Prepare_Notification::cannalisting_info('', esc_html__('No Deals found.', 'cannalisting_core'));
					}
				?>
				</div>
				<?php
				if (!empty($total_posts) && !empty($showposts) && $total_posts > $showposts) {?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php cannalisting_prepare_pagination($total_posts, $showposts); ?>
					</div>
				<?php } ?>
				 
				<?php
					$script	= "jQuery(document).ready(function ($) {cannalisting_init_map_script(".json_encode($sp_dealslist)."); });";
					wp_add_inline_script('cannalisting_ad_gmaps', $script,'after');
				// 	wp_add_inline_script('pogoslider', $script,'after');
				// 	wp_add_inline_script('cannalisting_maps', $script,'after');
				?> 
				 
			 </div>
		  </div>
	   </div>
	</div>
 </div>
<?php get_footer(); ?>
<script>
	$(document).ready(function() {
		$('.sp-sub-categories').on('change', function() {
			this.form.submit();
		});
		$('.sp-pricetype').on('change', function() {
			this.form.submit();
		});
		$("#location-latitude").on("input", function() {
           console.log("okay");
        });
	});
</script>

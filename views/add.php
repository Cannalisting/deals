<?php
/**
 *
 * The template part to add new ad.
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      http://cannalisting-theme-author.com/
 */
global $current_user;
$user_identity = $current_user->ID;
$content = esc_html__('Add your content here.', 'cannalisting_core');
$settings = array('media_buttons' => false,'quicktags' => true);

$ad_limit = 0;
if (function_exists('fw_get_db_settings_option')) {
	$ad_limit = fw_get_db_settings_option('ad_limit');
}

$ad_limit 			= !empty( $ad_limit ) ? $ad_limit  : 0;
$remaining_deals 		= cannalisting_get_subscription_meta('subscription_deals', $user_identity);

$remaining_deals 	= !empty( $remaining_deals ) ? $remaining_deals  : 0;
$remaining_deals 	= $remaining_deals + $ad_limit; //total in package and one free
$posted_deals		= cannalisting_get_total_posts_by_user($user_identity,'sp_deals');

$social_links 	= apply_filters('cannalisting_get_social_media_icons_list',array());
$price_types	= apply_filters('cannalisting_get_price_type_list',cannalisting_ad_price_type());

//location 
$profile_latitude  	= get_user_meta($user_identity, 'latitude', true);
$profile_longitude 	= get_user_meta($user_identity, 'longitude', true);

if (function_exists('fw_get_db_settings_option')) {
    $dir_longitude = fw_get_db_settings_option('dir_longitude');
    $dir_latitude = fw_get_db_settings_option('dir_latitude');
    $dir_longitude = !empty($dir_longitude) ? $dir_longitude : '-0.1262362';
    $dir_latitude = !empty($dir_latitude) ? $dir_latitude : '51.5001524';
} else {
    $dir_longitude = '-0.1262362';
    $dir_latitude = '51.5001524';
}

$profile_latitude 	= !empty($profile_latitude) ? $profile_latitude : $dir_longitude;
$profile_longitude 	= !empty($profile_longitude) ? $profile_longitude : $dir_latitude;
$business_days 		= cannalisting_prepare_business_hours_settings();
$timezones 			= apply_filters('cannalisting_time_zones', array()); 

$ad_videos = array(
        0 => ''
    );
?>
<div id="tg-content" class="tg-content spv-ad-modify">
    <div class="tg-dashboardbox tg-businesshours">
        <div class="tg-dashboardtitle">
            <h2><?php esc_html_e('Post New Deal', 'cannalisting_core'); ?></h2>
        </div>
        <?php if ( isset($remaining_deals) && $remaining_deals > $posted_deals ) { ?>
        <div class="tg-servicesmodal tg-categoryModal">
            <div class="tg-modalcontent">
                <form class="tg-themeform tg-formamanagejobs tg-manage-ad-form tg-addad sp-dashboard-profile-form">
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="form-group">
                                    <input type="text" name="ad[title]" class="form-control" placeholder="<?php esc_html_e('Deal Title', 'cannalisting_core'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="form-group">
                                    <?php wp_editor($content, 'ad_detail', $settings); ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<div class="tg-dashboardtitle"><h2><?php esc_html_e('Tagline', 'cannalisting_core'); ?></h2></div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
									<div class="form-group">
										<input type="text" name="ad[tagline]" class="form-control" placeholder="<?php esc_html_e('Deal tagline', 'cannalisting_core'); ?>">
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Categories', 'cannalisting_core'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[categories][]" data-placeholder="<?php esc_html_e('Select categories', 'cannalisting_core'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select categories', 'cannalisting_core'); ?></option>
													<?php cannalisting_get_term_options_with_key('', 'ad_category'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <?php do_action('cannalisting_featured_ad_selection', $user_identity, ''); ?>      
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Tags', 'cannalisting_core'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[tags][]" data-placeholder="<?php esc_html_e('Select tags', 'cannalisting_core'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select tags', 'cannalisting_core'); ?></option>
													<?php cannalisting_get_term_options_with_key('', 'ad_tags'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-dashboardbox tg-basicinformation">
							<div class="tg-amenitiesfeaturesbox">
								<h2><?php esc_html_e('Amenties/Features', 'cannalisting_core'); ?></h2>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[amenities][]"  data-placeholder="<?php esc_html_e('Select amenities', 'cannalisting_core'); ?>" multiple class="sp-sub-categories">
													<option value=""><?php esc_html_e('Select amenities', 'cannalisting_core'); ?></option>
													<?php cannalisting_get_term_options_with_key('', 'ad_amenity'); ?>
												</select>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<h2><?php esc_html_e('Contact informations', 'cannalisting_core'); ?></h2>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[website]" class="form-control" placeholder="<?php esc_html_e('Deal website', 'cannalisting_core'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[email]" class="form-control" placeholder="<?php esc_html_e('Deal email address', 'cannalisting_core'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[phone]" class="form-control" placeholder="<?php esc_html_e('Deal phone number', 'cannalisting_core'); ?>">
									</div>
								</div>
							</div>
                   		</div>
                    </fieldset>
                    <fieldset>
                        <div class="tg-socialinformation tg-amenitiesfeaturesbox spv-ad-hours">
                        	<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Social Links', 'cannalisting_core'); ?></h2>
								<span class="spv-collap-config"><i class="lnr lnr-pencil"></i></span>
							</div>
							<div class="spv-deals-config tg-haslayout elm-none">
								<div class="row tg-socialinformationbox">
									<?php 
									if( !empty( $social_links ) ){
										foreach( $social_links as $key => $social ){
											$icon		= !empty( $social['icon'] ) ? $social['icon'] : '';
											$classes	= !empty( $social['classses'] ) ? $social['classses'] : '';
											$placeholder		= !empty( $social['placeholder'] ) ? $social['placeholder'] : '';
											$color		= !empty( $social['color'] ) ? $social['color'] : '#484848';
										?>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-left">
											<div class="form-group tg-inputwithicon <?php echo esc_attr( $classes );?>">
												<i class="tg-icon <?php echo esc_attr( $icon );?>" style="background:<?php echo esc_attr( $color );?>"></i>
												<input type="text" class="form-control" name="ad[social][<?php echo esc_attr( $key );?>]" value="" placeholder="<?php echo esc_attr( $placeholder );?>">
											</div>
										</div>
									<?php }}?>
								</div>
                 			</div>
                  		</div>
                    </fieldset>                
                 	<fieldset>
						<div class="tg-amenitiesfeaturesbox spv-ad-hours">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Business Hours', 'cannalisting_core'); ?></h2>
								<span class="spv-collap-config"><i class="lnr lnr-pencil"></i></span>
							</div>
							<div class="spv-deals-config tg-haslayout elm-none">
								<div class="tg-haslayout spv-timezone">
									<div class="tg-dashboardtitle">
										<h2><?php esc_html_e('Timezone', 'cannalisting_core'); ?></h2>
										<p><?php esc_html_e('You can set timezone for this add. Leave it empty to use default timezone from Profile Settings.', 'cannalisting_core'); ?></p>
									</div>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
											<div class="form-group">
												<?php if( !empty( $timezones ) ) {?>
												<span class="tg-select">
													<select name="_timezone" class="_timezone">
														<?php								
														foreach ($timezones as $key => $value) { 
															if( !empty($time_zone) && $time_zone == $key ){
																$selected = 'selected';
															} else {
																$selected = '';
															}	
														?>
														<option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_attr( $value ); ?></option>
														<?php } ?>
													</select>									
												</span>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<?php
								if (!empty($business_days) && is_array($business_days)) {
									foreach ($business_days as $key => $days) {?>
										<div class="tg-businesshourssbox">
											<div class="form-group">
												<div class="tg-daychckebox">
													<h3><?php echo esc_attr($days); ?></h3>
													<div class="tg-checkbox">
														<input type="checkbox" value="true" name="schedules[<?php echo esc_attr($key); ?>][off_day]" id="<?php echo esc_attr($key); ?>">
														<label for="<?php echo esc_attr($key); ?>"><?php esc_html_e('Mark As Day Off', 'cannalisting_core'); ?></label>
													</div>
												</div>
											</div>
											<div class="time-slot-wrap"> 
												<div class="tg-startendtime">
													<div class="form-group">
														<div class="tg-inpuicon">
															<i class="lnr lnr-clock"></i>
															<input type="text" value="" name="schedules[<?php echo esc_attr($key); ?>][starttime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Open Time', 'cannalisting_core'); ?>">
														</div>
													</div>
													<div class="form-group">
														<div class="tg-inpuicon">
															<i class="lnr lnr-clock"></i>
															<input type="text" value="" name="schedules[<?php echo esc_attr($key); ?>][endtime]" class="form-control business-hours-time" placeholder="<?php esc_html_e('Close Time', 'cannalisting_core'); ?>">
														</div>
													</div>	
												</div>	
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</fieldset>                     
                    <fieldset>
                      	<div class="tg-amenitiesfeaturesbox">
							<h2><?php esc_html_e('Deal Pricings', 'cannalisting_core'); ?></h2>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<span class="tg-select">
											<select name="ad[pricing_type]">
												<option value=""><?php esc_html_e('Select pricing options', 'cannalisting_core'); ?></option>
												<?php if( !empty( $price_types ) ) {
														foreach( $price_types as $key => $value ){?>
													<option value="<?php echo esc_attr( $key );?>"><?php echo esc_attr($value['desc']); ?></option>
												<?php }}?>
											</select>
										</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[price]" class="form-control" placeholder="<?php esc_html_e('Deal Price', 'cannalisting_core'); ?>">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
									<div class="form-group">
										<input type="text" name="ad[currency]" class="form-control" placeholder="<?php esc_html_e('Currency Symbol', 'cannalisting_core'); ?>">
									</div>
								</div>
							</div>
                   		</div>
                    </fieldset>
                    <fieldset>
                    	<div class="tg-dashboardbox tg-videogallery">
							<div class="tg-videogallerybox">
								<div class="tg-dashboardtitle">
									<h2><?php esc_html_e('Audio/Video', 'cannalisting_core'); ?></h2>
								</div>
								<div class="video-slot-wrap">
									<?php
									if (!empty($ad_videos)) {
										$video_count = 0;
										foreach ($ad_videos as $key => $media) {
											$video_count++;
											?>
											<div class="tg-startendtime">
												<div class="form-group">
													<div class="tg-inpuicon">
														<i class="lnr lnr-film-play"></i>
														<input type="text" value="<?php echo esc_url($media); ?>" name="ad[videos][]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'cannalisting_core'); ?>">
													</div>
												</div>
												<?php if ($video_count === 1) { ?>
													<button type="button" class="tg-addtimeslot add-new-videoslot">+</button>
												<?php } else { ?>
													<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
												<?php } ?>
											</div>
											<?php
										}
									}
									?>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                    	<div class="tg-dashboardbox tg-location">
							<div class="tg-dashboardtitle">
								<h2><?php esc_html_e('Location', 'cannalisting_core'); ?><?php do_action('cannalisting_get_tooltip','section','location');?></h2>
							</div>
							<div class="tg-locationbox">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<div class="form-group locate-me-wrap">
											<input type="text" value="" name="ad[address]" class="form-control" id="location-address-0" />
											<a href="javascript:;" data-key="fetch" class="geolocate"><img src="<?php echo get_template_directory_uri(); ?>/images/geoicon.svg" width="16" height="16" class="geo-locate-me" alt="<?php esc_html_e('Locate me!', 'cannalisting_core'); ?>"></a>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
										<p><strong><?php esc_html_e('Important Instructions: The given below latitude and longitude fields are required to show your deal on map. You can simply search location in the above location field and the system will auto detect the latitude, longitude, country and city. If for some reason this does not return the required result, you can manually type in the information.', 'cannalisting_core'); ?></strong></p>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
										<div class="form-group">
											<input type="text" placeholder="<?php esc_html_e('Longitude', 'cannalisting_core'); ?>" value="" name="ad[longitude]" class="form-control" id="location-longitude-0" />
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 pull-left">
										<div class="form-group">
											<input type="text" placeholder="<?php esc_html_e('Latitude', 'cannalisting_core'); ?>" value="" name="ad[latitude]" class="form-control" id="location-latitude-0" />
										</div>
									</div>

									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[country]" class="sp-country-select">
													<option value=""><?php esc_html_e('Choose Country', 'cannalisting_core'); ?></option>
													<?php cannalisting_get_term_options('', 'countries'); ?>
												</select>
											</span>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 pull-left">
										<div class="form-group">
											<span class="tg-select">
												<select name="ad[city]" class="sp-city-select">
													<option value=""><?php esc_html_e('Choose City', 'cannalisting_core'); ?></option>
												</select>
											</span>
										</div>
									</div>
									<div class="sp-data-location">
										<input class="locations-data" data-key="city" type="hidden" value="" placeholder="<?php esc_html_e('City', 'cannalisting_core'); ?>" id="locality" disabled="true" />
										<input class="locations-data" data-key="state" type="hidden" value="" placeholder="<?php esc_html_e('State', 'cannalisting_core'); ?>" id="administrative_area_level_1" disabled="true" />
										<input class="locations-data" data-key="country" type="hidden" value="" placeholder="<?php esc_html_e('Country', 'cannalisting_core'); ?>" id="country" disabled="true" />
										<input class="locations-data" data-key="code" type="hidden" value="" placeholder="<?php esc_html_e('Country Code', 'cannalisting_core'); ?>" id="country_code" disabled="true" />
										<input class="locations-data" data-key="postal_town" type="hidden" value="" placeholder="<?php esc_html_e('Postal Town', 'cannalisting_core'); ?>" id="postal_town" disabled="true" />
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 pull-left">
										<div class="form-group">
											<div id="location-pickr-map" class="location-pickr-map"></div>
										</div>
									</div>

									<?php
										$script = "jQuery(document).ready(function (e) {
													jQuery.cannalisting_init_profile_map(0,'location-pickr-map', ". esc_js($profile_latitude) . "," . esc_js($profile_longitude) . ");
												});";
										wp_add_inline_script('cannalisting_maps', $script, 'after');
									?>
								</div>
							</div>
						</div>
                    </fieldset>
                    <fieldset>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                                <div class="tg-dashboardbox tg-imggallery">
									<div class="tg-dashboardtitle">
										<h2><?php esc_html_e('Gallery', 'cannalisting_core'); ?></h2>
									</div>
									<div class="tg-imggallerybox">
										<div class="tg-upload">
											<div class="tg-uploadhead">
												<span>
													<h3><?php esc_html_e('Upload Photo Gallery', 'cannalisting_core'); ?></h3>
													<i class="fa fa-exclamation-circle"></i>
												</span>
												<i class="lnr lnr-upload"></i>
											</div>
											<div class="tg-box">
												<label class="tg-fileuploadlabel" for="tg-photogallery">
													<div id="plupload-ad-container">
														<a href="javascript:;" id="upload-ad-photos" class="tg-fileinput sp-upload-container">
															<i class="lnr lnr-cloud-upload"></i>
															<span><?php esc_html_e('Or Drag Your Files Here To Upload', 'cannalisting_core'); ?></span>
														</a>
													</div> 
												</label>
												<div class="tg-ad sp-profile-ad-photos">
													<div class="tg-galleryimages">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div id="tg-updateall" class="tg-updateall">
                            <div class="tg-holder">
                                <span class="tg-note"><?php esc_html_e('Click to', 'cannalisting_core'); ?> <strong> <?php esc_html_e('Submit Deal Button', 'cannalisting_core'); ?> </strong> <?php esc_html_e('to add the deal.', 'cannalisting_core'); ?></span>
                                <?php wp_nonce_field('cannalisting_ad_nounce', 'cannalisting_ad_nounce'); ?>
                                <a class="tg-btn process-ad" data-type="add" href="javascript:;"><?php esc_html_e('Submit Deal', 'cannalisting_core'); ?></a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <?php } else { ?>
            <div class="tg-dashboardappointmentbox">
                <?php cannalisting_Prepare_Notification::cannalisting_info(esc_html__('Oops', 'cannalisting_core'), esc_html__('You reached to maximum limit of deals post. Please upgrade your package to add more deals.', 'cannalisting_core')); ?>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/template" id="tmpl-load-media-links">
	<div class="tg-startendtime">
	<div class="form-group">
	<div class="tg-inpuicon">
	<i class="lnr lnr-film-play"></i>
	<input type="text" name="ad[videos][]" class="form-control" placeholder="<?php esc_html_e('Audio/Video Link', 'cannalisting_core'); ?>">
	</div>
	</div>
	<button type="button" class="tg-addtimeslot tg-deleteslot delete-video-slot"><i class="lnr lnr-trash"></i></button>
	</div>
</script>
<script type="text/template" id="tmpl-load-profile-ad-thumb">
	<div class="tg-galleryimg">
		<figure>
			<img src="{{data.thumbnail}}">
			<figcaption>
				<i class="fa fa-close del-profile-ad-photo"></i>
			</figcaption>
			<input type="hidden" name="temp_items[]" value="{{data.name}}">
		</figure>
	</div>
</script>
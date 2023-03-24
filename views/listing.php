<?php
/**
 *
 * The template part for displaying the dashboard deals.
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      http://cannalisting-theme-author.com/
 * @since 1.0
 */
global $current_user,
 $wp_roles,
 $userdata,
 $paged;

$user_identity = $current_user->ID;
$url_identity = $user_identity;
if (!empty($_GET['identity'])) {
    $url_identity = $_GET['identity'];
}

$dir_profile_page = '';
if (function_exists('fw_get_db_settings_option')) {
    $dir_profile_page = fw_get_db_settings_option('dir_profile_page', $default_value = null);
}

$get_username = cannalisting_get_username($url_identity);
$profile_page = isset($dir_profile_page[0]) ? $dir_profile_page[0] : '';
$show_posts = get_option('posts_per_page') ? get_option('posts_per_page') : 10;

$pg_page = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var

//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);

$order = 'DESC';
if (!empty($_GET['order'])) {
    $order = esc_attr($_GET['order']);
}

$sorting = 'ID';
if (!empty($_GET['sort'])) {
    $sorting = esc_attr($_GET['sort']);
}

$args = array('posts_per_page' => $show_posts,
    'post_type' => 'sp_deals',
    'orderby' => $sorting,
    'order' => $order,
    'post_status' => array('publish', 'pending'),
    'author' => $url_identity,
    'paged' => $paged,
    'suppress_filters' => false
);

$query = new WP_Query($args);
$count_post = $query->found_posts;
?>
<div id="tg-content" class="tg-content">
    <div class="tg-joblisting tg-dashboardmanagejobs">
        <div class="tg-dashboardhead">
            <div class="tg-dashboardtitle">
                <h2><?php esc_html_e('Manage Deals', 'cannalisting_core'); ?><?php do_action('cannalisting_get_tooltip','section','deals');?></h2>
            </div>
            <div class="tg-btnaddservices">
                <a href="<?php cannalisting_Profile_Menu::cannalisting_profile_menu_link($profile_page, 'deals', $url_identity, '', 'add'); ?>"><?php esc_html_e('Create New Deal', 'cannalisting_core'); ?></a>
            </div>
        </div>
        <?php if ($query->have_posts()) { ?>
            <div class="tg-sortfilters">
                <form class="form-sort-deals" method="get" action="<?php cannalisting_Profile_Menu::cannalisting_profile_menu_link($profile_page, 'deals', $url_identity, '', 'listing'); ?>">
                    <div class="tg-sortfilter tg-sortby">
                        <div class="tg-select">
                            <select name="sort" class="sort_by">
                                <option value="ID" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'ID' ? 'selected' : ''; ?>><?php esc_html_e('Latest deals at top', 'cannalisting_core'); ?></option>
                                <option value="title" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'title' ? 'selected' : ''; ?>><?php esc_html_e('Order by title', 'cannalisting_core'); ?></option>
                                <option value="name" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'name' ? 'selected' : ''; ?>><?php esc_html_e('Order by ad name', 'cannalisting_core'); ?></option>
                                <option value="date" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'date' ? 'selected' : ''; ?>><?php esc_html_e('Order by date', 'cannalisting_core'); ?></option>
                                <option value="rand" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'rand' ? 'selected' : ''; ?>><?php esc_html_e('Random order', 'cannalisting_core'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="tg-sortfilter tg-arrange">
                        <div class="tg-select">
                            <select name="order" class="order_by">
                                <option value="DESC" <?php echo isset($_GET['order']) && $_GET['order'] == 'DESC' ? 'selected' : ''; ?>><?php esc_html_e('DESC', 'cannalisting_core'); ?></option>
                                <option value="ASC" <?php echo isset($_GET['order']) && $_GET['order'] == 'ASC' ? 'selected' : ''; ?>><?php esc_html_e('ASC', 'cannalisting_core'); ?></option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" class="" value="deals" name="ref">
                    <input type="hidden" class="" value="listing" name="mode">
                    <input type="hidden" class="" value="<?php echo intval($url_identity); ?>" name="identity">
                </form>
            </div>
            <table class="tg-tablejoblidting job-listing-wrap fw-ext-ad-listing">
                    <thead>    
                        <tr>                
                            <th><?php esc_html_e('Photo', 'cannalisting_core'); ?></th>
                            <th><?php esc_html_e('Title', 'cannalisting_core'); ?></th>
                            <th><?php esc_html_e('Category', 'cannalisting_core'); ?></th>
                            <th><?php esc_html_e('Action', 'cannalisting_core'); ?></th>
                        </tr>
                    </thead> 
                    <tbody>               
                    <?php
                    $today = time();
                    while ($query->have_posts()) : $query->the_post();
                        global $post;                        
                        $height = 92;
                        $width = 92;
                        $address = '';
                        $thumbnail = cannalisting_prepare_thumbnail($post->ID, $width, $height);
                        if( empty( $thumbnail ) ) {
                            $thumbnail = get_template_directory_uri().'/images/img-92x92.jpg';
                        }
                        if (function_exists('fw_get_db_post_option')) {
                            $address = fw_get_db_post_option($post->ID, 'address', true);
                        }
                        $args = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
                        $categories = wp_get_post_terms( $post->ID, 'ad_category', $args );
                        ?>
                        <tr>
                            <td>
                                <figure>
                                    <img src="<?php echo esc_url( $thumbnail ); ?>" alt="<?php the_title(); ?>">
                                </figure>
                            </td>
                            <td>                                
                                <div class="tg-contentbox"> 
                                    <div class="tg-title">
                                        <h3><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></h3>
                                    </div>
                                    <?php if( !empty( $address ) ) { ?>
                                    	<span><i class="lnr lnr-location"></i>&nbsp;<?php echo esc_attr($address); ?></span> 
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
							<?php 
								if( !empty( $categories ) ) {
									$total = count($categories); 
									$show_total = '';
									if( $total > 1 ){
										$show_total = $total - 1;
									}
									
									$counter = 0; 
									
									foreach ($categories as $key => $value) { 
										$counter++;
										if( $counter == 1 ){?>
										<a class="tg-addcategorylink" href="<?php echo esc_url( get_term_link( $value->term_id ) ); ?>"><?php echo esc_attr( $value->name ); ?></a>
										<?php if( !empty( $show_total ) ) { ?>
											<em>+<?php echo esc_attr( $show_total ); ?></em>
										<?php } 
										} 
									}
								}
							?>
                            </td>                            
                            <td>
                                <div class="tg-actionbtns">
                                <a class="tg-btnview" href="<?php the_permalink(); ?>"><i class="lnr lnr-eye"></i></a>                                   
                                <a class="tg-btnedite" href="<?php cannalisting_Profile_Menu::cannalisting_profile_menu_link($profile_page, 'deals', $url_identity, '', 'edit', $post->ID); ?>"><i class="lnr lnr-pencil"></i></a>
                                    <a class="tg-btnedite btn-ad-del" data-key="<?php echo intval($post->ID); ?>"><i class="lnr lnr-trash"></i></a>
                                </div>                                
                            </td>
                        </tr>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </tbody>
            </table>
            <?php
            if (!empty($count_post) && $count_post > $show_posts) {
                cannalisting_prepare_pagination($count_post, $show_posts);
            }
            ?>
        <?php } else { ?>
            <div class="tg-dashboardappointmentbox">
                <?php cannalisting_Prepare_Notification::cannalisting_info(esc_html__('Information', 'cannalisting_core'), esc_html__('No deal found.', 'cannalisting_core')); ?>
            </div>
        <?php } ?>
    </div>
</div>
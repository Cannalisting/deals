<?php
/**
 *
 * cannalisting display author deals..
 *
 * @package   cannalisting
 * @author    cannalisting-theme-author
 * @link      cannalisting-theme-uri
 * @since 1.0
 */
global $wp_query;
//Get User Queried Object Data
$queried_object = $wp_query->get_queried_object();
$post_author_id = $queried_object->ID;

$per_page = 2;
$limit = (int) $per_page;

$pg_page 		= get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
$pg_paged 		= get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
$dir_deals_uri 	= cannalisting_get_deals_page_uri('dir_deals_uri');

//paged works on single pages, page - works on homepage
$paged = max($pg_page, $pg_paged);
$offset = ($paged - 1) * $limit;

$json = array();
$meta_query_args = array();

$query_args = array(
	'post_type' 	=> 'sp_deals',
	'post_status' 	=> 'publish',
	'posts_per_page'=> $limit,
	'author'	 	=> $post_author_id,
	'order' 		=> 'DESC',
	'orderby' 		=> 'ID',
);

$query_args	= apply_filters('cannalisting_apply_provider_detail_ad_filters',$query_args);

//Get User Queried Object Data
$provider_name = cannalisting_get_username($post_author_id);
$query = new WP_Query($query_args);
$count_post = $query->found_posts;
if ( $query->have_posts() ){?>
<div class="sp-provider-detaildeals">
	<div class="tg-companyfeaturebox">
		<div class="tg-companyfeaturetitle">
            <h3><?php esc_html_e('Deals By','cannalisting_core');?>&nbsp;“<?php echo esc_attr( $provider_name );?>”</h3>
        </div>
		<div class="addfeatures">
			<?php 
				while ( $query->have_posts() ) : $query->the_post();
					global $post;
					$height 	= intval(255);
					$width 		= intval(200);
					$user_ID 	= get_the_author_meta('ID');
					$user_url 	= get_author_posts_url($user_ID);
					$thumbnail  = cannalisting_prepare_thumbnail($post->ID, $width, $height);
					if( empty( $thumbnail ) ) {
						$thumbnail = get_template_directory_uri().'/images/placeholder-200x255.jpg';
					}					
				?>
				<div class="tg-automotive">
					<figure class="tg-featuredimg tg-authorlink">
						<?php do_action('cannalisting_get_ad_featured_tag',$post->ID);?>
						<div class="ad-media-wrap"><img src="<?php echo esc_url( $thumbnail );?>" alt="<?php the_title();?>"></div>
						<?php do_action('cannalisting_get_ad_category',$post->ID);?>
					</figure>
					<div class="tg-companycontent tg-authorfeature">
						<div class="tg-featuredetails">
							<div class="tg-title">
								<h2><?php do_action('cannalisting_get_ad_title',$post->ID,get_the_title());?></h2>
							</div>
							<?php do_action('cannalisting_print_favorite_deals',$post->ID,$post_author_id);?>
							<?php do_action('cannalisting_get_ad_address',$post->ID);?>
						</div>
						<?php do_action('cannalisting_get_ad_provider_detail',$post->ID,$post_author_id);?>
						<?php do_action('cannalisting_get_ad_meta',$post->ID,$post_author_id);?>
					</div>
				</div>    
			<?php
				endwhile;
				wp_reset_postdata();
			?>
			<?php if( $count_post > $limit ){?>
				<div class="loadmore-deals"><a target="_self" href="<?php echo esc_url( $dir_deals_uri );?>?pid=<?php echo intval( $post_author_id );?>"><?php esc_html_e('View All','cannalisting_core');?></a></div>
			<?php }?>
		</div>
	</div>			
</div>
<?php }?>
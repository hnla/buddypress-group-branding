<?php
/**
* Provide BP group functions for group branding
* @package BuddyPress-Group-Branding
* 
*/

/*
* This file sets the content to display from the CPT 'Sponsors' via a do_action 
* in a custom front page for groups.
*
* It sets up a basic check when entering a single group page  to see if it's a 
* sponsor enabled one and gets the post_id for the CPT to let us set our constant.
*
* If we check and return a sponsor ID that matches to a post_meta key with value the same
* we loop the CPT post and feed through to the do_action.
*
*/
	
	/*
	* here be our scripts & styles - if any
	*/
if( !is_admin()  ) {
	/**
	* @ToDo: add checks for various theme dir locations for stylesheets
	*/
	function bgb_styles() {
		if( bp_is_group() ) {
			$file_exists = file_exists( get_stylesheet_directory() . 'css/bgb-styles.css');
			//var_dump($file_exists);
			if( $file_exists ) :
				wp_enqueue_style( 'bgb-styles',  get_stylesheet_directory_uri() . '/bgb-styles.css', array() );
			else:
				wp_enqueue_style( 'bgb-styles',  plugins_url('/css/bgb-styles.css')  , array() );
			endif;
		}
	}
add_action( 'wp_enqueue_scripts', 'bgb_styles' );
}

$bp = buddypress();

/*
* Set up and check some details prior to single group page load.
* We check BP current_group to get it's ID to pass to the group meta to retrieve the sponsor post_id
* & confirm that this group does have a sponsor
*/
class bgb_setup {
/*
* In other words this ought to be re-built using classes! Looking forward to a rainy day.
*/
}
function setup_group_sponsor_home() {
$bp = buddypress();
global $bgb_group_data;
	
	if( bp_is_group() ) {
	$group_current_group_id = $bp->groups->current_group->id ;
	$group_has_sponsor_post_id = groups_get_groupmeta( $group_current_group_id, $meta_key = 'bgb_has_sponsor_post_id');
	
	$bgb_group_data = (object) array(
				'current_group_id' =>  $group_current_group_id ,
				'group_sponsor_post_id' => $group_has_sponsor_post_id,
				'group_has_sponsor' => ($group_has_sponsor_post_id)? true : false 
				);
	
	if( $bgb_group_data->group_has_sponsor ) 
		// todo: need to find a better way of doing this and of template file ?.
		// We set this constant if group has sponsor we check for this define in home.php
		// where BP runs it's checks to see which template to load/locate - this is not great approach
		// as it means we must edit & provide a new home.php for this constant check/template selection.
		define('BGB_CUSTOM_FRONT', 'bgb-group-front.php' ); 
		
	//var_dump( $bgb_group_data );
	}
}
add_action( 'bp_actions', 'setup_group_sponsor_home' );

// Add a body class if group has a sponsor/brand
function bgb_set_body_token($classes) {
global $bgb_group_data;
if ( $bgb_group_data->group_has_sponsor ) {
	$classes[] .= 'bgb-group-has-sponsor';
}
return $classes;
}
add_filter('body_class', 'bgb_set_body_token');
/*
* Set custom image sizes for sponsor banner.
* If theme not support 'post-thumbs' then set support
* Set series of banner sizes for selection by admins
*
* @ToDo: This needs a settings screen to allow user to set sizes & hard or soft crop args
*/
function add_custom_thumb_size() {

	if( function_exists('add_theme_support') && !current_theme_supports('post_thumbnails') ) {
		add_theme_support( 'post-thumbnails' );
		}
	//if( $some_option_says_yes ) {
	// hard crop, keep dimensions crop picture to fit
	add_image_size('sponsor_banner_wide', 800, 400, true);
	//}
	
}
add_action('after_setup_theme', 'add_custom_thumb_size');
/*
* if using front.php or our custom version of front as defined by our constant 
* earlier we need to move the default tab behaviour. 'home' tab usually
* shows 'activty' - move activity to it's own tab so we still have access to group activity.
*/
// Group custom front page  -  create new 'Activity' tab.
function add_activity_tab() {
	$bp = buddypress();
	global $bgb_group_data;

	// only run if on single group else trying to get property of non object
	if( bp_is_group() ) {
	$group_current_group_id = $bp->groups->current_group->id ;
	$group_has_sponsor_post_id = groups_get_groupmeta( $group_current_group_id, $meta_key = 'bgb_has_sponsor_post_id'); 
	}
	if(bp_is_group() && $group_has_sponsor_post_id ) {
		bp_core_new_subnav_item( 
			array( 
				'name' => 'Activity', 
				'slug' => 'activity', 
				'parent_slug' => $bp->groups->current_group->slug, 
				'parent_url' => bp_get_group_permalink( $bp->groups->current_group ), 
				'position' => 11, 
				'item_css_id' => 'nav-activity',
				'screen_function' => create_function('',"bp_core_load_template( apply_filters( 'groups_template_group_home', 'groups/single/home' ) );"),
				'user_has_access' => 1
			) 
		);
 
		if ( bp_is_current_action( 'activity' ) ) {
			add_action( 'bp_template_content_header', create_function( '', 'echo "' . esc_attr( 'Activity' ) . '";' ) );
			add_action( 'bp_template_title', create_function( '', 'echo "' . esc_attr( 'Activity' ) . '";' ) );
		}
	
	}
//var_dump($bp->groups->current_group);

}// close function
 
add_action( 'bp_actions', 'add_activity_tab', 8 );

/*
* Manipulate & filter the BP group header data
* 
* We need to pass the post 'featured post thumb' as the avatar to use
* and replace the group description with the CPT metadata 'sponsor summary'
*/
function bgb_group_header() {
	$bp = buddypress();
	global $bgb_group_data;
	
	if( ! bp_is_group() )
		return;
	// we need to run some checks on whether user has set 'use featured thumb as avatar' 
	// here and set new metadata in CPT 
	// In the actual function we run a check on whether we do  manage to get a fetured thumb returned
	// by wp_get_attachment  and bail  out if not, so perhaps sufficient?
	

	$bgb_enable_elements = get_post_meta( $bgb_group_data->group_sponsor_post_id, 'bgb_header_elements', true);
	
	if( $bgb_enable_elements['bgb_enable_header'] ) {
		if( $bgb_enable_elements['bgb_header_image'] )
			add_filter('bp_get_group_avatar', 'bgb_group_header_avatar');
		if( $bgb_enable_elements['bgb_header_description'] )
			add_filter('bp_get_group_description', 'bgb_group_header_description');
	}	
}
add_action('bp_actions', 'bgb_group_header');

/** 
* Replace group $avatar with featured image
* We only filter our header featured image if option allows it in bgb_group_header()
*/
function bgb_group_header_avatar($avatar) {
global $wp, $groups_template, $bgb_group_data; 
$bp = buddypress();
	
	$featured_url = wp_get_attachment_image_src(  get_post_thumbnail_id( $bgb_group_data->group_sponsor_post_id ),  'sponsor_banner_wide'  );
	//var_dump($featured_url );	
	
	if( ! bp_is_group() || ! $featured_url ) 
	return $avatar;
	
	$avatar  = '<img src="' . $featured_url['0'] . '" alt="' . esc_attr( $groups_template->group->name ) . '" title="this avatar is a filtered one for bgb plugin" />'; 
	return $avatar;
}
/** 
* Manage group header description
* We only filter our header description if option allows it in bgb_group_header()
*/
function bgb_group_header_description( ) {
	$bp = buddypress();
	global $bgb_group_data;
	//global $group, $groups_template;

		
	$group_current_group_id = $bp->groups->current_group->id ;
	$group_has_sponsor_post_id = groups_get_groupmeta( $group_current_group_id, $meta_key = 'bgb_has_sponsor_post_id');	
	
	$sponsor_description = stripslashes( wpautop( get_post_meta( $group_has_sponsor_post_id, 'bgb_sponsor_summary', true) ) );
		
	return $sponsor_description;

}

/*
* This is the main content from the CPT for the new group front page
* ToDo: Although the two WP_Query approach was necessary initially, it needs checking again
* now we have group meta set with a post ID to use.
*/
function bgb_group_content() {
global $bgb_group_data;
		
		if( bp_is_group_single() ) {
	// Need some means of checking that there is actually a group sponsor, or or do we?
	// If no post meta for the ID we pass then sponsor_id is empty & we can return false.
	
	// Obvious: the bp group id
	$group_id = bp_get_group_id();
	
	// fucking nightmare trying to tie together post_id unkown Vs group_meta hard to set
	// to test whether this single group should be a sponsors group
	$sponsor_group_id = get_post_meta( $group_id, 'bgb_sponsor_group_id', true);
	$group_has_sponsor = groups_get_groupmeta($group_id, $meta_key = 'bgb_has_sponsor_post_id');
	
	//var_dump( $group_id );
	//var_dump( $group_has_sponsor );

	$sponsor_post_id = '';
			
			$sponsor_list_id = new WP_Query( 
				array( 
					'post_type' => 'bgb_sponsors', 
					'post_status' => 'publish',
					//'meta_key' => 'bgb_sponsor_group_id',
					'meta_query' => array(
						array(
							'key' => 'bgb_sponsor_group_id',
							// We know the group ID must be set when creating the sponsor post
							// and that the BP group_id must match to that piece of metadata
							// so we use $group_id to find correct post and later from this the postID
							'value' => $group_id
						)
					) 
				) 
			);
			while( $sponsor_list_id->have_posts() ) : $sponsor_list_id->the_post();			
			
			// get the true post id for this sponsors CPT
			$sponsor_post_id = ( ! empty($sponsor_list_id->post->ID ) )? $sponsor_list_id->post->ID : ''  ;
			
			endwhile;
			wp_reset_postdata();
			
			/*
			* Now we have the post id from the meta value group id we run a second loop 
			* to get the CPT data based on the proper post ID.
			* N.B this still feels  awkward and missing a far better way of doing this.
			*/
			$sponsors_post_meta = new WP_Query (
				array(
					'post_type' => 'bgb_sponsors',
					'p' => $sponsor_post_id
				)
			);
		
		// BuddyPress strips the filter in theme compat mode as it 
		// grabs the _content() in the page loop to push it's own content through	
		// We'll re-instate the filter then remove it again after we have finished the loop
		// this attempt is fine for 'p' tags, but still strips do_shortcode(s)
		/**
		* @ToDo: check if need both wpautop and BP filter - think not also check if can allow shortcodes
		*/
		add_filter( 'the_content', 'wpautop' ); 
		bp_restore_all_filters('the_content');
		// Get the sponsor ID based on the post ID we now have
		$sponsor_id = get_post_meta( $sponsor_post_id, 'bgb_sponsor_group_id', true);
		// check if we should show branding for this group
		$is_sponsor_enabled = get_post_meta( $sponsor_post_id, 'bgb_enable_sponsor', true);
		
		if( $sponsor_id == $group_id && $is_sponsor_enabled ) :		
		
		if( $sponsors_post_meta->have_posts() ) : while( $sponsors_post_meta->have_posts() ) : $sponsors_post_meta->the_post(); ?>
		
		<?php ######### dumping out general 'stuff' for visual que ############# ?>
		<?php $show_dump = false; if( $show_dump ) { ?>
		<p><?php var_dump($bgb_group_data); ?></p>
		<p>this is group id: <?php var_dump($group_id); ?></p>
		<p>this is sponsor id: <?php var_dump($sponsor_id); ?></p>
		<p>Sponsor is enable for group: <?php var_dump( $is_sponsor_enabled ); ?></p>
		<?php } ?>
		<?php ########## remove the block above  for testing only ############## ?>
		
		<article id="group-sponsor-front">
			
			<header>
				<h2><?php the_title() ?></h2>
			</header>
		
			<div class="sponsor-content">
			<?php the_content(); ?>
			</div>
		
		</article>
		<?php
		endwhile; endif;
		//remove_filter( 'the_content', 'wpautop' );
		bp_remove_all_filters('the_content');
		wp_reset_postdata();	
		
		endif;// if sponsor_id == group_id
		
		} // endif group single	
	}
	// pass our CPT post data to our custom do_action in bgb-group-front.php
	add_action( 'bgb_content', 'bgb_group_content'  );
?>

<?php

/*
* This file provides all the save_post functions for the metaboxes
*
* Rather than setting nonces for each box ( apparently & in practise seems to be an issue for multiple
* save function) we rely on data sanitization of the $_POST[] variables 
* This may need re-visiting & revising!.
*
* ToDo: merge these metadata saves into one, and as an array? As example 'enable_group_header' function
*/

if(! isset( $_POST['save'] )  )
	return;

/*
* Right Column: metabox saves
*/
function bgb_save_enable_sponsor($post_id) {
global $wp, $post;
 
	// precaution! prevent functions running if not CPT in question; perhaps overkill?
	if(  'bgb_sponsors' !== $post->post_type )
		return;
		
#### this save needs attention not sure I like simply removing the meta entry if value is not set ########
 
 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) {
  return $post->ID;
    }
	//if ( !isset( $_POST['enable_this_sponsor'] ) || !wp_verify_nonce( $_POST['enable_this_sponsor], basename( __FILE__ ) ) )
	  //return $post_id;
	
	//var_dump($post);
	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);

//var_dump($post_type);
	if( !current_user_can($post_type->cap->edit_post, $post_id) )
	return $post_id;
	
	$new_meta_value = (isset($_POST['bgb_enable_this_sponsor'] ) ? $_POST['bgb_enable_this_sponsor'] : '');
	
	$meta_key = 'bgb_enable_sponsor';
	
	$meta_value = get_post_meta($post_id, $meta_key, true);

	// Works but needs review - not quite correct or best.
	/*if ( $new_meta_value && '' == $meta_value ) 
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );*/
	
	if ( $new_meta_value && $new_meta_value != $meta_value ) {
  update_post_meta( $post_id, $meta_key, $new_meta_value );	
	
	}	elseif ( '' == $new_meta_value && $meta_value ) {
		$meta_value = '0';
	 update_post_meta( $post_id, $meta_key, $meta_value );
	}
	
}
	//post saves
add_action('save_post', 'bgb_save_enable_sponsor', 10, 2);

function bgb_save_enable_header($post_id) {
global $wp, $post;
	
	// precaution! prevent functions running if not CPT in question; perhaps overkill?
	if(  'bgb_sponsors' !== $post->post_type )
		return;
		
 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
   return $post->ID;
  }
	//if ( !wp_verify_nonce( $_POST['bgb_enable_group_header_nonce'], basename( __FILE__ ) ) )
	 // return $post_id;

	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);

	if( !current_user_can($post_type->cap->edit_post, $post_id) )
		return $post_id;
	
	$new_meta_value = array(
			'bgb_enable_header' => ( isset($_POST['bgb_enable_group_header'] ) ? sanitize_text_field( $_POST['bgb_enable_group_header'] ) : ''),
			'bgb_header_image' => ( isset($_POST['bgb_enable_group_image'] ) ?   sanitize_text_field( $_POST['bgb_enable_group_image'] ) : ''),
			'bgb_header_description' => ( isset($_POST['bgb_enable_group_description'] ) ? sanitize_text_field( $_POST['bgb_enable_group_description'] ) : '')
			);
		
	$meta_key = 'bgb_header_elements';
	$meta_value = get_post_meta($post_id, $meta_key, true);
	
	if ( $new_meta_value && $new_meta_value != $meta_value ) {
  update_post_meta( $post_id, $meta_key, $new_meta_value );	
	
	}elseif ( '' == $new_meta_value && $meta_value ) {
		$meta_value = '0';
	 update_post_meta( $post_id, $meta_key, $meta_value );
	}

}
	//post saves
add_action('save_post', 'bgb_save_enable_header', 10, 2);

/*
* Left Column: Metabox saves
*/

function bgb_sponsors_details($post_id) {
global $wp, $post;
	
	// precaution! prevent functions running if not CPT in question; perhaps overkill?
	if(  'bgb_sponsors' !== $post->post_type )
		return;
		
 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
   return $post->ID;
  }
	//if ( !wp_verify_nonce( $_POST['bgb_enable_group_header_nonce'], basename( __FILE__ ) ) )
	 // return $post_id;

	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);

	if( !current_user_can($post_type->cap->edit_post, $post_id) )
		return $post_id;
	
	$new_meta_value = array(
			'name' => ( isset($_POST['name'] ) ) ? sanitize_text_field( $_POST['name'] ) : '',
			'company_name' => ( isset($_POST['company_name'] ) ) ?   sanitize_text_field( $_POST['company_name'] ) : '',
			'public_email' => ( isset($_POST['public_email'] ) && is_email( $_POST['public_email'] ) ) ? sanitize_text_field( $_POST['public_email'] ) : '',
			'address_1' => ( isset($_POST['address_1'] ) ) ?   sanitize_text_field( $_POST['address_1'] ) : '',
			'address_2' => ( isset($_POST['address_2'] ) ) ?   sanitize_text_field( $_POST['address_2'] ) : '',
			'address_3' => ( isset($_POST['address_3'] ) ) ?   sanitize_text_field( $_POST['address_3'] ) : '',
			'city' => ( isset($_POST['city'] ) ) ?   sanitize_text_field( $_POST['city'] ) : '',
			'state' => ( isset($_POST['state'] ) ) ?   sanitize_text_field( $_POST['state'] ) : '',
			'country' => ( isset($_POST['country'] ) ) ?   sanitize_text_field( $_POST['country'] ) : '',
			'postal_code' => ( isset($_POST['postal_code'] ) ) ?   sanitize_text_field( $_POST['postal_code'] ) : '',
			);
		
	$meta_key = 'bgb_sponsors_details';
	$meta_value = get_post_meta($post_id, $meta_key, true);
	
	if ( $new_meta_value && $new_meta_value != $meta_value ) {
  update_post_meta( $post_id, $meta_key, $new_meta_value );	
	
	}elseif ( '' == $new_meta_value && $meta_value ) {
		$meta_value = '';
	 update_post_meta( $post_id, $meta_key, $meta_value );
	}

}
	//post saves
add_action('save_post', 'bgb_sponsors_details', 10, 2);

function bgb_summary($post_id) {
global $wp, $post;
 
	// precaution! prevent functions running if not CPT in question; perhaps overkill?
	if(  'bgb_sponsors' !== $post->post_type )
		return;

 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
     return $post->ID;
    }
	//if ( !isset( $_POST['bgb_sponsor_summary'] ) || !wp_verify_nonce( $_POST['bgb_sponsor_summary_nonce'], basename( __FILE__ ) ) )
	 // return $post_id;
	
	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);
	//var_dump($post_type);
	if( !current_user_can($post_type->cap->edit_post, $post_id) )
	return $post_id;
	
	$bgb_tags = array(
			'p' => array(),
			'br' => array(),
			'i' => array(),
			'em' => array(),
			'b' => array(),
			'strong' => array(),
			'blockquote' => array(),
			'img' => array(
					'src' => array(),
					'alt' => array(),
					'class' => array()
					),
			'a' => array(
					'href' => array(),
					'title' => array()
					),
			'span' => array(
					'style' => array()
					)
			);
	$new_meta_value = (isset($_POST['bgb_sponsor_summary'] ) ? wp_kses( $_POST['bgb_sponsor_summary'], $bgb_tags)  : '');
	
	$meta_key = 'bgb_sponsor_summary';
	
	$meta_value = get_post_meta($post_id, $meta_key, false);

	if ( $new_meta_value && '' == $meta_value ) 
		add_post_meta( $post_id, $meta_key, $new_meta_value, false );
	
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
  update_post_meta( $post_id, $meta_key, $new_meta_value );
		
	elseif ( '' == $new_meta_value && $meta_value )
	 delete_post_meta( $post_id, $meta_key, $meta_value );
}
	//post saves
add_action('save_post', 'bgb_summary', 10, 2);

function bgb_sponsor_id($post) {
global $wp, $post;
 
	// precaution! prevent functions running if not CPT in question; perhaps overkill?
	if(  'bgb_sponsors' !== $post->post_type )
		return;

 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
     return $post->ID;
    }
//if ( !wp_verify_nonce( $_POST['bgb_sponsor_group_id_nonce'], basename( __FILE__ ) ) )
	//  return $post_id;
	
	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);
	//var_dump($post_type);
	
	if( !current_user_can($post_type->cap->edit_post, $post_id) )
	return $post_id;
	
	$new_meta_value = (isset($_POST['bgb_sponsor_group_id'] ) ? absint( $_POST['bgb_sponsor_group_id'] ) : '');
	
	$meta_key = 'bgb_sponsor_group_id';
	
	$meta_value = get_post_meta($post_id, $meta_key, true);
	
	/*
	* This block of add/update options is hugely confusing but critical.
	* Group meta must have the post id but also needs a means of updating if it changes 
	* Note to self: iirc if we don't delete meta it increments causing confusion?
	*/
	if ( $new_meta_value )
		groups_update_groupmeta( $new_meta_value, 'bgb_has_sponsor_post_id', $post_id );
	
	if( $new_meta_value  !== $meta_value )
		groups_delete_groupmeta( $meta_value, 'bgb_has_sponsor_post_id', $post_id );
		//groups_update_groupmeta( $new_meta_value, 'bgb_has_sponsor_post_id', $post_id );

	if ( $new_meta_value && '' == $meta_value ) {
		add_post_meta( $post_id, $meta_key, $new_meta_value, false );		
		}
		
	elseif ( $new_meta_value && $new_meta_value !== $meta_value ) {  
		update_post_meta( $post_id, $meta_key, $new_meta_value );		
		groups_update_groupmeta( $new_meta_value, 'bgb_has_sponsor_post_id', $post_id );
		}
		
	elseif ( '' == $new_meta_value && $meta_value )
	 delete_post_meta( $post_id, $meta_key, $meta_value ); // not sure why I wanted to delete but this looks wrong check in detail.
}
	//post saves
add_action('save_post', 'bgb_sponsor_id', 10, 2);


function bgb_sponsors_post_id($post) {
global $wp, $post;
 
 if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
     return $post->ID;
    }

	$post_id = $post->ID;
	$post_type = get_post_type_object($post->post_type);
	//var_dump($post_type);
	//if( !current_user_can($post_type->cap->edit_post, $post_id) )
	//return $post_id;
	
	$new_meta_value = $post_id;
	
	$meta_key = 'bgb_sponsors_post_id';
	
	$meta_value = get_post_meta($post_id, $meta_key, false);

	if ( $new_meta_value && '' == $meta_value ) 
		add_post_meta( $post_id, $meta_key, $new_meta_value, false );
	
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
  update_post_meta( $post_id, $meta_key, $new_meta_value );
		
	elseif ( '' == $new_meta_value && $meta_value )
	 delete_post_meta( $post_id, $meta_key, $meta_value );
}
	//post saves
add_action('save_post', 'bgb_sponsors_post_id', 10, 2);


####### SAVED FOR RFERENCE: REMOVE WHEN NO LONGER REQUIRED ############

/*
* BP Groups meta is being set in the function earlier 'bgb_sponsor_id'
* This attempt proved unecessary to run as seperate function.
*/
function bgb_add_group_meta_id($post) {
global $wp, $post, $groups, $bp;
//	$post_id = $post->ID;
//	$meta_key = 'bgb_sponsor_group_id';
//	$bgb_group_meta = groups_get_groupmeta($new_meta_value, 'bgb_has_sponsor');
	$new_group_id = '1' ;//( isset($_POST['bgb_group_id'] ) ) ? $_POST['bgb_group_id'] : '';
	
// $meta_value	= get_post_meta($post_id, $meta_key, false);
//	$bgb_group_meta = groups_get_groupmeta(meta_value, 'bgb_has_sponsor');

//		if ( $new_meta_value  )
		groups_update_groupmeta( 4, 'bgb_has_sponsor', '1' );
				
//		elseif ( $new_meta_value && $bgb_group_meta &&  $new_meta_value != $bgb_group_meta  )
//		groups_update_groupmeta( $new_meta_value, 'bgb_has_sponsor', '1' );
		
//		elseif ( '' !== $new_meta_value  )
//		groups_update_groupmeta( $new_meta_value, 'bgb_has_sponsor', '0' );
}
//add_action('groups_details_updated', 'bgb_add_group_meta_id');


?>
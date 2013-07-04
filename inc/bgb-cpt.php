<?php
/**
* Register our CPT & Taxomomies
*
*
*/
	function register_post_type_sponsor() {
	// Sponsors are site affilliates taking branded groups
		// Set up some labels for the post type
		$labels = array(
			'name' => __( 'Sponsors' , 'bgb-sponsor'),
			'singular_name' => __( 'sponsors' , 'bgb-sponsor'),
			'search_items' =>  __( 'Search Sponsors' , 'bgb-sponsor'),
			'all_items' => __( 'All Sponsors' , 'bgb-sponsor'),
			'parent_item' => __( 'Parent sponsor' , 'bgb-sponsor'),
			'parent_item_colon' => __( 'Parent Sponsor:' , 'bgb-sponsor'),
			'edit_item' => __( 'Edit Sponsor' , 'bgb-sponsor'), 
			'update_item' => __( 'Update Sponsor' , 'bgb-sponsor'),
			'add_new_item' => __( 'Add New Sponsor' , 'bgb-sponsor'),
			'new_item_name' => __( 'New sponsor Name' , 'bgb-sponsor')
		);
		$args = array(
			'label'	   => __( 'Sponsors', 'bgb-sponsor' ),
			'labels'   => $labels,
			'public' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'rewrite' => array('slug' => 'sponsors', 'feeds' => false),
			'capability_type' => 'post',
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
			'taxonomies' => array( 'category', 'sponsors' ),
			'has_archive' => true
		);
		register_post_type('bgb_sponsors', $args);
		

/*		register_taxonomy(  
			'sponsors-group',
			'bgb_sponsor',  
			array(  
				'hierarchical' => false,  
				'label' => __('Sponsors Group', 'bgb-sponsor'),  
				'query_var' => true,  
	    	'rewrite' => array('slug' => 'sponsors/group')
			)  
		);
*/		
		register_taxonomy(  'sponsors', 'bgb_sponsors',  $args );
			$args = array(  
				'hierarchical' => false,  
				'label' => __('Sponsors', 'bgb-sponsor'),
				'add_new_item' 	=> __( 'Add New Sponsor', 'bgb-sponsor' ),  
				'query_var' => 'Sponsors',
				'show_tagcloud' => true,  
	    	'rewrite' => array('slug' => 'sponsors', 'with_front' => false),
				'labels' => array(
					'name' => 'sponsors',
					'singular_name' => 'sponsor',
					'edit_item' => 'Edit sponsor',
					'update_item' => 'Update Sponsor',
					'add_new_item' => 'Add New Sponsor',
					'all_items' => 'All Sponsors',
					'search_items' => 'Search Sponsors',
					'parent_item' => 'Sponsors',
					'parent_item_colon' => 'Parent sponsors',
					),
			);  
register_taxonomy_for_object_type('sponsors', 'bgb_sponsors');	
	
	// terms for categoies
	// wp_insert_term( __('starters', 'rev-dishes'), 'dishes', $args = array('description' => 'First course dishes', 'parent' => 1, 'slug' => 'dishes') );
	// terms for 'cat name'
	/*
	wp_insert_term( __('American', 'bgb-sponsor'), 'sponsor_name'); // 'sponsor_name' => registered_taxonomy
	wp_insert_term( __('Chinese', 'bgb-sponsor'), 'sponsor_name');
				
	register_taxonomy_for_object_type('post_tag', 'custom_post_type');
	
	*/	
/*register_taxonomy_for_object_type('category', 'custom_post_type');*/
		
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if( ( is_category() || is_tag() )  && empty( $query->query_vars['suppress_filters'] )) {
    $post_type = get_query_var('post_type');
		//var_dump(get_query_var('post_type'));
		if($post_type)
	   $post_type = $post_type;
		else
	   $post_type = array('post', 'bgb_sponsors', 'nav_menu_items'); // need wp_nav_menu as it's a cpt by any other definition
    $query->set('post_type',$post_type);
	
		return $query;
  }
}

}
add_action('init', 'register_post_type_sponsor');
?>
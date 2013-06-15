<?php

/* 
* Register metaboxes for post types	
*/

/*
* Right Column sideboxes: primarilly checkbox enable/disable features 
*/

function bgb_metaboxes_enable_sponsor() {
 
    add_meta_box(  
        'bgb_enable_sponsors', // $id  
        'Enable / Disable group branding', // $title   
        'bgb_enable_the_sponsor', // $callback  
        'bgb_sponsors', // $page  
        'side', // $context  
        'high' // $priority
					);   
  
}
add_action('add_meta_boxes', 'bgb_metaboxes_enable_sponsor'); 

function bgb_metaboxes_enable_group_header() {
 
    add_meta_box(  
        'bgb_enable_group_header', // $id  
        'Enable / Disable group branding of the group header', // $title   
        'bgb_enable_group_header', // $callback  
        'bgb_sponsors', // $page  
        'side', // $context  
        'high' // $priority
					);   
  
}
add_action('add_meta_boxes', 'bgb_metaboxes_enable_group_header');
/*
* Left Column: Main metabox options
*/
function bgb_metaboxes_summary() {
 
    add_meta_box(  
        'bgb_sponsor_summary', // $id  
        'Sponsor Summary', // $title   
        'bgb_sponsor_summary', // $callback  
        'bgb_sponsors', // $page  
        'normal', // $context  
        'high' // $priority
					);   
  
}
add_action('add_meta_boxes', 'bgb_metaboxes_summary');

function bgb_metaboxes_id() {
 
    add_meta_box(  
        'bgb_sponsor_group_id', // $id  
        'Sponsor Group ID', // $title   
        'bgb_sponsor_group_id', // $callback  
        'bgb_sponsors', // $page  
        'normal', // $context  
        'high' // $priority
					);   
  
}
add_action('add_meta_boxes', 'bgb_metaboxes_id');

function bgb_metaboxes_sponsor_details() {
 
    add_meta_box(  
        'bgb_sponsor_details', // $id  
        'Sponsor Details', // $title   
        'bgb_sponsor_details', // $callback  
        'bgb_sponsors', // $page  
        'normal', // $context  
        'high' // $priority
					);   
  
}
add_action('add_meta_boxes', 'bgb_metaboxes_sponsor_details');

/*
* Right Column: metabox callback functions
*/

	function bgb_enable_the_sponsor($post) {
	global $wp, $post, $typenow;
	//var_dump(get_post_meta( $post->ID, 'bgb_enable_sponsor', true ) );
	?> 
		<p><?php _e('To enable sponsors branding for this group tick this checkbox', 'bgb_sponsor'); ?></p>
		 <label>Enable group branding</label>
		 <input type="checkbox" name="bgb_enable_this_sponsor" value="1"  <?php checked(get_post_meta( $post->ID, 'bgb_enable_sponsor', true ), 1 )?> />		 
		
	<?php
	}
	function bgb_enable_group_header($post) {
	global $wp;
	$enable_header_elements = get_post_meta( $post->ID, 'bgb_header_elements', true );
	//var_dump($enable_header_elements)	;
		?> 
		<p><?php _e('Enable group header elements.', 'bgb-branding'); ?></p>
		 <label for="enable-group-branding">Enable group header branding</label>
		 <input id="enable-group-branding" type="checkbox" name="bgb_enable_group_header" value="1"  <?php checked( $enable_header_elements['bgb_enable_header'], 1 )?> />
		 
		<p><?php _e('If you do not want to use a featured image for the header you can add an image via the summary description editor.', 'bgb-branding'); ?></p>
		 <label for="enable-featured-image"><?php _e('Enable group header featured image', 'bgb-branding'); ?></label>
		 <input id="enable-featured-image" type="checkbox" name="bgb_enable_group_image" value="1"  <?php checked( $enable_header_elements['bgb_header_image'], 1 )?> />
		
		<p><?php _e('Enable the use of the custom summary description for group header.', 'bgb-branding'); ?></p>
		 <label for="enable-header-description"><?php _e('Enable group header description', 'bgb-branding'); ?></label>
		 <input id="enable-header-description" type="checkbox" name="bgb_enable_group_description" value="1"  <?php checked( $enable_header_elements['bgb_header_description'], 1 )?> />		 
	<?php
	}

/*
* Left Column : metabox callback functions
*/
	function bgb_sponsor_summary($post) {
	global $wp, $post;
	//var_dump($post_id->ID);

		?> 
		<p><?php _e('A short summary for this sponsor  - can be used in the group heading description', 'bgb-branding'); ?></p>
		<p><?php _e('Double spaces will be rendered as paragraphs, however bear in mind that your theme &amp; styles will dictate how much text looks ok in the header area.', 'bgb-branding'); ?></p>
		<p><?php _e('Allowed tags: &lt;i&gt;, &lt;em&gt;, &lt;b&gt;, &lt;strong&gt;, &lt;a&gt;, &lt;br&gt;, &lt;blockquote&gt;', 'bgb-branding') ; ?></p>
		<p><?php _e('You may use the editor buttons for \'underline\', \'text color\' but editor buttons are restricted to these styles and the tags above', 'bgb-branding'); ?></p>
	
		<label style="display: block;font-weight: bold;font-size: 14px;margin-bottom: 5px;">Sponsor Summary</label>
			
	<?php 
 	$content = get_post_meta($post->ID, 'bgb_sponsor_summary', true ) ;
		wp_editor( $content, 'bgbsummaryeditor', array('textarea_name' => 'bgb_sponsor_summary') ); 

	}

	function bgb_sponsor_group_id($post) {
	$bp = buddypress();
	$bgb_fetch_groups = $bp->groups;
	//var_dump($bp->groups );
	
	$group_id = get_post_meta( $post->ID, 'bgb_sponsor_group_id', true );
	
	// Give us the group that now has a sponsor ID i.e has been selected
	$bgb_group = groups_get_group( 'group_id=' . $group_id );
	
	// Set up our select options from a loop of all available group slugs
	$bps_groups  = groups_get_groups( array( 'show_hidden' => true, ) ); ?>
	
	<p><?php _e('The group name to link this sponsor with. (The group must be created in advance)', 'bgb-branding') ?></p><p><?php //var_dump($all_groups->name) ?></p>
	
	<label for="bgb-group-sponsor-id"><?php _e('Select Group Name', 'bgb-branding') ?></label>
	<select name="bgb_sponsor_group_id" id="bgb-group-sponsor-id">
	<?php
	foreach( $bps_groups['groups'] as $all_groups ) : 
	( $bgb_group->id == $all_groups->id ) ? $selected = 'selected' : $selected = '';
		echo $option = '<option class="group-id-' . $all_groups->id . '" value="' . $all_groups->id . '"' . $selected . '>' . $all_groups->slug . '</option>';
	endforeach; 	?>
	</select>

		<?php // we don't especially need this snippet at this time, but may use. ?>
		<script type="text/javascript">
			jQuery('#bgb-group-sponsor-id').blur(function() {;				
				var	bgbGroupID = this.value;
				jQuery('#set-bgb-group-id').val( bgbGroupID );
			});
		</script>
		<input id="set-bgb-group-id" type="hidden" name="bgb_group_id" value="" />
		
		<p><span style="font-weight: bold;">Current group name selected for sponsor : </span> <?php echo ( ! empty( $bgb_group->slug ) ) ? '<span style="font-weight: bold; font-size: 14px; border: 1px solid #bebebe;background: #fff;padding: 2px 10px;">' .  $bgb_group->slug . '</span> Group ID = ' . $bgb_group->id : '<span>' .  _e(' Please select group name. Group name is displayed after saving', 'bgb')  . '</span>' ;?></p>	 
	<?php
	}

	function bgb_sponsor_details($post) {
	global $wp;
	$bgb_sponsors_details = get_post_meta( $post->ID, 'bgb_sponsors_details', true );
	//var_dump($bgb_sponsors_details)	;
		?> 
		<p><?php _e('Sponsors name & address details', 'bgb-branding'); ?></p>
		 
			<fieldset class="sponsor-general-details"><legend><?php _e('General sponsor details', 'bgb-branding'); ?></legend>
				<label for="sponsor-name">Name</label>
		 	<input id="sponsor-name" type="text" name="name" value="<?php echo esc_html( $bgb_sponsors_details['name'] );  ?>" />
		 	<label for="sponsor-company-name">Company Name</label>
		 	<input id="sponsor-company-name" type="text" name="company_name" value="<?php echo esc_html( $bgb_sponsors_details['company_name'] );  ?>"   />
				<label for="sponsor-public-email">Public Email</label>
		 	<input id="sponsor-public-email" type="email" name="public_email" value="<?php echo esc_html( $bgb_sponsors_details['public_email'] );  ?>"  />
		 </fieldset>
		
		<fieldset class="sponsor-address"><legend>Sponsor address</legend>
		 <p>
			<label for="address-1"><?php _e('Addres line 1', 'bgb-branding'); ?></label>
		 <input id="address-1" type="text" name="address_1" value="<?php echo esc_html( $bgb_sponsors_details['address_1'] );  ?>"   />
		 <p>
			<label for="address-2"><?php _e('Addres line 2', 'bgb-branding'); ?></label>
		 <input id="address-2" type="text" name="address_2" value="<?php echo esc_html( $bgb_sponsors_details['address_2'] );  ?>"   />
		 <p>
			<label for="address-3"><?php _e('Addres line 3', 'bgb-branding'); ?></label>
		 <input id="address-3" type="text" name="address_3" value="<?php echo esc_html( $bgb_sponsors_details['address_3'] );  ?>"   />
		 <p>
			<label for="city"><?php _e('City', 'bgb-branding'); ?></label>
		 <input id="city" type="text" name="city" value="<?php echo esc_html( $bgb_sponsors_details['city'] );  ?>"   />
		 <p>
		 <p>
			<label for="state"><?php _e('State', 'bgb-branding'); ?></label>
		 <input id="state" type="text" name="state" value="<?php echo esc_html( $bgb_sponsors_details['state'] );  ?>"   />
		 <p>
		 <p>
			<label for="country"><?php _e('Country', 'bgb-branding'); ?></label>
		 <input id="country" type="text" name="country" value="<?php echo esc_html( $bgb_sponsors_details['country'] );  ?>"   />
		 <p>
			<label for="address-zip"><?php _e('Zip or Post Code', 'bgb-branding'); ?></label>
		 <input id="address-zip" type="text" name="postal_code" value="<?php echo esc_html( $bgb_sponsors_details['postal_code'] );  ?>"   />
			</p>
		</fieldset>
	
	<?php
	}	
#############################################################################

	function rev_dish_ingredients($post) {
	global $wp;

		 wp_nonce_field( basename( __FILE__ ), 'revivalist_dish_post_nonce' ); ?>
		 <table>
		 
		 <thead>
			 <tr>
			 	<th>Qnt</th><th>Ingredient</th><th>Notes</th>
			 </tr>
		 </thead>
		 <tfoot></tfoot>
		 <tbody>
		 <tr>
		 <td>
		 <label>Qnt</label>
		 <input type="text" name="ingredients_qnt" value="<?php echo esc_attr( get_post_meta( $post->ID, 'ingredient_qnt', false ) ); ?>" />
		 </td>
		 <td>
		 <label>Ingredient Description</label>
		 <input type="text" name="ingredient_desc" value="<?php echo esc_attr( get_post_meta( $post->ID, 'ingredient_desc', false ) ); ?>" />
		 </td>
		 <td>
		 <label>Ingredient Notes</label>
		 <input type="text" name="ingredient_notes" value="<?php echo esc_attr( get_post_meta( $post->ID, 'ingredient_notes', false ) ); ?>" />		 
		 </td>
		 </tr>
		 </tbody>
		 </table>
	<?php	
	}
	
//add_meta_box('rev-ingredients', 'Ingredients', 'rev_dish_ingredients', 'revivalist_dishes', 'normal', 'high');
//add_meta_box('rev-summary', 'dish Summary', 'rev_dish_summary', 'revivalist_dishes', 'normal', 'high');

?>
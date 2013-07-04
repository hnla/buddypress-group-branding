=== BP Group Branding ===
Contributors: hnla AKA Hugo 
Tags: buddypress, Groups, branding
Requires at least: BuddyPress 1.6
Tested up to: WP 3.5.1, BuddyPress 1.8
Stable tag: 0.9

Allow Buddypress groups to be sponsored with a custom front page

== Description ==
BP Group Branding allows a site owner to override the default BuddyPress groups 
home page (displaying activity by default) with a custom 'front' page, this page
can be configured to display a custom header with sponsors logo and description 
along with a post style introduction for the page content below. The header  can be 
carried forward through all group screens The group activit screen is moved to a new 
tab of it's own.

All group sponsors are created using custom post types so setup should be familiar  
to anyone used to posts. All options are managed from the individual CPT's.

== Installation ==

* Unzip or upload the directory '/bp-group-branding/' to your WP plugins directory and activate from the Dashboard of the main blog.
* Move the template files 'home.php' & 'bgb-group-front.php' into your BP /groups/single/ directory - first though re-name your existing home.php to home.php.bck
* To configure a new group branding front page select 'New' from the 'Sponsors menuu entry in the dashboard to create a new Custom post and configure the options available in the post screen.
* Currently all available options are managed for each individual sponsor in each sponsors custom post.
* Further template files are available to manage WP type archive lists of all sponsors and a sponsor single post, these would live in your theme root.
* Styling in initial release is minimal and would require the user to further style to better fit to their theme.

 == Frequently Asked Questions ==
 None

 == Upgrade Notice ==
  
 == Screenshots ==

== Changelog ==

** V 0.9 **  06/07/13
Initial beta test release

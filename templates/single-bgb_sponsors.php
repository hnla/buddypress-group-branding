<?php
/**
 * A template for displaying a single BGB Sponsor
 *
	* This is a rough & ready template with few frills 
	*
 * @package buddypress Group Branding
 * @subpackage buddypress Group Branding single template
 * @since buddypress Group Branding 0.9
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">
<h1>this is s single sponsors display</h1>
			<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<?php if( has_post_thumbnail() ) ?>
			<?php the_post_thumbnail(); ?>
			
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bgb-branding' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bgb-branding' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		
		<?php	if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' )); ?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2><?php printf( __( 'About %s', 'bgb-branding' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
		<?php endif; ?>
	
	</article>
	
	<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
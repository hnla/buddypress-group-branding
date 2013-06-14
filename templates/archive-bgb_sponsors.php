<?php
/**
 * A template for displaying an archive list of all site group sponsors
 *
	* This is a rough & ready template with few frills 
	*
 * @package buddypress Group Branding
 * @subpackage buddypress Group Branding Archive template
 * @since buddypress Group Branding 0.9
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'twentytwelve' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'bgb-branding' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'twentytwelve' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'bgb-branding' ) ) . '</span>' );
					else :
						_e( 'Group Sponsors', 'bgb-branding' );
					endif;
				?></h1>
			</header><!-- .archive-header -->

		<?php
		/* Start the Loop */
		while ( have_posts() ) : the_post(); ?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<?php if( has_post_thumbnail() ) ?>
			<?php the_post_thumbnail('thumbnail'); ?>
			
			<h1 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h1>
		</header>
		
		<div class="entry-content">
			
			<?php the_excerpt() ; ?>
		
		</div><!-- .entry-content -->
			
	</article>

	<?php	endwhile;

			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<p>Nothing to show yet</p>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?>

<?php /* Display navigation to next/previous pages when applicable */ 



// WP_Query arguments

$args = array (
	'pagination'             => true,
	'paged'                  => get_query_var( 'paged' ),// ($_REQUEST['facpaged']) ? absint($_REQUEST['facpaged']) : 1,
	'posts_per_page'         => get_option('posts_per_page'),
);

if ( is_category() ){
	$category = get_category( get_query_var( 'cat' ) );
	$cat_id = $category->cat_ID;
	$args['cat'] = $cat_id; 
} elseif ( is_tag() ) {
	$args['tag_id'] = get_query_var( 'tag_id' ) ;
} elseif(is_year() ) {
	$args['year'] = get_query_var('year');
} elseif(is_month() ) {
	$args['year'] =get_query_var('year');
	$args['monthnum'] = get_query_var('monthnum');
} elseif(is_day() ) {
	$args['year'] = get_query_var('year');
	$args['monthnum'] = get_query_var('monthnum');
	$args['day'] = get_query_var('day');
} elseif(is_author() ){
	$args['author'] = get_query_var('author');
}


// The Query
$q = new WP_Query( $args );
?>


<?php if ( $q->max_num_pages > 1 ) : ?>
	<div id="blog-navigation">
		<?php //posts_nav_link('&nbsp;&nbsp;-&nbsp;&nbsp;','<i class="fa fa-angle-left"></i>&nbsp;&nbsp;Newer','Older&nbsp;&nbsp;<i class="fa fa-angle-right"></i>'); ?>	
		
		
		<?php 
			
			$the_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			//blog url
			if ( get_option('page_for_posts') > 0){
				$blogurl = get_permalink( get_option( 'page_for_posts' ));
			}else{
				$blogurl = home_url();
			}

			$return = paginate_links( array(
				'type' 		=> 'plain',
				'base'      => @add_query_arg('paged','%#%',$blogurl),
				'format'    => '?paged=%#%',
				'current' 	=> $the_paged,//5,//($_REQUEST['facpaged']) ? absint($_REQUEST['facpaged']) : 1,
				'total' 	=> $q->max_num_pages,
				'end_size' 	=> 1,
				'mid_size' 	=> 2,
				'prev_text' => __( 'Prev', 'faculty' ),
				'next_text' => __( 'Next', 'faculty' )
			));

		echo $return;
		?>

	</div><!-- #nav-above -->
<?php else: ?>
	<div id="blog-navigation">
		<?php if (is_category() OR is_tag() ): ?>
			<?php 
				$term =  get_queried_object();
				$term_obj = get_term( $term->term_taxonomy_id, $term->taxonomy ); 
			?>
			<span><?php echo $term_obj->count; ?></span> <span><?php _e( 'posts', 'faculty' ); ?></span>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php /* Start the Loop */ ?>

<div class="archive-contnet" id="archive-content">
	<div class="inner-wrapper">

		<?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); ?>
							
			<div class="post post-ajax" <?php post_class(); ?> data-id="<?php echo get_page_uri($post->id); ?>">
				<a href="<?php the_permalink() ?>" data-url="<?php the_permalink() ?>" class="ajax-single">
					
					<?php if( ot_get_option('blog_thumbs','') == "on" AND has_post_thumbnail() ) : ?>
						<div class="blog-thumb">
							<?php the_post_thumbnail('thumbnail'); ?>
						</div>
						<div class="blog-info">
							<div class="blog-date"><?php the_time('F jS, Y') ?></div>
							<h4><?php the_title(); ?></h4>
						</div>
						<div class="clearfix"></div>
					<?php else: ?>
						<div class="blog-date"><?php the_time('F jS, Y') ?></div>

						<h4><?php the_title(); ?></h4>

						<!-- <div class="meta"><em>by</em> <?php the_author() ?></div> -->

						<div class="blog-excerpt">
							<?php the_excerpt(); ?>
						</div>
					<?php endif; ?>

				</a>
			</div>
			
		<?php endwhile; ?>

		<?php else : ?>
			<h3><?php _e( 'No posts', 'faculty' ); ?></h3>
		<?php endif; ?>
	</div>	
</div>

<?php 
	// Restore original Post Data
	wp_reset_postdata();
?>				
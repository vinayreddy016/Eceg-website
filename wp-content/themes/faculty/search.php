<?php 
/**
 * search.php
 *
 * The template for displaying search results.
 */
?>

<?php get_header(); ?>

    
	<div class="fac-page home">
		<div id="inside">
				
			

			<div class="pageheader">
                <div class="headercontent">
                    <div class="section-container">
                        
                        <h2 class="title noborder"><?php printf( __( 'Search Results for "%s"', 'faculty' ), get_search_query() ); ?></h2>
                        
                        <h2><?php _e('Displaying', 'faculty'); ?> <?php $num = $wp_query->post_count; if (have_posts()) : echo $num; endif;?> <?php _e('of', 'faculty'); ?> <?php $search_count = 0; $search = new WP_Query("s=$s & showposts=-1"); if($search->have_posts()) : while($search->have_posts()) : $search->the_post(); $search_count++; endwhile; endif; echo $search_count;?> <?php _e('results', 'faculty'); ?> </h2>
                    </div>
                </div>
            </div>
            <div class="pagecontents">
                <div class="section color-1">
                    <div class="section-container">
                		<?php if ( have_posts() ) : ?>
                            <?php while( have_posts() ) : the_post(); ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php the_excerpt(); ?></p>
                                <hr/> 
                            <?php endwhile; ?>
                            <?php wp_link_pages(); ?>
                        <?php else : ?>
                            <?php _e('Sorry, we could not find any results', 'faculty'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
			
		</div>	
	</div>
	<div id="overlay"></div>
<?php get_footer(); ?>



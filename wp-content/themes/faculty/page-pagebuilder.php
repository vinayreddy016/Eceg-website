<?php
/*
Template Name: Page Builder Template
*/
?>

<?php get_header(); ?>

    
	<div class="fac-page home">
		<div id="inside">
				
			<?php the_post(); ?>

			<?php the_content(); ?>
			
			<?php wp_link_pages(); ?>
		</div>	
	</div>
	<div id="overlay"></div>
<?php get_footer(); ?>

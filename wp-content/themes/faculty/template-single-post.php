<div class="pageheader">
    <div class="headercontent">
        <div class="section-container">
            
            <?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
			<?php if($url): ?>
				<img src="<?php echo $url; ?>" alt="" class="img-responsive"/>
			<?php endif; ?>
            <h2 class="title"><?php the_title(); ?></h2>
            
            <div class="post-meta">
            	
            	<span><i class="fa fa-calendar"></i>&nbsp;<?php the_date(); ?></span>
	            
	            <?php if (ot_get_option( 'blog_author' ,'on') == 'on') : ?>
	            | <span><i class="fa fa-edit"></i>&nbsp;<?php the_author(); ?></span>
	            <?php endif; ?>

	            | <span><i class="fa fa-folder-o"></i>&nbsp;<?php the_category(', ','single'); ?></span>
	            
	            <?php if (ot_get_option( 'blog_tags', 'on' ) == 'on') : ?>
	            | <span><i class="fa fa-tag"></i>&nbsp;<?php the_tags(''); ?></span>
	            <?php endif; ?>
	            
	           
	            <ul class="post-socials">
	            	<?php if (ot_get_option('blog_fb', 'off') == "on"): ?>
	                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
	                <?php endif; ?>
	                <?php if(ot_get_option( 'blog_twitter', 'off') == 'on'): ?>
	                <li><a href="https://twitter.com/intent/tweet?original_referer=<?php echo site_url(); ?>&amp;text=<?php the_title(); ?>&amp;url=<?php the_permalink();?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
	                <?php endif; ?>
	                <?php if(ot_get_option( 'blog_gp','off' ) == 'on'): ?>
	                <li><a href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
	            	<?php endif; ?>
	            </ul>


            </div>
            
        </div>
    </div>
</div>

<div class="page-contents color-1">
	<div class="section">
		<div class="section-container">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>
	</div>
</div>

<?php 
// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) : ?>	
<div class="page-contents color-2">
	<div class="section">
		<div class="section-container">
		<?php comments_template(); ?>
		</div>
	</div>
</div>
<?php endif; ?>
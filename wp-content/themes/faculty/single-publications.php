<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?>
<?php
    the_post();
    $fac_class = '';
    if ( ! has_post_thumbnail() ){
        $fac_class = 'no_thumbnail';
    }
?>
<?php get_header(); ?>

    
	<div class="fac-page home <?php echo $fac_class;?>">
		<div id="inside">
				
            <?php 
                $bg_image = ot_get_option('fac_pub_header_bg',''); 
                $styles = "";
                if ( '' != $bg_image ){
                    $styles = "background-image:url(".$bg_image.");";
                }
            ?>
			
            <div class="pageheader pubheader" style="<?php echo $styles; ?>">
                    <div class="section-container">
                        <div class="header-wrapper">
                            <h2 class="title">
                                <?php $pub_title = get_post_meta( get_the_ID(), 'fac_pub_title', TRUE ); ?>
                                <?php if( trim($pub_title) == ''): ?>
                                    <?php the_title(); ?>
                                <?php else: ?>
                                    <?php echo $pub_title; ?>
                                <?php endif; ?>
                            </h2>
                        </div>
                    </div>
            </div>

            <div class="pagecontents pubcontents">
                <div class="section color-1">
                    <div class="section-container">
                        <div class="pub-single-info">
                            <?php if ( has_post_thumbnail() ): ?>
                                <div class="attachment">
                                    <div class="pub-thumb">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                    <div class="link-buttons">
                                        <?php $file = get_post_meta( get_the_ID(), 'fac_pub_docfile', TRUE ); ?>
                                        <?php if ( '' != trim($file) ){$has_file = true;} ?>
                                        <?php if ($has_file): ?>
                                            <a class="download-btn" href="<?php echo $file; ?>">
                                                <i class="fa fa-cloud-download"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php $pub_link = get_post_meta( get_the_ID(), 'fac_pub_ext_link', TRUE ); ?>
                                        <?php if ('' != trim($pub_link) ): ?>
                                            <a target="_blank" class="external-btn <?php echo $has_file?'':"full"; ?>" href="<?php echo esc_url($pub_link);?>">
                                                <i class="fa fa-external-link"></i>
                                                <span><?php _e('External Link','faculty'); ?></span>
                                            </a>
                                        <?php endif; ?>
                                    </div> 
                                </div>
                            <?php endif; ?>

                            <div class="description">
                                <?php $terms = get_the_terms( get_the_ID(), 'pubtype' ); ?>
                                <?php if (is_array($terms) && count($terms) >0 ): ?>
                                    <ul class="cats">
                                    <?php foreach ($terms as $term): ?>
                                        <li><a href="<?php echo esc_url(get_term_link($term->term_id,$term->taxonomy)); ?>"><?php echo $term->name; ?></a></li>
                                    <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="authors"><span><?php echo get_post_meta( get_the_ID(), 'fac_pub_authors', TRUE ); ?></span></div>
                                <div class="citation"><span><?php echo get_post_meta( get_the_ID(), 'fac_pub_cit', TRUE ); ?></span></div>
                                <div class="pubyear"><?php echo __('Publication year: ', 'faculty') . get_post_meta( get_the_ID(), 'fac_pub_year', TRUE ); ?></div>
                            </div>
                            <?php if ( ! has_post_thumbnail() ): ?>
                                <div class="link-buttons">
                                    <?php $file = get_post_meta( get_the_ID(), 'fac_pub_docfile', TRUE ); ?>
                                    <?php if ( '' != trim($file) ){$has_file = true;} ?>
                                    <?php if ($has_file): ?>
                                        <a class="download-btn" href="<?php echo $file; ?>">
                                            <i class="fa fa-cloud-download"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php $pub_link = get_post_meta( get_the_ID(), 'fac_pub_ext_link', TRUE ); ?>
                                    <?php if ('' != trim($pub_link) ): ?>
                                        <a target="_blank" class="external-btn inline <?php echo $has_file?'':"full"; ?>" href="<?php echo esc_url($pub_link);?>">
                                            <i class="fa fa-external-link"></i>
                                            <span><?php _e('External Link','faculty'); ?></span>
                                        </a>
                                    <?php endif; ?>
                                </div> 
                            <?php endif; ?>
                            
                        </div>
                        <div class="pub-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) : ?>    
                <div class="section color-2">
                    <div class="section-container">
                    <?php comments_template(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
		</div>	
	</div>
	<div id="overlay"></div>
<?php get_footer(); ?>



<?php
/*
Template Name: Gallery Themplate
*/
?>

<?php get_header(); ?>
<div class="fac-page home">
    <?php the_post(); ?>
    <div id="inside">
        <div id="gallery" class="page">
            <?php 
                $styles = "";
                $header_class = "";
                if ( has_post_thumbnail() ){
                    $header_class = 'has-bg';
                    $styles = "background-image:url(".get_the_post_thumbnail_url().");";
                }
            ?>
            <div id="gallery-header" class="pageheader <?php echo $header_class; ?>" style="<?php echo $styles; ?>">
                <div class="headercontent">
                    <div class="section-container">
                        
                        <div class="row">
                            <div class="middle-cols primary-col">
                                <h2 class="title"><?php the_title(); ?></h2>
                            </div>
                            <div class="middle-cols secondary-col">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="pagecontents">
                
                <div class="section color-1" id="gallery-large">
                    <div class="section-container">
                        
                        <ul id="grid" class="grid">
                            <?php
                            //setup new WP_Query
                            $wp_query = new WP_Query( 
                                array(
                                    'posts_per_page'    =>    -1,
                                    'post_type'         =>    'gallery'
                                )
                            );
                            
                            //begine loop
                            while ($wp_query->have_posts()) : $wp_query->the_post();

                                $image_id = get_post_thumbnail_id(); 
                                $image_url = wp_get_attachment_image_src($image_id,'', true);
                            ?>
                                
                            
                            <li>
                                <div>
                                    <img alt="image" src="<?php echo $image_url[0]; ?>">
                                    <a href="<?php echo $image_url[0]; ?>" class="popup-with-move-anim">
                                        <div class="over">
                                            <div class="comein">
                                                <?php if (get_the_excerpt()==''):?>
                                                    <i class="fa fa-search"></i>
                                                <?php else:?>
                                                    <h3 class="item-title"><?php echo the_title(); ?></h3> 
                                                    <div class="item-description"><?php echo get_the_excerpt(); ?></div>
                                                <?php endif; ?>
                                                <div class="comein-bg"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            
                        <?php endwhile; // end of the loop. ?>
                        
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </div>    
    </div>
    
</div>
<div id="overlay"></div>
<?php get_footer(); ?>



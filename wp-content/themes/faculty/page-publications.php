<?php
/*
Template Name: Publications Template
*/

$is_paginated = ot_get_option('fac_paginate_pubs','off');
global $wp_query;
?>

<?php get_header(); ?>

<div class="fac-page home">
    <?php the_post(); ?>
    <div id="inside">
        <div id="publications" class="page">
            <div class="page-container">
                <?php 
                    $bg_image = ot_get_option('fac_pub_header_bg',''); 
                    $styles = "";
                    $header_class = "";
                    if ( '' != $bg_image ){
                        $styles = "background-image:url(".$bg_image.");";
                        $header_class = "has-bg";
                    }
                ?>
                <div class="pageheader <?php echo $header_class; ?>" style="<?php echo $styles; ?>">
                    <div class="headercontent">
                        <div class="section-container">
                            <?php if(is_page()): ?>
                                <h2 class="title"><?php the_title(); ?></h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            <?php elseif(is_archive()): ?>
                                <h2 class="title">
                                <?php if(is_tax()): ?>
                                    <?php $term = $wp_query->queried_object; ?>
                                    <?php echo $term->name ?>
                                <?php else :?>
                                    <?php _e('Publications','faculty'); ?>
                                <?php endif; ?>
                                </h2>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="pagecontents">
                    <?php $types = fac_get_pubtypes(); ?>

                    <?php if (count($types)>0 && ot_get_option('show_pub_filter','on')=="on"): ?>
                    <div class="section color-1" id="filters">
                        <div class="section-container">
                            <div class="row">

                                <div class="col-md-3">
                                    <h3>
                                    <?php 
                                    if ( is_tax() )
                                    {
                                        _e( 'Publication Types:', 'faculty' ); 
                                    }else{
                                        _e( 'Filter by type:', 'faculty' ); 
                                    }
                                    
                                    ?>
                                        
                                    </h3>
                                </div>

                                <?php if (function_exists('ot_get_option')): ?>

                                    <?php if (ot_get_option('pub_filter','dropdown') == 'inline'): ?>

                                        <?php if($is_paginated == 'on'): ?>
                                            <div class="col-md-9" id="miu-filter">
                                        <?php else: ?>
                                            <div class="col-md-6" id="miu-filter">
                                        <?php endif; ?>
                                        

                                            <?php
                                            $activeclassinline = '';
                                            if(!is_tax() )
                                                $activeclassinline="active";
                                            ?>
                                            <a class="btn btn-default btn-sm <?php echo $activeclassinline; ?>" href="<?php echo get_post_type_archive_link('publications'); ?>" value="all"><?php _e( 'All types', 'faculty' ); ?>
                                                (
                                                    <?php

                                                    echo count( get_posts( array(
                                                        'post_type' => 'publications',
                                                        'nopaging'  => true, // display all posts
                                                    ) ) );

                                                    ?>
                                                )
                                            </a>
                                            <?php foreach ($types as $type): ?>
                                                <?php
                                                $activeclassinline = '';
                                                if(is_tax()){
                                                    if($type->slug == $term->slug)
                                                        $activeclassinline="active";
                                                }
                                                ?>
                                                <a class="btn btn-default btn-sm <?php echo $activeclassinline; ?>" href="<?php echo get_term_link( $type->slug, 'pubtype' ); ?>" value=".<?php echo $type->slug ?>"><?php echo $type->name; ?>
                                                (
                                                <?php
                                                echo count( get_posts( array(
                                                    'post_type' => 'publications',
                                                    'tax_query' => array(
                                                            array(
                                                                'taxonomy' => 'pubtype',
                                                                'field' => 'slug',
                                                                'terms' => $type->slug
                                                            )
                                                        ),
                                                    'nopaging'  => true, // display all posts
                                                ) ) );
                                                 ?>
                                                )
                                                </a>
                                            <?php endforeach; ?>
                                        </div>

                                    <?php else: ?>
                                        <div class="col-md-6">
                                            <select id="cd-dropdown" name="cd-dropdown" class="cd-select <?php if($is_paginated == 'on' || is_tax()) echo "with-links" ?>">

                                                <option value="all" data-url="<?php echo get_post_type_archive_link('publications'); ?>" <?php if (ot_get_option('pub_filter_preset','')=='' && ! is_tax('pubtype')){echo"selected";} ?>><?php _e( 'All types', 'faculty' ); ?>
                                                    (
                                                    <?php
                                                    echo count( get_posts( array(
                                                        'post_type' => 'publications',
                                                        'nopaging'  => true, // display all posts
                                                    ) ) );
                                                     ?>
                                                    )
                                                </option>

                                                <?php $q_object = get_queried_object();?>


                                                <?php foreach ($types as $type): ?>
                                                    <?php 
                                                        $selected='';
                                                        if (is_tax('pubtype')){
                                                            if ($q_object->slug==$type->slug){
                                                                $selected='selected';
                                                            }
                                                        }else{
                                                            if ($type->slug == ot_get_option('pub_filter_preset','')){
                                                                $selected='selected';
                                                            }
                                                        }
                                                    ?>
                                                    <option value=".<?php echo $type->slug ?>" data-url="<?php echo get_term_link( $type->slug, 'pubtype' ); ?>" <?php echo $selected;?>>
                                                    <?php echo $type->name; ?>
                                                    (
                                                    <?php
                                                    echo count( get_posts( array(
                                                        'post_type' => 'publications',
                                                        'tax_query' => array(
                                                                array(
                                                                    'taxonomy' => 'pubtype',
                                                                    'field' => 'slug',
                                                                    'terms' => $type->slug
                                                                )
                                                            ),
                                                        'nopaging'  => true, // display all posts
                                                    ) ) );
                                                     ?>
                                                    )
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <?php if($is_paginated == 'on'): ?>
                                        <div class="col-md-9">
                                    <?php else: ?>
                                        <div class="col-md-6">
                                    <?php endif; ?>
                                    <select id="cd-dropdown" name="cd-dropdown" class="cd-select">
                                        <option class="filter" value="all" selected><?php _e( 'All types', 'faculty' ); ?></option>
                                        <?php foreach ($types as $type): ?>
                                            <option class="filter" value="<?php echo $type->slug ?>"><?php echo $type->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php endif; ?>

                                <?php if($is_paginated != 'on'): ?>
                                <div class="col-md-3" id="sort">
                                    <span><?php _e('Sort by year','faculty'); ?>:</span>
                                    <div class="btn-group pull-right">

                                        <button type="button" data-sort="year:asc" class="sort btn btn-default btn-sm"><i class="fa fa-sort-numeric-asc"></i></button>
                                        <button type="button" data-sort="year:desc" class="sort btn btn-default btn-sm"><i class="fa fa-sort-numeric-desc"></i></button>

                                        <?php if( ot_get_option('override_order','off') =='on'): ?>
                                            <?php if(ot_get_option('pub_order','asc') == 'asc'): ?>
                                                <script> window.pubOrder = 'asc';</script>
                                            <?php elseif(ot_get_option('pub_order','asc') == 'desc'): ?>
                                                <script> window.pubOrder = 'desc';</script>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>


                    <?php $is_toggleable = ot_get_option('pubs_single_link', 'on') == 'on' ? false : true; ?>
                    <div class="section color-2 <?php echo $is_toggleable ? '_fac_toggleable' : ''; ?>" id="pub-grid">
                        <div class="section-container">

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pitems <?php if($is_paginated == "on") echo "is-paginated"; ?> <?php if(!$is_toggleable) echo "no-toggle"; ?>">
                                        <?php


                                        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

                                        // //setup new WP_Query
                                        if(ot_get_option('override_order','off')=='on'){
                                            $arg= array(
                                                'post_type'         => 'publications',
                                                'meta_key'          => 'fac_pub_year',
                                                'orderby'           => 'meta_value title',
                                                'order'             => ot_get_option('pub_order','asc')
                                            );
                                        }else{
                                            $arg = array(
                                                'post_type'         => 'publications',
                                                'order'             => 'ASC',
                                                'orderby'           => 'menu_order'
                                            );
                                        }


                                        if ( $is_paginated == 'on' ){
                                            $arg['paged'] = $paged;
                                            $arg['posts_per_page'] = ot_get_option('fac_paginate_pubs_per_page',10);
                                        }
                                        else{
                                            $arg['posts_per_page'] = -1;
                                        }

                                        if(is_tax()){
                                            $term = $wp_query->queried_object;
                                            $arg['tax_query'] = array(
                                                array(
                                                    'taxonomy' => 'pubtype',
                                                    'field'    => 'slug',
                                                    'terms'    => $term->slug
                                                ),
                                            );
                                        }

                                        $temp = $wp_query;
                                        $wp_query= null;
                                        $wp_query = new WP_Query($arg);
                                        $counter = 0;


                                        $big = 999999999; // need an unlikely integer

                                        $links = paginate_links( array(
                                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                            'format' => '?paged=%#%',
                                            'current' => max( 1, get_query_var('paged') ),
                                            'total' => $wp_query->max_num_pages
                                        ) );

                                        if(!empty($links))
                                            echo "<div class=\"fac-pagination\">".$links."</div>\n";
                                        
                                        //begine loop
                                        while (have_posts()) : the_post();

                                        $meta= get_post_custom($post->ID);

                                        ?>


                                            <?php if (ot_get_option('pub_layout','default') == 'compact'): ?>

                                                <div class="item mix<?php fac_taxonomy_name('slug'); ?>"

                                                    <?php if ( ! empty($meta['fac_pub_year'][0]) ):  ?>
                                                        data-year="<?php echo $meta['fac_pub_year'][0] ?>"
                                                    <?php endif; ?>
                                                >
                                                    <?php $thumbclass=''; ?>
                                                    <?php if(has_post_thumbnail()): ?>
                                                        <?php $thumbclass = 'pub-has-thumbnail'; ?>
                                                    <?php endif; ?>
                                                    <div class="pubmain compact <?php echo $thumbclass; ?>">

                                                        <?php if(has_post_thumbnail()): ?>
                                                        <div class="pub-thumb">
                                                           <?php the_post_thumbnail('thumbnail'); ?>
                                                        </div>
                                                        <?php endif; ?>

                                                        <div class="pub-contents">
                                                            <?php if ( $is_toggleable): ?>
                                                            <div class="pubassets">


                                                                <a href="#" class="pubcollapse">
                                                                    <i class="fa fa-plus-square-o"></i>
                                                                </a>

                                                                <?php if ( ! empty($meta['fac_pub_ext_link'][0]) ):  ?>
                                                                <a href="<?php echo $meta['fac_pub_ext_link'][0] ?>" class="tooltips" title="External link" target="_blank">
                                                                    <i class="fa fa-external-link"></i>
                                                                </a>
                                                                <?php endif; ?>

                                                                <?php if ( ! empty($meta['fac_pub_docfile'][0]) ):  ?>
                                                                <a href="<?php echo $meta['fac_pub_docfile'][0] ?>" class="tooltips" title="<?php _e( 'Download', 'faculty' ); ?>" target="_blank">
                                                                    <i class="fa fa-cloud-download"></i>
                                                                </a>
                                                                <?php endif; ?>

                                                            </div>
                                                            <?php endif; ?>

                                                            <?php if ( ! $is_toggleable ) : ?>
                                                            <h4 class="pubtitle"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo $meta['fac_pub_title'][0] ?></a></h4>
                                                            <?php else: ?>
                                                                <h4 class="pubtitle"><?php echo $meta['fac_pub_title'][0] ?></h4>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="clearfix"></div>

                                                    </div>

                                                    <div class="pubdetails">
                                                        <div class="pubmeta">
                                                            <?php fac_taxonomy_name('name',true); ?>
                                                            <div class="pubauthor"><?php echo $meta['fac_pub_authors'][0] ?></div>
                                                            <div class="pubcite"><?php echo $meta['fac_pub_cit'][0] ?></div>

                                                            <?php if ( ! empty($meta['fac_pub_year'][0]) ):  ?>
                                                            <div class="pubyear"><?php echo __('Publication year: ', 'faculty') . $meta['fac_pub_year'][0] ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if ( $is_toggleable) { the_content(); } ?>
                                                    </div>

                                                </div>
                                            <?php else: ?>

                                                <div class="item mix<?php fac_taxonomy_name('slug'); ?>"

                                                    <?php if ( ! empty($meta['fac_pub_year'][0]) ):  ?>
                                                        data-year="<?php echo $meta['fac_pub_year'][0] ?>"
                                                    <?php endif; ?>
                                                >
                                                    <?php $thumbclass=''; ?>
                                                    <?php if(has_post_thumbnail()): ?>
                                                        <?php $thumbclass = 'pub-has-thumbnail'; ?>
                                                    <?php endif; ?>
                                                    <div class="pubmain <?php echo $thumbclass;?> ">

                                                        <?php if(has_post_thumbnail()): ?>
                                                        <div class="pub-thumb">
                                                           <?php the_post_thumbnail('medium'); ?>
                                                        </div>
                                                        <?php endif; ?>

                                                        <div class="pub-contents">
                                                            <?php if ( $is_toggleable): ?>
                                                            <div class="pubassets">

                                                                <?php if ($post->post_content!="") : ?>
                                                                    <a href="#" class="pubcollapse">
                                                                        <i class="fa fa-plus-square-o"></i>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if ( ! empty($meta['fac_pub_ext_link'][0]) ):  ?>
                                                                    <a href="<?php echo $meta['fac_pub_ext_link'][0] ?>" class="tooltips" title="External link" target="_blank">
                                                                        <i class="fa fa-external-link"></i>
                                                                    </a>
                                                                <?php endif; ?>

                                                                <?php if ( ! empty($meta['fac_pub_docfile'][0]) ):  ?>
                                                                    <a href="<?php echo $meta['fac_pub_docfile'][0] ?>" class="tooltips" title="<?php _e( 'Download', 'faculty' ); ?>" target="_blank">
                                                                        <i class="fa fa-cloud-download"></i>
                                                                    </a>
                                                                <?php endif; ?>

                                                            </div>
                                                            <?php endif; ?>

                                                            <?php if ( ! $is_toggleable ) : ?>
                                                            <h4 class="pubtitle"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo $meta['fac_pub_title'][0] ?></a></h4>
                                                            <?php else: ?>
                                                                <h4 class="pubtitle"><?php echo $meta['fac_pub_title'][0] ?></h4>
                                                            <?php endif; ?>

                                                            <div class="pubcontents">
                                                                <?php fac_taxonomy_name('name',true); ?>

                                                                <div class="pubauthor"><?php echo $meta['fac_pub_authors'][0] ?></div>
                                                                <div class="pubcite"><?php echo $meta['fac_pub_cit'][0] ?></div>

                                                                <?php if ( ! empty($meta['fac_pub_year'][0]) ):  ?>
                                                                <div class="pubyear"><?php echo __('Publication year: ', 'faculty') . $meta['fac_pub_year'][0] ?></div>
                                                                <?php endif; ?>
                                                            </div>

                                                        </div>

                                                        <div class="clearfix"></div>

                                                    </div>
                                                    <?php if ($post->post_content!="") : ?>
                                                    <div class="pubdetails">
                                                        <?php if ( $is_toggleable) { the_content(); } ?>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; //end if for layout mode?>



                                        <?php endwhile; // end of the loop. ?>

                                        <?php


                                            $big = 999999999; // need an unlikely integer

                                        $links = paginate_links( array(
                                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                            'format' => '?paged=%#%',
                                            'current' => max( 1, get_query_var('paged') ),
                                            'total' => $wp_query->max_num_pages
                                        ) );

                                        if(!empty($links))
                                            echo "<div class=\"fac-pagination\">".$links."</div>\n";

                                        wp_reset_query();?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>
<div id="overlay"></div>
<?php get_footer(); ?>
<?php
/**
 *  visual composer things
 * 
 * @package Faculty theme
 * @author owwwlab
 */

// don't load directly
if (!defined('ABSPATH')) die('-1');

/**
 * class to extend visual composer.
 *
 * @since 1.0.0
 *
 * @package faculty
 * @author  owwwlab
 */

 class Owlab_vc_extend {

 	/**
	 * list of shortcodes to add to vc
	 *
	 * @since 1.0.0
	 */
   	public $shortcodes;
 	
 	public $inline_js = '';


     /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct($shortcodes='') {

    	// grab shortcodes array
    	$this->shortcodes = $shortcodes;


		// We safely integrate with VC with this hook
		add_action( 'init', array( $this, 'integrateWithVC' ) );

		// Use this when creating a shortcode addon
		$this->add_all_shortcodes();

		// Register CSS and JS
		add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );

    }


    /**
     * adds all shortcode css and js to the page
     *
     * @since 1.0.0
     * @param      
     * @return 
     */
    public function loadCssAndJs() {
    
        
    
    }


    /*
    Show notice if your plugin is activated but Visual Composer is not
    */
    // public function showVcVersionNotice() {
    //     $plugin_data = get_plugin_data(__FILE__);
    //     echo '
    //     <div class="updated">
    //       <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'faculty'), $plugin_data['Name']).'</p>
    //     </div>';
    // }
    

    /**
     * integrate settings and maps with vc
     *
     * @since 1.0.0
     * @param  void    
     * @return void
     */
    public function integrateWithVC() {
    
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            //add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }

        //map all custom shortcodes
        if ( is_array($this->shortcodes) ){
        	foreach ($this->shortcodes as $sc_name => $sc_array) {
	        	vc_map($sc_array);
	        	
	        }
        }
	        
    
    }
    
    /**
     * adds all shortcodes to wp
     *
     * @since 1.0.0
     * @param  void    
     * @return void 
     */
    public function add_all_shortcodes() {
    	
    	if ( is_array($this->shortcodes) ){
	    	foreach ($this->shortcodes as $sc_name => $sc_array) {
	    		add_shortcode( $sc_array['base'], array( $this, 'render_'.$sc_name ) );
	    	}
        }
    }


    /**
     * helper class
     *
     * @since 1.0.0
     * @param  void    
     * @return void 
     */
    public function getExtraClass( $el_class ) {
		$output = '';
		if ( $el_class != '' ) {
			$output = " " . str_replace( ".", "", $el_class );
		}
		return $output;
	}


    /**
     * title
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_title ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => __("Title", "faculty"),
		    'title_align' => 'text-center',
		    'title_tag' => 'big_head',
		    'title_color' => '#4b4b4b',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);

		$class = ($title_tag == "big_head")? "fac-big-title fac-title" : "fac-title";

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class.' '.$title_align.$el_class);

		switch ($title_tag) {
			case 'big_head':
				$ot='<h1';
				$ct='</h1>';
				break;
			case 'title_h1':
				$ot='<h1';
				$ct='</h1>';
				break;
			case 'title_h2':
				$ot='<h2';
				$ct='</h2>';
				break;
			case 'title_h3':
				$ot='<h3';
				$ct='</h3>';
				break;
			case 'title_h4':
				$ot='<h4';
				$ct='</h4>';
				break;			
			
			default:
				$ot='<h3';
				$ct='</h3>';
				break;
		}

		$output = $ot.' class="'.$css_class.'" style="color:'.$title_color.'">'.esc_html($title).$ct."\n";
		return $output;
    }


    /**
     * wrapper
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_wrapper ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'el_class'        		=> '',
		    'wrapper_bgcolor'       => '#f5f5f5',
		    'wrapper_padding'       => '',
		    'wrapper_margin'   		=> ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);

		$css_class = $el_class;

		$style = 'style="padding:'.$wrapper_padding.';margin:'.$wrapper_margin.';background-color:'.$wrapper_bgcolor.';"';

		$output = '<div class="'.$css_class.'" '.$style.'>';
		$output .= wpb_js_remove_wpautop($content);
		$output .= '</div>';
		return $output;
    }

     /**
     * position
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_position ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ul-dates '.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';
		return $output;
    }


    /**
     * position_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_position_single ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
			'pos_title' 	=>'sample position',
			'url'			=> '',
			'pos_loc'		=>'',
			'pos_start'		=> date("Y"),
			'pos_end'		=> date("Y"),
			'el_class'		=>''
		), $atts));

		if ($pos_loc ==''){
			$pos_loc = $content;
		}

		$el_class = $this->getExtraClass($el_class);

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		$link = vc_build_link( $url );

		$output = "\n\t\t\t" . '<li class="'.$css_class.'">';
	    $output .= "\n\t\t\t\t" . '<div class="dates"><span>'.$pos_end.'</span><span>'.$pos_start.'</span></div>';
	    
	    if ( ! empty($link['url']) ){
			$output .= "\n\t\t\t\t" . '<div class="content"><h4><a href="'.$link['url'].'" target="'.$link['target'].'">'.$pos_title.'</a></h4><p>'.$pos_loc.'</p></div>';
		}else{
			$output .= "\n\t\t\t\t" . '<div class="content"><h4>'.$pos_title.'</h4><p>'.$pos_loc.'</p></div>';
		}
	    
	    $output .= "\n\t\t\t" . '</li>';
		return $output;

    }

     /**
     * education
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_education ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ul-card '.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';
		return $output;
    }


    /**
     * education_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_education_single ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
			'edu_title' 	=>'sample position',
			'url'			=> '',
			'edu_loc'		=>'sample location',
			'edu_level'		=>'',
			'edu_year'		=>'',
			'el_class' 		=> ''
		), $atts));

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);
		$link = vc_build_link( $url );

		$output = "\n\t\t\t" . '<li class="'.$css_class.'">';
		$output .= '<div class="dy">';
		if (!empty($edu_level))
			$output .= "\n\t\t\t\t" . '<span class="degree">'.$edu_level.'</span>';

		if (strlen($edu_year)>1){
			$output .= "\n\t\t\t\t" .'<span class="year">'.$edu_year.'</span></div>';
		}else{
			$output .= "\n\t\t\t\t" .'</div>';
		}


		$output .= "\n\t\t\t\t" . '<div class="description">';
		if ( ! empty($link['url']) ){
			$output .= "\n\t\t\t\t" . '<p class="what"><a href="'.$link['url'].'" target="'.$link['target'].'">'.$edu_title.'</a></p>';
		}else{
			$output .= "\n\t\t\t\t" . '<p class="what">'.$edu_title.'</p>';
		}
		$output .= "\n\t\t\t" . '<p class="where">'.$edu_loc.'</p></div>';
		$output .= "\n\t\t\t" . '</li>';
		return $output;

    }


     /**
     * interest
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_interest ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ul-boxed list-unstyled'.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';
		return $output;
    }


     /**
     * interest_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_interest_single ($atts, $content = null) {
    	
    	
		extract(shortcode_atts(array(
			'interest_title' 	=>'',
			'el_class' 			=>''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		if($interest_title==''){
			$interest_title = wpb_js_remove_wpautop($content);
		}
		$output = '<li class="'.$css_class.'">'.$interest_title.'</li>';
		    
		return $output;

    }


    /**
     * licon
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_licon ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'list-unstyled'.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';

		return $output;
    }

    /**
     * licon_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_licon_single ($atts, $content = null) {
    	

		extract(shortcode_atts(array(
			'licon_des' 	=>'',
			'licon_class'	=>'',
			'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,$el_class);

		if ($licon_des==''){
		    $licon_des = wpb_js_remove_wpautop($content);
		}

		$output = "\n\t\t\t" . '<li class="'.$css_class.'">';
		    $output .= "\n\t\t\t\t" . '<strong><i class="fa '.$licon_class.'"></i>&nbsp;&nbsp;</strong>';
		    $output .= "\n\t\t\t\t" . '<span>'.$licon_des.'</span>';
		    $output .= "\n\t\t\t" . '</li>';
		return $output;

    	
    }


    /**
     * single_icon
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_single_icon ($atts, $content = null) {
    	
    	
		extract(shortcode_atts(array(
			'icon_class' 	=>'',
			'icon_size'	=>'',
			'icon_color' 	=>'#ccc',
			'icon_display'	=>'inline',
			'icon_align'	=>'center',
			'el_class' => ''


		), $atts));



		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,$el_class);

		$output ='<i class="fa '.$icon_class.' '.$css_class.'" style="color:'.$icon_color.';font-size:'.$icon_size.'px ;display:'.$icon_display.';text-align:'.$icon_align.'"></i>';

		return $output;

    }

     /**
     * award
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_award ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'timeline '.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';
		return $output;
    	
    }


    /**
     * award_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_award_single ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
			'award_title' 	=>'sample award title',
			'award_date'	=>'2014',
			'award_content'	=>'',
			'award_image'   =>'',
		    'el_class' => ''
		), $atts));

		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		$img_link=wp_get_attachment_image_src( $award_image, 'large') ;
		$img_link=$img_link[0];

		if ($award_content==''){
		    $award_content = wpb_js_remove_wpautop($content);
		}
		if ($img_link){
		    $content = '
		    <div class="col-md-2">
		        <img alt="image" class="thumbnail img-responsive" src="'.$img_link.'">
		    </div>
		    <div class="col-md-10">
		        '.$award_content.'
		    </div>';
		}else{
		    $content = '
		    <div class="col-md-12">
		        '.$award_content.'
		    </div>';
		}


		$output = "\n\t\t\t" . '<li class="'.$css_class.'">';
		    $output .= "\n\t\t\t\t" . '<div class="date">'.$award_date.'</div>';
		    $output .= "\n\t\t\t\t" . '<div class="circle"></div>';
		    $output .= "\n\t\t\t\t" . '<div class="data"><div class="subject">'.$award_title.'</div><div class="text row">'.$content.'</div></div>';
		    $output .= "\n\t\t\t" . '</li>';
		return $output;

    }


    /**
     * lab
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_lab ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		$class = 'lab-'.rand();

		$output='<div class="lab-carousels-wrapper '.$class.'"><div class="labp-heads-wrap '.$css_class.'">'.wpb_js_remove_wpautop($content).'<div class="lab-carousel"></div>';
		$output.=' <div><a href="#" class="prev"><i class="fa fa-chevron-circle-left"></i></a><a href="#" class="next"><i class="fa fa-chevron-circle-right"></i></a></div></div>';
		$output.='<div class="lab-details"></div></div>';

		$this->inline_js .= '(function($){

					$(".'.$class.'").LabCarousel();
					$( document ).ajaxComplete(function() {
						$(".'.$class.'").LabCarousel();
                    });

                })(jQuery);';
		
        
        
		add_action('wp_footer', array( $this,'append_js_to_footer'),100000,1);

		return $output;
    	
    }

    public function append_js_to_footer($inline) {
        $out = '<script type="text/javascript" id="lab-carousel">';
        $out .= $this->inline_js;
        $out .='</script>';
        echo $out;
    }

    /**
     * lab_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_lab_single ($atts, $content = null) {
    	
    	
		extract(shortcode_atts(array(
			'lab_name' 	=>'',
			'lab_pos'	=>'',
			'lab_desc'  => '',
			'lab_image'	=>'',
			'lab_link'	=>'',
			'lab_link_external' => 'no',
			'lab_follow' =>'',
		    'el_class' => ''
		), $atts));


		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		$img_link=wp_get_attachment_image_src( $lab_image, 'large') ;
		$img_link=$img_link[0];

		if ($lab_follow == ''){
			$lab_follow = "Follow";
		}

		$output = "\n\t\t\t" . '<div class="dummy-lab-item '.$css_class.'">';
		$output .= "\n\t\t\t\t" . '<div class="lab-item-image"><img src='.$img_link.' alt="'.$lab_name.'" class="img-circle lab-img"></div>';
		$output .= "\n\t\t\t\t" . '<div class="lab-item-info"><h3>'.$lab_name.'</h3><h4>'.$lab_pos.'</h4>';
		if ( !empty($lab_desc) )
		{
			$output .= '<span class="lab-item-desc">'.$lab_desc.'</span>';
		}
		if (strlen($lab_link) >0)
		{
		    if ( $lab_link_external == 'yes') 
		    {
		        $target = ' target="_blank" ';
		    }
			$output .= "\n\t\t\t\t" . '<a href="'.$lab_link.'" '.$target.' class="btn btn-info">'.$lab_follow.'</a>';
		}
		$output .= "\n\t\t\t" . '</div></div>';

		return $output;

    }

    /**
     * project
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_project ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
		    'title' => '',
		    'el_class' => ''
		), $atts));

		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'ul-withdetails '.$el_class);

		$output='<ul class="'.$css_class.'">'.wpb_js_remove_wpautop($content).'</ul>';

		return $output;

    }


    /**
     * project_single
     *
     * @since 3.0.0
     * @param      
     * @return 
     */
    public function render_project_single ($atts, $content = null) {
    	
    	extract(shortcode_atts(array(
			'project_title' 	=>'',
			'project_short_description'	=>'',
			'project_image'	=>'',
		    'el_class' => ''
		), $atts));


		$el_class = $this->getExtraClass($el_class);
		$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class);

		$img_link=wp_get_attachment_image_src( $project_image, 'large') ;
		$img_link=$img_link[0];

		if ($img_link == ''){
			$img_link = get_template_directory_uri().'/img/project-default.png';
		}
		if(empty($content))
			$css_class .= "no-details";
		
		$output ='<li class="'.$css_class.'">';
		$output .= "\n\t\t\t\t" . '<div class="wrap"><div class="image" style="background-image:url('.$img_link.');">';
		$output .='<div class="imageoverlay"><i class="fa fa-search"></i></div></div>';
		$output .='<div class="meta"><h3>'.$project_title.'</h3><p>'.$project_short_description.'</p></div></div>';
	
		if(!empty($content)):
			$output .= "\n\t\t".'<div class="details">';
			$output .= "\n\t\t\t".wpb_js_remove_wpautop($content, true);
			$output .= "\n\t\t".'</div> ';
		endif;
		$output .='</li>';
		return $output;

    	
    }
    function render_publications($atts)
    {
    	extract(shortcode_atts(array(
			'widget_title' 		=>'',
			'publication_ids'	=>'',
			'orderby' 			=> 'menu_order',
			'order' 			=> 'DESC',
		    'el_class' 			=> ''
		), $atts));


		// get posts
    	$args = array(
		    'post__in' => explode(',',$publication_ids),
		    'posts_per_page' 	=> -1,
		    'post_type'	=> 'publications',
		    'order' => $order
		);

    	switch ($orderby) {
    		case 'post__in':
    			$args['orderby'] = 'post__in';
    			break;
    		case 'year':
    			$args['orderby'] = array( 'meta_value_num' => $order, 'title' => 'ASC' );
    			$args['meta_key'] = 'fac_pub_year';
    			break;
    		default:
    			$args['orderby'] = 'menu_order title';
    			break;
    	}
		$pubs = get_posts( $args);

		$output = '<div class="fac-publications">';
		// echo title
		$widget_title = esc_attr($widget_title);
		if ( $widget_title != '')
			$output .= "<h2>" .esc_attr($widget_title) . "</h2>";

		if ( count($pubs) > 0)
		{
			$output .= '<div class="pitems">';
			
			foreach ( $pubs as $pub )	{
				
				$url = $pub->guid;
				$meta = get_post_meta($pub->ID);
				$has_thumbnail = has_post_thumbnail($pub);
				$output .= '<div class="item">';
					if ( $has_thumbnail )
                    	$output .= '<div class="pubmain pub-has-thumbnail">';
                    else
                    	$output .= '<div class="pubmain">';
                    	
                	if ( $has_thumbnail){
                    	$output .= '<div class="pub-thumb">';
                           $output .= get_the_post_thumbnail($pub,'medium');
                        $output .= '</div><!-- .pub-thumb -->';
                 	}

                    $output .= '<div class="pub-contents">';
                    	$output .= '<h4 class="pubtitle">';
							$output .= '<a href="'.esc_url($url).'">'.$meta['fac_pub_title'][0].'</a>';
						$output .= '</h4>';
						
						$output .= '<div class="pubcontents">';

							
							$terms = get_the_terms( $pub->ID , 'pubtype' );
							if ( !empty($terms) ){
								foreach ( $terms as $term ) {

									$t_id = $term->term_id;
									$term_meta = get_option( "faulty_pubtypes_$t_id" );
									$link = get_term_link($t_id,'pubtype');
									$output .= '<a href="'.$link.'">';
									
									if ( is_array($term_meta) ){
										if (array_key_exists('faculty_label_color', $term_meta))
											$output .= '<span class="'.$term_meta['faculty_label_color'].'">'.$term->name.'</span>'; 
										else
											$output .= '<span class="label label-warning">'.$term->name.'</span>'; 
									}else{
										$output .= '<span class="label label-warning">'.$term->name.'</span>'; 
									}

									$output .= '</a>';
								}
							}

							$output .= '<div class="pubauthor">'. $meta['fac_pub_authors'][0].'</div><!-- .pubauthor -->';
                            $output .= '<div class="pubcite">'. $meta['fac_pub_cit'][0].'</div><!-- .pubcite -->';
							$output .= '<div class="pubyear">'. __('Publication year: ', 'faculty') . $meta['fac_pub_year'][0].'</div><!-- .pubyear -->';
						$output .= '</div><!-- .pubcontents -->';
                    $output .= '</div><!-- .pub-contents -->';
                    $output .= '<div class="clearfix"></div>';
							
                    $output .= '</div><!-- .pubmain -->';
				$output .= '</div><!-- .item -->';
			}

			$output .= '</div><!-- .pitems -->'; //.pitems
		}

		$output .= '</div><!-- .fac-publications -->'; // .fac-publications

		return $output;
    }

}


//list shortcodes to add to vc as an array here
$shortcodes = array(

	/* Title block
	---------------------------------------------------------- */
	'title' => array(
		"name" => __("Title", "faculty"),
		"base" => "vc_title",
		"icon" => get_template_directory_uri()."/img/vc_icons/vc-title.png",
		"description" => __('Place a title tag', "faculty"),
		"category" 		=> __("faculty", "faculty"),
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Title", "faculty"),
				"param_name" => "title",
				"holder" => "div",
				"value" => __("Title", "faculty"),
				"description" => __("Separator title.", "faculty")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Title position", "faculty"),
				"param_name" => "title_align",
				"value" => array(
					__('Align center', "faculty") => "text-center", 
					__('Align left', "faculty") => "text-left", 
					__('Align right', "faculty") => "text-right"
				),
				"description" => __("Select title location.", "faculty")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Title tag", "faculty"),
				"param_name" => "title_tag",
				"value" => array(
				__('Big heading', "faculty") => "big_head",
				__('h1', "faculty") => "title_h1", 
				__('h2', "faculty") => "title_h2",
				__('h3', "faculty") => "title_h3",
				__('h4', "faculty") => "title_h4"
				),
				"description" => __("Select title tag.", "faculty")
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Custom font Color', "faculty" ),
				'param_name' => 'title_color',
				'description' => __( 'You can assign a custom color if you need to.', "faculty" )
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "faculty"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
			)
		),
		"js_view" => 'VcTextSeparatorView'
	),

    //Wrapper
	'wrapper'	=>	array(
		"name" => __("wrapper", "faculty"),
		"base" => "vc_wrapper",
		"as_parent" => 'all',
		"content_element" => true,
		"show_settings_on_create" => true,
		"category" 		=> __("faculty", "faculty"),
		"icon" => get_template_directory_uri()."/img/vc_icons/row.png",
		"description" => __('Place content elements inside the wrapper and give it proper spacing', "faculty"),
		"params" => array(
			 array(
			  "type" => "colorpicker",
			  "heading" => __("Custom Background Color", "faculty"),
			  "param_name" => "wrapper_bgcolor",
			  "description" => __("Select backgound color for your wrapper", "faculty")
			),
			array(
			  "type" => "textfield",
			  "heading" => __('Padding', "faculty"),
			  "param_name" => "wrapper_padding",
			  "description" => __("You can use px and it can be all four side padding top right bottom left eg(20px 0px 15px 10px) ", "faculty")
			),
			array(
			  "type" => "textfield",
			  "heading" => __('Margin', "faculty"),
			  "param_name" => "wrapper_margin",
			  "description" => __("YYou can use px and it can be all four side margin top right bottom left eg(20px 0px 15px 10px) ", "faculty")
			)
		),
		"js_view" => 'VcColumnView'
	),
	//Position block
	'position'	=>	array(
	    "name" => __("Positions", "faculty"),
	    "base" => "vc_position",
	    "as_parent" => array('only' => 'vc_position_single'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	    'is_container'=>true,
	    "content_element" => true,
	    "show_settings_on_create" => false,
		"category" 		=> __("faculty", "faculty"),
	    "icon" => get_template_directory_uri()."/img/vc_icons/position.png",
	    "params" => array(
	         array(
	          "type" => "textfield",
	          "heading" => __("Widget title", "faculty"),
	          "param_name" => "pos-widget_title",
	          "description" => __("Enter widget title", "faculty")
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => __("Extra class name", "faculty"),
	          "param_name" => "el_class",
	          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
	        )    
	    ),
	    "js_view" => 'VcColumnView'
	),

	'position_single'	=>	array(
	    "name" => __("Single position", "faculty"),
	    "base" => "vc_position_single",
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "as_child" => array('only' => 'vc_position'), // Use only|except attributes to limit parent (separate multiple values with comma)
	    "icon" => get_template_directory_uri()."/img/vc_icons/position.png",
	    "params" => array(
	        array(
		      "type" => "textfield",
		      "heading" => __("Position title", "faculty"),
		      "param_name" => "pos_title",
		      "description" => __("Enter position title", "faculty"),
		      "holder"	=> 'div'
		    ),
		    array(
	            'type'        => 'vc_link',
	            'heading'     => __( 'Link for title', 'faculty' ),
	            'param_name'  => 'url',
	            'description' => __( 'Add link to the title. leave blank to ignore', 'faculty' ),
	        ),
		    array(
		      "type" => "textfield",
		      "heading" => __("Position location", "faculty"),
		      "param_name" => "pos_loc",
		      "value" =>'',
		      "description" => __("Enter position location or leave it blank and use HTML contnet instead", "faculty"),
		      "holder"	=> 'div'
		    ),
		    array(
		      "type" => "textarea_html",
		      "holder" => "div",
		      "class" => "messagebox_text",
		      "heading" => __("HTML Content instead of location", "faculty"),
		      "param_name" => "content",
		      "value" => '',
		      "description" => __("This could be a short decription about the award in HTML mode", "faculty")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => __("Position start date", "faculty"),
		      "param_name" => "pos_start",
		      "description" => __("Enter period start date(eg:2012)", "faculty")
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => __("Position end date", "faculty"),
		      "param_name" => "pos_end",
		      "description" => __("Enter period end date(eg:present)", "faculty")
		    )
	    )
	),

	//Education block
	'education' => array(
	    "name" => __("Educations", "faculty"),
	    "base" => "vc_education",
	    "as_parent" => array('only' => 'vc_education_single'),
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "show_settings_on_create" => false,
	    "icon" => get_template_directory_uri()."/img/vc_icons/education.png",
	    "params" => array(
	         array(
	          "type" => "textfield",
	          "heading" => __("Widget title", "faculty"),
	          "param_name" => "pos-widget_title",
	          "description" => __("Enter widget title", "faculty")
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => __("Extra class name", "faculty"),
	          "param_name" => "el_class",
	          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
	        )    
	    ),
	    "js_view" => 'VcColumnView'
	),
	'education_single' => array(
		"name" => __("Single education", "faculty"),
		"base" => "vc_education_single",
		"content_element" => true,
		"category" 		=> __("faculty", "faculty"),
		"as_child" => array('only' => 'vc_education'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"icon" => get_template_directory_uri()."/img/vc_icons/education.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Education title", "faculty"),
				"param_name" => "edu_title",
				"description" => __("Enter degree title", "faculty"),
				"holder"	=> 'div'
			),
			array(
	            'type'        => 'vc_link',
	            'heading'     => __( 'Link for title', 'faculty' ),
	            'param_name'  => 'url',
	            'description' => __( 'Add link to the title. leave blank to ignore', 'faculty' ),
	        ),
			array(
				"type" => "textfield",
				"heading" => __("Education location", "faculty"),
				"param_name" => "edu_loc",
				"description" => __("Enter university/institution", "faculty"),
				"holder"	=> 'div'
			),
			array(
				"type" => "textfield",
				"heading" => __("Education level", "faculty"),
				"param_name" => "edu_level",
				"description" => __("Enter degree level(eg:B.A)", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Education date", "faculty"),
				"param_name" => "edu_year",
				"description" => __("Enter graduation year(eg:2010) or leave it empty", "faculty")
			)
		)
	),

	//Research interests block
	'interest' => array(
	    "name" => __("Interests", "faculty"),
	    "base" => "vc_interest",
	    "as_parent" => array('only' => 'vc_interest_single'),
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "show_settings_on_create" => false,
	    "icon" => get_template_directory_uri()."/img/vc_icons/interest.png",
	    "params" => array(
	        array(
	          "type" => "textfield",
	          "heading" => __("Widget title", "faculty"),
	          "param_name" => "pos-widget_title",
	          "description" => __("Enter widget title", "faculty")
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => __("Extra class name", "faculty"),
	          "param_name" => "el_class",
	          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
	        )    
	    ),
	    "js_view" => 'VcColumnView'
	),

	'interest_single' => array(
	    "name" => __("Single interest", "faculty"),
	    "base" => "vc_interest_single",
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "as_child" => array('only' => 'vc_interest'), // Use only|except attributes to limit parent (separate multiple values with comma)
	    "icon" => get_template_directory_uri()."/img/vc_icons/interest.png",
	    "params" => array(
	        array(
		        "type" => "textfield",
		        "heading" => __("Research interest title", "faculty"),
		        "param_name" => "interest_title",
		        "value" => '',
		        "holder"=>'div',
		        "description" => __("Enter your field of interest in plain text or leave it blank and use HTML content below", "faculty")
	      	),
	     	array(
		        "type" => "textarea_html",
		        "holder" => "div",
		        "class" => "messagebox_text",
		        "heading" => __("HTML Content", "faculty"),
		        "param_name" => "content",
		        "value" => '',
		        "holder"=>'div',
		        "description" => __("This could be a short decription about the award in HTML mode", "faculty")
	     	),
    	)
	),

	//List icon block
	'licon' => array(
	    "name" => __("List with icons", "faculty"),
	    "base" => "vc_licon",
	    "as_parent" => array('only' => 'vc_licon_single'),
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "show_settings_on_create" => false,
	    "icon" => get_template_directory_uri()."/img/vc_icons/licon.png",
	    "params" => array(
	        array(
	          "type" => "textfield",
	          "heading" => __("Widget title", "faculty"),
	          "param_name" => "pos-widget_title",
	          "description" => __("Enter widget title", "faculty")
	        ),
	        array(
	          "type" => "textfield",
	          "heading" => __("Extra class name", "faculty"),
	          "param_name" => "el_class",
	          "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
	        )    
	    ),
	    "js_view" => 'VcColumnView'
	),
	'licon_single' => array(
	    "name" => __("Single icon with description", "faculty"),
	    "base" => "vc_licon_single",
	    "content_element" => true,
		"category" 		=> __("faculty", "faculty"),
	    "as_child" => array('only' => 'vc_licon'), // Use only|except attributes to limit parent (separate multiple values with comma)
	    "icon" => get_template_directory_uri()."/img/vc_icons/licon.png",
	    "params" => array(
			array(
				"type" => "textfield",
				"heading" => __("List description", "faculty"),
				"param_name" => "licon_des",
				"description" => __("Enter the description", "faculty"),
				"holder"	  => 'div',
				"description" => __("Simple content, You can leave this unchanged and put your content in HTML Content Box.", "faculty")
			),
			array(
				"type" => "textarea_html",
				"class" => "messagebox_text",
				"heading" => __("HTML Content", "faculty"),
				"param_name" => "content",
				"value" => '',
				"holder"	  => 'div',
				"description" => __("This could be a short decription in HTML mode", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon class", "faculty"),
				"param_name" => "licon_class",
				"description" => __("Enter the class of icon eg:fa-book ( see available class here :http://fontawesome.io/icons/)", "faculty")
			)
	    )
	),



	// Single fontawesome icon
	'single_icon' => array(
		"name" => __("Single fontawesome icon", "faculty"),
		"base" => "vc_single_icon",
		"icon" => get_template_directory_uri()."/img/vc_icons/single-image.png",
		"category" 		=> __("faculty", "faculty"),
		"description" => __('Simple fontawesome icon', "faculty"),
		"icon" => get_template_directory_uri()."/img/vc_icons/ficon.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Icon class", "faculty"),
				"param_name" => "icon_class",
				"description" => __("Enter the class of icon eg:fa-book ( see available class here :http://fontawesome.io/icons/)", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon font size", "faculty"),
				"param_name" => "icon_size",
				"description" => __("Enter the size of icon eg:20", "faculty")
			),
			array(
				"type" => "colorpicker",
				"heading" => __("Icon color", "faculty"),
				"param_name" => "icon_color",
				"description" => __("Select the color of icon", "faculty"),
				//"dependency" => Array('element' => "bgcolor", 'value' => array('custom'))
			),
			array(
				"type" => "dropdown",
				"heading" => __("Text align", "faculty"),
				"param_name" => "icon_align",
				"value" => array(__('Align center', "faculty") => "center", __('Align left', "faculty") => "left", __('Align right', "faculty") => "right"),
				"description" => __("Select text align.", "faculty")
			),
			array(
				"type" => "dropdown",
				"heading" => __("Icon display", "faculty"),
				"param_name" => "icon_display",
				"value" => array(__("inline", "faculty") => "inline", __("block", "faculty") => "block"), 
				"description" => __("Select type of display", "faculty"),
				"admin_label" => true
			)

		)
	),

	//Awards block
	'award' => array(
		"name" => __("Awards", "faculty"),
		"base" => "vc_award",
		"as_parent" => array('only' => 'vc_award_single'),
		"content_element" => true,
		"category" 		=> __("faculty", "faculty"),
		"show_settings_on_create" => false,
		"icon" => get_template_directory_uri()."/img/vc_icons/award.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Widget title", "faculty"),
				"param_name" => "pos-widget_title",
				"description" => __("Enter widget title", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "faculty"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
			)    
		),
		"js_view" => 'VcColumnView'
	),
	'award_single' => array(
		"name" => __("Single award", "faculty"),
		"base" => "vc_award_single",
		"content_element" => true,
		"category" 		=> __("faculty", "faculty"),
		"as_child" => array('only' => 'vc_award'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"icon" => get_template_directory_uri()."/img/vc_icons/award.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Award title", "faculty"),
				"param_name" => "award_title",
				"description" => __("Enter award title", "faculty"),
				"holder" => "div"
			),
			array(
				"type" => "textfield",
				"heading" => __("Award date", "faculty"),
				"param_name" => "award_date",
				"description" => __("Enter award date or period(eg:June 2011)", "faculty")
			),
			array(
				"type" => "textarea",
				"class" => "messagebox_text",
				"heading" => __("Text Content", "faculty"),
				"param_name" => "award_content",
				"value" => '',
				"description" => __("Simple content, You can leave this unchanged and put your content in HTML Content Box.", "faculty")
			),
			array(
				"type" => "textarea_html",
				"class" => "messagebox_text",
				"heading" => __("HTML Content", "faculty"),
				"param_name" => "content",
				"value" => '',
				"description" => __("This could be a short decription about the award in HTML mode", "faculty")
			),
			array(
				"type" => "attach_image",
				"heading" => __("Award image", "faculty"),
				"param_name" => "award_image",
				"value" => "",
				"description" => __("Select image from media library. ( Can be empty )", "faculty")
			)
		)
	),

	//Lab personnel carousel
	'lab' => array(
		"name" => __("Lab personnel carousel", "faculty"),
		"base" => "vc_lab",
		"as_parent" => array('only' => 'vc_lab_single'),
		"content_element" => true,
		"category" 		=> __("faculty", "faculty"),
		"show_settings_on_create" => false,
		"icon" => get_template_directory_uri()."/img/vc_icons/lab.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Widget title", "faculty"),
				"param_name" => "pos-widget_title",
				"description" => __("Enter widget title", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "faculty"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
			)    
		),
		"js_view" => 'VcColumnView'
	),
	
	'lab_single' => array(
		"name" => __("Single personnel", "faculty"),
		"base" => "vc_lab_single",
		"category" 		=> __("faculty", "faculty"),
		"content_element" => true,
		"as_child" => array('only' => 'vc_lab'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"icon" => get_template_directory_uri()."/img/vc_icons/lab.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Person name", "faculty"),
				"param_name" => "lab_name",
				"description" => __("Enter personnel name", "faculty"),
				"holder"	=> 'div'
			),
			array(
				"type" => "textfield",
				"heading" => __("Person position", "faculty"),
				"param_name" => "lab_pos",
				"description" => __("Enter personnel position", "faculty"),
				'holder'	=>'div'
			),
			array(
				"type" => "textarea",
				"heading" => __("Short Description", "faculty"),
				"param_name" => "lab_desc",
			),
			array(
				"type" => "textfield",
				"heading" => __("Person follow link", "faculty"),
				"param_name" => "lab_link",
				"description" => __("Enter personel follow link, <strong>leave this blank to disable hyperlink</strong>", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("follow button text", "faculty"),
				"param_name" => "lab_follow",
				"description" => __("Enter text for the follow button, leave blank and it will be Follow", "faculty")
			),
			array(
				"type" => "checkbox",
				"heading" => __("open in new tab?", "faculty"),
				"param_name" => "lab_link_external",
				"value"     => array(__("Yes, Please",'faculty') => 'yes')
			),
			array(
				"type" => "attach_image",
				"heading" => __("Person image", "faculty"),
				"param_name" => "lab_image",
				"value" => "",
				"description" => __("Select image from media library.", "faculty")
			)
		)
	),

	//Research project
	'project' => array(
		"name" => __("Reserach projects", "faculty"),
		"base" => "vc_project",
		"as_parent" => array('only' => 'vc_project_single'),
		"content_element" => true,
		"category" 		=> __("faculty", "faculty"),
		"show_settings_on_create" => false,
		"icon" => get_template_directory_uri()."/img/vc_icons/project.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Widget title", "faculty"),
				"param_name" => "pos-widget_title",
				"description" => __("Enter widget title", "faculty")
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "faculty"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
			)    
		),
		"js_view" => 'VcColumnView'
	),
	'project_single' => array(
		"name" => __("Single project", "faculty"),
		"base" => "vc_project_single",
		"category" 		=> __("faculty", "faculty"),
		"content_element" => true,
		"as_child" => array('only' => 'vc_project'), // Use only|except attributes to limit parent (separate multiple values with comma)
		"icon" => get_template_directory_uri()."/img/vc_icons/project.png",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Project title", "faculty"),
				"param_name" => "project_title",
				"description" => __("Enter the title of project", "faculty"),
				"holder"	  => 'strong'
			),
			array(
				"type" => "textfield",
				"heading" => __("Project short description", "faculty"),
				"param_name" => "project_short_description",
				"description" => __("Enter very short description of the project", "faculty"),
				"holder"	  => 'div'
			),
			array(
				"type" => "textarea_html",
				"class" => "messagebox_text",
				"heading" => __("Text", "faculty"),
				"param_name" => "content",
				"value" => __("<p>This could be a full decription about the project</p>", "faculty")
			),

			array(
				"type" => "attach_image",
				"heading" => __("Project image", "faculty"),
				"param_name" => "project_image",
				"value" => "",
				"description" => __("Select image from media library.", "faculty")
			)
		)
	),

	'publications' => array(
		"name" => __("Publications", "faculty"),
		"content_element" => true,
		"base" => "fac_publications",
		"category" 		=> __("faculty", "faculty"),
		"icon" => get_template_directory_uri()."/img/vc_icons/publication-icon.jpg",
		"params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Widget title", "faculty"),
				"param_name" => "widget_title",
				"description" => __("Enter widget title", "faculty")
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Publications', 'faculty' ),
				'param_name' => 'publication_ids',
				'description' => __( 'Add publications to the list by typing their title.', 'faculty' ),
				'settings' => array(
					'multiple' => true,
					'values' => fac_get_type_posts_data()
				),
			),
			array(
	            'type' => 'dropdown',
	            'heading' => __( 'Order by', 'faculty' ),
	            'param_name' => 'orderby',
	            'value' => array(
	            	__( 'Selected order above', 'faculty') => 'post__in',
	                __( 'Year', 'faculty' ) => 'year',
	                __( 'Default Order', 'faculty' ) => 'menu_order',
	            ),
	            'description' => __( 'Select order type.', 'faculty' ),
	         	'param_holder_class' => 'vc_grid-data-type-not-ids',
	            'std' => 'menu_order'
	        ),
	        array(
	            'type' => 'dropdown',
	            'heading' => __( 'Sort order', 'faculty' ),
	            'param_name' => 'order',
	            'value' => array(
	                __( 'Ascending', 'faculty' ) => 'ASC',
	                __( 'Descending', 'faculty' ) => 'DESC',
	            ),
	            'param_holder_class' => 'vc_grid-data-type-not-ids',
	            'description' => __( 'Select sorting order.', 'faculty' ),
	           	'std' => 'DESC',
	           	'dependency' => array(
                	'element' => 'orderby',
                	'value_not_equal_to' => array(
                    	'post__in', 'menu_order'
                	),
	            ),
	        ),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", "faculty"),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "faculty")
			)
		)
	)
);

if ( defined( 'WPB_VC_VERSION' ) ) {
	//declare parrent elements
	class WPBakeryShortCode_Vc_wrapper extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_position extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_education extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_award extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_lab extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_interest extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_project extends WPBakeryShortCodesContainer {}
	class WPBakeryShortCode_Vc_licon extends WPBakeryShortCodesContainer {}

	//Specific outputs

	class WPBakeryShortCode_Vc_project_single extends WPBakeryShortCode {
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}

	}


	class WPBakeryShortCode_Vc_lab_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}


	class WPBakeryShortCode_Vc_interest_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}

	class WPBakeryShortCode_Vc_position_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}
	class WPBakeryShortCode_Vc_education_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}

	class WPBakeryShortCode_Vc_award_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}

	class WPBakeryShortCode_Vc_licon_single extends WPBakeryShortCode {
		
		protected function outputTitle( $title ) {
			$icon = $this->settings('icon');
			if( filter_var( $icon, FILTER_VALIDATE_URL ) ) $icon = '';
            return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span> </h4>';
		}


	}

	//Remove VC elements
	vc_remove_element('vc_images_carousel');
	vc_remove_element('vc_flickr');
	vc_remove_element('vc_carousel');
	vc_remove_element('vc_posts_slider');


	// add academic icons 
	vc_add_param(
		'vc_icon',
		array(
			'type' => 'iconpicker',
			'heading' => __( 'Icon', 'js_composer' ),
			'param_name' => 'icon_owlacademics',
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'owlacademics',
				'iconsPerPage' => 1000,
			),
			'dependency' => array(
				'element' => 'type',
				'value' => 'owlacademics',
			),
			'description' => __( 'Select icon from library.', 'js_composer' ),
			"weight" => 1
		)
	);


	add_action( 'vc_after_init', 'owl_add_dropdown_to_vc_icons' ); 
	function owl_add_dropdown_to_vc_icons() {
		//Get current values stored in the color param in "Call to Action" element
		$param = WPBMap::getParam( 'vc_icon', 'type' );
		//Append new value to the 'value' array
		$param['value'][__( 'Academic Icons', 'faculty' )] = 'owlacademics';
		//Finally "mutate" param with new values
		vc_update_shortcode_param( 'vc_icon', $param );
	}

	add_filter( 'vc_iconpicker-type-owlacademics', 'vc_iconpicker_type_owlacademics' );
	function vc_iconpicker_type_owlacademics( $icons ){
		
		$owlacademics = array(
			array( 'ai ai-google-scholar' => 'Google Scholar' ),
			array( 'ai ai-google-scholar-square' => 'Google Scholar (square)' ),
			array( 'ai ai-researchgate' => 'ResearchGate' ),
			array( 'ai ai-researchgate-square' => 'ResearchGate (square)' ),
			array( 'ai ai-mendeley' => 'Mendeley ' ),
			array( 'ai ai-mendeley-square' => 'Mendeley (square)' ),
			array( 'ai ai-orcid' => 'orcid' ),
			array( 'ai ai-orcid-square' => 'orcid (square)' ),
			array( 'ai ai-impactstory' => 'impactstory' ),
			array( 'ai ai-impactstory-square' => 'impactstory (square)' ),
			array( 'ai ai-academia' => 'academia' ),
			array( 'ai ai-academia-square' => 'academia (square)' ),
			array( 'ai ai-zotero' => 'zotero' ),
			array( 'ai ai-zotero-square' => 'zotero (square)' ),
			array( 'ai ai-figshare' => 'figshare' ),
			array( 'ai ai-figshare-square' => 'figshare (square)' ),
			array( 'ai ai-dryad' => 'dryad' ),
			array( 'ai ai-dryad-square' => 'dryad (square)' ),
			array( 'ai ai-arxiv' => 'arxiv' ),
			array( 'ai ai-arxiv-square' => 'arxiv (square)' ),
			array( 'ai ai-scirate' => 'scirate' ),
			array( 'ai ai-scirate-square' => 'scirate (square)' ),
			array( 'ai ai-open-access' => 'open access' ),
			array( 'ai ai-open-access-square' => 'open access (square)' )
		);
		return array_merge( $icons, $owlacademics );
	}

	add_action( 'vc_enqueue_font_icon_element', 'owl_add_owlacademics_enqueue', 10 , 1 ); 
	function owl_add_owlacademics_enqueue($font) {
		if ($font == 'owlacademics')
			wp_enqueue_style( 'owl_acadmicons' );
	}

	add_action( 'vc_base_register_front_css', 'owl_register_academicicons' );
	add_action( 'vc_base_register_admin_css', 'owl_register_academicicons' );
	add_action( 'vc_backend_editor_enqueue_js_css', 'owl_enqueue_academicicons' );
	add_action( 'vc_frontend_editor_enqueue_js_css', 'owl_enqueue_academicicons' );
	function owl_register_academicicons(){
		wp_register_style( 'owl_acadmicons', get_template_directory_uri() . '/css/academicons.css', array(), '1.6.0');
	}
	function owl_enqueue_academicicons(){
		wp_enqueue_style( 'owl_acadmicons' );
	}


}
// Finally initialize code
if ( defined( 'WPB_VC_VERSION' ) ) {
	new Owlab_vc_extend($shortcodes);
}

/**
* get posts from a post type
*/
function fac_get_type_posts_data( $post_type = 'publications' ) {
	
	$posts = get_posts( array(
		'posts_per_page' 	=> -1,
		'post_type'			=> $post_type,
	));
	$result = array();
	foreach ( $posts as $post )	{
		$result[] = array(
			'value' => $post->ID,
			'label' => $post->post_title,
		);
	}
	return $result;
}


	


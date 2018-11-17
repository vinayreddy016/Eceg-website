<?php
/**
 *  adds required metaboxes using optiontree
 * 
 * @package Faculty
 * @author owwwlab
 */

/**
 * Initialize the custom Meta Boxes. 
 */
add_action( 'admin_init', 'fac_publications_meta_boxes' );



if ( ! function_exists('fac_publications_meta_boxes'))
{

	function fac_publications_meta_boxes() {
	  
	  $year_span = absInt(date("Y"))+2;
	  $prefix = "fac_pub_";
	  /**
	   * Create a custom meta boxes array that we pass to 
	   * the OptionTree Meta Box API Class.
	   */
	  $my_meta_box = array(
			'id'          => 'pub_meta_box',
			'title'       => __( 'Publication Meta Box', 'faculty' ),
			'desc'        => '',
			'pages'       => array( 'publications' ),
			'context'     => 'normal',
			'priority'    => 'high',
			'fields'      => array(
				
				array(
					'label'	=> __('Publication Title','faculty'),
					'desc'	=> __('Title of the Publication','faculty'),
					'id'          => $prefix.'title',
					'type'        => 'text',
					'std'         => '',
				),
				array(
					'label'	=> __('Publication Year','faculty'),
					'desc'	=> __('Year of the Publication, For example: <code>2016</code>, This field is also used for sorting purpose.','faculty'),
					'id'	=> $prefix.'year',
					'type'	=> 'numeric-slider',
					'min_max_step'=> '1950,'. $year_span .',1',
					'std'   => date('Y')
				),
				array(
					'label'	=> __('Authors','faculty'),
					'desc'	=> __('List of authors , For example:<code>Jennifer Doe, Emily N. Garbinsky, Kathleen D. Vohs</code>','faculty'),
					'id'	=> $prefix.'authors',
					'type'	=> 'text',
					'std'         => '',
				),
				array(
					'label'	=> __('Citation','faculty'),
					'desc'	=> __('For example: <code>Journal of Consumer Psychology, Volume 22, Issue 2, Pages 191-194</code>','faculty'),
					'id'	=> $prefix.'cit',
					'type'	=> 'text',
					'std'         => '',
				),
				array(
					'label'	=> __('External Link','faculty'),
					'desc'	=> __('Link to publishe website','faculty'),
					'id'	=> $prefix.'ext_link',
					'type'	=> 'text'
				),
				array(
					'label'	=> __('Downloadable File','faculty'),
					'desc'	=> __('Document file (pdf,doc)','faculty'),
					'id'	=> $prefix.'docfile',
					'type'	=> 'upload'
				)

			)
	  );
	  
	  /**
	   * Register our meta boxes using the 
	   * ot_register_meta_box() function.
	   */
	  if ( function_exists( 'ot_register_meta_box' ) )
		ot_register_meta_box( $my_meta_box );

	}

}





if ( ! function_exists("fac_change_optiontree_upload_text")){
	function fac_change_optiontree_upload_text( $example ) {
		// Maybe modify $example in some way.
		return __( 'Set File', 'faculty' );
	}
}
add_filter( 'ot_upload_text', 'fac_change_optiontree_upload_text' );
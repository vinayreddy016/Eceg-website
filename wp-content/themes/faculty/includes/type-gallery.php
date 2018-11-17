<?php 
add_action('init', 'gallery_register');

function gallery_register(){
	$gallery_labels = array(
	    'name' 					=> __('Gallery','faculty'),
	    'singular_name' 		=> __('Gallery','faculty'),
	    'add_new' 				=> __('Add New','faculty'),
	    'add_new_item' 			=> __("Add New Gallery",'faculty'),
	    'edit_item' 			=> __("Edit Gallery",'faculty'),
	    'new_item' 				=> __("New Gallery",'faculty'),
	    'view_item' 			=> __("View Gallery",'faculty'),
	    'search_items' 			=> __("Search Gallery",'faculty'),
	    'not_found' 			=> __( 'No galleries found','faculty'),
	    'not_found_in_trash' 	=> __('No galleries found in Trash','faculty'), 
	    'parent_item_colon' 	=> ''
	);
	$gallery_args = array(
	    'labels' 				=> $gallery_labels,
	    'public' 				=> true,
	    'publicly_queryable' 	=> true,
	    'show_ui' 				=> true, 
	    'query_var' 			=> true,
	    'rewrite' 				=> true,
	    'hierarchical' 			=> false,
	    'menu_position' 		=> null,
	    'capability_type' 		=> 'post',
	    'supports' 				=> array('title', 'excerpt', 'thumbnail'),
	    'menu_icon' 			=> 'dashicons-format-gallery'
	); 
	register_post_type('gallery', $gallery_args);
	flush_rewrite_rules( false );
};

//----------------------------------------------
//--------------------------admin custom columns
//----------------------------------------------
//admin_init
add_action('manage_posts_custom_column', 'jss_custom_columns');
add_filter('manage_edit-gallery_columns', 'jss_add_new_gallery_columns');
 
function jss_add_new_gallery_columns( $columns ){
    $columns['jss_post_thumb'] = __('Thumbnail','faculty'); 
    return $columns;
}
 
function jss_custom_columns( $column ){
    global $post;
 	   
    switch ($column) {
        case 'jss_post_thumb' : echo the_post_thumbnail('admin-gallery-thumb'); break;
    }
}
 
// //add thumbnail images to column
// //add_filter('manage_posts_columns', 'jss_add_post_thumbnail_column', 4);
// //add_filter('manage_pages_columns', 'jss_add_post_thumbnail_column', 4);
// add_filter('manage_gallery_columns', 'jss_add_post_thumbnail_column', 4);
 
// // Add the column
// function jss_add_post_thumbnail_column($cols){
//     $cols['jss_post_thumb'] = __('Thumbnail', 'faculty');
//     return $cols;
// }
 
// function jss_display_post_thumbnail_column($col, $id){
//   switch($col){
//     case 'jss_post_thumb':
//       if( function_exists('the_post_thumbnail') )
//         echo the_post_thumbnail( 'admin-gallery-thumb' );
//       else
//         echo 'Not supported in this theme';
//       break;
//   }
// }


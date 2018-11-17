<?php
/**
 * @package WordPress
 * @subpackage faculty
 */

define ('THEME_VERSION', wp_get_theme()->get( 'Version' ));
define( 'FAC_THEMEROOT', get_template_directory_uri() );
define( 'FAC_CSS', FAC_THEMEROOT . '/css' );
define( 'FAC_IMAGES', FAC_THEMEROOT . '/img' );
define( 'FAC_SCRIPTS', FAC_THEMEROOT . '/js' );

/**
 * Required: include OptionTree.
 */
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
load_template( trailingslashit( get_template_directory() ) . 'option-tree/ot-loader.php' );
load_template( trailingslashit( get_template_directory() ) . 'includes/theme-options.php' );


/*
* Include custom page types (CPTs)
*/
require_once( get_template_directory().'/includes/type-gallery.php');
require_once( get_template_directory().'/includes/type-publications.php');
locate_template( array( 'includes/type-publications-metabox.php' ), true, true );


/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'faculty', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 900;


/**
 * Enqueue the Google fonts.
 */
function fac_google_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'faculty-lato', "$protocol://fonts.googleapis.com/css?family=Lato:100,300,400,700,100italic,300italic,400italic" );
}
add_action( 'wp_enqueue_scripts', 'fac_google_fonts' );



/**
* Enqueue scripts and styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action('wp_enqueue_scripts', 'faculty_add_scripts');
function faculty_add_scripts() {
    
    wp_enqueue_script( 'jquery' );

    //add modernizr
	wp_enqueue_script( 'modernizer', get_template_directory_uri() . '/js/modernizr.custom.63321.js');

    //add bootstrap.min.js
	wp_enqueue_script( 'bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add mouswheel plugin
	wp_enqueue_script( 'mouswheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ),THEME_VERSION,true );

	//add carouFredSel
	wp_enqueue_script( 'carouFredSel', get_template_directory_uri() . '/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ),THEME_VERSION,true );

	//add dropdown plugin
	wp_enqueue_script( 'dropdown', get_template_directory_uri() . '/js/jquery.dropdownit.js', array( 'jquery' ),THEME_VERSION,true );

	//add mixitup plugin
	wp_enqueue_script( 'mixitup', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add touchSwip plugin
	wp_enqueue_script( 'touchSwip', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),THEME_VERSION,true );

	//add magnific-popup
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array( 'jquery' ),THEME_VERSION,true );

	//add masonry
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.min.js','',THEME_VERSION,true);

	
	//add scrollTo
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/js/ScrollToPlugin.min.js', array('jquery'),THEME_VERSION,true);

	//add tweenmax
	wp_enqueue_script( 'tweenmax', get_template_directory_uri() . '/js/TweenMax.min.js','',THEME_VERSION,true);

	//add imagesLoaded
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js','',THEME_VERSION,true);

	//Nice scroll
	wp_enqueue_script( 'nice-scroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js',array( 'jquery' ),THEME_VERSION,true);

	//lab carousle plugin
	wp_enqueue_script( 'owlab-lab-carousel', get_template_directory_uri() . '/js/owwwlab-lab-carousel.js',array( 'jquery','carouFredSel' ),THEME_VERSION,true);

	// comments
	wp_enqueue_script( 'comment-reply' );



}


// include last bits
function owlab_latest_enqueue() {

	wp_deregister_script( 'waypoints' );
	wp_dequeue_script('waypoints');
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), THEME_VERSION, true );
	wp_enqueue_script( "waypoints" );

	//load visual composer main js file
	wp_enqueue_script( "wpb_composer_front_js" );

	//after that load custom js
	wp_enqueue_script( 'faculty-script', get_template_directory_uri() . '/js/custom.js', array( 'jquery','waypoints' ),THEME_VERSION,true );


}
add_action("wp_enqueue_scripts", "owlab_latest_enqueue", 10000);



/**
* Inject custome script
* @since v1.1.0
*/
function fac_custom_js() {

    $script =
		'var siteUrl = "'.home_url().'/";';
	if (is_singular())
	{
		$script .= ' var isSingle = true;';
		$script .= ' var blogUrl = "'.home_url().'/blog/";';
	}

	if ( function_exists( 'ot_get_option' ) ){

		$script .= ' var perfectScroll = "'.ot_get_option('no_perfect_scroll','off').'";';

		$script .= ' var blogAjaxState = "'.ot_get_option('blog_ajax','off').'";';


		if (ot_get_option('pub_filter_preset','')=='')
			$pubfilter = "false";
		else
			$pubfilter = ot_get_option('pub_filter_preset','');
		$script .= ' window.pubsFilter = "'.$pubfilter.'";';


		$is_paginated = ot_get_option('fac_paginate_pubs','off');
		if ( $is_paginated == 'on' )
			$script .= ' var pubsMix=false;';
		else
			$script .= ' var pubsMix=true;';

		if ( is_tax('pubtype') || $is_paginated == 'on')
		{
			$script .= ' window.filteringFlag=false;';
		}else{
			$script .= ' window.filteringFlag=true;';
		}

		if (is_tax('pubtype')){
			$q_object = get_queried_object();
			$script .= ' window.pubsFilter = "'.$q_object->slug.'";';
		}

	}

    echo '<script type="text/javascript">'.$script.'</script>';
}
add_action('wp_head', 'fac_custom_js');


/**
* Inject custome styles
* @since v1.1.0
*/
function fac_custom_css() {

   	if ( ! function_exists( 'ot_get_option' ) )
		return;

	$styles='';
	if (ot_get_option('no_perfect_scroll','off')=='off'){
		$styles.='
		#blog-content,
		#archive-content,
		.fac-page,.home{
			overflow:auto;
			overflow-x:hidden;
		}';
	}
	if (ot_get_option('circle_around_logo','on')=='off'){
		$styles .= '
		#profile .portrate img{
			border-radius : inherit;
			-webkit-border-radius: inherit;
			-moz-border-radius: inherit;
		}
		';
	}
	$styles .= '
	ul#navigation > li.external:hover a .fa,
	ul#navigation > li.current-menu-item > a .fa,
	ul#navigation > li.current-menu-parent > a .fa,
	.cd-active.cd-dropdown > span
	{
		color:'. ot_get_option( 'c_main_color','#03cc85' ).';
	}
	ul.ul-dates div.dates span,
	ul.ul-card li .dy .degree,
	ul.timeline li .date,
	#labp-heads-wrap,
	.labp-heads-wrap,
	.ul-withdetails li .imageoverlay,
	.cd-active.cd-dropdown ul li span:hover,
	.pubmain .pubassets a.pubcollapse,
	.pitems .pubmain .pubassets a:hover,
	.pitems .pubmain .pubassets a:focus,
	.pitems .pubmain .pubassets a.pubcollapse,
	.commentlist .reply
	{
		background-color: '. ot_get_option( 'c_main_color','#03cc85' ).';
	}
	.ul-boxed li,
	ul.timeline li .data,.widget ul li,
	.fac-pagination{
		border-left-color:'. ot_get_option( 'c_main_color','#03cc85' ).';
	}
	#labp-heads-wrap:after{
		border-top-color: '. ot_get_option( 'c_main_color','#03cc85' ).';
	}
	ul.ul-dates div.dates span:last-child,
	ul.ul-card li .dy .year,
	ul.timeline li.open .circle{
		background-color: '. ot_get_option( 'c_darker_color', '#03bb7a' ).';
	}
	ul.timeline li.open .data {
		border-left-color: '. ot_get_option( 'c_darker_color', '#03bb7a' ).';
	}
	.pitems .pubmain .pubassets {
		border-top-color: '. ot_get_option( 'c_darker_color', '#03bb7a' ).';
	}
	a{
		color: '. ot_get_option( 'c_link_color', '#428bca' ).';
	}
	a:hover, a:focus{
		color: '. ot_get_option( 'c_link_hover_color', '#2a6496' ).';
	}
	ul#navigation > li:hover,
	ul#navigation > li:focus,
	ul#navigation > li.current-menu-item,
	ul#navigation > li.current-menu-parent {
		background-color: '. ot_get_option('menuhover', '#363636').';
		border-top: 1px solid '. ot_get_option('c_menu_item_bt', '#373737').';
		border-bottom: 1px solid '. ot_get_option('c_menu_item_bb', '#2B2B2B').';
	}

	ul#navigation > li {
		background-color: '. ot_get_option('c_menu_item_bg','#303030').';
		border-top: 1px solid '. ot_get_option('c_menu_item_bt', '#373737').';
		border-bottom: 1px solid '. ot_get_option('c_menu_item_bb', '#2B2B2B').';
	}



	.fac-page #inside >.wpb_row:first-child:before {
		border-top-color: '. ot_get_option('c_head_row', '#f3f3f3').';
	}
	.fac-page #inside >.wpb_row:nth-child(odd),
	.fac-page .section:nth-child(odd){
		background-color: '. ot_get_option('c_odd',  '#f7f7f7').';
	}
	.fac-page #inside >.wpb_row:nth-child(even),
	.fac-page .section:nth-child(even){
		background-color: '. ot_get_option('c_even', '#fcfcfc').';
	}
	.fac-page #inside >.wpb_row:first-child,
	.pageheader {
		background-color: '. ot_get_option('c_head_row', '#f3f3f3').';
	}
	.fac-page #inside >.wpb_row:first-child:before,
	.pageheader:after {
		border-top-color: '. ot_get_option('c_head_row', '#f3f3f3').';
	}

	#sidebar,
	ul#navigation .sub-menu {
		background-color: '. ot_get_option('c_side_back', '#2b2b2b').';
	}

	#sidebar-footer{
		background-color: '. ot_get_option('c_side_footer_back', '#202020').';
		}

	#gallery-header{
		background-color: '. ot_get_option('c_gal_head', '#2c2c2d').';
	}
	#gallery-large{
		background-color: '. ot_get_option('c_gal_body', '#303030').';
	}
	ul.ul-card li,
	ul.timeline li .data,
	.ul-boxed li,
	.ul-withdetails li,
	.pitems .pubmain,
	.commentlist li{
		background-color: '. ot_get_option('c_box_bg', '#f5f5f5').';
	}

	ul.timeline li.open .data,
	.ul-withdetails li .details,
	#lab-details,
	.pitems .pubdetails,
	.commentlist .comment-author-admin{
		background-color: '. ot_get_option('c_box_bg_alt', '#fff').';
	}
	a#hideshow,#hideshow i{
		color: '. ot_get_option('c_blog_hs','#FFED52').';
	}
	.archive-header{
		background-color: '. ot_get_option('c_blog_list_head','#2b2b2b').';
		color: '. ot_get_option('c_blog_list_head_text','').';
	}

	#profile .title h2{
		font-size: '. ot_get_option('t_sidebar_title','28').'px;
	}
	#profile .title h3{';
	$h3 = ot_get_option('t_sidebar_title','28')-10;

	$styles .= '
		font-size: '. $h3.'px;
	}
	ul#navigation > li > a{
		font-size: '. ot_get_option('t_menu','14').'px;
	}
	body{
		font-size: '. ot_get_option('t_global','16').'px;
	}
	.fac-big-title{
		font-size: '. ot_get_option('t_big_title','50') .'px;
	}
	.headercontent .title{
		font-size: '. ot_get_option('t_blog_title_size','50') .'px;
	}
	.fac-title, .fac-big-title, .headercontent .title{
		color: '.ot_get_option('c_headings_color','#333333').';
	}
	';
    echo '<style id="fac_custom_options">'.$styles.'</style>';

    $custom_css = ot_get_option('fac_custom_css','');
   	if ( $custom_css != '') {
        echo '<style id="fac_custom_css">'.$custom_css.'</style>';   
    }
    

}
add_action('wp_head', 'fac_custom_css');




/**
* Inject analytics
* @since v1.1.0
*/
function fac_analytics() {
	if ( function_exists( 'ot_get_option' ) ){
		echo ot_get_option( 'etc_analytics_code','' );
	}
}
add_action('wp_head', 'fac_analytics');




/**
* Inject facicon
* @since v1.1.0
*/
function fac_favicon() {
	if ( function_exists( 'ot_get_option' ) ){
		$favicon = '<link rel="icon" type="image/png" href="'. ot_get_option('etc_fav_icon','').'">';
		echo $favicon;
	}
}
add_action('wp_head', 'fac_favicon');



/**
* IE fixes
* @since v 1.1.0
*/
function fac_inject_ie(){

	echo '
	<!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	';
}
add_action( 'wp_head','fac_inject_ie' );




/**
* Enqueue styles for the front end.
* @since Faculty 1.0
* @return void
*/
add_action( 'wp_enqueue_scripts', 'faculty_add_styles' );

function faculty_add_styles() {

	// Add Bootstrap styles
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css', array());

	// Add Font-awesome
	// since v2.3 this is handled via separate function

	// Add magnific-pupup
	wp_enqueue_style( 'magnific-pupup', get_template_directory_uri() . '/css/magnific-popup.css', array() );

	// Add scroll bar
	//wp_enqueue_style( 'perfect-scroll-style', get_template_directory_uri() . '/css/perfect-scrollbar-0.4.5.min.css', array() );

	// Add faculty specific
	wp_enqueue_style( 'faculty-styles', get_template_directory_uri() . '/css/style.css', array('bootstrap-style'),THEME_VERSION,false);

	// Add faculty specific
	wp_enqueue_style( 'faculty-custom-style', get_template_directory_uri() . '/css/styles/default.css', array('bootstrap-style'));

	// Add academicons
	wp_enqueue_style( 'owl_acadmicons', get_template_directory_uri() . '/css/academicons.css', array(), '1.6.0');

    // added since 1.5.1
    wp_enqueue_style( 'xr-styles', get_stylesheet_directory_uri() . '/style.css');
}


// if some third party has loaded the font-awesome we don't need it
// since v2.3
add_action('wp_enqueue_scripts', 'fac_check_font_awesome', 99999);

function fac_check_font_awesome() {
  global $wp_styles;
  $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
  if ( in_array('font-awesome.css', $srcs) || in_array('font-awesome.min.css', $srcs)  ) {
    /* echo 'font-awesome.css registered'; */
  } else {
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
  }
}


/**
 * Remove code from the <head>
 */
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
//remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.



// Hide the version of WordPress you're running from source and RSS feed
// Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
function hcwp_remove_version() {return '';}
add_filter('the_generator', 'hcwp_remove_version');



/**
 * This theme uses wp_nav_menus() for the sidebar
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu( 'sidemenu', 'Main Menu' );
}


/**
 * Register our sidebars and widgetized areas.
 *
 */
function fac_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Faculty Sidebar','faculty' ),
		'id' => 'right_side_1',
		'before_widget' => '<div class="widget widget-side">',
		'after_widget' => '</div></div>',
		'before_title' => '<h2 class="title">',
		'after_title' => '</h2><div class="widget-contents">',
		'description'  => __( 'Widgets in this area will be shown on the right-hand side if you select "Page builder with sidebar" template.','faculty' ),
	) );

	register_sidebar( array(
		'name' => __( 'Faculty footer of sidebar','faculty' ),
		'id' => 'footer_of_sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h5 class="title">',
		'after_title' => '</h5>',
		'description'  => __( 'Put just a tiny widget here like your language switcher.','faculty' ),
	) );

	/**
	 * add dynamic sidebars
	 * added from v3.0
	 */
	if (ot_get_option('incr_sidebars')){
	    $pp_sidebars = ot_get_option('incr_sidebars');
	    foreach ($pp_sidebars as $pp_sidebar) {

	        register_sidebar(array(
	            'name' => $pp_sidebar["title"],
	            'id' => $pp_sidebar["id"],
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
	            'after_widget' => '</div></div>',
	            'before_title' => '<h3 class="title">',
	            'after_title' => '</h3><div class="widget-contents">',
	        ));
	    }
	}

}
add_action( 'widgets_init', 'fac_widgets_init' );




/**
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
	add_theme_support( 'automatic-feed-links' );
}


/**
 * This theme uses post thumbnails
 */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'admin-gallery-thumb', 80, 80, true); //admin thumbnail
}


/**
 * Add default posts and comments RSS feed links to head
 */
if ( function_exists( 'add_theme_support')){
    add_theme_support( 'post-thumbnails' );
}

/**
 * Let wordpress handle titles with fallback
 */
add_theme_support( 'title-tag' );

if ( ! function_exists( '_wp_render_title_tag' ) ) 
{
	function fac_slug_render_title() {
		echo "<title>". wp_title( '|', true, 'right' ) ."</title>";
	}
	add_action( 'wp_head', 'fac_slug_render_title' );
}



/*
* This theme uses custom excerpt lenght
*/
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );





/*
* Utility functions
*/
function fac_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">

		<div class="comment-avatar">
			<img src="<?php echo fac_get_avatar_url(get_avatar( $comment, 60 )); ?>" class="authorimage" />
		</div>

		<div class="commenttext">

			<?php printf(__('<cite class="fn">%s</cite>','faculty'), get_comment_author_link()) ?>

			<?php if ($comment->comment_approved == '0') : ?>
			     <br />
			     <em><?php _e('Your comment is awaiting moderation.','faculty') ?></em>
			     <br />
			<?php endif; ?>

			<div class="comment-meta commentmetadata pull-right">
				<?php printf(__('%1$s at %2$s','faculty'), get_comment_date(),  get_comment_time()) ?>
			</div>

			<?php comment_text() ?>

			<?php if ( comments_open() ) : ?>
			<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<?php endif; ?>

		</div>
    </div>
    </li>
	<?php
}

function fac_get_avatar_url($get_avatar){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}



add_action('comment_post', 'fac_ajaxify_comments',20, 2);
function fac_ajaxify_comments($comment_ID, $comment_status){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    	//If AJAX Request Then
        switch($comment_status){
                case '0':
                        //notify moderator of unapproved comment
                        wp_notify_moderator($comment_ID);
                case '1': //Approved comment
                        echo "success";
                        $commentdata=&get_comment($comment_ID, ARRAY_A);
                        $post=&get_post($commentdata['comment_post_ID']);
                        wp_notify_postauthor($comment_ID);
                break;
                default:
                        echo "error";
        }
        exit;
    }
}

/**
 * Include Google fonts
 * added from v3.1.4
 */
if ( !function_exists('faculty_google_fonts_into_head')){

	function faculty_google_fonts_into_head(){

		$body_font_face = ot_get_option('faculty_body_font','Lato');
		if ($body_font_face != 'none'){
			$body_font_face = str_replace('+', ' ', $body_font_face);
			echo "<link href='http://fonts.googleapis.com/css?family=$body_font_face:100,200,300,400,600,700,900,b&subset=latin-ext,greek-ext' rel='stylesheet' type='text/css'>";
			echo "<style>
				body
				{font-family:$body_font_face;}
			</style>";
		}

		$heading_font_face = ot_get_option('faculty_headings_font','Lato');
		if ( $heading_font_face !='none'){
			$heading_font_face = str_replace('+', ' ', $heading_font_face);
			echo "<link href='http://fonts.googleapis.com/css?family=$heading_font_face:100,200,300,400,600,700,900,b&subset=latin-ext,greek-ext' rel='stylesheet' type='text/css'>";
			echo "<style>
				h1,h2,h3,h4,h5,h6,
				fac-page h2.title
				{font-family:$heading_font_face;}
			</style>";
		}

	}

	add_action( 'wp_head', 'faculty_google_fonts_into_head' );
}






/**
 * Include the TGM_Plugin.
 * added from v3.0
 */
require_once  get_template_directory(). '/tgm/faculty.php';



/**
 * Include the Visual Composer extension.
 * added from v3.0
 * Note: You need to update your vc plugin to v4 to avoid errors
 */
require_once  get_template_directory(). '/includes/functions-vc.php';

/**
 * Set Visual Composer as theme usage avoiding TGM update nag
 */
if ( function_exists('vc_set_as_theme') )
{
	vc_set_as_theme();
}


if ( !function_exists( 'get_the_archive_title' )){

	function get_the_archive_title() {
		if ( is_category() ) {
			$title = sprintf( __( 'Category: %s','faculty' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( __( 'Tag: %s','faculty' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( __( 'Author: %s','faculty' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( __( 'Year: %s','faculty' ), get_the_date( _x( 'Y', 'yearly archives date format','faculty' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( __( 'Month: %s','faculty' ), get_the_date( _x( 'F Y', 'monthly archives date format','faculty' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( __( 'Day: %s','faculty' ), get_the_date( _x( 'F j, Y', 'daily archives date format','faculty' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title','faculty' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title','faculty' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( __( 'Archives: %s','faculty' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( '%1$s: %2$s' , $tax->labels->singular_name, single_term_title( '', false ) );
		} else {
			$title = __( 'Archives' ,'faculty');
		}


		return $title;
	}
}




/**
 * ----------------------------------------------------------------------------------------
 * main menu walker
 * ----------------------------------------------------------------------------------------
 */	
class Fac_Walker extends Walker_Nav_Menu {
 
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "<span class=\"submenu-trigger\"></span>\n$indent<ul class=\"sub-menu\">\n";
    }
}



/**
 * ----------------------------------------------------------------------------------------
 * add post type archives to menu selection
 * from: http://stackoverflow.com/questions/20879401/how-to-add-custom-post-type-archive-to-men
 * ----------------------------------------------------------------------------------------
 */
add_action('admin_head-nav-menus.php', 'faculty_add_metabox_menu_posttype_archive');

function faculty_add_metabox_menu_posttype_archive() {
	add_meta_box('faculty-metabox-nav-menu-posttype', __('Post type Archives','faculty'), 'faculty_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}

function faculty_metabox_menu_posttype_archive() {
	$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

	if ($post_types) :
	    $items = array();
	    $loop_index = 999999;

	    foreach ($post_types as $post_type) {
	        $item = new stdClass();
	        $loop_index++;

	        $item->object_id = $loop_index;
	        $item->db_id = 0;
	        $item->object = 'post_type_' . $post_type->query_var;
	        $item->menu_item_parent = 0;
	        $item->type = 'custom';
	        $item->title = $post_type->labels->name;
	        $item->url = get_post_type_archive_link($post_type->query_var);
	        $item->target = '';
	        $item->attr_title = '';
	        $item->classes = array();
	        $item->xfn = '';

	        $items[] = $item;
	    }

	    $walker = new Walker_Nav_Menu_Checklist(array());

	    echo '<div id="posttype-archive" class="posttypediv">';
	    echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
	    echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
	    echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
	    echo '</ul>';
	    echo '</div>';
	    echo '</div>';

	    echo '<p class="button-controls">';
	    echo '<span class="add-to-menu">';
	    echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'faculty') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
	    echo '<span class="spinner"></span>';
	    echo '</span>';
	    echo '</p>';

	endif;
}

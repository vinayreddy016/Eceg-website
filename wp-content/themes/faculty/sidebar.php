<a href="#sidebar" class="mobilemenu"><i class="fa fa-bars"></i></a>

<?php 
    $bg_image = ot_get_option('fac_side_bg',''); 
    $styles = "";
    $header_class = "";
    if ( '' != $bg_image ){
        $styles = "background-image:url(".$bg_image.");";
        $header_class = "has-bg";
    }
?>
<div id="sidebar" class="<?php echo $header_class; ?>" style="<?php echo $styles; ?>">
    <div id="sidebar-wrapper">
        <div id="sidebar-inner">
          <!-- Profile/logo section-->
          <div id="profile" class="clearfix">
              <div class="portrate">
                <a href="<?php echo get_home_url();?>">
                  <img src="<?php echo ot_get_option('personal_photo',FAC_IMAGES.'/user.png') ?>" alt="<?php echo ot_get_option( 'person_name' ,__('Your Name','faculty')); ?>">
                </a>
              </div>
              <div class="title">
                  <h2><?php echo ot_get_option( 'person_name', __('Your Name','faculty')); ?></h2>
                  <h3><?php echo ot_get_option( 'sub_title', __('Your Affiliation','faculty') ); ?></h3>
              </div>   
          </div>
          <!-- /Profile/logo section-->

          <!-- Main navigation-->
          <div id="main-nav">

              <?php  
              if ( has_nav_menu( 'sidemenu' ) ) {
                wp_nav_menu( array(
                  'theme_location' => 'sidemenu',
                  'menu' => '',
                  'container' => false,
                  'menu_class' => false,
                  'items_wrap' => '<ul id = "navigation" class = "%2$s">%3$s</ul>',
                  'depth' => 0,
                  'walker' => new Fac_Walker
                ) ); 
              }
              ?>
          </div>
          <!-- /Main navigation-->

          <!--Sidebar footer-->
           <?php get_template_part( 'side-footer' ); ?>
           <!--Sidebar footer-->
        </div>

    </div>
        

          

</div>

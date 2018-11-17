<!-- Sidebar footer -->
<?php if (ot_get_option( 'side_footer' ,'on')=='on'): ?>
<div id="sidebar-footer">
    <div class="social-icons">
        <ul>
            <?php if (ot_get_option( 'si_email' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_email_address' ,''); ?>"><i class="fa fa-envelope-o"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_facebook','off' )=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_facebook_url' ,''); ?>"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_twitter' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_twitter_url' ,''); ?>"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_gplus' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_gplus_url' ,''); ?>"><i class="fa fa-google-plus"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_linkedin' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_linkedin_url' ,''); ?>"><i class="fa fa-linkedin"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_google_scholar' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_google_scholar_url' ,''); ?>"><i class="ai ai-google-scholar"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_academia' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_academia_url' ,''); ?>"><i class="academia"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_rg' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_rg_url' ,''); ?>"><i class="researchgate"></i></a></li>
            <?php endif; ?>

            

            <?php if (ot_get_option( 'si_youtube' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_youtube_url' ,''); ?>"><i class="fa fa-youtube"></i></a></li>
            <?php endif; ?>
            
            <?php if (ot_get_option( 'si_instagram' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_instagram_url' ,''); ?>"><i class="fa fa-instagram"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_flickr' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_flickr_url' ,''); ?>"><i class="fa fa-flickr"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_pinterest' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_pinterest_url' ,''); ?>"><i class="fa fa-pinterest"></i></a></li>
            <?php endif; ?>
            <?php if (ot_get_option( 'si_rss' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_rss_url' ,''); ?>"><i class="fa fa-rss"></i></a></li>
            <?php endif; ?>

            <?php if (ot_get_option( 'si_github' ,'off')=="on"): ?>
            <li><a target="_blank" href="<?php echo ot_get_option( 'si_github_url' ,''); ?>"><i class="fa fa-github"></i></a></li>
            <?php endif; ?>
        </ul>
    </div>

    <?php if ( is_active_sidebar( 'footer_of_sidebar' ) ) : ?>
    <div id="side-footer-widget">
        <?php dynamic_sidebar( 'footer_of_sidebar' ); ?>
    </div>
    <?php endif; ?>

    <?php if (ot_get_option( 'copyright','' )!=''): ?>
    <div id="copyright"><?php echo ot_get_option( 'copyright','' ) ?></div>
    <?php endif; ?>

</div>
<?php endif; ?>
 <!-- /Sidebar footer -->
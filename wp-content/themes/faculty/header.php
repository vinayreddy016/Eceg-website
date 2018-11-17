<?php
/**
 * @package WordPress
 * @subpackage faculty
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
    <?php wp_head(); ?>
	</head>
	
	<body  <?php body_class( ); ?>>
	
        <div id="wrapper">
            <?php get_sidebar(); ?>

            <div id="main">
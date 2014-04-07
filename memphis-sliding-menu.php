<?php
/*
 
Plugin Name: Memphis Sliding Menu
Plugin URI: http://
Description: A sliding menu for WordPress
Author: Ian Howatson
Version: 1.0.4
Author URI: http://www.kingofnothing.net/
Date: 4/07/2013

Copyright 2013 Ian Howatson  (email : ian.howatson@kingofnothing.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
include 'mslide-settings.php';
include 'mslide-functions.php';
include 'mslide-shortcode.php';
add_action( 'widgets_init', 'memphis_sliding_menu_widget' );
add_action( 'wp_enqueue_scripts', 'memphis_sliding_menu_script' );
add_action( 'admin_enqueue_scripts', 'memphis_sliding_menu_script' );
add_action('admin_init', 'mslide_admin');

?>
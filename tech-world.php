<?php
/*
Plugin Name: TechWorld Plugin
Description: This plugin adds a custom widget to display a "Quote of the Day" on the WordPress dashboard.
Version: 1.0
Author: crackwits
Author URI: https://crackwits.com
*/

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}



add_action( 'wp_dashboard_setup', 'add_dashboard_tech_widget' );
function add_dashboard_tech_widget() {
    wp_add_dashboard_widget( 'dashboard_tech_widget', 'Tech World', 'display_dashboard_tech_widget' );
}

function display_dashboard_tech_widget() {

    echo 'hi';
}


function techworld_quotes_admin_menu() {
    add_menu_page(
        'TechWorld Quotes',
        'TechWorld Quotes',
        'manage_options',
        'techworld-quotes',
        'techworld_quotes_admin_page'
    );
}
add_action('admin_menu', 'techworld_quotes_admin_menu');


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

    $quotes = get_quote_from_database();

    echo '<h2>Quote of the Day</h2>';
    echo '<p>' . $quotes . '</p>';
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


function save_quote_to_database($quote) {
    $old_cuotes =get_quote_from_database();
    if(!empty($old_cuotes)){
        $new = $old_cuotes;
        $new []=$quote[0];
    }else{
        $new[]=$quote[0];
    }

   
    update_option('techworld_quotes', $new);
}

function get_quote_from_database() {
    return get_option('techworld_quotes');
}

function techworld_quotes_admin_page() {
    if (isset($_POST['submit_quote'])) {
        $quote [] = $_POST['quote'];
        save_quote_to_database($quote);
    }

    $quotes = get_option('techworld_quotes');

    echo '<h2>Add New Quote</h2>';
    echo '<form method="post">';
    echo '<label for="quote">Quote:</label>';
    echo '<textarea id="quote" name="quote"></textarea><br>';
    echo '<input type="submit" name="submit_quote" value="Submit Quote"><br>';

    echo '<h2>Existing Quotes</h2>';
    if ($quotes) {
        //$quotes = json_decode($quotes);
        echo '<ul>';
        foreach ($quotes as $quote) {
            echo '<li>' . $quote . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No quotes found</p>';
    }
    echo '</form>';
}

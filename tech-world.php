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


//add  dashboard widget
add_action( 'wp_dashboard_setup', 'add_dashboard_tech_widget' );
function add_dashboard_tech_widget() {
    wp_add_dashboard_widget( 'dashboard_tech_widget', 'Tech World', 'display_dashboard_tech_widget' );
}



function display_dashboard_tech_widget() {
    $quotes = get_option('techworld_quotes');

    if (!empty($quotes)) {
        $last_updated = get_option('techworld_quotes_last_updated', ''); 

        if ($last_updated !== date('Y-m-d')) {
            $random_quote = $quotes[array_rand($quotes)];
            update_option('techworld_quotes_last_updated', date('Y-m-d')); 
            echo '<h2>Quote of the Day</h2>';
            echo '<p>' . $random_quote . '</p>';
            $last_quote = update_option('techworld_quotes_last_quote', $random_quote);

        } else {
            $last_quote = get_option('techworld_quotes_last_quote', '');
            echo '<h2>Quote of the Day</h2>';
            echo '<p>' . $last_quote . '</p>';
        }
    } else {
        echo '<p>No quotes found</p>';
    }
}

// add admin menu
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

//save quote
function save_quote_to_database($quote) {
    $old_cuotes =get_option('techworld_quotes');
    if(!empty($old_cuotes)){
        $new = $old_cuotes;
        $new []=$quote[0];
    }else{
        $new[]=$quote[0];
    }

    update_option('techworld_quotes', $new);
}

// function get_quote_from_database() {
//     return get_option('techworld_quotes');
// }



//admin page
function techworld_quotes_admin_page() {
    if (isset($_POST['submit_quote'])) {
        $quote [] = $_POST['quote'];
        save_quote_to_database($quote);
    }

    $quotes = get_option('techworld_quotes');
    ?>
    <div class="quote-form">
    <h2>Add New Quote</h2>
    <form method="post">
    <label for="quote">Quote:</label>
    <textarea id="quote" name="quote"></textarea><br>
    <input type="submit" name="submit_quote" value="Submit Quote"><br>
    </form>
    </div>

    <div class="existing-quotes">
    <h2>Existing Quotes</h2>
    <?php
    if ($quotes) {
        echo '<ul>';
        foreach ($quotes as $quote) {
            echo '<li>' . $quote . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No quotes found</p>';
    }
    echo '</div>';
}

//add style 
function techworld_enqueue_admin_styles() {
    wp_enqueue_style( 'techworld-admin-styles', plugins_url( 'style.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'techworld_enqueue_admin_styles' );
<?php

/**
 * @package Volunteer Opportunity
 */
/*
Plugin Name: Volunteer Opportunity Plugin
Description: This is the Volunteer Opportunity Plugin for managing volunteer details dynamically and filter as per their volunteering hours.
Version: 0.1
Author: Nevil Patel
*/

    /**
     * myplugin_activate function to active the volunteer opportunity plugin
     * When it activated it create table in database with following columns in it.
     */
    function myplugin_activate() {
        global $wpdb;
        $table_name = 'volunteer_opportunity';
        $sql = $wpdb->query("CREATE TABLE volunteer_opportunity (
        id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
        position VARCHAR(255) NOT NULL,
        organization VARCHAR(255) NOT NULL,
        type ENUM('one-time', 'recurring', 'seasonal') NOT NULL,
        email VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        location VARCHAR(255) NOT NULL,
        hours DECIMAL NOT NULL,
        skills_required TEXT NOT NULL
        );");

        $wpdb->query("INSERT INTO volunteer_opportunity (position, organization, type, email, description, location, hours, skills_required)
        VALUES ('Community Garden Helper', 'Green City Initiative', 'recurring', 'garden@greencity.org', 'Assist in maintaining our community garden. Tasks include planting, weeding, and harvesting.', 'Downtown Community Center', 3.50, 'Gardening experience, ability to work outdoors'),
        ('Soup Kitchen Volunteer', 'Helping Hands Charity', 'one-time', 'kitchen@helpinghands.org', 'Help prepare and serve meals at our local soup kitchen. No experience necessary, just a willingness to help!', '123 Main St, Anytown', 4.00, 'Basic food handling, friendly demeanor');");

    }
    register_activation_hook( __FILE__,
    'myplugin_activate' );
    
    /**
     * myplugin_deactivate to deactivate the volunteer opportunity plugin.
     * it delete all the values from the volunteer_opportunity table.
     */
    function myplugin_deactivate() {
        global $wpdb;
        $wpdb->query("DELETE FROM volunteer_opportunity;");
    }
    register_deactivation_hook( __FILE__, 'myplugin_deactivate' );

    /**
     * Admin panel feature
     */
    // Hook to create the admin menu
add_action('admin_menu', 'volunteer_admin_menu');

function volunteer_admin_menu() {
    add_menu_page(
        'Volunteer Opportunities', 
        'Volunteer', 
        'manage_options', 
        'volunteer', 
        'volunteer_admin_panel'
    );
}

/**
 * Volunteer admin panel with HTML and logic
 */
function volunteer_admin_panel() {
    global $wpdb;
    $table_name = 'volunteer_opportunity';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['add_volunteer'])) {
            // If statement create new volunteer data using POST method.
            $result = $wpdb->insert($table_name, [
                'position'        => sanitize_text_field($_POST['position']),
                'organization'    => sanitize_text_field($_POST['organization']),
                'type'            => sanitize_text_field($_POST['type']),
                'email'           => sanitize_email($_POST['email']),
                'description'     => sanitize_textarea_field($_POST['description']),
                'location'        => sanitize_text_field($_POST['location']),
                'hours'           => floatval($_POST['hours']),
                'skills_required' => sanitize_textarea_field($_POST['skills_required'])
            ]);
            
            if ($result !== false) {
                echo "<div><p>Volunteer opportunity added successfully!</p></div>";
            } else {
                echo "<div><p>Error: Unable to add volunteer opportunity. Please try again.</p></div>";
            }
        }
    }


    //Add Opportunity from here! 
    ?>
    <div class="wrap">
        <h1>Volunteer Opportunities</h1>
        <form method="POST">
            <input type="hidden" name="update_volunteer">
            <table>
                <tr><th>Position</th><td><input type="text" name="position" required></td></tr>
                <tr><th>Organization</th><td><input type="text" name="organization" required></td></tr>
                <tr><th>Type</th><td>
                    <select name="type" required>
                        <option value="one-time">One-Time</option>
                        <option value="recurring">Recurring</option>
                        <option value="seasonal">Seasonal</option>
                    </select>
                </td></tr>
                <tr><th>Email</th><td><input type="email" name="email" required></td></tr>
                <tr><th>Description</th><td><textarea name="description" required></textarea></td></tr>
                <tr><th>Location</th><td><input type="text" name="location" required></td></tr>
                <tr><th>Hours</th><td><input type="number" name="hours" required></td></tr>
                <tr><th>Skills Required</th><td><textarea name="skills_required" required></textarea></td></tr>
            </table>
            <p><button type="submit" name="submit">submit</button></button></p>
        </form>

        <!-- Display Existing Opportunities by getting all the data from the database -->
        <h2>Existing Opportunities</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Position</th>
                    <th>Organization</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Hours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <p>No volunteering opportunities available.</p>
    </div>
    <?php   
}
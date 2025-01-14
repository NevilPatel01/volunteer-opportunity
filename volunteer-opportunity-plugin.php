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
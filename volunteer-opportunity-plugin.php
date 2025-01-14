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
    $wpdb->query("CREATE TABLE volunteer_opportunity (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    position VARCHAR(255) NOT NULL,
    organization VARCHAR(255) NOT NULL,
    type ENUM('one-time', 'recurring', 'seasonal') NOT NULL,
    email VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    hours DECIMAL(4,2) NOT NULL,
    skills_required TEXT NOT NULL,
    );");
    $wpdb->query("INSERT INTO Events (Name) VALUES ('Coffee Break');");
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
        register_deactivation_hook( __FILE__,
        'myplugin_deactivate' );
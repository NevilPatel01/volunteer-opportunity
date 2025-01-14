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

function myplugin_activate() {
    global $wpdb;
    $wpdb->query("CREATE TABLE Volunteer_Opportunity (
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
    $wpdb->query("INSERT INTO Events (Name) VALUES ('Pizza Lunch');");
    }
    register_activation_hook( __FILE__,
    'myplugin_activate' );
    

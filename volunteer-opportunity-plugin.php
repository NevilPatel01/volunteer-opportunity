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

    // Handle form submissions
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add_volunteer'])) {
            // Create new opportunity
            $wpdb->insert($table_name, [
                'position'        => sanitize_text_field($_POST['position']),
                'organization'    => sanitize_text_field($_POST['organization']),
                'type'            => sanitize_text_field($_POST['type']),
                'email'           => sanitize_email($_POST['email']),
                'description'     => sanitize_textarea_field($_POST['description']),
                'location'        => sanitize_text_field($_POST['location']),
                'hours'           => floatval($_POST['hours']),
                'skills_required' => sanitize_textarea_field($_POST['skills_required'])
            ]);
            echo "<div class='updated'><p>Volunteer opportunity added successfully!</p></div>";
        } elseif (isset($_POST['update_volunteer'])) {
            // Update opportunity
            $id = intval($_POST['update_volunteer']);
            $wpdb->update($table_name, [
                'position'        => sanitize_text_field($_POST['position']),
                'organization'    => sanitize_text_field($_POST['organization']),
                'type'            => sanitize_text_field($_POST['type']),
                'email'           => sanitize_email($_POST['email']),
                'description'     => sanitize_textarea_field($_POST['description']),
                'location'        => sanitize_text_field($_POST['location']),
                'hours'           => floatval($_POST['hours']),
                'skills_required' => sanitize_textarea_field($_POST['skills_required'])
            ], ['id' => $id]);
            echo "<div class='updated'><p>Volunteer opportunity updated successfully!</p></div>";
        } elseif (isset($_POST['delete_volunteer'])) {
            // Delete opportunity
            $id = intval($_POST['delete_volunteer']);
            $wpdb->delete($table_name, ['id' => $id]);
            echo "<div class='updated'><p>Volunteer opportunity deleted successfully!</p></div>";
        }
    }

    // Fetch existing opportunities
    $opportunities = $wpdb->get_results("SELECT * FROM $table_name");

    // Determine if we are editing an existing opportunity
    $edit_opportunity = null;
    if (isset($_GET['edit'])) {
        $id = intval($_GET['edit']);
        $edit_opportunity = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
    }

    // Admin panel interface
    ?>
    <div class="wrap">
        <h1>Volunteer Opportunities</h1>

        <!-- Add/Edit Opportunity Form -->
        <h2><?php echo $edit_opportunity ? 'Edit Opportunity' : 'Add New Opportunity'; ?></h2>
        <form method="POST">
            <input type="hidden" name="update_volunteer" value="<?php echo esc_attr($edit_opportunity->id ?? ''); ?>">
            <table class="form-table">
                <tr><th>Position</th><td><input type="text" name="position" value="<?php echo esc_attr($edit_opportunity->position ?? ''); ?>" required></td></tr>
                <tr><th>Organization</th><td><input type="text" name="organization" value="<?php echo esc_attr($edit_opportunity->organization ?? ''); ?>" required></td></tr>
                <tr><th>Type</th><td>
                    <select name="type" required>
                        <option value="one-time" <?php selected($edit_opportunity->type ?? '', 'one-time'); ?>>One-Time</option>
                        <option value="recurring" <?php selected($edit_opportunity->type ?? '', 'recurring'); ?>>Recurring</option>
                        <option value="seasonal" <?php selected($edit_opportunity->type ?? '', 'seasonal'); ?>>Seasonal</option>
                    </select>
                </td></tr>
                <tr><th>Email</th><td><input type="email" name="email" value="<?php echo esc_attr($edit_opportunity->email ?? ''); ?>" required></td></tr>
                <tr><th>Description</th><td><textarea name="description" required><?php echo esc_textarea($edit_opportunity->description ?? ''); ?></textarea></td></tr>
                <tr><th>Location</th><td><input type="text" name="location" value="<?php echo esc_attr($edit_opportunity->location ?? ''); ?>" required></td></tr>
                <tr><th>Hours</th><td><input type="number" name="hours" value="<?php echo esc_attr($edit_opportunity->hours ?? ''); ?>" step="0.01" required></td></tr>
                <tr><th>Skills Required</th><td><textarea name="skills_required" required><?php echo esc_textarea($edit_opportunity->skills_required ?? ''); ?></textarea></td></tr>
            </table>
            <p class="submit"><button type="submit" name="<?php echo $edit_opportunity ? 'update_volunteer' : 'add_volunteer'; ?>" value="<?php echo esc_attr($edit_opportunity->id ?? ''); ?>" class="button-primary"><?php echo $edit_opportunity ? 'Update Opportunity' : 'Add Opportunity'; ?></button></p>
        </form>

        <!-- Display Existing Opportunities -->
        <h2>Existing Opportunities</h2>
        <?php if (!empty($opportunities)): ?>
        <table class="widefat fixed" cellspacing="0">
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
                <?php foreach ($opportunities as $opportunity): ?>
                <tr>
                    <td><?php echo esc_html($opportunity->id); ?></td>
                    <td><?php echo esc_html($opportunity->position); ?></td>
                    <td><?php echo esc_html($opportunity->organization); ?></td>
                    <td><?php echo esc_html($opportunity->type); ?></td>
                    <td><?php echo esc_html($opportunity->email); ?></td>
                    <td><?php echo esc_html($opportunity->location); ?></td>
                    <td><?php echo esc_html($opportunity->hours); ?></td>
                    <td>
                        <a href="?page=volunteer&edit=<?php echo $opportunity->id; ?>" class="button">Edit</a>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="delete_volunteer" value="<?php echo $opportunity->id; ?>" class="button-secondary">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No volunteer opportunities available.</p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Shortcode implementations
 */
function wporg_shortcode($atts = [], $content = null){
    global $wpdb;
    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id=%d", $atts[0]);
    $results = $wpdb->get_results($query);
    return ($results[0]->id);
    }
    add_shortcode('event', 'wporg_shortcode');